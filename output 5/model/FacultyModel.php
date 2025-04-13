<?php
include '../includes/db.php';

class FacultyModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllFaculty() {
        $sql = "SELECT * FROM faculty";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addFaculty($data) {
        $sql = "INSERT INTO faculty (first_name, middle_name, last_name, age, gender, address, position, salary) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
    
        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }
    
        $stmt->bind_param(
            "sssisdsd",
            $data['first_name'],
            $data['middle_name'],
            $data['last_name'],
            $data['age'],
            $data['gender'],
            $data['address'],
            $data['position'],
            $data['salary']
        );
    
        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }
    
        return true;
    }

    public function updateFaculty($id, $data) {
        $sql = "UPDATE faculty SET first_name=?, middle_name=?, last_name=?, age=?, gender=?, address=?, position=?, salary=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssisdsdi", $data['first_name'], $data['middle_name'], $data['last_name'], $data['age'], $data['gender'], $data['address'], $data['position'], $data['salary'], $id);
        return $stmt->execute();
    }

    public function deleteFaculty($id) {
        $sql = "DELETE FROM faculty WHERE id=?";
        $stmt = $this->conn->prepare($sql);
    
        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }
    
        $stmt->bind_param("i", $id);
    
        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }
    
        return true;
    }
}
?>