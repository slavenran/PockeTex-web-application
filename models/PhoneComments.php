<?php

class PhoneComments {

    /**
     * @var PDO
     */
    private $conn;

    public $id;
    public $text;
    public $user_id;
    public $phone_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $sql = "SELECT c.*, u.username as username, u.imageurl as imageurl FROM phone_comments c, users u WHERE c.user_id = u.id AND c.phone_id = :phone_id ORDER BY id";

        $stmt = $this->conn->prepare($sql);

        $this->phone_id = htmlspecialchars(strip_tags($this->phone_id));

        $stmt->bindParam(':phone_id', $this->phone_id);

        $stmt->execute();

        return $stmt;
    }

//    public function read_single() {
//        $sql = "SELECT * FROM comments WHERE id = ? LIMIT 0,1";
//
//        $stmt = $this->conn->prepare($sql);
//        $stmt->bindParam(1, $this->id);
//        $stmt->execute();
//
//        $row = $stmt->fetch(PDO::FETCH_ASSOC);
//
//        $this->text = $row['text'];
//    }

    public function create() {
        $query = 'INSERT INTO phone_comments SET text = :text, user_id = :user_id, phone_id = :phone_id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->text = htmlspecialchars(strip_tags($this->text));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->phone_id = htmlspecialchars(strip_tags($this->phone_id));

        //Bind data
        $stmt->bindParam(':text', $this->text);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':phone_id', $this->phone_id);

        //Execute query
        if($stmt->execute()) {
            return true;
        }

        //Print error if smt goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function delete() {
        //Create query
        $query = 'DELETE FROM phone_comments WHERE id = :id';

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