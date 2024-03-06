<?php

class Image {

    // public static function insertImage($conn, $user_id, $image_name) {
    //     $sql = "INSERT INTO image (user_id, image_name)
    //             VALUE (:user_id, :image_name)";

    //     $stmt = $conn->prepare($sql);

    //     $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
    //     $stmt->bindValue(":image_name", $image_name, PDO::PARAM_STR);

    //     if ($stmt->execute()) {
    //         return true;
    //     }
    // }

    // public static function  getImagesByUserId($conn, $user_id) {
    //     $sql = "SELECT image_name FROM image
    //             WHERE user_id = :user_id";

    //     $stmt = $conn->prepare($sql);

    //     $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);

    //     $stmt->execute();

    //     $images = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //     return $images;
    // }

    // public static function deletePhotoFromDirectory($path) {
    //     try {
    //         if(!file_exists($path)) {
    //             throw new Exception("Subor neexistuje a preto nemoze byt vymazany");
    //         }

    //         if(unlink($path)) {
    //             return true;
    //         } else {
    //             throw new Exception("Pri mazani suboru doslo k chybe");
    //         }

    //     } catch (Exception $e) {
    //         echo "Chyba: " . $e->getMessage();
    //     }
    // }

    // public static function deletePhotoFromDatabase($conn, $image_name) {
    //     $sql = "DELETE FROM image
    //             WHERE image_name = :image_name";

    //     $stmt = $conn->prepare($sql);

    //     try {
    //         $stmt->bindValue(":image_name", $image_name, PDO::PARAM_STR);

    //         if(!$stmt->execute()) {
    //             throw new Exception("Obrazok sa nepodarilo zmazat z databaze");
    //         }

    //     } catch (Exception $e) {
    //         echo "Chyba: " . $e->gettMessage();
    //     }
    // }

    public static function getEmployeePhotoName($image_name, $image_tmp_name) {

        $image_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

        $allowed_extensions = ["jpg", "jpeg", "png"];

        if(in_array($image_extension, $allowed_extensions)) {
            $new_image_name = uniqid("IMG-", true) . "." . $image_extension;

            $image_upload_path = "../uploads/employees/" . $new_image_name;

            move_uploaded_file($image_tmp_name, $image_upload_path);
            
            return $new_image_name;
        }
    }

    public static function getMachinePhotoName($image_name, $image_tmp_name) {

        $image_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

        $allowed_extensions = ["jpg", "jpeg", "png"];

        if(in_array($image_extension, $allowed_extensions)) {
            $new_image_name = uniqid("IMG-", true) . "." . $image_extension;

            $image_upload_path = "../uploads/machines/" . $new_image_name;

            move_uploaded_file($image_tmp_name, $image_upload_path);
            
            return $new_image_name;
        }
    }

    /**
     * Function for deleting photos that are not in the database.
     *
     * @param PDO $connection PDO object for connecting to the database.
     * @return bool Returns TRUE if the function was successful, otherwise FALSE.
     */
    public static function deleteEmployeePhoto($connection) {
        $uploadsDir = "../uploads/employees";

        if (!is_dir($uploadsDir)) {
            error_log("Directory 'uploads' does not exist.\n", 3, "../errors/error.log");
            return false;
        }

        $images = [];
        try {
            $sql = "SELECT image_name FROM employee";
            $stmt = $connection->prepare($sql);
            if ($stmt->execute()) {
                $images = $stmt->fetchAll(PDO::FETCH_COLUMN);
            } else {
                throw new Exception("Retrieving data about images failed");
            }
        } catch (Exception $e) {
            $errorMessage = "Error with function deletePhoto: " . $e->getMessage() . "\n";
            error_log($errorMessage, 3, "../errors/error.log");
            return false;
        }

        $files = scandir($uploadsDir);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                if (!in_array($file, $images)) {
                    $filePath = $uploadsDir . '/' . $file;
                    if (file_exists($filePath)) {
                        unlink($filePath);
                        echo "The file $file has been deleted.<br>";
                    } else {
                        echo "File $file does not exist.<br>";
                    }
                }
            }
        }
        return true;
    }

     /**
     * Function for deleting photos that are not in the database.
     *
     * @param PDO $connection PDO object for connecting to the database.
     * @return bool Returns TRUE if the function was successful, otherwise FALSE.
     */
    public static function deleteMachinePhoto($connection) {
        $uploadsDir = "../uploads/machines";

        if (!is_dir($uploadsDir)) {
            error_log("Directory 'uploads' does not exist.\n", 3, "../errors/error.log");
            return false;
        }

        $images = [];
        try {
            $sql = "SELECT machine_image FROM machine";
            $stmt = $connection->prepare($sql);
            if ($stmt->execute()) {
                $images = $stmt->fetchAll(PDO::FETCH_COLUMN);
            } else {
                throw new Exception("Retrieving data about images failed");
            }
        } catch (Exception $e) {
            $errorMessage = "Error with function deletePhoto: " . $e->getMessage() . "\n";
            error_log($errorMessage, 3, "../errors/error.log");
            return false;
        }

        $files = scandir($uploadsDir);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                if (!in_array($file, $images)) {
                    $filePath = $uploadsDir . '/' . $file;
                    if (file_exists($filePath)) {
                        unlink($filePath);
                        echo "The file $file has been deleted.<br>";
                    } else {
                        echo "File $file does not exist.<br>";
                    }
                }
            }
        }
        return true;
    }
}