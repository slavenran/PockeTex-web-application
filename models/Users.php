<?php

class Users {
    /**
     * @var PDO
     */
    private $conn;

    public $id;
    public $username;
    public $password;
    public $email;
    public $imageurl;
    public $readmsgs;
    public $phone_id;
    public $cid;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $sql = "SELECT * FROM users ORDER BY id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt;
    }

    public function read_single() {
        $sql = "SELECT * FROM users WHERE id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = $row['id'];
        $this->username = $row['username'];
        $this->password = $row['password'];
        $this->email = $row['email'];
        $this->imageurl = $row['imageurl'];
        $this->readmsgs = $row['readmsgs'];
    }

    public function create() {
        $query = 'INSERT INTO users SET username = :username, password = :password, email = :email';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->email = htmlspecialchars(strip_tags($this->email));

        //Bind data
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':email', $this->email);

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
        $query = 'UPDATE users SET username = :username, email = :email, readmsgs = :readmsgs WHERE id = :id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->readmsgs = htmlspecialchars(strip_tags($this->readmsgs));
        $this->id = htmlspecialchars(strip_tags($this->id));

        //Bind data
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':readmsgs', $this->readmsgs);
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
        $ratingQuery = 'DELETE FROM ratings WHERE users_id_rating = :id';

        $stmt = $this->conn->prepare($ratingQuery);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);

        $stmt->execute();

        //Create query
        $query = 'DELETE FROM users WHERE id = :id';

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

    public function read_wishlist() {
        $sql = "SELECT m.name, p.model, p.year, p.image, p.storage, p.resolution, p.cost, p.description, p.id FROM phones p, manufacturers m WHERE p.manufacturer_id = m.id AND p.id IN (SELECT phones_id_wishlist FROM wishlist WHERE users_id_wishlist = :id ORDER BY id)";

        $stmt = $this->conn->prepare($sql);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);

        $stmt->execute();

        return $stmt;
    }

    public function read_cart() {
        $sql = "SELECT m.name, p.model, p.year, p.image, p.storage, p.resolution, p.cost, p.description, p.id, c.id AS cid FROM phones p, manufacturers m, cart c
                WHERE p.manufacturer_id = m.id AND c.phones_id_cart = p.id and c.users_id_cart = :id";
//SELECT m.name, p.model, p.year, p.image, p.storage, p.resolution, p.cost, p.description, p.id FROM phones p, manufacturers m WHERE p.manufacturer_id = m.id AND p.id IN (SELECT phones_id_cart FROM cart WHERE users_id_cart = :id)
        $stmt = $this->conn->prepare($sql);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);

        $stmt->execute();

        return $stmt;
    }

    public function add_to_wishlist() {
        $sql = "INSERT INTO wishlist SET phones_id_wishlist = :phones_id_wishlist, users_id_wishlist = :users_id_wishlist";

        //Prepare statement
        $stmt = $this->conn->prepare($sql);

        //Bind data
        $stmt->bindParam(':phones_id_wishlist', $this->phone_id);
        $stmt->bindParam(':users_id_wishlist', $this->id);

        //Execute query
        if($stmt->execute()) {
            return true;
        }

        //Print error if smt goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function add_to_cart() {
        $sql = "INSERT INTO cart SET phones_id_cart = :phones_id_cart, users_id_cart = :users_id_cart";

        //Prepare statement
        $stmt = $this->conn->prepare($sql);

        //Bind data
        $stmt->bindParam(':phones_id_cart', $this->phone_id);
        $stmt->bindParam(':users_id_cart', $this->id);

        //Execute query
        if($stmt->execute()) {
            return true;
        }

        //Print error if smt goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function purchase_from_cart() {
        $sql = 'DELETE FROM cart WHERE users_id_cart = :id';

        $stmt = $this->conn->prepare($sql);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function remove_from_wishlist() {

        $sql = 'DELETE FROM wishlist WHERE phones_id_wishlist = :phone_id AND users_id_wishlist = :id';

        //Prepare statement
        $stmt = $this->conn->prepare($sql);

        $this->id = htmlspecialchars(strip_tags($this->id));

        //Bind data
        $stmt->bindParam(':phone_id', $this->phone_id);
        $stmt->bindParam(':id', $this->id);

        //Execute query
        if($stmt->execute()) {
            return true;
        }

        //Print error if smt goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function remove_from_cart() {

        $sql = 'DELETE FROM cart WHERE id = :cid AND users_id_cart = :id';

        //Prepare statement
        $stmt = $this->conn->prepare($sql);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->cid = htmlspecialchars(strip_tags($this->cid));

        //Bind data
        $stmt->bindParam(':cid', $this->cid);
        $stmt->bindParam(':id', $this->id);

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