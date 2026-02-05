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
            max-width: 1400px;
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
        }
        
        .navigation a:hover {
            background-color: #333;
        }
        
        .gallery {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 20px;
            margin: 20px;
        }
        
        @media (max-width: 1400px) {
            .gallery {
                grid-template-columns: repeat(5, 1fr);
            }
        }
        
        @media (max-width: 1200px) {
            .gallery {
                grid-template-columns: repeat(4, 1fr);
            }
        }
        
        @media (max-width: 900px) {
            .gallery {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        
        @media (max-width: 600px) {
            .gallery {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
                margin: 15px;
            }
        }
        
        .object-card {
            background-color: white;
            border-radius: 2px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: transform 0.2s;
            text-decoration: none;
            display: block;
            color: inherit;
        }
        
        .object-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }
        
        .object-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
        }
        
        .object-info {
            padding: 15px;
        }
        
        .object-info h3 {
            color: #333;
            margin-bottom: 10px;
        }
        
        .object-info .type {
            color: #000;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .object-info p {
            color: #666;
            line-height: 1.5;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }
        
        .no-objects {
            text-align: center;
            padding: 40px;
            background-color: white;
            border-radius: 2px;
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
            // laad database configuratie
            require_once 'config.php';
            
            try {
                // verbind met database
                $pdo = getDatabaseConnection();
                
                // haal alle objecten op gesorteerd op nieuwste eerst
                $stmt = $pdo->query("SELECT * FROM ruimteObjecten ORDER BY id DESC");
                $objecten = $stmt->fetchAll();
                
                // check of er objecten zijn
                if (count($objecten) > 0) {
                    // loop door alle objecten
                    foreach ($objecten as $object) {
                        // toon elk object als klikbare kaart
                        echo '<a href="detail.php?id=' . $object['id'] . '" class="object-card">';
                        echo '<img src="kosmos/' . htmlspecialchars($object['filename']) . '" alt="' . htmlspecialchars($object['objectName']) . '">';
                        echo '<div class="object-info">';
                        echo '<h3>' . htmlspecialchars($object['objectName']) . '</h3>';
                        echo '<div class="type">Type: ' . htmlspecialchars($object['type']) . '</div>';
                        echo '<p>' . htmlspecialchars($object['description']) . '</p>';
                        echo '</div>';
                        echo '</a>';
                    }
                } else {
                    // geen objecten gevonden toon bericht
                    echo '<div class="no-objects">Nog geen ruimte objecten geupload.</div>';
                }
            } catch (PDOException $e) {
                // bij fout toon foutmelding
                echo '<div class="no-objects">Kon gegevens niet laden uit de database.</div>';
            }
            ?>
        </div>
    </div>
</body>
</html>
