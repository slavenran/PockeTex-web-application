<?php

class UserPhones {

    /**
     * @var PDO
     */
    private $conn;

    public $id;
    public $model;
    public $user_id;
    public $image;
    public $description;
    public $cost;
    public $phone_number;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $sql = "SELECT * FROM user_phones ORDER BY id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt;
    }

    public function read_single() {
        $sql = "SELECT * FROM user_phones WHERE model = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $this->model);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = $row['id'];
        $this->year = $row['year'];
    }

    public function create() {
        $query = 'INSERT INTO user_phones SET model = :model, user_id = :user_id, image = :image, description = :description, cost = :cost, phone_number = :phone_number';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->model = htmlspecialchars(strip_tags($this->model));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->image = htmlspecialchars(strip_tags($this->image));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->cost = htmlspecialchars(strip_tags($this->cost));
        $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));

        //Bind data
        $stmt->bindParam(':model', $this->model);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':cost', $this->cost);
        $stmt->bindParam(':phone_number', $this->phone_number);

        //Execute query
        if($stmt->execute()) {
            return true;
        }

        //Print error if smt goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    //Update post
//    public function update() {
//        //Create query
//        $query = 'UPDATE ' . $this->table . ' SET title = :title, body = :body, author = :author, category_id = :category_id
//                  WHERE id = :id';
//
//        //Prepare statement
//        $stmt = $this->conn->prepare($query);
//
//        //Clean data
//        $this->title = htmlspecialchars(strip_tags($this->title));
//        $this->body = htmlspecialchars(strip_tags($this->body));
//        $this->author = htmlspecialchars(strip_tags($this->author));
//        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
//        $this->id = htmlspecialchars(strip_tags($this->id));
//
//        //Bind data
//        $stmt->bindParam(':title', $this->title);
//        $stmt->bindParam(':body', $this->body);
//        $stmt->bindParam(':author', $this->author);
//        $stmt->bindParam(':category_id', $this->category_id);
//        $stmt->bindParam(':id', $this->id);
//
//        //Execute query
//        if($stmt->execute()) {
//            return true;
//        }
//
//        //Print error if smt goes wrong
//        printf("Error: %s.\n", $stmt->error);
//
//        return false;
//    }

    public function delete() {
        //Create query
        $query = 'DELETE FROM user_phones WHERE id = :id';

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