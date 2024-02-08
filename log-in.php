<?php

require "classes/Database.php";
require "classes/Url.php";
require "classes/User.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $connection = Database::databaseConnection();
    $login_name = $_POST["login_name"];
    $login_password = $_POST["login_password"];

    if (User::authentication($connection, $login_name, $login_password)) {
        
        $id = User::getUserId($connection, $login_name);
        $position = User::getUserPosition($connection, $login_name);
        $role = User::getUserRole($connection, $id);

        session_regenerate_id(true);

        $_SESSION["is_logged_in"] = true;
        $_SESSION["logged_in_user_id"] = $id;
        $_SESSION["role"] = $role;

        if ($role === "director" or $role === "manager") {
            Url::redirectUrl("/company/$role/home-page.php");
        } else {
            Url::redirectUrl("/company/$role/home-page.php?id=$id&position=$position");
        }
        
    } else {
       $error = "Login error";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/log-in.css">
    <script src="https://kit.fontawesome.com/bd1040f7a7.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <main class="log-in">
        <?php if(!empty($error)): ?>
            <p> <?= $error ?> </p>
            <a href="sign-in.php">
                <i class="fa-solid fa-arrow-left-long"> Back to Sign In</i>
            </a>
        <?php endif; ?>
    </main>
    
</body>
</html>