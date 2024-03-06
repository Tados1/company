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
            Url::redirectUrl("/company/$role/home-page.php?id=$id");
        }
        
    } else {
        $error = "Incorrect login name or password";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/sign-in.css">
    <title>Sign In</title>
</head>
<body>
            
    <form method="POST" onsubmit="return delayRedirect(this)">
        <h1>Sign in</h1>
        
        <div class="login-name">
            <p>Login Name</p>
            <input class="login_name" type="text" name="login_name" >
        </div>
        
        <div class="password">
            <p>Password</p>
            <input class="login_password" type="password" name="login_password" >
        </div>

        <input class="btn" type="submit" value="Sign in">

        <input id="inpLock" type="checkbox">
        <label class="btn-lock" for="inpLock">
            <svg width="36" height="40" viewBox="0 0 36 40">
                <path class="lockb" d="M27 27C27 34.1797 21.1797 40 14 40C6.8203 40 1 34.1797 1 27C1 19.8203 6.8203 14 14 14C21.1797 14 27 19.8203 27 27ZM15.6298 26.5191C16.4544 25.9845 17 25.056 17 24C17 22.3431 15.6569 21 14 21C12.3431 21 11 22.3431 11 24C11 25.056 11.5456 25.9845 12.3702 26.5191L11 32H17L15.6298 26.5191Z"></path>
                <path class="lock" d="M6 21V10C6 5.58172 9.58172 2 14 2V2C18.4183 2 22 5.58172 22 10V21"></path>
                <path class="bling" d="M29 20L31 22"></path>
                <path class="bling" d="M31.5 15H34.5"></path>
                <path class="bling" d="M29 10L31 8"></path>
            </svg>
        </label>

        <?php if(isset($error)): ?>
            <div class="error">
                <p><?php echo $error; ?></p>
            </div>
        <?php endif; ?>
    </form>

    <script src="js/sign-in.js"></script>
</body>
</html>