<?php
// laad database configuratie
require_once 'config.php';

// controleer of formulier is verzonden
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit();
}

// haal formulier gegevens op
$naam = trim($_POST['naam'] ?? '');
$type = trim($_POST['type'] ?? '');
$omschrijving = trim($_POST['omschrijving'] ?? '');

// controleer of alle velden zijn ingevuld
if (empty($naam) || empty($type) || empty($omschrijving)) {
    header('Location: index.php?error=' . urlencode('Alle velden moeten worden ingevuld.'));
    exit();
}

// controleer of bestand is geupload
if (!isset($_FILES['afbeelding']) || $_FILES['afbeelding']['error'] === UPLOAD_ERR_NO_FILE) {
    header('Location: index.php?error=' . urlencode('Geen bestand geselecteerd.'));
    exit();
}

// controleer op upload fouten
if ($_FILES['afbeelding']['error'] !== UPLOAD_ERR_OK) {
    header('Location: index.php?error=' . urlencode('Er is een fout opgetreden bij het uploaden.'));
    exit();
}

// haal bestand informatie op
$bestand = $_FILES['afbeelding'];
$bestandNaam = $bestand['name'];
$bestandTmpNaam = $bestand['tmp_name'];
$bestandGrootte = $bestand['size'];
$bestandType = $bestand['type'];

// controleer of bestand een afbeelding is
$toegestaneTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $bestandTmpNaam);
finfo_close($finfo);

// check mime type
if (!in_array($mimeType, $toegestaneTypes)) {
    header('Location: index.php?error=' . urlencode('Alleen afbeeldingsbestanden zijn toegestaan (JPEG, PNG, GIF, WebP).'));
    exit();
}

// extra controle met getimagesize
$imageInfo = @getimagesize($bestandTmpNaam);
if ($imageInfo === false) {
    header('Location: index.php?error=' . urlencode('Het bestand is geen geldige afbeelding.'));
    exit();
}

// controleer bestandsgrootte max 5mb
$maxGrootte = 5 * 1024 * 1024;
if ($bestandGrootte > $maxGrootte) {
    header('Location: index.php?error=' . urlencode('De afbeelding is te groot. Maximum grootte is 5MB.'));
    exit();
}

// maak kosmos map aan als die niet bestaat
$uploadDir = __DIR__ . '/kosmos/';
if (!file_exists($uploadDir)) {
    if (!mkdir($uploadDir, 0755, true)) {
        header('Location: index.php?error=' . urlencode('Kon de upload map niet aanmaken.'));
        exit();
    }
}

// maak unieke bestandsnaam
$bestandExtensie = strtolower(pathinfo($bestandNaam, PATHINFO_EXTENSION));
$nieuweBestandNaam = uniqid('space_', true) . '.' . $bestandExtensie;
$doelPad = $uploadDir . $nieuweBestandNaam;

// verplaats bestand naar kosmos map
if (!move_uploaded_file($bestandTmpNaam, $doelPad)) {
    header('Location: index.php?error=' . urlencode('Kon de afbeelding niet opslaan.'));
    exit();
}

// als upload gelukt is sla dan op in database
try {
    // verbind met database
    $pdo = getDatabaseConnection();
    
    // maak insert query
    $sql = "INSERT INTO ruimteObjecten (objectName, type, description, filename) VALUES (:naam, :type, :omschrijving, :afbeelding)";
    $stmt = $pdo->prepare($sql);
    
    // voer query uit met gegevens
    $stmt->execute([
        ':naam' => $naam,
        ':type' => $type,
        ':omschrijving' => $omschrijving,
        ':afbeelding' => $nieuweBestandNaam
    ]);
    
    // gelukt ga terug naar formulier met succes bericht
    header('Location: index.php?success=1');
    exit();
    
} catch (PDOException $e) {
    // als database fout verwijder dan geupload bestand
    if (file_exists($doelPad)) {
        unlink($doelPad);
    }
    
    header('Location: index.php?error=' . urlencode('Database fout: gegevens konden niet worden opgeslagen.'));
    exit();
}
?>
