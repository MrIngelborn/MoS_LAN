<?php
    class Database {
        const USERNAME="root";
        const PASSWORD="root";
        const HOST="localhost";
        const DB="plan18";

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
        static function query($sql, array $params=array(), $args=null) {
            $connection = Self::getConnection();
            $stmt = $connection->prepare($sql);
            
            foreach ($params as $key => $value) {
	            $stmt->bindParam(':'.$key, $value);
            }
            
            $stmt->execute($args);
            return $stmt;
        }
    }
?>