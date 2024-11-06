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
        $_SESSION['username'] = $user; // Set session variable
        header('Location: index.php'); // Redirect to index page
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

        .login-container {
            background-color: rgba(255, 255, 255, 0.6); /* Light background with transparency */
            backdrop-filter: blur(10px); /* Blur effect for better visibility against background */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 300px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
            color: #333; /* Darker text color for better contrast */
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: rgba(255, 255, 255, 0.8); /* Light background for inputs with some transparency */
        }

        .login-container button {
            background-color: #007bff; /* Primary blue color */
            color: white;
            padding: 12px 20px;
            margin: 10px 0;
            border: none;
            cursor: pointer;
            width: 100%;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .login-container button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
        
        .title {
            font-size: 48px; /* Large font size */
            color: #5a3e36; /* Dark brown color */
            margin-bottom: 30px; /* Space below the title */
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Slight shadow for depth */
            font-family: 'Georgia', serif; /* Different font style */
            position: absolute; /* Position it on the background */
            top: 10%; /* Adjust top position as needed */
        }
    </style>
</head>
<body>
<div class="title">DALIA IceWorks</div> <!-- Styled title on the background -->

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
