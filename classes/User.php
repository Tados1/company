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
                    return password_verify($login_password, $user[0]);
                }
            } else {
                throw new Exception("User login error");
            }
        } catch (Exception $e) {
            error_log("Error with function authentication\n", 3, "../errors/error.log");
            echo "Error type: " . $e->getMessage();
        }
    }

    public static function getUserId($connection, $login_name) {
        $sql = "SELECT employee_id FROM employee
                WHERE login_name = :login_name";

        $stmt = $connection->prepare($sql);

        $stmt->bindValue(":login_name", $login_name, PDO::PARAM_STR);

        try {
            if ($stmt->execute()) {
                if ($stmt->execute()) {
                    $result = $stmt->fetch();
                    $user_id = $result[0];
                    return $user_id;
                }
            } else {
                throw new Exception("Error getting user id");
            }
        } catch (Exception $e) {
            error_log("Error with function getUserId\n", 3, "../errors/error.log");
            echo "Error type: " . $e->getMessage();
        }       
    }

    public static function getUserPosition($connection, $login_name) {
        $sql = "SELECT position FROM employee
                WHERE login_name = :login_name";

        $stmt = $connection->prepare($sql);

        $stmt->bindValue(":login_name", $login_name, PDO::PARAM_STR);

        try {
            if ($stmt->execute()) {
                if ($stmt->execute()) {
                    $result = $stmt->fetch();
                    $user_position = $result[0];
                    return $user_position;
                }
            } else {
                throw new Exception("Error getting user position");
            }
        } catch (Exception $e) {
            error_log("Error with function getUserPosition\n", 3, "../errors/error.log");
            echo "Error type: " . $e->getMessage();
        }       
    }

    public static function getUserRole($connection, $id) {
        $sql = "SELECT role FROM employee
                WHERE employee_id = :employee_id";

        $stmt = $connection->prepare($sql);

        $stmt->bindValue(":employee_id", $id, PDO::PARAM_INT);

        try {
            if ($stmt->execute()) {       
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result["role"];
            } else {
                throw new Exception("Error getting user role");
            }
        } catch (Exception $e) {
            error_log("Error with function getUserRole\n", 3, "../errors/error.log");
            echo "Error type: " . $e->getMessage();
        }       
    }
}