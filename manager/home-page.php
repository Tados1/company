<?php 

require "../classes/Auth.php";

session_start();

if (!Auth::isLoggedIn("manager") ) {
    die("Unauthorized access");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/home-page.css">
    <title>Home Page</title>
</head>
<body>
    <div class="home-page">
        <?php require "../assets/manager-header.php"; ?>
        <div class="heading-home-page">
            <h1>HOME PAGE</h1>  
        </div>   
    </div>
</body>
</html>