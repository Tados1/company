<?php

class Manager {

    public static function getAllEmployees($connection, $columns = "*") {
        $sql = "SELECT $columns 
            FROM employee
            WHERE role = 'employee'";

        $stmt = $connection->prepare($sql);

        try {
            if($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                throw new Exception("Failed to get all data");
            }
        } catch (Exception $e) {
            error_log("Error with function getAllEmployees\n", 3, "../errors/error.log");
            echo "Error type: " . $e->getMessage();
        }     
    }

    public static function getEmployee($connection, $id, $columns = "*") {
        $sql = "SELECT $columns
                FROM employee
                WHERE employee_id = :employee_id";
        
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(":employee_id", $id, PDO::PARAM_INT);

        try {
            if($stmt->execute()) {
                return $stmt->fetch();
            } else {
                throw new Exception("Retrieving data about one employee failed");
            }
        } catch (Exception $e) {
            error_log("Error with function getEmployee, failed to get data\n", 3, "../errors/error.log");
            echo "Error Type: " . $e->getMessage();
        }
    }

    public static function createEmployee($connection, $name, $surname, $position, $login_name, $password, $role, $image_name) {

        $sql = "INSERT INTO employee (name, surname, position, login_name, password, role, image_name) 
        VALUES (:name, :surname, :position, :login_name, :password, :role, :image_name)";

        $stmt = $connection->prepare($sql);

        $stmt->bindValue(":name", $name, PDO::PARAM_STR);
        $stmt->bindValue(":surname", $surname, PDO::PARAM_STR);
        $stmt->bindValue(":position", $position, PDO::PARAM_STR);
        $stmt->bindValue(":login_name", $login_name, PDO::PARAM_STR);
        $stmt->bindValue(":password", password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);  
        $stmt->bindValue(":role", $role, PDO::PARAM_STR);
        $stmt->bindValue(":image_name", $image_name, PDO::PARAM_STR);

        try {
            if($stmt->execute()) {
                $id = $connection->lastInsertId();
                return $id;
            } else {
                throw new Exception("Failed to create employee");
            }
        } catch (Exception $e) {
            error_log("Error with function createEmployee\n", 3, "../errors/error.log");
            echo "Error Type: " . $e->getMessage();
        }
    }

    public static function editEmployee($connection, $name, $surname, $position, $login_name, $password, $id, $image_name, $role = "employee"){

        $sql = "UPDATE employee
                    SET name = :name,
                        surname = :surname,
                        position = :position,
                        login_name = :login_name,
                        password = :password,
                        image_name = :image_name,
                        role = :role
                    WHERE employee_id = :id";
        
        $stmt = $connection->prepare($sql);

        $stmt->bindValue(":name", $name, PDO::PARAM_STR);
        $stmt->bindValue(":surname", $surname, PDO::PARAM_STR);
        $stmt->bindValue(":position", $position, PDO::PARAM_STR);
        $stmt->bindValue(":login_name", $login_name, PDO::PARAM_STR);
        $stmt->bindValue(":password", password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);  
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->bindValue(":image_name", $image_name, PDO::PARAM_STR);
        $stmt->bindValue(":role", $role, PDO::PARAM_STR);

        try {
            if($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Edit employee failed"); 
            }
        } catch (Exception $e) {
            error_log("Error with function editEmployee\n", 3, "../errors/error.log");
            echo "Error Type: " . $e->getMessage();
        }
    }

    public static function deleteEmployee($connection, $id){
        $sql = "DELETE
                FROM employee
                WHERE employee_id = :id";
        
        $stmt = $connection->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        try {
            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Deleting the employee failed");
            }
        } catch (Exception $e) {
            error_log("Error with function deleteEmployee\n", 3, "../errors/error.log");
            echo "Error Type: " . $e->getMessage();
        }
    }
}
