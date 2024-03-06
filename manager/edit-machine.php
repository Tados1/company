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

$connection = Database::databaseConnection();

if ( isset($_GET["id"]) ){
    $one_machine = Machine::getMachine($connection, $_GET["id"]);

    if ($one_machine) {
        $machine_name = $one_machine["machine_name"];
        $machine_type = $one_machine["machine_type"];
        $machine_status = $one_machine["machine_status"];
        $id = $one_machine["machine_id"];

    } else {
        die("Machine not found");
    }

} else {
    die("ID not entered, machine not found");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
                
            if(Machine::editMachine($connection, $machine_name, $machine_type, $machine_status, $new_image_name, $id)) {
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/edit-machine.css">
    <title>Edit Machine</title>
</head>
<body>
    <?php require "../assets/manager-header.php"; ?>

    <main class="edit-machine">
        <form method="POST" class="edit-form" enctype="multipart/form-data">

            <input  type="text" 
                    name="machine_name" 
                    placeholder="Machine Name" 
                    value="<?= htmlspecialchars($machine_name)  ?>"
                    required
            >

            <div class="machine-type">
                <p>Machine Type:</p>

                <div class="radio-label">
                    <input type="radio" id="lathe" name="machine_type" value="lathe">
                    <label for="lathe">Lathe</label>
                </div>

                <div class="radio-label">
                    <input type="radio" id="milling" name="machine_type" value="milling">
                    <label for="milling">Milling</label>  
                </div>
                
            </div>
           
            <div class="machine-status">
                <p>Machine Status:</p>

                <div class="radio-label">
                    <input type="radio" id="active" name="machine_status" value="active">
                    <label for="active">Active</label>
                </div>

                <div class="radio-label">
                    <input type="radio" id="non-active" name="machine_status" value="non-active">
                    <label for="non-active">Non-active</label>  
                </div>   
            </div>

            <input type="file" name="image">
            
            <button>Change</button>
        </form>
    </main>
    
</body>
</html>