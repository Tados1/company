<?php

class Employee {

    public static function getAllEmployees($connection, $columns = "*") {
        $sql = "SELECT $columns 
            FROM employee";

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
}
