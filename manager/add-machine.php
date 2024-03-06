<?php

require "../classes/Database.php";
require "../classes/Url.php";
require "../classes/Machine.php";
require "../classes/Auth.php";
require "../classes/Image.php";

session_start();

if (!Auth::isLoggedIn("manager") ) {
    die("Unauthorized access");
}

$machine_name = null;
$machine_type = null;
$machine_status = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $connection = Database::databaseConnection();

    $machine_name = $_POST["machine_name"];
    $machine_type = $_POST["machine_type"];
    $machine_status = $_POST["machine_status"];

    $image_name = $_FILES["image"]["name"];
    $image_size = $_FILES["image"]["size"];
    $image_tmp_name = $_FILES["image"]["tmp_name"];
    $error = $_FILES["image"]["error"];

    if(!$error) {
        if ($image_size > 9000000){
            Url::redirectUrl("/company/errors/error-page.php?error_text=Your file is too big");
        } else {
            $new_image_name = Image::getMachinePhotoName($image_name, $image_tmp_name);
                
            if(Machine::createMachine($connection, $machine_name, $machine_type, $machine_status, $new_image_name)) {
                Url::redirectUrl("/company/manager/machines.php");
            } else {
                Url::redirectUrl("/company/errors/error-page.php?error_text=Your file extension is not allowed");
            }
        }
    } else {
        Url::redirectUrl("/company/errors/error-page.php?error_text=Unfortunately, the image could not be inserted");
    }
}

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
</head>
<body>
<?php require "../assets/manager-header.php"; ?>

    <main>
        <section class="add-form">
            <form method="POST" enctype="multipart/form-data">
                <input  type="text" 
                        name="machine_name" 
                        placeholder="Machine Name" 
                        value="<?= htmlspecialchars($machine_name)  ?>"
                        required
                >

                <p>Machine Type:</p>
                <input type="radio" id="lathe" name="machine_type" value="lathe">
                <label for="lathe">Lathe</label>
                <input type="radio" id="milling" name="machine_type" value="milling">
                <label for="milling">Milling</label>  

                <p>Machine Status:</p>
                <input type="radio" id="active" name="machine_status" value="active">
                <label for="active">Active</label>
                <input type="radio" id="non-active" name="machine_status" value="non-active">
                <label for="non-active">Non-active</label>  

                <input type="file" name="image">

                <input type="submit" value="Add Machine">
            </form>
        </section>
    </main>
</body>
</html>