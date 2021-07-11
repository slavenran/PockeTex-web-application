<?php

class Comments {

    /**
     * @var PDO
     */
    private $conn;

    public $id;
    public $text;
    public $users_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $sql = "SELECT c.*, u.username as username, u.imageurl as imageurl FROM comments c, users u WHERE c.users_id = u.id ORDER BY id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt;
    }

    public function read_single() {
        $sql = "SELECT * FROM comments WHERE id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->text = $row['text'];
    }

    public function create() {
        $query = 'INSERT INTO comments SET text = :text, users_id = :users_id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->text = htmlspecialchars(strip_tags($this->text));
        $this->users_id = htmlspecialchars(strip_tags($this->users_id));

        //Bind data
        $stmt->bindParam(':text', $this->text);
        $stmt->bindParam(':users_id', $this->users_id);

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
        $query = 'UPDATE comments SET text = :text
                  WHERE id = :id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->text = htmlspecialchars(strip_tags($this->text));
        $this->id = htmlspecialchars(strip_tags($this->id));

        //Bind data
        $stmt->bindParam(':text', $this->text);
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
        //Create query
        $query = 'DELETE FROM comments WHERE id = :id';

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