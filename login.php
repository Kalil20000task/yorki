<?php
session_start();
$servername = "localhost";
$username = "root"; // Update with your database username
$password = ""; // Update with your database password
$dbname = "trainup"; // Update with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login
$errorMessage = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Fetch user from database
    $sql = "SELECT * FROM tbl_users WHERE username = '$user' AND password = '$pass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc(); // Fetch user data
        $_SESSION['username'] = $user; // Set session variable for username
        $_SESSION['role'] = $userData['role']; // Set session variable for role


        // $_SESSION['username'] = $user; // Set session variable
        header('Location: studentlist.php'); // Redirect to index page
        exit();
    } else {
        $errorMessage = 'Invalid username or password!';
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="cssstyle.css">

    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url('images/ice.jpg') no-repeat center center fixed; /* Update with your ice-themed image path */
            background-size: cover;
        }

    </style>
</head>
<body>
<div class="title">Train Up</div> <!-- Styled title on the background -->

    <div class="login-container">
        <h2>Login</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <?php if ($errorMessage): ?>
                <div class="error-message"><?php echo $errorMessage; ?></div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
