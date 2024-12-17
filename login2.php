<?php
session_start();
require("connection.php");

// Initialize errorMessage to avoid "undefined variable" notice
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Assuming you have already established a database connection in $conn

    // Prepare the SQL statement
    $sql2 = "SELECT r.role_name
             FROM Roles r
             JOIN UserRoles ur ON r.role_id = ur.role_id
             JOIN Users u ON ur.user_id = u.user_id
             WHERE u.username = ?";

    if ($stmt = $conn->prepare($sql2)) {
        // Bind the username variable to the prepared statement
        $stmt->bind_param("s", $user);

        // Execute the statement
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Check if a user was found
        if ($result->num_rows > 0) {
            $roles = [];
    
            // Fetch all roles for the user
            while ($row = $result->fetch_assoc()) {
                $roles[] = $row['role_name']; // Add each role to the array
            }
        
            // Display the roles for debugging
            echo "Roles: " . implode(", ", $roles) . "<br>";
        
            // Store roles in the session
            $_SESSION['role'] = $roles;
            $_SESSION['username'] = $user; // Set session variable
        header('Location: studentlist.php'); // Redirect to index page
        // exit();
           
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
