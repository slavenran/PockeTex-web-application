<?php

class Phones {

    /**
     * @var PDO
     */
    private $conn;

    public $id;
    public $model;
    public $year;
    public $manufacturer_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $sql = "SELECT * FROM phones ORDER BY model";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt;
    }

    public function read_single() {
        $sql = "SELECT * FROM phones WHERE model = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $this->model);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = $row['id'];
        $this->year = $row['year'];
    }

    public function create() {
        $query = 'INSERT INTO phones SET model = :model, year = :year, manufacturer_id = :manufacturer_id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->model = htmlspecialchars(strip_tags($this->model));
        $this->year = htmlspecialchars(strip_tags($this->year));
        $this->manufacturer_id = htmlspecialchars(strip_tags($this->manufacturer_id));

        //Bind data
        $stmt->bindParam(':model', $this->model);
        $stmt->bindParam(':year', $this->year);
        $stmt->bindParam(':manufacturer_id', $this->manufacturer_id);

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
        $ratingQuery = 'DELETE FROM ratings WHERE phones_id_rating = :id';

        $stmt = $this->conn->prepare($ratingQuery);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);

        $stmt->execute();

        //Create query
        $query = 'DELETE FROM phones WHERE id = :id';

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