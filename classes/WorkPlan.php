<?php

class WorkPlan {
    public static function createWorkPlan($connection, $id, $work_type, $note, $machines) {
        $machinesString = implode(",", $machines);

        $sql = "INSERT INTO work_plan (user_id, work_type, note, machines) 
        VALUES (:id, :work_type, :note, :machines)";

        $stmt = $connection->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->bindValue(":work_type", $work_type, PDO::PARAM_STR);
        $stmt->bindValue(":note", $note, PDO::PARAM_STR);
        $stmt->bindValue(":machines", $machinesString, PDO::PARAM_STR);

        try {
            if($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Failed to create work plan");
            }
        } catch (Exception $e) {
            error_log("Error with function createWorkPlan\n", 3, "../errors/error.log");
            echo "Error Type: " . $e->getMessage();
        }
    }

    public static function updateWorkPlan($connection, $id, $work_type, $note, $machines) {
        $machinesString = implode(", ", $machines);

        $sql = "UPDATE work_plan
                    SET work_type = :work_type,
                        note = :note,
                        machines = :machines
                    WHERE user_id = :id";
        
        $stmt = $connection->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->bindValue(":work_type", $work_type, PDO::PARAM_STR);
        $stmt->bindValue(":note", $note, PDO::PARAM_STR);
        $stmt->bindValue(":machines", $machinesString, PDO::PARAM_STR);

        try {
            if($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Update work plan failed"); 
            }
        } catch (Exception $e) {
            error_log("Error with function updateWorkPlan\n", 3, "../errors/error.log");
            echo "Error Type: " . $e->getMessage();
        }
    }

    public static function getWorkPlan($connection, $id) {
        $sql = "SELECT work_type, note, machines 
                FROM work_plan
                WHERE user_id = :id";

        $stmt = $connection->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        try {
            if($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                throw new Exception("Failed to get work plan");
            }
        } catch (Exception $e) {
            error_log("Error with function getWorkPlan\n", 3, "../errors/error.log");
            echo "Error type: " . $e->getMessage();
        }     
    }

    public static function checkExistWorkPlan($connection, $id) {
        $sql = "SELECT user_id FROM work_plan WHERE user_id = :id";

        $stmt = $connection->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        try {
            if($stmt->execute()) {
                if($stmt->rowCount() > 0) {
                    return true; 
                } else {
                    return false; 
                }
            } else {
                throw new Exception("Failed to check exist work plan");
            }
        } catch (Exception $e) {
            error_log("Error with function checkExistWorkPlan\n", 3, "../errors/error.log");
            echo "Error Type: " . $e->getMessage();
        }
    }

    public static function deleteWorkPlan($connection) {
        $sql = "DELETE FROM work_plan WHERE TIMESTAMPDIFF(HOUR, created_at, NOW()) > 24";

        $stmt = $connection->prepare($sql);

        try {
            if($stmt->execute()) {
                return true;
            }  else {
                throw new Exception("Failed to delete work plan");
            }
        } catch (Exception $e) {
            error_log("Error with function deleteWorkPlan\n", 3, "../errors/error.log");
            echo "Error Type: " . $e->getMessage();
        }
    }
}