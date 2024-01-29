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

}