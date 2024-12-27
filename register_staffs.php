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

     <link href="menustyle.css" rel="stylesheet">
</head>
<body>
<?php
    include "header.php";
    ?>
    <div class="container">
    <div class="text-center" style="display: flex; align-items: center; justify-content: center; gap: 10px;">
    <img src="images/logo.png" alt="Logo" style="width: 69px; height: auto;">
    <h2 style="margin: 0;">Register Staff Members</h2>
</div>
      
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
                <button class="btn" type="submit" style="background-color: #ec971f;">Register User</button>
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
