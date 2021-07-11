<?php

class Database {
    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=localhost;dbname=smartphones;', 'root', '');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
        }
        return $this->conn;
    }

}

?>