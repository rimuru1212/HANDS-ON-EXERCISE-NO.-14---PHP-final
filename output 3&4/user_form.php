<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_id'])) {
        // Handle record deletion
        $delete_id = $_POST['delete_id'];
        $sql = "DELETE FROM records WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $delete_id, $user_id);
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Record deleted successfully!";
        } else {
            $_SESSION['error_message'] = "Error deleting record: " . $conn->error;
        }
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } 
    elseif (isset($_POST['update_id'])) {
        $update_id = $_POST['update_id'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $contact = $_POST['contact'];

        $sql = "UPDATE records SET age=?, gender=?, email=?, address=?, contact=? WHERE id=? AND user_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssii", $age, $gender, $email, $address, $contact, $update_id, $user_id);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Record updated successfully!";
        } else {
            $_SESSION['error_message'] = "Error updating record: " . $conn->error;
        }
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
    else {
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $contact = $_POST['contact'];

        $sql = "INSERT INTO records (user_id, age, gender, email, address, contact) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iissss", $user_id, $age, $gender, $email, $address, $contact);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Record added successfully!";
        } else {
            $_SESSION['error_message'] = "Error: " . $conn->error;
        }
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
}

$records = [];
$sql = "SELECT * FROM records WHERE user_id = ? ORDER BY id DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $records[] = $row;
}

$editing = false;
$edit_record = null;
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    foreach ($records as $record) {
        if ($record['id'] == $edit_id) {
            $editing = true;
            $edit_record = $record;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Records</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this record?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-6 overflow-hidden">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">User Information Form</h1>
        
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-8">
            <?php if ($editing): ?>
                <input type="hidden" name="update_id" value="<?php echo $edit_record['id']; ?>">
                <div class="mb-4 bg-yellow-100 p-3 rounded">
                    <p class="text-yellow-800 font-bold">Editing Record ID: <?php echo $edit_record['id']; ?></p>
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="text-blue-500 text-sm">Cancel Edit</a>
                </div>
            <?php endif; ?>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="age">
                    Age
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                       type="number" name="age" placeholder="Age" 
                       value="<?php echo $editing ? $edit_record['age'] : ''; ?>" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">
                    Gender
                </label>
                <div class="flex items-center space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" class="form-radio" name="gender" value="male" 
                            <?php echo ($editing && $edit_record['gender'] == 'male') ? 'checked' : ''; ?> required>
                        <span class="ml-2">Male</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" class="form-radio" name="gender" value="female" 
                            <?php echo ($editing && $edit_record['gender'] == 'female') ? 'checked' : ''; ?> required>
                        <span class="ml-2">Female</span>
                    </label>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Email
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                       type="email" name="email" placeholder="Email" 
                       value="<?php echo $editing ? $edit_record['email'] : ''; ?>" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="address">
                    Address
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                          name="address" placeholder="Address" rows="3" required><?php echo $editing ? $edit_record['address'] : ''; ?></textarea>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="contact">
                    Contact Number
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                       type="text" name="contact" placeholder="Contact Number" 
                       value="<?php echo $editing ? $edit_record['contact'] : ''; ?>" required>
            </div>
            
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
                        type="submit">
                    <?php echo $editing ? 'Update Record' : 'Add Record'; ?>
                </button>
                <a href="index.php" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Back
                </a>
            </div>
        </form>
        
        <h2 class="text-xl font-bold text-gray-800 mb-4">List of Registered Persons</h2>
        <div class="bg-white shadow-md rounded overflow-hidden">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Age</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Gender</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Address</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Contact</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $record): ?>
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo $record['age']; ?></td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo $record['gender']; ?></td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo $record['email']; ?></td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo $record['address']; ?></td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo $record['contact']; ?></td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <a href="?edit=<?php echo $record['id']; ?>" class="text-blue-500 hover:text-blue-700 mr-3">Edit</a>
                                <form id="delete-form-<?php echo $record['id']; ?>" method="POST" style="display: inline;">
                                    <input type="hidden" name="delete_id" value="<?php echo $record['id']; ?>">
                                    <a href="#" onclick="confirmDelete(<?php echo $record['id']; ?>)" class="text-red-500 hover:text-red-700">Delete</a>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($records)): ?>
                        <tr>
                            <td colspan="6" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">No records found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>