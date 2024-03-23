<?php

class Image {
    public static function getPhotoName($image_name, $image_tmp_name, $type) {

        $image_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

        $allowed_extensions = ["jpg", "jpeg", "png"];

        if(in_array($image_extension, $allowed_extensions)) {
            $new_image_name = uniqid("IMG-", true) . "." . $image_extension;

            $image_upload_path = "../uploads/$type/" . $new_image_name;

            move_uploaded_file($image_tmp_name, $image_upload_path);
            
            return $new_image_name;
        }
    }

    public static function deletePhoto($connection, $choice) {
        $uploadsDir = "../uploads/$choice";

        if (!is_dir($uploadsDir)) {
            error_log("Directory 'uploads' does not exist.\n", 3, "../errors/error.log");
            return false;
        }

        $images = [];
        try {
            $sql = "SELECT {$choice}_image FROM $choice";
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
                if ($file == 'default-' . $choice . '.jpg') {
                    continue;
                }
                if (!in_array($file, $images)) {
                    $filePath = $uploadsDir . '/' . $file;
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    } else {
                        echo "File $file does not exist.<br>";
                    }
                }
            }
        }
        return true;
    }
}