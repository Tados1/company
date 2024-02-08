<?php

require "../classes/Database.php";
require "../classes/Url.php";
require "../classes/Manager.php";
require "../classes/Auth.php";

session_start();

$role = $_SESSION["role"]; 

if (!Auth::isLoggedIn("manager") ) {
    die("Unauthorized access");
}


$name = null;
$surname = null;
$position = null;
$login_name = null;
$password = null;
$role = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $position = $_POST["position"];
    $login_name = $_POST["login_name"];
    $password = $_POST["password"];
    $role = "employee";

    $connection = Database::databaseConnection();
    
    $id = Manager::createEmployee($connection, $name, $surname, $position, $login_name, $password, $role);

    if($id){
        Url::redirectUrl("/company/manager/one-employee.php?id=$id");
    } else {
        echo "The employee was not created";
    }
}

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/add-form-manager.css">
    <title>Add Employee</title>
</head>
<body>
<?php require "../assets/manager-header.php"; ?>

    <main class="add">
            <form method="POST"  class="add-form">

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
                
                

                <button>Add Employee</button>

            </form>
    </main>
</body>
</html>