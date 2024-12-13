<?php
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
            <div class="input-group">
            <label for="course">Role:</label>
            <select id="role" name="role" required>
            <!-- <option value="">Select a role</option> -->
            <option value="office">Office</option>
            <option value="admin">Admin</option>
          

            <!-- <option value="">Select a course</option> -->


             <?php
             if ($courseResult->num_rows > 0) {
                   // Loop through the result set
                   while ($row = $courseResult->fetch_assoc()) {
                   // Use the course name as both the value and the text displayed in the option
                   echo "<option value='" . $row["courses"] . "'>"?> <?php echo $row['courses'];?> <?php "</option>";
                  }
             } else {
                   echo "<option value=''>No courses available</option>";
                }
                ?>
            </select>



            </div>

            <!-- <div class="input-group">
                    <label for="term">Class :</label>
                    <input type="number" min=0 max=20 name="class" id="class" >
            </div> -->
           
           
           
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
