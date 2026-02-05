<?php
require_once 'config.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit();
}

// Get form data
$naam = trim($_POST['naam'] ?? '');
$type = trim($_POST['type'] ?? '');
$omschrijving = trim($_POST['omschrijving'] ?? '');

// Validate form data
if (empty($naam) || empty($type) || empty($omschrijving)) {
    header('Location: index.php?error=' . urlencode('Alle velden moeten worden ingevuld.'));
    exit();
}

// Check if file was uploaded
if (!isset($_FILES['afbeelding']) || $_FILES['afbeelding']['error'] === UPLOAD_ERR_NO_FILE) {
    header('Location: index.php?error=' . urlencode('Geen bestand geselecteerd.'));
    exit();
}

// Check for upload errors
if ($_FILES['afbeelding']['error'] !== UPLOAD_ERR_OK) {
    header('Location: index.php?error=' . urlencode('Er is een fout opgetreden bij het uploaden.'));
    exit();
}

// Get file information
$bestand = $_FILES['afbeelding'];
$bestandNaam = $bestand['name'];
$bestandTmpNaam = $bestand['tmp_name'];
$bestandGrootte = $bestand['size'];
$bestandType = $bestand['type'];

// Check if file is an image
$toegestaneTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $bestandTmpNaam);
finfo_close($finfo);

if (!in_array($mimeType, $toegestaneTypes)) {
    header('Location: index.php?error=' . urlencode('Alleen afbeeldingsbestanden zijn toegestaan (JPEG, PNG, GIF, WebP).'));
    exit();
}

// Additional validation using getimagesize
$imageInfo = @getimagesize($bestandTmpNaam);
if ($imageInfo === false) {
    header('Location: index.php?error=' . urlencode('Het bestand is geen geldige afbeelding.'));
    exit();
}

// Check file size (max 5MB)
$maxGrootte = 5 * 1024 * 1024; // 5MB in bytes
if ($bestandGrootte > $maxGrootte) {
    header('Location: index.php?error=' . urlencode('De afbeelding is te groot. Maximum grootte is 5MB.'));
    exit();
}

// Create kosmos directory if it doesn't exist
$uploadDir = __DIR__ . '/kosmos/';
if (!file_exists($uploadDir)) {
    if (!mkdir($uploadDir, 0755, true)) {
        header('Location: index.php?error=' . urlencode('Kon de upload map niet aanmaken.'));
        exit();
    }
}

// Generate unique filename
$bestandExtensie = strtolower(pathinfo($bestandNaam, PATHINFO_EXTENSION));
$nieuweBestandNaam = uniqid('space_', true) . '.' . $bestandExtensie;
$doelPad = $uploadDir . $nieuweBestandNaam;

// Move uploaded file
if (!move_uploaded_file($bestandTmpNaam, $doelPad)) {
    header('Location: index.php?error=' . urlencode('Kon de afbeelding niet opslaan.'));
    exit();
}

// If upload successful, save to database
try {
    $pdo = getDatabaseConnection();
    
    $sql = "INSERT INTO ruimteObjecten (naam, type, omschrijving, afbeelding) VALUES (:naam, :type, :omschrijving, :afbeelding)";
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute([
        ':naam' => $naam,
        ':type' => $type,
        ':omschrijving' => $omschrijving,
        ':afbeelding' => $nieuweBestandNaam
    ]);
    
    // Success - redirect with success message
    header('Location: index.php?success=1');
    exit();
    
} catch (PDOException $e) {
    // If database insert fails, delete the uploaded file
    if (file_exists($doelPad)) {
        unlink($doelPad);
    }
    
    header('Location: index.php?error=' . urlencode('Database fout: gegevens konden niet worden opgeslagen.'));
    exit();
}
?>
