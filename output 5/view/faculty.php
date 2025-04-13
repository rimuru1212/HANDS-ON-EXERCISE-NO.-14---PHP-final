<?php
include '../includes/db.php';
include '../model/FacultyModel.php';
$facultyModel = new FacultyModel($conn);
$facultyList = $facultyModel->getAllFaculty();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <?php include '../includes/header.php'; ?>

    <div class="container mx-auto mt-5">
        <h2 class="text-2xl font-bold mt-6">Add Faculty</h2>
        <form action="../controller/FacultyController.php" method="POST" class="bg-white p-6 shadow-md rounded">
            <input type="text" name="first_name" placeholder="First Name" required class="border p-2 w-full mb-2">
            <input type="text" name="middle_name" placeholder="Middle Name" class="border p-2 w-full mb-2">
            <input type="text" name="last_name" placeholder="Last Name" required class="border p-2 w-full mb-2">
            <input type="number" name="age" placeholder="Age" required class="border p-2 w-full mb-2">
            <select name="gender" required class="border p-2 w-full mb-2">
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
            <input type="text" name="address" placeholder="Address" required class="border p-2 w-full mb-2">
            <input type="text" name="position" placeholder="Position" required class="border p-2 w-full mb-2">
            <input type="number" name="salary" step="0.01" placeholder="Salary" required class="border p-2 w-full mb-2">
            <button type="submit" name="add" class="bg-indigo-600 text-white p-2 rounded">Add Faculty</button>
            <a href="../index.php" class="bg-indigo-600 text-white p-2 py-2 px-4 rounded">
                Back
            </a>
        </form>

        <h2 class="text-2xl font-bold mb-4">Faculty List</h2>
        <table class="table-auto w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2">First Name</th>
                    <th class="px-4 py-2">Middle Name</th>
                    <th class="px-4 py-2">Last Name</th>
                    <th class="px-4 py-2">Age</th>
                    <th class="px-4 py-2">Gender</th>
                    <th class="px-4 py-2">Address</th>
                    <th class="px-4 py-2">Position</th>
                    <th class="px-4 py-2">Salary</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($facultyList as $faculty): ?>
                    <tr>
                        <td class="border px-4 py-2"><?= $faculty['first_name']; ?></td>
                        <td class="border px-4 py-2"><?= $faculty['middle_name']; ?></td>
                        <td class="border px-4 py-2"><?= $faculty['last_name']; ?></td>
                        <td class="border px-4 py-2"><?= $faculty['age']; ?></td>
                        <td class="border px-4 py-2"><?= $faculty['gender']; ?></td>
                        <td class="border px-4 py-2"><?= $faculty['address']; ?></td>
                        <td class="border px-4 py-2"><?= $faculty['position']; ?></td>
                        <td class="border px-4 py-2"><?= $faculty['salary']; ?></td>
                        <td class="border px-4 py-2">
                            <a href="../controller/FacultyController.php?delete=<?= $faculty['id']; ?>" class="text-red-600">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>