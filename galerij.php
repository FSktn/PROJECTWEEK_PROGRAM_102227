<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESA - Ruimte Objecten Galerij</title>
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
            max-width: 1200px;
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
            background-color: #0066cc;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 3px;
        }
        
        .navigation a:hover {
            background-color: #0052a3;
        }
        
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .object-card {
            background-color: white;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .object-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }
        
        .object-info {
            padding: 15px;
        }
        
        .object-info h3 {
            color: #333;
            margin-bottom: 10px;
        }
        
        .object-info .type {
            color: #0066cc;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .object-info p {
            color: #666;
            line-height: 1.5;
        }
        
        .no-objects {
            text-align: center;
            padding: 40px;
            background-color: white;
            border-radius: 5px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>ESA Ruimte Objecten Galerij</h1>
        
        <div class="navigation">
            <a href="index.php">Nieuw Object Uploaden</a>
        </div>
        
        <div class="gallery">
            <?php
            require_once 'config.php';
            
            try {
                $pdo = getDatabaseConnection();
                $stmt = $pdo->query("SELECT * FROM ruimteObjecten ORDER BY upload_datum DESC");
                $objecten = $stmt->fetchAll();
                
                if (count($objecten) > 0) {
                    foreach ($objecten as $object) {
                        echo '<div class="object-card">';
                        echo '<img src="kosmos/' . htmlspecialchars($object['afbeelding']) . '" alt="' . htmlspecialchars($object['naam']) . '">';
                        echo '<div class="object-info">';
                        echo '<h3>' . htmlspecialchars($object['naam']) . '</h3>';
                        echo '<div class="type">Type: ' . htmlspecialchars($object['type']) . '</div>';
                        echo '<p>' . htmlspecialchars($object['omschrijving']) . '</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="no-objects">Nog geen ruimte objecten geupload.</div>';
                }
            } catch (PDOException $e) {
                echo '<div class="no-objects">Kon gegevens niet laden uit de database.</div>';
            }
            ?>
        </div>
    </div>
</body>
</html>
