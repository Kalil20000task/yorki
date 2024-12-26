<?php
session_start();
include("connection.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize errorMessage to avoid "undefined variable" notice
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Query to check if the username exists and fetch the password and user ID
    $sql = "SELECT u.user_id, u.password 
            FROM users u 
            WHERE u.username = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the username variable to the prepared statement
        $stmt->bind_param("s", $user);

        // Execute the statement
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Check if the username exists
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Verify the provided password against the stored password
            if ($pass== $row['password']) {
                $userId = $row['user_id'];

                // Query to fetch roles for the user
                $sql2 = "SELECT r.role_name
                         FROM roles r
                         JOIN userroles ur ON r.role_id = ur.role_id
                         WHERE ur.user_id = ?";
                
                if ($stmt2 = $conn->prepare($sql2)) {
                    // Bind the user ID to the prepared statement
                    $stmt2->bind_param("i", $userId);

                    // Execute the statement
                    $stmt2->execute();

                    // Get the result
                    $result2 = $stmt2->get_result();
                    $roles = [];

                    // Fetch all roles for the user
                    while ($roleRow = $result2->fetch_assoc()) {
                        $roles[] = $roleRow['role_name'];
                    }

                    // Store roles and username in the session
                    $_SESSION['role'] = $roles;
                    $_SESSION['username'] = $user;

                    // Redirect to the student list page
                    header('Location: studentlist.php');
                    exit();
                } else {
                    $errorMessage = 'Error fetching roles: ' . $conn->error;
                }
            } else {
                $errorMessage = 'Invalid username or password!';
            }
        } else {
            $errorMessage = 'Invalid username or password!';
        }

        // Close the statement
        $stmt->close();
    } else {
        $errorMessage = 'Error preparing SQL statement: ' . $conn->error;
    }
}

// Close the connection (if needed)
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
            background: url('images/ice.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .error-message {
            color: red;
            margin-top: 10px;
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
