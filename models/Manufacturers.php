<?php

class Manufacturers {

    /**
     * @var PDO
     */
    private $conn;

    public $id;
    public $name;
    public $country;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $sql = "SELECT * FROM manufacturers ORDER BY id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt;
    }

    public function read_single() {
        $sql = "SELECT * FROM manufacturers WHERE id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $row['name'];
        $this->country = $row['country'];
    }

    public function create() {
        $query = 'INSERT INTO manufacturers SET name = :name, country = :country';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->country = htmlspecialchars(strip_tags($this->country));

        //Bind data
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':country', $this->country);

        //Execute query
        if($stmt->execute()) {
            return true;
        }

        //Print error if smt goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    //Update post
    public function update() {
        //Create query
        $query = 'UPDATE manufacturers SET name = :name, country = :country
                  WHERE id = :id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->country = htmlspecialchars(strip_tags($this->country));
        $this->id = htmlspecialchars(strip_tags($this->id));

        //Bind data
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':country', $this->country);
        $stmt->bindParam(':id', $this->id);

        //Execute query
        if($stmt->execute()) {
            return true;
        }

        //Print error if smt goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function delete() {

        $query = 'SELECT * FROM phones WHERE manufacturer_id = :id';
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ratingQuery = 'DELETE FROM ratings WHERE phones_id_rating = :id';

            $stmtRating = $this->conn->prepare($ratingQuery);

            $phoneId = $row['id'];

            $stmtRating->bindParam(':id', $phoneId);

            $stmtRating->execute();
        }


        $query = 'DELETE FROM phones WHERE manufacturer_id = :id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);

        $stmt->execute();

        //Create query
        $query = 'DELETE FROM manufacturers WHERE id = :id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()){
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }

}

?>