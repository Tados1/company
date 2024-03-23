<?php

require "../classes/Database.php";
require "../classes/Url.php";
require "../classes/Employee.php";
require "../classes/Auth.php";
require "../classes/Image.php";

session_start();

if (!Auth::isLoggedIn("director") ) {
    die("Unauthorized access");
}

$name = null;
$surname = null;
$position = null;
$login_name = null;
$password = null;
$role = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $connection = Database::databaseConnection();

    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $login_name = $_POST["login_name"];
    $password = $_POST["password"];
    $role = $_POST["role"];
    if ($role === "employee") {
        $position = $_POST["position"];
    } else {
        $position = "";
    }

    $image_name = $_FILES["image"]["name"];
    $image_size = $_FILES["image"]["size"];
    $image_tmp_name = $_FILES["image"]["tmp_name"];
    $error = $_FILES["image"]["error"];

    if(!$error) {
        if ($image_size > 9000000){
            Url::redirectUrl("/errors/error-page.php?error_text=Your file is too big&page=employees");
        } else {
            $new_image_name = Image::getPhotoName($image_name, $image_tmp_name, "employee");
                
            if(Employee::createEmployee($connection, $name, $surname, $position, $login_name, $password, $role, $new_image_name)) {
                Url::redirectUrl("/director/employees.php");
            } else {
                Url::redirectUrl("/errors/error-page.php?error_text=Your file extension is not allowed&page=employees");
            }
        }
    } else {
        Employee::createEmployee($connection, $name, $surname, $position, $login_name, $password, $role, "default-employee.jpg");
        Url::redirectUrl("/director/employees.php");
    }
}

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/add-employee-director.css">
    <title>Add Employee</title>
</head>
<body>
    <?php require "../assets/director-header.php"; ?>

    <?php require "../assets/blue-background.php"; ?>

    <main class="add-employee-form">
        <form method="POST" class="add-form" enctype="multipart/form-data">

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

            <div class="position">
                    <label for="position">Position:</label>
                    <select name="position" id="position">
                        <option value="turner">Turner</option>
                        <option value="miller">Miller</option>
                    </select>
            </div>

            <div class="role">
                    <label for="role">Role:</label>
                    <select name="role" id="role">
                        <option value="employee">Employee</option>
                        <option value="manager">Manager</option>
                        <option value="director">Director</option>
                    </select>
            </div>
           
            <label for="file" class="file-upload">
                <div class="icon">
                    <svg viewBox="0 0 24 24" fill="" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z" fill=""></path> </g></svg>
                </div>
                
                <span>Upload image</span>
                
                <input id="file" type="file" name="image">
            </label>

            <button> 
                <span>Add Employee</span>
            </button>

        </form>
    </main>
</body>
</html>