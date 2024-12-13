<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set JSON content type
header('Content-Type: application/json');

// Database connection
require "connection.php";

// Check if course and class are provided
if (isset($_POST['course']) && isset($_POST['class'])) {
    $course = $_POST['course'];
    $class = $_POST['class'];

    // Fetch distinct classes based on the selected course
    $classesQuery = "SELECT DISTINCT classes FROM course_names WHERE courses = ?";
    $stmt = $conn->prepare($classesQuery);
    $stmt->bind_param("s", $course);
    $stmt->execute();
    $classesResult = $stmt->get_result();
    $classes = [];
    while ($row = $classesResult->fetch_assoc()) {
        $classes[] = $row['classes']; // Ensure this matches your database column
    }

    // Fetch distinct levels based on the selected course and class
    $levelsQuery = "SELECT DISTINCT level FROM course_names WHERE courses = ? AND classes = ?";
    $stmt = $conn->prepare($levelsQuery);
    $stmt->bind_param("ss", $course, $class);
    $stmt->execute();
    $levelsResult = $stmt->get_result();
    $levels = [];
    while ($row = $levelsResult->fetch_assoc()) {
        $levels[] = $row['level']; // Ensure this matches your database column
    }

    // Send classes and levels as JSON
    echo json_encode(['classes' => $classes, 'levels' => $levels]);

} else {
    // Handle missing course or class parameters
    echo json_encode(['error' => 'Both course and class must be specified']);
}
?>
