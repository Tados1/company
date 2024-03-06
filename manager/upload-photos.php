<?php 

    require "../classes/Database.php";
    require "../classes/Auth.php";
    require "../classes/Url.php";
    require "../classes/Image.php";

    session_start();

    if (!Auth::isLoggedIn("manager") ) {
        die("Unauthorized access");
    }
    
    $employee_id = $_SESSION["logged_in_user_id"];

    if(isset($_POST["submit"]) && isset($_FILES["image"])) {

        $connection = Database::databaseConnection();

        $image_name = $_FILES["image"]["name"];
        $image_size = $_FILES["image"]["size"];
        $image_tmp_name = $_FILES["image"]["tmp_name"];
        $error = $_FILES["image"]["error"];

        if($error === 0) {
            if ($image_size > 9000000){
                Url::redirectUrl("/company/errors/error-page.php?error_text=Vas subor je prilis velky");
            } else {
                $image_extension = pathinfo($image_name, PATHINFO_EXTENSION);
                $image_extension_lower_case = strtolower($image_extension);

                $allowed_extensions = ["jpg", "jpeg", "png"];

                if(in_array($image_extension_lower_case, $allowed_extensions)) {
                    $new_image_name = uniqid("IMG-", true) . "." . $image_extension_lower_case;

                    if(!file_exists("../uploads/employee/" . $employee_id)) {
                        mkdir("../uploads/employee/" . $employee_id, 0777, true);
                    }

                    $image_upload_path = "../uploads/employee" . $employee_id . "/" . $new_image_name;

                    move_uploaded_file($image_tmp_name, $image_upload_path);
                    
                    if(Image::insertImage($connection, $employee_id, $new_image_name)) {
                        Url::redirectUrl("/company/manager/photos.php");
                    }

                } else {
                    
                    Url::redirectUrl("/company/errors/error-page.php?error_text=Koncovka vasho suboru nie je povolena");
                }
            }
        } else {
            Url::redirectUrl("/company/errors/error-page.php?error_text=Vlozit obrazok sa bohuzial nepodarilo");
        }

    }

?>