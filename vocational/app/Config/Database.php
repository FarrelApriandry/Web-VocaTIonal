<?php

require_once __DIR__ . '/../Core/Env.php';
Env::load(__DIR__ . '/../../.env');

class Database {
    private static $conn;

    public static function getConnection() {
        if (!self::$conn) {
            try {

                $host = getenv('DB_HOST');
                $db   = getenv('DB_NAME');
                $user = getenv('DB_USER');
                $pass = getenv('DB_PASS');

                $dsn = "mysql:host=$host;dbname=$db";
                
                $options = [
                    PDO::ATTR_PERSISTENT => true,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ];

                self::$conn = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                die("Connection Failed: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}

if (Database::getConnection()) {
    echo "Database connection successful!";
}