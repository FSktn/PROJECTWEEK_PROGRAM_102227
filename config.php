<?php
// database instellingen
define('DB_HOST', 'localhost');
define('DB_NAME', '102227_PROJECTWEEK');
define('DB_USER', '102227_2');
define('DB_PASS', 'Mgmq9jfcx1');

// maak database verbinding met pdo
function getDatabaseConnection() {
    try {
        // maak connectie string
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        
        // pdo opties instellen
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_TIMEOUT => 5,
        ];
        
        // verbind met database
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}
?>
