<?php

class Database {

    public static function databaseConnection() {
        $db_host = "localhost";
        $db_name = "company";
        $db_user = "company_admin";
        $db_password = "company123";

        $connection = "mysql:host=" . $db_host . ";dbname=" . $db_name . ";charset=utf8";

        try {
            $db = new PDO($connection, $db_user, $db_password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }
}