<?php

    require "../classes/Auth.php";
    require "../classes/Database.php";
    require "../classes/Image.php";

    session_start();

    if (!Auth::isLoggedIn("manager") ) {
        die("Unauthorized access");
    }

    $connection = Database::databaseConnection();
    $employee_id = $_SESSION["logged_in_user_id"];

    $allImages = Image::getImagesByUserId($connection, $employee_id);

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php require "../assets/manager-header.php"; ?>

    <main>
        <section class="upload-photos">
            <h1>Photos</h1>

            <form action="upload-photos.php" method="POST" enctype="multipart/form-data">
                <input type="file" name="image" require>
                <input type="submit" name="submit" value="upload photo">
            </form>
        </section>

        <section class="images">
            <article>
                <?php foreach($allImages as $one_image): ?>
                    <div>
                        <div>
                            <img src=<?= "../uploads/" . $employee_id . "/" . $one_image["image_name"] ?>>
                        </div>

                        <div>
                            <a href=<?= "../uploads/" . $employee_id . "/" . $one_image["image_name"] ?> download>Download</a>

                            <a href="delete-photo.php?id=<?= $employee_id ?>&image_name=<?= $one_image["image_name"] ?>">Delete</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </article>
        </section>
    </main>

</body>
</html>