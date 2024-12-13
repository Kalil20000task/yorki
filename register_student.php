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
        <h2>Select a Course</h2>
        <form id="studentForm">
             <div class="input-group">
                <label for="studentName">Student's Name</label>
                <input type="text" name="studentName" id="studentName" placeholder="Enter student's name" required>
             </div>
            <div class="input-group">
            <label for="course">Course Name:</label>
            <select id="course" name="course" required>
            <option value="">Select a course</option>

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

            <div class="input-group">
                    <label for="term">Class :</label>
                    <input type="number" min=0 max=20 name="class" id="class" >
            </div>
            <div class="input-group">
            <label for="course">Level Name:</label>
            <select id="course" name="level">
            <option value="">Select level only for English course</option>
            <option value="A0">A0</option>
            <option value="A1">A1</option>

            <option value="A2">A2</option>

            <option value="A3">A3</option>

            <option value="B1">B1</option>

            <option value="B2">B2</option>

            <option value="B3">B3</option>



            </select>



            </div>
           
           
            <div class="input-group">
                <button class="btn" type="submit">Register Student</button>
            </div>
        </form>
    </div>
    
    <script>
        document.getElementById("studentForm").addEventListener("submit", function (e) {
            e.preventDefault(); // Prevent form submission

            // Collect form data
            const formData = new FormData(this);

            // Send data using fetch
            fetch("process.php", {
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
