<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}
require "connection.php";
$sql = "SELECT DISTINCT courses FROM course_names";
$courseResult = $conn->query($sql);


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Redirect</title>
    <!-- <link rel="stylesheet" href="cssstyle.css"> -->

    <style>
        /* Copy the styles from your HTML */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('images/ice.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }
        .container {
            margin: 20px auto;
            padding: 20px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 8px;
            color: #fff;
            width: 40%;
        }
        .container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .input-group {
            margin-bottom: 15px;
        }
        .input-group label {
            display: block;
            margin-bottom: 5px;
            color: #ccc;
        }
        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #555;
            border-radius: 5px;
            font-size: 16px;
            background-color: #444;
            color: #f8f8f8;
        }
        .input-group input:focus {
            border-color: #007bff;
        }
        .buttons {
            display: flex;
            justify-content: space-between;
        }
        .buttons button {
            width: 48%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .input-group .btn {
            background-color: #007bff;
            color: #fff;
        }
        .input-group select, .input-group button {
            width: 100%;
            padding: 10px;
            border: 1px solid #555;
            border-radius: 5px;
            background-color: #444;
            color: #fff;
            font-size: 16px;
        }
        button:hover {
            opacity: 0.9;
        }

        .roles-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin: 15px;
}

.role-row {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    width: 100%;
}

.role-row label {
    width: calc(25% - 10px); /* 4 roles per row */
    box-sizing: border-box;
    margin-bottom: 10px;
}

input[type="checkbox"] {
    margin-right: 5px;
}

    </style>
</head>
<body>
<?php
    include "header.php";
    ?>
    <div class="container">
        <h2>Register Staff Members</h2>
        <form id="studentForm">
             <div class="input-group">
                <label for="fullName">Full Name</label>
                <input type="text" name="fullName" id="fullName" placeholder="Enter user's Fullname" required>
             </div>
             <div class="input-group">
                <label for="userName">User Name</label>
                <input type="text" name="userName" id="userName" placeholder="Enter username" required>
             </div>
             <div class="input-group">
                <label for="passwword">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter user's name" required>
             </div>
            <!-- <div class="input-group"> -->
            <label for="course">Role:</label>
            <div class="roles-container">
    <!-- Static roles options -->

    <!-- Dynamic course options from database -->
     <div class='role-row'>
     <label>
            <input type="checkbox" name="roles[]" value="office"> Office
        </label>
        <label>
            <input type="checkbox" name="roles[]" value="admin"> Admin
        </label>
    <?php

//here u have no worries if new roles are not included in the checkbox lists, as the 
//roles are fetched dynaically from courses table which is inturn updated when a new course is added.

    if ($courseResult->num_rows > 0) {
        $count = 2; // Initialize a counter for each row
        // Loop through the result set and generate checkboxes for each course
        while ($row = $courseResult->fetch_assoc()) {
            // Start a new row after every 4 checkboxes
            if ($count % 4 == 0 && $count > 2) {
                echo "</div><div class='role-row'>"; // Close and open a new row
            }
            echo "<label>";
            echo "<input type='checkbox' name='roles[]' value='" . $row["courses"] . "'> " . $row['courses'];
            echo "</label>";
            $count++;
        }
    } else {
        echo "<label>No courses available</label>";
    }
    ?>

            </div>
            </div>
           
           
            <div class="input-group">
                <button class="btn" type="submit">Register User</button>
            </div>
        </form>
    </div>
    
    <script>
        document.getElementById("studentForm").addEventListener("submit", function (e) {
            e.preventDefault(); // Prevent form submission

            // Collect form data
            const formData = new FormData(this);

            // Send data using fetch
            fetch("staffprocess.php", {
                method: "POST",
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        alert(data.message); // Success message
                        location.reload();
                    } else {
                        alert("Error: " + data.message); // Error message
                    }
                })
                .catch(error => {
                    alert("An unexpected error occurred: " + error.message);
                });
        });
    </script>
</body>
</html>
