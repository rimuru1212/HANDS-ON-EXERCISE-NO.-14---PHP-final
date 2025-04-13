<?php
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "SELECT * FROM users WHERE reset_token=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $updateQuery = "UPDATE users SET password=?, reset_token=NULL WHERE reset_token=?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ss", $new_password, $token);
        $stmt->execute();

        $success = "Password has been reset. <a href='login.php' class='text-blue-600 hover:text-blue-800'>Login</a>";
    } else {
        $error = "Invalid or expired token.";
    }
} elseif (isset($_GET['token'])) {
    $token = $_GET['token'];
} else {
    die("Invalid request.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold text-center mb-6 text-gray-800">Reset Your Password</h1>
        
        <?php if(isset($error)): ?>
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-md">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <?php if(isset($success)): ?>
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-md">
                <?php echo $success; ?>
            </div>
        <?php else: ?>
            <form method="POST" class="space-y-4">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter your new password" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <button type="submit" 
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Reset Password
                </button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>