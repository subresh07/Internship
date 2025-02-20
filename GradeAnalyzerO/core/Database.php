<?php
namespace Core;

use mysqli;
use Exception;

class Database
{
    private static ?Database $instance = null;
    private ?mysqli $conn = null;

    private function __construct()
    {
        // Database Configuration
        $servername = 'mysql'; // Change to '127.0.0.1' if necessary
        $username = 'root';
        $password = 'root';
        $db_name = 'grade_analyzer';

        try {
            $this->conn = new mysqli($servername, $username, $password, $db_name);
            if ($this->conn->connect_error) {
                throw new Exception("Database connection failed: " . $this->conn->connect_error);
            }
        } catch (Exception $e) {
            die("Database Connection Error: " . $e->getMessage());
        }
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(): mysqli
    {
        return $this->conn;
    }
}


