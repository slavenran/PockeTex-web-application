<?php

class Ratings {

    /**
     * @var PDO
     */
    private $conn;

    public $id;
    public $users_id_rating;
    public $phones_id_rating;
    public $rating;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create_rating(){
        $query = 'INSERT INTO ratings SET rating = :rating, users_id_rating = :users_id_rating, phones_id_rating = :phones_id_rating';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->users_id_rating = htmlspecialchars(strip_tags($this->users_id_rating));
        $this->phones_id_rating = htmlspecialchars(strip_tags($this->phones_id_rating));
        $this->rating = htmlspecialchars(strip_tags($this->rating));

        //Bind data
        $stmt->bindParam(':users_id_rating', $this->users_id_rating);
        $stmt->bindParam(':phones_id_rating', $this->phones_id_rating);
        $stmt->bindParam(':rating', $this->rating);

        //Execute query
        if($stmt->execute()) {
            return true;
        }

        //Print error if smt goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function update_rating(){
        $query = 'UPDATE ratings SET rating = :rating WHERE users_id_rating = :users_id_rating AND phones_id_rating = :phones_id_rating';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->users_id_rating = htmlspecialchars(strip_tags($this->users_id_rating));
        $this->phones_id_rating = htmlspecialchars(strip_tags($this->phones_id_rating));
        $this->rating = htmlspecialchars(strip_tags($this->rating));

        //Bind data
        $stmt->bindParam(':users_id_rating', $this->users_id_rating);
        $stmt->bindParam(':phones_id_rating', $this->phones_id_rating);
        $stmt->bindParam(':rating', $this->rating);

        //Execute query
        if($stmt->execute()) {
            return true;
        }

        //Print error if smt goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

}

?>