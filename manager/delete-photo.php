<?php 

    require "../classes/Database.php";
    require "../classes/Auth.php";
    require "../classes/Url.php";
    require "../classes/Image.php";

    session_start();

    if (!Auth::isLoggedIn("manager") ) {
        die("Unauthorized access");
    }

    $connection = Database::databaseConnection();
    $employee_id = $_SESSION["logged_in_user_id"];
    $image_name = $_GET["image_name"];

    $image_path = "../uploads/" . $employee_id . "/" . $image_name;

    if(Image::deletePhotoFromDirectory($image_path)) {
        Image:: deletePhotoFromDatabase($connection, $image_name);
        UrL::redirectUrl("/company/manager/photos.php");
    }
