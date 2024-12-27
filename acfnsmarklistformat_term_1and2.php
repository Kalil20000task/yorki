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
    <link href="allstyles.css" rel="stylesheet">

 
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
            <label for="classwork1">Classwork 1 (5)</label>
            <input type="number" id="classwork1" min="0" max="5" oninput="calculateTotal()">
        </div>

        
        <div class="input-group">
            <label for="classwork2">Classwork 2 (5)</label>
            <input type="number" id="classwork2" min="0" max="5" oninput="calculateTotal()">
        </div>
    </div>

    <div class="input-group-wrapper">
        <div class="input-group">
            <label for="test1">Test 1 (10)</label>
            <input type="number" id="test1" min="0" max="10" oninput="calculateTotal()">
        </div>
        <div class="input-group">
            <label for="test2">Test 2 (10)</label>
            <input type="number" id="test2" min="0" max="10" oninput="calculateTotal()">
        </div>
    </div>

    <div class="input-group-wrapper">
        <div class="input-group">
            <label for="groupAssignment1">Group Assignment 1 (5)</label>
            <input type="number" id="groupAssignment1" min="0" max="5" oninput="calculateTotal()">
        </div>
        <div class="input-group">
            <label for="groupAssignment2">Group Assignment 2 (5)</label>
            <input type="number" id="groupAssignment2" min="0" max="5" oninput="calculateTotal()">
        </div>
    </div>

    <div class="input-group-wrapper">
        <div class="input-group">
            <label for="participation">Participation (5)</label>
            <input type="number" id="participation" min="0" max="5" oninput="calculateTotal()">
        </div>
        <div class="input-group">
            <label for="attendance">Attendance (5)</label>
            <input type="number" id="attendance" min="0" max="5" oninput="calculateTotal()">
        </div>
    </div>

    <div class="input-group-wrapper">
        <div class="input-group">
            <label for="finalExam">Final Exam (50)</label>
            <input type="number" id="finalExam" min="0" max="50" oninput="calculateTotal()">
        </div>
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
        const test1 = parseFloat(document.getElementById('test1').value) || 0;
        const test2 = parseFloat(document.getElementById('test2').value) || 0;
        const groupAssignment1 = parseFloat(document.getElementById('groupAssignment1').value) || 0;
        const groupAssignment2 = parseFloat(document.getElementById('groupAssignment2').value) || 0;
        const participation = parseFloat(document.getElementById('participation').value) || 0;
        const attendance = parseFloat(document.getElementById('attendance').value) || 0;
        const finalExam = parseFloat(document.getElementById('finalExam').value) || 0;

        const total = classwork1 + classwork2 + test1 + test2 + groupAssignment1 + groupAssignment2 + participation + attendance + finalExam;

        document.getElementById('total-display').value = total.toFixed(2);
    }

    // Function to submit marks via AJAX
    function submitMarks() {
        const studentName = document.getElementById('studentName').value;
        const total = parseFloat(document.getElementById('total-display').value);
        const course = "<?php echo $course; ?>";
        const classname = "<?php echo $classname; ?>";
        const classtablename = "<?php echo $classtablename; ?>";


        const term = "<?php echo $term; ?>";
         

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
            test1: document.getElementById('test1').value,
            test2: document.getElementById('test2').value,
            groupAssignment1: document.getElementById('groupAssignment1').value,
            groupAssignment2: document.getElementById('groupAssignment2').value,
            participation: document.getElementById('participation').value,
            attendance: document.getElementById('attendance').value,
            finalExam: document.getElementById('finalExam').value,
            total: total,
        };

        // AJAX POST request
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "markinserter.php", true);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                if(xhr.responseText.includes("Duplicate")){
                    alert ("you are trying to insert a duplicate record");
                }
                else{
                    alert(xhr.responseText);

                }
                document.querySelector('form').reset();
                document.getElementById('total-display').value = '';
            }
        };
        xhr.send(JSON.stringify(data));
    }
</script>

</html>
