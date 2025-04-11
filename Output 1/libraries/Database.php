<?php

class Database {
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $dbname = 'myfirstdb';

    private $dbh; // db connection object
    private $stmt;
    private $error;

    public function __construct() {
        $dsn = "mysql: host=$this->host; dbname=$this->dbname";
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        // Create a PDO instance
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    // Prepare statement with query
    public function setQuery($sql){
        $this->stmt = $this->dbh->prepare($sql);
    }

    // Bind values
    public function bindValue($param, $value, $type = null) {
        if(is_null($type)) {
            switch(true) {
                case is_int($value) :
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value) :
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value) :
                    $type = PDO::PARAM_NULL;
                    break;
                default :
                    $type = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindParam($param, $value, $type);
    }

    // Execute prepared statement
    public function execute() {
        return $this->stmt->execute();
    }

    // Get result set as array of objects
    public function getResultSet() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Get single record as object
    public function getSingleRecord() {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    // Get row count
    public function getRowCount() {
        return $this->stmt->rowCount();
    }

}

// $db = new Database();

// $db->setQuery("INSERT INTO persons(person_fname,person_mname,person_lname) 
//                 VALUES(:fname, :mname, :lname)");
// $db->bindValue(':fname', 'Marlon Juhn 1');
// $db->bindValue(':mname', 'Marsado 1');
// $db->bindValue(':lname', 'Timogan 1');

// if($db->execute()) {
//     echo "Success";
// } else {
//     echo "Failed";
// }

// $db->setQuery("SELECT * FROM persons");


// print_r($db->getResultSet());