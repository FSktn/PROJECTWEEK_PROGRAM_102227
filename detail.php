<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESA - Object Details</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
        }
        
        h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .navigation {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .navigation a {
            background-color: #000;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 2px;
            margin: 0 5px;
        }
        
        .navigation a:hover {
            background-color: #333;
        }
        
        .detail-card {
            background-color: white;
            border-radius: 2px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .detail-card img {
            width: 100%;
            height: auto;
            max-height: 600px;
            object-fit: contain;
            background-color: #000;
        }
        
        .detail-info {
            padding: 30px;
        }
        
        .detail-info h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 28px;
        }
        
        .info-row {
            margin-bottom: 20px;
        }
        
        .info-label {
            color: #000;
            font-weight: bold;
            font-size: 14px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        
        .info-value {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
        }
        
        .error {
            background-color: #ffebee;
            color: #c62828;
            padding: 20px;
            border-radius: 2px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>ESA Ruimte Object Details</h1>
        
        <div class="navigation">
            <a href="galerij.php">Terug naar Overzicht</a>
            <a href="index.php">Nieuw Object Uploaden</a>
        </div>
        
        <?php
        // laad database configuratie
        require_once 'config.php';
        
        // controleer of id parameter aanwezig is en een nummer is
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            echo '<div class="error">Geen geldig object geselecteerd.</div>';
            exit();
        }
        
        // haal id op uit url\n        $id = (int)$_GET['id'];\n        \n        try {\n            // verbind met database\n            $pdo = getDatabaseConnection();\n            \n            // haal object op met specifieke id\n            $stmt = $pdo->prepare(\"SELECT * FROM ruimteObjecten WHERE id = :id\");\n            $stmt->execute([':id' => $id]);\n            $object = $stmt->fetch();\n            \n            // check of object gevonden is\n            if ($object) {\n                // toon object details\n                echo '<div class=\"detail-card\">';\n                echo '<img src=\"kosmos/' . htmlspecialchars($object['filename']) . '\" alt=\"' . htmlspecialchars($object['objectName']) . '\">';\n                echo '<div class=\"detail-info\">';\n                echo '<h2>' . htmlspecialchars($object['objectName']) . '</h2>';\n                \n                // toon type\n                echo '<div class=\"info-row\">';\n                echo '<div class=\"info-label\">Type</div>';\n                echo '<div class=\"info-value\">' . htmlspecialchars($object['type']) . '</div>';\n                echo '</div>';\n                \n                // toon omschrijving\n                echo '<div class=\"info-row\">';\n                echo '<div class=\"info-label\">Omschrijving</div>';\n                echo '<div class=\"info-value\">' . nl2br(htmlspecialchars($object['description'])) . '</div>';\n                echo '</div>';\n                \n                echo '</div>';\n                echo '</div>';\n            } else {\n                // object niet gevonden\n                echo '<div class=\"error\">Object niet gevonden.</div>';\n            }\n        } catch (PDOException $e) {\n            // bij fout toon foutmelding\n            echo '<div class=\"error\">Kon gegevens niet laden uit de database.</div>';\n        }
        ?>
    </div>
</body>
</html>
