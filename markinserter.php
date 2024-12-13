<?php
session_start(); // Start session management

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo "You are not logged in!";
    exit();
}
require "connection.php";

// Retrieve JSON data sent by AJAX
$data = json_decode(file_get_contents("php://input"), true);

// Check if data is received
if (isset($data['studentName'])) {
    $classtablename = $data['classtablename'];
    $studentName = $data['studentName'] ?? ''; // Assuming studentName is required, default to empty string
    $course = $data['course'] ?? '';
    $level = $data['level'] ?? '';
    $classname = $data['classname'] ?? '';
    $term = $data['term'] ?? '';
    $classwork1 = !empty($data['classwork1']) ? $data['classwork1'] : 0;
    $classwork2 = !empty($data['classwork2']) ? $data['classwork2'] : 0;
    $test1 = !empty($data['test1']) ? $data['test1'] : 0;
    $test2 = !empty($data['test2']) ? $data['test2'] : 0;
    $groupAssignment1 = !empty($data['groupAssignment1']) ? $data['groupAssignment1'] : 0;
    $groupAssignment2 = !empty($data['groupAssignment2']) ? $data['groupAssignment2'] : 0;
    $participation = !empty($data['participation']) ? $data['participation'] : 0;
    $attendance = !empty($data['attendance']) ? $data['attendance'] : 0;
    $finalExam = !empty($data['finalExam']) ? $data['finalExam'] : 0;

    // Get current date
    $currentDate = date('Y-m-d'); // Current date in Y-m-d format

    // Calculate total marks (for example, sum of all marks)
    $totalMarks = $classwork1 + $classwork2 + $test1 + $test2 + $groupAssignment1 + $groupAssignment2 + $participation + $attendance + $finalExam;

    // Check if the table exists
    $checkTableQuery = "SHOW TABLES LIKE '$classtablename'";
    $result = $conn->query($checkTableQuery);

    if ($result->num_rows === 0) {
        // Table does not exist
        echo "Table `$classtablename` does not exist. Do you want to create it?";
        // If user confirms (assuming client-side will handle the confirmation via AJAX):
        // Create the table
        $createTableQuery = "CREATE TABLE `$classtablename` (
            id INT AUTO_INCREMENT PRIMARY KEY,
            student_name VARCHAR(100) NOT NULL,
            course_name VARCHAR(255) NOT NULL,
            level VARCHAR(255) NOT NULL,
            class VARCHAR(255) NOT NULL,
            term VARCHAR(100) NOT NULL,
            classwork1 INT DEFAULT 0,
            classwork2 INT DEFAULT 0,
            test1 INT DEFAULT 0,
            test2 INT DEFAULT 0,
            group_assignment1 INT DEFAULT 0,
            group_assignment2 INT DEFAULT 0,
            participation INT DEFAULT 0,
            attendance INT DEFAULT 0,
            final_exam INT DEFAULT 0,
            total INT DEFAULT 0,
            date DATE NOT NULL,
            UNIQUE(student_name, term)
        )";

        if ($conn->query($createTableQuery) === TRUE) {
            echo "Table `$classtablename` created successfully.";
        } else {
            echo "Error creating table: " . $conn->error;
            exit();
        }
    }

    // Insert data into the table
    $insertQuery = "INSERT INTO `$classtablename`
                    (student_name, course_name, level, class, term, classwork1, classwork2, test1, test2, group_assignment1, group_assignment2, participation, attendance, final_exam, total, date) 
                    VALUES 
                    ('$studentName', '$course','$level','$classname', '$term', '$classwork1', '$classwork2', '$test1', '$test2', '$groupAssignment1', '$groupAssignment2', '$participation', '$attendance', '$finalExam', '$totalMarks', '$currentDate')";
if ($conn->query($insertQuery) === TRUE) {
    echo "New record created successfully.";
} else {
    if ($conn->errno === 1062) { // Duplicate entry error code
        echo "Duplicate entry found for student: $studentName and term: $term.";
    } else {
        echo "Error: " . $insertQuery . "<br>" . $conn->error;
    }
}
} else {
    echo "No data received!";
}

// Close the connection
$conn->close();
?>
