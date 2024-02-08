<?php

require "../classes/Database.php";
require "../classes/Url.php";
require "../classes/Machine.php";
require "../classes/Auth.php";

session_start();

if (!Auth::isLoggedIn("manager") ) {
    die("Unauthorized access");
}
$connection = Database::databaseConnection();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if(Machine::deleteMachine($connection, $_GET["id"])){
        Url::redirectUrl("/company/manager/machines.php");
    };
}

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/delete-page.css">
    <script src="https://kit.fontawesome.com/bd1040f7a7.js" crossorigin="anonymous"></script>
    <title>Delete Machine</title>
</head>
<body>
    <?php require "../assets/manager-header.php"; ?>

    <main  class="delete-page">
        <section class="delete-form">
            <form method="POST">
            <div class="user-icon"><i class="fa-solid fa-trash"></i></div>
                <div class="delete-text">
                    <p>Are you sure you want to delete this machine?</p>
                </div>
                
                <div class="btns">
                    <button>Delete</button>
                    <a href="machines.php">Cancel</a>
                </div>          
            </form>
        </section>
    </main>
</body>
</html>