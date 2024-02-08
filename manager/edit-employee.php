<?php

require "../classes/Database.php";
require "../classes/Url.php";
require "../classes/Manager.php";
require "../classes/Auth.php";

session_start();

if (!Auth::isLoggedIn("manager") ) {
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

    if(Manager::editEmployee($connection, $name, $surname, $position, $login_name, $password, $id)){
        Url::redirectUrl("/company/manager/one-employee.php?id=$id");
    };
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/edit-manager.css">
    <title>Edit Employee</title>
</head>
<body>
    <?php require "../assets/manager-header.php"; ?>

    <main class="edit">
        
        <form method="POST" class="edit-form">

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

            <p>Position:</p>

            <div class="radio-label">
                <input type="radio" id="turner" name="position" value="turner">
                <label for="turner">Turner</label>
            </div>

            <div class="radio-label">
                <input type="radio" id="miller" name="position" value="miller">
                <label for="miller">Miller</label>  
            </div>

            <button>Change</button>
        </form>
    </main>
    
</body>
</html>