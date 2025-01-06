<?php
session_start(); // Start session management

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();

}
require "connection.php";


$course = isset($_GET['course']) ? preg_replace('/[^a-zA-Z0-9]/', '', $_GET['course']) : null;
$classname = isset($_GET['class']) ? preg_replace('/[^a-zA-Z0-9]/', '', $_GET['class']) : null;
$level = isset($_GET['level']) ? preg_replace('/[^a-zA-Z0-9]/', '', $_GET['level']) : null;
$term = isset($_GET['term']) ? preg_replace('/[^a-zA-Z0-9]/', '', $_GET['term']) : null;



// Check if all parameters are valid
if ($course && $classname && $level) {
    // Construct the table name
    $tablename = "class" . $course . $level . "c" . $classname;
    $classtablename="class".$course.$level."c".$classname."marklist";

    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT studentname FROM `$tablename`");
    if ($stmt) {
        $stmt->execute();
        $studentResult = $stmt->get_result();
    } else {
        echo "Invalid table name or query.";
    }
} else {
    echo "Invalid parameters provided.";
}
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
    <h2><?php echo $course."_".$level . "_C".$classname . "_term" . $term ?></h2>

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
            <label for="speakingskills">Speaking Skills (20)</label>
            <input type="number" id="speakingskills" min="0" max="20" oninput="calculateTotal()">
        </div>
        <div class="input-group">
            <label for="writingskills">Writing Skills (15)</label>
            <input type="number" id="writingskills" min="0" max="15" oninput="calculateTotal()">
        </div>
        
       
    </div>

    <div class="input-group-wrapper">
    <div class="input-group">
            <label for="listeningskills">Listening Skills (20)</label>
            <input type="number" id="listeningskills" min="0" max="20" oninput="calculateTotal()">
        </div>
        
        <div class="input-group">
            <label for="readingskills">Reading Skills (15)</label>
            <input type="number" id="readingskills" min="0" max="15" oninput="calculateTotal()">
        </div>
    </div>

    <div class="input-group-wrapper">
    <div class="input-group">
            <label for="grammar">Grammar/Vocabulary (20)</label>
            <input type="number" id="grammar" min="0" max="20" oninput="calculateTotal()">
        </div>
   
        <div class="input-group">
            <label for="participation">Participation (10)</label>
            <input type="number" id="participation" min="0" max="10" oninput="calculateTotal()">
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
        const speakingskills = parseFloat(document.getElementById('speakingskills').value) || 0;
        const readingskills = parseFloat(document.getElementById('readingskills').value) || 0;
        const writingskills = parseFloat(document.getElementById('writingskills').value) || 0;
        const listeningskills = parseFloat(document.getElementById('listeningskills').value) || 0;
        const grammar = parseFloat(document.getElementById('grammar').value) || 0;
        // const panctuality = parseFloat(document.getElementById('panctuality').value) || 0;
        const participation = parseFloat(document.getElementById('participation').value) || 0;
        // const attendance = parseFloat(document.getElementById('attendance').value) || 0;
        // const homework = parseFloat(document.getElementById('homework').value) || 0;
        // const discipline= parseFloat(document.getElementById('discipline').value) || 0;
        // const finalExam = parseFloat(document.getElementById('finalExam').value) || 0;


        const total = speakingskills + readingskills + writingskills + listeningskills + grammar + participation ;

        document.getElementById('total-display').value = total.toFixed(2);
    }

    // Function to submit marks via AJAX
    function submitMarks() {

        const studentName = document.getElementById('studentName').value;
        const total = parseFloat(document.getElementById('total-display').value);
        const course = "<?php echo $course; ?>";
        const classname = "<?php echo $classname; ?>";
        const level = "<?php echo $level; ?>";
        const term = "<?php echo $term; ?>";
        const classtablename="<?php echo $classtablename; ?>";

        if (!studentName) {
            alert("Student name is required!");
            return;
        }

        // Collect data to send
        const data = {
            classtablename:classtablename,
            studentName: studentName,
            course: course,
            level:level,
            classname: classname,
            term: term,
            speakingskills: document.getElementById('speakingskills').value,
            readingskills: document.getElementById('readingskills').value,
            writingskills: document.getElementById('writingskills').value,
            listeningskills: document.getElementById('listeningskills').value,
            grammar: document.getElementById('grammar').value,
            // panctuality: document.getElementById('panctuality').value,
            participation: document.getElementById('participation').value,
            // attendance: document.getElementById('attendance').value,
            // finalExam: document.getElementById('finalExam').value,
            // homework: document.getElementById('homework').value,
            // discipline:document.getElementById('discipline').value,
            total: total,
            // tablename:"acfns_term1",
        };

        // AJAX POST request
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "french25markinserter.php", true);
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
