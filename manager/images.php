<?php 

    require "../classes/Database.php";
    require "../classes/Image.php";

    $connection = Database::databaseConnection();
    $images = Image::deletePhoto($connection);

    $directory = '../uploads';
    $files = scandir($directory);

    // Porovnání názvů souborů v adresáři a v databázi
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            $found = false;
            foreach ($images as $image) {
                if ($file == $image['image_name']) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                // Soubor je v adresáři, ale není v databázi, takže ho můžeme odstranit
                $path = $directory . '/' . $file;
                if (file_exists($path)) {
                    unlink($path); // Odstranění souboru
                    echo "Soubor $file byl odstraněn.<br>";
                } else {
                    echo "Soubor $file neexistuje.<br>";
                }
            }
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>