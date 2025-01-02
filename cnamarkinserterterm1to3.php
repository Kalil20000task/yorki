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
    // $classwork1 = !empty($data['classwork1']) ? $data['classwork1'] : 0;
    // $classwork2 = !empty($data['classwork2']) ? $data['classwork2'] : 0;
    $test1 = !empty($data['test1']) ? $data['test1'] : 0;
    $test2 = !empty($data['test2']) ? $data['test2'] : 0;
    $Assignment1 = !empty($data['assignment1']) ? $data['assignment1'] : 0;
    $Assignment2 = !empty($data['assignment2']) ? $data['assignment2'] : 0;
    $Assignment3 = !empty($data['assignment3']) ? $data['assignment3'] : 0;
    $Assignment4 = !empty($data['assignment4']) ? $data['assignment4'] : 0;

    $Assignment5 = !empty($data['assignment5']) ? $data['assignment5'] : 0;
    $groupdiscussion = !empty($data['groupdiscussion']) ? $data['groupdiscussion'] : 0;


    
    

    // $GroupAssignment = !empty($data['GroupAssignment']) ? $data['GroupAssignment'] : 0;
    // $attendance = !empty($data['attendance']) ? $data['attendance'] : 0;
    // $finalexam = !empty($data['finalexam']) ? $data['finalexam'] : 0;
    $total = !empty($data['total']) ? $data['total'] : 0;

    // Get current date
    $currentDate = date('Y-m-d'); // Current date in Y-m-d format

    // Calculate total marks (for example, sum of all marks)
    // $totalMarks =  $test1 + $test2 + $Assignment1 + $Assignment2 + $GroupAssignment + $attendance + $finalexam;

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
           
            class VARCHAR(255) NOT NULL,
            term VARCHAR(100) NOT NULL,
          
            test1 DECIMAL(10,1) DEFAULT 0,
            test2 DECIMAL(10,1) DEFAULT 0,
            Assignment1 DECIMAL(10,1) DEFAULT 0,
            Assignment2 DECIMAL(10,1) DEFAULT 0,
            Assignment3 DECIMAL(10,1) DEFAULT 0,
            Assignment4 DECIMAL(10,1) DEFAULT 0,
            Assignment5 DECIMAL(10,1) DEFAULT 0,
            groupdiscussion DECIMAL(10,1) DEFAULT 0,
            total DECIMAL(10,1) DEFAULT 0,
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
                    (student_name, course_name, class, term, test1, test2, Assignment1, Assignment2,Assignment3,Assignment4,Assignment5 ,groupdiscussion, total, date) 
                    VALUES 
                    ('$studentName', '$course','$classname', '$term', '$test1', '$test2', '$Assignment1', '$Assignment2','$Assignment3', '$Assignment4','$Assignment5' ,'$groupdiscussion', '$total', '$currentDate')";
if ($conn->query($insertQuery) === TRUE) {
    echo "New record created successfully.";
} else {
    if ($conn->errno === 1062) { // Duplicate entry error code
        echo "Duplicate entry found for student: $studentName and term: $term.";
    } else {
        echo "Error: ";
    }
}
} else {
    echo "No data received!";
}

// Close the connection
$conn->close();
?>
