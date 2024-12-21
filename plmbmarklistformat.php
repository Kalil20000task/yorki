<?php
session_start(); // Start session management

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();

}
require "connection.php";


$course = isset($_GET['course']) ? htmlspecialchars($_GET['course']) : 'N/A';
$classname = isset($_GET['class']) ? htmlspecialchars($_GET['class']) : 'N/A';
$term = isset($_GET['term']) ? htmlspecialchars($_GET['term']) : 'N/A';
$level = isset($_GET['level']) ? preg_replace('/[^a-zA-Z0-9]/', '', $_GET['level']) : null;


$tablename="class".$course."c".$classname;
$classtablename="class".$course.$level."c".$classname."marklist";
$sql = "SELECT studentname FROM $tablename";
$studentResult = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACFNS Term 1 Mark Input</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: url('images/ice.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }
        .container {
            background: rgba(0, 0, 0, 0.8);
            border-radius: 8px;
            padding: 20px;
            /* max-width: 800px; */
            margin: 50px auto;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
            display: flex;
            flex-direction: column;
            width: 80%;
        }
        .container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .input-group-wrapper {
           display: flex;
           justify-content: space-between; /* Space between the two fields */
             margin-bottom: 15px; /* Space between the rows */
           }
        .input-group {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column; /* Stack the label and input vertically within each pair */
            flex: 1; /* Allow each group to take equal space */
            margin-left: 20px; /* Space between the two groups */
            padding-right: 30px;
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
        .input-group select, .input-group button {
            width: 100%;
            padding: 10px;
            border: 1px solid #555;
            border-radius: 5px;
            background-color: #444;
            color: #fff;
            font-size: 16px;
        }
        .buttons {
            display: flex;
            /* justify-content: space-between; */
            justify-content: center;  /* Centers the content horizontally */

        }
        .buttons button {
            width: 48%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .buttons .submit {
            background-color: #007bff;
            color: #fff;
            /* justify-content: center;  Centers the content horizontally */


        }
        .buttons .reset {
            background-color: red;
            color: #fff;
        }
    </style>
 
</head>
<body>
<?php
    include "header.php";
    ?>
<div class="container">
    <h2><?php echo $course . "_C" . $classname . "_term" . $term ?></h2>

    <!-- <div class="input-group">
        <label for="studentName">Student's Name</label>
        <input type="text" id="studentName" placeholder="Enter student's name" required>
    </div> -->

    <div class="input-group">
            <label for="studentName">Student's Name:</label>
            <select id="studentName" name="studentName" required>
            <option value="">Select a Student</option>

             <?php
             if ($studentResult->num_rows > 0) {
                   // Loop through the result set
                   while ($row = $studentResult->fetch_assoc()) {
                   // Use the course name as both the value and the text displayed in the option
                   echo "<option value='" . $row["studentname"] . "'>"?> <?php echo $row['studentname'];?> <?php "</option>";
                  }
             } else {
                   echo "<option value=''>No student available available</option>";
                }
                ?>
            </select>



            </div>

    <div class="input-group-wrapper">
        <div class="input-group">
            <label for="classwork1">Classwork 1 (10)</label>
            <input type="number" id="classwork1" min="0" max="10" oninput="calculateTotal()">
        </div>
        <div class="input-group">
            <label for="classwork2">Classwork 2 (10)</label>
            <input type="number" id="classwork2" min="0" max="10" oninput="calculateTotal()">
        </div>
        
    </div>

    <div class="input-group-wrapper">
       
      <div class="input-group">
            <label for="homework1">Homework 1 (5)</label>
            <input type="number" id="homework1" min="0" max="5" oninput="calculateTotal()">
        </div>
        <div class="input-group">
            <label for="homework2">Homework 2 (5)</label>
            <input type="number" id="homework2" min="0" max="5" oninput="calculateTotal()">
        </div>
    </div>
    <div class="input-group-wrapper">
       
    <div class="input-group">
            <label for="assignment1">Assignment 1 (10)</label>
            <input type="number" id="assignment1" min="0" max="10" oninput="calculateTotal()">
        </div>
        <div class="input-group">
            <label for="assignment2">Assignment 2 (10)</label>
            <input type="number" id="assignment2" min="0" max="10" oninput="calculateTotal()">
        </div>
    </div>
    <div class="input-group-wrapper">
       
       <div class="input-group">
               <label for="finalproject">Final Project (20)</label>
               <input type="number" id="finalproject" min="0" max="20" oninput="calculateTotal()">
           </div>
           <div class="input-group">
               <label for="finalexam">Final Exam (30)</label>
               <input type="number" id="finalexam" min="0" max="30" oninput="calculateTotal()">
           </div>
       </div>
   

    <div class="input-group-wrapper">
   
        <div class="input-group">
            <label for="total-display">Total (100)</label>
            <input type="text" id="total-display" readonly>
        </div>
    </div>

    <div class="buttons">
        <button class="submit" onclick="submitMarks()">Submit</button>
        <!-- <button type="reset" class="reset">Reset</button> -->
    </div>
</div>

</body>
<script>
    // Function to calculate total marks dynamically
    function calculateTotal() {
        const classwork1 = parseFloat(document.getElementById('classwork1').value) || 0;
        const classwork2 = parseFloat(document.getElementById('classwork2').value) || 0;
        const homework1 = parseFloat(document.getElementById('homework1').value) || 0;
        const homework2 = parseFloat(document.getElementById('homework2').value) || 0;
        const Assignment1 = parseFloat(document.getElementById('assignment1').value) || 0;
        const Assignment2 = parseFloat(document.getElementById('assignment2').value) || 0;
        const finalproject = parseFloat(document.getElementById('finalproject').value) || 0;
        const finalexam = parseFloat(document.getElementById('finalexam').value) || 0;

        const total = classwork1 + classwork2 + homework1 + homework2 + Assignment1 + Assignment2 + finalproject + finalexam;

        document.getElementById('total-display').value = total.toFixed(2);
    }

    // Function to submit marks via AJAX
    function submitMarks() {
        
        const studentName = document.getElementById('studentName').value;
        const total = parseFloat(document.getElementById('total-display').value);
        const course = "<?php echo $course; ?>";
        const classname = "<?php echo $classname; ?>";

        const term = "<?php echo $term; ?>";
        const classtablename = "<?php echo $classtablename; ?>";


        if (!studentName) {
            alert("Student name is required!");
            return;
        }
 
        // Collect data to send
        const data = {
            classtablename:classtablename,

            studentName: studentName,
            course: course,
            classname: classname,
            term: term,
            classwork1: document.getElementById('classwork1').value,
            classwork2: document.getElementById('classwork2').value,
            homework1: document.getElementById('homework1').value,
            homework2: document.getElementById('homework2').value,
            Assignment1: document.getElementById('assignment1').value,
            Assignment2: document.getElementById('assignment2').value,
            finalproject: document.getElementById('finalproject').value,
            
            finalexam: document.getElementById('finalexam').value,
            total: total,
        };
        // alert("till here");
        // AJAX POST request
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "plmbmarkinserter.php", true);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                alert(xhr.responseText);
                document.querySelector('form').reset();
                document.getElementById('total-display').value = '';
            }
        };
        xhr.send(JSON.stringify(data));
    }
</script>

</html>