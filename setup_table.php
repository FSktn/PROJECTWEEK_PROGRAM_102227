<?php
// Voeg de ontbrekende 'type' kolom toe aan de tabel
require_once 'config.php';

try {
    $pdo = getDatabaseConnection();
    
    // Check if type column already exists
    $stmt = $pdo->query("SHOW COLUMNS FROM ruimteObjecten LIKE 'type'");
    if ($stmt->rowCount() == 0) {
        $pdo->exec("ALTER TABLE ruimteObjecten ADD COLUMN type VARCHAR(100) NOT NULL AFTER objectName");
        echo "✓ Kolom 'type' toegevoegd<br>";
    } else {
        echo "✓ Kolom 'type' bestaat al<br>";
    }
    
    echo "<br><a href='index.php'>Ga naar upload formulier</a>";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
