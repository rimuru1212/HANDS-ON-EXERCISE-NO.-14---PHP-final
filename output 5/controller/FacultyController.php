<?php
include '../includes/db.php';
include '../model/FacultyModel.php';

$facultyModel = new FacultyModel($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add"])) {
    $data = [
        'first_name' => $_POST['first_name'],
        'middle_name' => $_POST['middle_name'],
        'last_name' => $_POST['last_name'],
        'age' => $_POST['age'],
        'gender' => $_POST['gender'],
        'address' => $_POST['address'],
        'position' => $_POST['position'],
        'salary' => $_POST['salary']
    ];

    if ($facultyModel->addFaculty($data)) {
        header("Location: ../view/faculty.php"); 
        exit();
    } else {
        die("Failed to add faculty.");
    }
}

if (isset($_GET["delete"])) {
    $id = intval($_GET["delete"]); 
    if ($facultyModel->deleteFaculty($id)) {
        header("Location: ../view/faculty.php");
        exit();
    } else {
        die("Failed to delete faculty.");
    }
}