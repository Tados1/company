<?php

class User {

    public static function authentication($connection, $login_name, $login_password) {
        $sql = "SELECT password 
                FROM employee
                WHERE login_name = :login_name";

        $stmt = $connection->prepare($sql);

        $stmt->bindValue(":login_name", $login_name, PDO::PARAM_STR);

        try {
            if ($stmt->execute()) {
                if ($user = $stmt->fetch()) {
                    return password_verify($login_password, $user['0']);
                }
            } else {
                throw new Exception("User login error");
            }
        } catch (Exception $e) {
            error_log("Error with function authentication\n", 3, "../errors/error.log");
            echo "Error type: " . $e->getMessage();
        }
    }

    public static function getUserInfo($connection, $login_name, $info) {
        $sql = "SELECT $info FROM employee
                WHERE login_name = :login_name";

        $stmt = $connection->prepare($sql);

        $stmt->bindValue(":login_name", $login_name, PDO::PARAM_STR);

        try {
            if ($stmt->execute()) {
                if ($stmt->execute()) {
                    $result = $stmt->fetch();
                    $user_info = $result[0];
                    return $user_info;
                }
            } else {
                throw new Exception("Error getting user $info");
            }
        } catch (Exception $e) {
            error_log("Error with function getUser$info\n", 3, "../errors/error.log");
            echo "Error type: " . $e->getMessage();
        }       
    }
}