<?php

require "../classes/Database.php";
require "../classes/Url.php";
require "../classes/Manager.php";
require "../classes/Auth.php";
require "../classes/Image.php";

session_start();

if (!Auth::isLoggedIn("director") ) {
    die("Unauthorized access");
}

$connection = Database::databaseConnection();

if ( isset($_GET["id"]) ){
    $one_employee = Manager::getEmployee($connection, $_GET["id"]);

    if ($one_employee) {
        $name = $one_employee["name"];
        $surname = $one_employee["surname"];
        $position = $one_employee["position"];
        $login_name = $one_employee["login_name"];
        $password = $one_employee["password"];
        $id = $one_employee["employee_id"];
        $role = $one_employee["role"];

    } else {
        die("Employee not found");
    }

} else {
    die("ID not entered, employee not found");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $position = $_POST["position"];
    $login_name = $_POST["login_name"];
    $password = $_POST["password"];
    $role = $_POST["role"];

    $image_name = $_FILES["image"]["name"];
    $image_size = $_FILES["image"]["size"];
    $image_tmp_name = $_FILES["image"]["tmp_name"];
    $error = $_FILES["image"]["error"];

    if(!$error) {
        if ($image_size > 9000000){
            Url::redirectUrl("/company/errors/error-page.php?error_text=Your file is too big");
        } else {
            $new_image_name = Image::getEmployeePhotoName($image_name, $image_tmp_name);
                
            if(Manager::editEmployee($connection, $name, $surname, $position, $login_name, $password, $id, $new_image_name, $role)) {
                Url::redirectUrl("/company/director/one-employee.php?id=$id");
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
    <link rel="stylesheet" href="../css/director-edit.css">
    <title>Edit Employee</title>
</head>
<body>
    <?php require "../assets/director-header.php"; ?>

    <main class="edit">
        <form method="POST" class="edit-form" enctype="multipart/form-data">

            <input  type="text" 
                    name="name" 
                    placeholder="Name" 
                    value="<?= htmlspecialchars($name)  ?>"
                    required
            >

            <input  type="text" 
                    name="surname" 
                    placeholder="Surname"
                    value="<?= htmlspecialchars($surname) ?>" 
                    required
            >

            <input type="text" 
                    name="login_name" 
                    placeholder="Login Name"
                    value="<?= htmlspecialchars($login_name) ?>"  
                    required
            >

            <input type="password" 
                    name="password" 
                    placeholder="Password" 
                    value="<?= htmlspecialchars($password) ?>"  
                    required
            >

            <div class="position-role">
                <div class="position">
                    <p>Position:</p>

                    <div class="radio-label">
                        <input type="radio" id="turner" name="position" value="turner">
                        <label for="turner">Turner</label>
                    </div>

                    <div class="radio-label">
                        <input type="radio" id="miller" name="position" value="miller">
                        <label for="miller">Miller</label>  
                    </div>
                </div>
                
                <div class="role">
                    <p>Role:</p>

                    <div class="radio-label">
                        <input type="radio" id="employee" name="role" value="employee" required>
                        <label for="employee">Employee</label>
                    </div>  

                    <div class="radio-label">
                        <input type="radio" id="manager" name="role" value="manager" required>
                        <label for="manager">Manager</label>  
                    </div>

                    <div class="radio-label">
                        <input type="radio" id="director" name="role" value="director" required>
                        <label for="director">Director</label> 
                    </div>
                </div>
            </div>

            <input type="file" name="image">

            <button>Change</button>
        </form>
    </main>
    
</body>
</html>