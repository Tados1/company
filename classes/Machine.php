<?php

class Machine {

    public static function getAllMachines($connection, $columns = "*") {
        $sql = "SELECT $columns 
                FROM machine";

        $stmt = $connection->prepare($sql);

        try {
            if($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                throw new Exception("Failed to get all data");
            }
        } catch (Exception $e) {
            error_log("Error with function getAllMachines\n", 3, "../errors/error.log");
            echo "Error type: " . $e->getMessage();
        }     
    }

    public static function getMachine($connection, $id, $columns = "*") {
        $sql = "SELECT $columns
                FROM machine
                WHERE machine_id = :id";
        
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        try {
            if($stmt->execute()) {
                return $stmt->fetch();
            } else {
                throw new Exception("Retrieving data about one machine failed");
            }
        } catch (Exception $e) {
            error_log("Error with function getMachine, failed to get data\n", 3, "../errors/error.log");
            echo "Error Type: " . $e->getMessage();
        }
    }

    public static function createMachine($connection, $machine_name, $machine_type, $machine_status, $machine_image) {

        $sql = "INSERT INTO machine (machine_name, machine_type, machine_status, machine_image) 
        VALUES (:machine_name, :machine_type, :machine_status, :machine_image)";

        $stmt = $connection->prepare($sql);

        $stmt->bindValue(":machine_name", $machine_name, PDO::PARAM_STR);
        $stmt->bindValue(":machine_type", $machine_type, PDO::PARAM_STR);
        $stmt->bindValue(":machine_status", $machine_status, PDO::PARAM_STR);
        $stmt->bindValue(":machine_image", $machine_image, PDO::PARAM_STR);

        try {
            if($stmt->execute()) {
                $id = $connection->lastInsertId();
                return $id;
            } else {
                throw new Exception("Failed to create machine");
            }
        } catch (Exception $e) {
            error_log("Error with function createMachine\n", 3, "../errors/error.log");
            echo "Error Type: " . $e->getMessage();
        }
    }

    public static function editMachine($connection, $machine_name, $machine_type, $machine_status, $machine_image, $id){

        $sql = "UPDATE machine
                    SET machine_name = :machine_name,
                        machine_type = :machine_type,
                        machine_status = :machine_status,
                        machine_image = :machine_image
                    WHERE machine_id = :id";
        
        $stmt = $connection->prepare($sql);

        $stmt->bindValue(":machine_name", $machine_name, PDO::PARAM_STR);
        $stmt->bindValue(":machine_type", $machine_type, PDO::PARAM_STR);
        $stmt->bindValue(":machine_status", $machine_status, PDO::PARAM_STR);
        $stmt->bindValue(":machine_image", $machine_image, PDO::PARAM_STR);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        try {
            if($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Edit machine failed"); 
            }
        } catch (Exception $e) {
            error_log("Error with function editMachine\n", 3, "../errors/error.log");
            echo "Error Type: " . $e->getMessage();
        }
    }


    public static function deleteMachine($connection, $id){
        $sql = "DELETE
                FROM machine
                WHERE machine_id = :id";
        
        $stmt = $connection->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        try {
            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Deleting the machine failed");
            }
        } catch (Exception $e) {
            error_log("Error with function deleteMachine\n", 3, "../errors/error.log");
            echo "Error Type: " . $e->getMessage();
        }
    }

    public static function getExactTypeMachines($connection, $position, $columns = "*") {
        if ($position === "turner") {
            $sql = "SELECT $columns
                FROM machine
                WHERE machine_type = 'lathe'";
        } else {
            $sql = "SELECT $columns
                FROM machine
                WHERE machine_type = 'milling'";
        }
        
        $stmt = $connection->prepare($sql);

        try {
            if($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                throw new Exception("Failed to get all data");
            }
        } catch (Exception $e) {
            error_log("Error with function getAllMachines\n", 3, "../errors/error.log");
            echo "Error type: " . $e->getMessage();
        }     
    }

}