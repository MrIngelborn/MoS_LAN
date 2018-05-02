<?php
    class Database {
        const USERNAME="root";
        const PASSWORD="root";
        const HOST="localhost";
        const DB="plan19";

        static function getConnection() {
            $username = self::USERNAME;
            $password = self::PASSWORD;
            $host = self::HOST;
            $db = self::DB;
            $connection = new PDO("mysql:dbname=$db;host=$host", $username, $password);
            return $connection;
        }
        static function getConnection_noDB() {
            $username = self::USERNAME;
            $password = self::PASSWORD;
            $host = self::HOST;
            $connection = new PDO("mysql:host=$host", $username, $password);
            return $connection;
        }
        static function query($sql, $args = null) {
            $connection = Self::getConnection();
            $stmt = $connection->prepare($sql);
            $stmt->execute($args);
            return $stmt;
        }
    }
?>