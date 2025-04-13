<?php
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $token = bin2hex(random_bytes(50));

        $updateQuery = "UPDATE users SET reset_token=? WHERE email=?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();
        $message = "Password reset link: <a href='reset_password.php?token=$token' class='text-blue-600 hover:text-blue-800'>Reset Password</a>";
    } else {
        $error = "No account found with that email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold text-center mb-6 text-gray-800">Forgot Password</h1>
        
        <?php if(isset($error)): ?>
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-md">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <?php if(isset($message)): ?>
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-md">
                <?php echo $message; ?>
            </div>
        <?php else: ?>
            <form method="POST" class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" name="email" id="email" placeholder="Enter your email" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <button type="submit" 
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Send Reset Link
                </button>
            </form>
        <?php endif; ?>
        
        <div class="mt-4 text-center">
            <a href="login.php" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                Back to Login
            </a>
        </div>
    </div>
</body>
</html>