<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESA - Ruimte Object Uploaden</title>
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
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
        }
        
        form {
            display: flex;
            flex-direction: column;
        }
        
        label {
            color: #555;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        input[type="text"],
        input[type="file"],
        textarea {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 14px;
        }
        
        textarea {
            min-height: 100px;
            resize: vertical;
            font-family: Arial, sans-serif;
        }
        
        input[type="submit"] {
            background-color: #0066cc;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 3px;
            font-size: 16px;
            cursor: pointer;
        }
        
        input[type="submit"]:hover {
            background-color: #0052a3;
        }
        
        .error {
            background-color: #ffebee;
            color: #c62828;
            padding: 10px;
            border-radius: 3px;
            margin-bottom: 20px;
        }
        
        .success {
            background-color: #e8f5e9;
            color: #2e7d32;
            padding: 10px;
            border-radius: 3px;
            margin-bottom: 20px;
        }
        
        .navigation {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .navigation a {
            color: #0066cc;
            text-decoration: none;
        }
        
        .navigation a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>ESA Ruimte Object Uploaden</h1>
        
        <div class="navigation">
            <a href="galerij.php">Bekijk Galerij</a>
        </div>
        
        <?php
        if (isset($_GET['error'])) {
            echo '<div class="error">' . htmlspecialchars($_GET['error']) . '</div>';
        }
        if (isset($_GET['success'])) {
            echo '<div class="success">Ruimte object succesvol geupload!</div>';
        }
        ?>
        
        <form action="verwerk.php" method="POST" enctype="multipart/form-data">
            <label for="naam">Naam van ruimte object:</label>
            <input type="text" id="naam" name="naam" required>
            
            <label for="type">Type object:</label>
            <input type="text" id="type" name="type" required>
            
            <label for="omschrijving">Korte omschrijving:</label>
            <textarea id="omschrijving" name="omschrijving" required></textarea>
            
            <label for="afbeelding">Afbeelding selecteren:</label>
            <input type="file" id="afbeelding" name="afbeelding" accept="image/*" required>
            
            <input type="submit" value="Upload Object">
        </form>
    </div>
</body>
</html>
