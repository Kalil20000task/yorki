<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}
require "connection.php";
if (!isset($_SESSION['role'])) {
    die("No roles found in session."); // Debug message
}

$roles = $_SESSION['role'];
if (in_array('admin', $roles)) {
    $sql = "SELECT DISTINCT courses FROM course_names";
    $result = $conn->query($sql);

// Fetch the results
$courses = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row['courses'];
    }
} else {
    echo "No courses found.";
}
}
elseif (in_array('office', $roles)) {
$sql = "SELECT DISTINCT courses FROM course_names";
$result = $conn->query($sql);

// Fetch the results
$courses = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row['courses'];
    }
} else {
    echo "No courses found.";
}
}

else{
    $placeholders = rtrim(str_repeat('?, ', count($roles)), ', ');

    // Create the SQL query
    $sql = "SELECT DISTINCT courses 
            FROM course_names 
            WHERE courses IN ($placeholders)";


// $result = $conn->query($sql);
// $courses = [];
// while ($row = $result->fetch_assoc()) {
//     $courses[] = $row['courses'];
// }


if ($stmt = $conn->prepare($sql)) {
    // Bind the roles array to the statement dynamically
    $types = str_repeat('s', count($roles)); // The types for bind_param (string for each role)
        $stmt->bind_param($types, ...$roles); // Bind the roles dynamically

        // Execute the statement
        $stmt->execute();

    // Get the results
    $result = $stmt->get_result();

    // Fetch and display the matching courses
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $courses[] = $row['courses'];
        }
    } else {
        echo "No matching courses found.";
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Error preparing the SQL statement: " . $conn->error;
}
}?>