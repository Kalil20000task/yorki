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
    <link href="menustyle.css" rel="stylesheet">
</head>
<body>
<?php include "header.php"; ?>
<div class="container">
<div class="text-center" style="display: flex; align-items: center; justify-content: center; gap: 0;">
    <img src="images/logo.png" alt="Logo" style="width: 69px; height: auto; margin: 0;">
    <h2 style="margin: 0; line-height: 1;">Select a course</h2>
</div>

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
                    while ($row = $courseResult->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row["courses"]) . "'>" . htmlspecialchars($row['courses']) . "</option>";
                    }
                } else {
                    echo "<option value=''>No courses available</option>";
                }
                ?>
            </select>
        </div>
        <div class="input-group">
            <label for="class">Class:</label>
            <input type="number" min="0" max="20" name="class" id="class" placeholder="Enter class level">
        </div>
        <div class="input-group">
            <label for="level">Level Name:</label>
            <select id="level" name="level">
                <option value="">Select level only for English course</option>
                <option value="A0">A0</option>
                <option value="A1">A1</option>
                <option value="A2">A2</option>
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
        e.preventDefault();
        const formData = new FormData(this);
        fetch("process.php", {
            method: "POST",
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    alert(data.message);
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(error => {
                alert("An unexpected error occurred: " + error.message);
            });
    });
</script>
</body>
</html>
