<?php
class Database
{
    private string $host = "mysql";
    private string $db_name = "grade_Analyzer";
    private string $username = "root";
    private string $password = "root";
    private ? mysqli $conn = null;



    public function __construct()
    {
        if(!$this->databaseExixts()){
            $this->createDatabase();
        }
        $this -> connect();
        $this -> createTables();
    }

    public function __connect(): ? mysqli{
        if ($this-> conn === null) {
            $this-> conn = new mysqli($this->host, $this->username, $this->password , $this->db_name);
            if($this->conn->connect_error){
                die("Database connection failed: " . $this->conn->connect_error);
            }
        }
    }
}


