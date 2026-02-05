<?php
require_once 'config.php';

echo "<h3>Database Test</h3>";

try {
    $pdo = getDatabaseConnection();
    echo "✓ Database connectie werkt<br><br>";
    
    // Check if table exists
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Tabellen in database:<br>";
    foreach ($tables as $table) {
        echo "- $table<br>";
    }
    echo "<br>";
    
    // Check table structure if ruimteObjecten exists
    if (in_array('ruimteObjecten', $tables)) {
        echo "✓ Tabel 'ruimteObjecten' bestaat<br><br>";
        echo "Kolommen in ruimteObjecten:<br>";
        $stmt = $pdo->query("DESCRIBE ruimteObjecten");
        $columns = $stmt->fetchAll();
        foreach ($columns as $col) {
            echo "- {$col['Field']} ({$col['Type']})<br>";
        }
    } else {
        echo "✗ Tabel 'ruimteObjecten' bestaat NIET<br>";
        echo "<br>SQL om tabel aan te maken:<br>";
        echo "<pre>";
        echo htmlspecialchars(file_get_contents('database.sql'));
        echo "</pre>";
    }
    
} catch (PDOException $e) {
    echo "✗ Error: " . $e->getMessage();
}
?>
