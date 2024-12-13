<?php
require "connection.php";

// Initialize response array
$response = [];

// Check if course is selected
if (isset($_POST['course'])) {
    $course = $_POST['course'];

    // Fetch classes based on the selected course
    if (isset($_POST['class']) && $_POST['class']) {
        $class = $_POST['class'];
        // Fetch terms based on the selected course and class
        $sqlTerms = "SELECT DISTINCT terms FROM course_names WHERE courses = ? AND classes = ?";
        $stmt = $conn->prepare($sqlTerms);
        $stmt->bind_param("ss", $course, $class);
        $stmt->execute();
        $resultTerms = $stmt->get_result();
        $terms = [];
        while ($row = $resultTerms->fetch_assoc()) {
            $terms[] = $row['terms'];
        }
        $response['terms'] = $terms;

        // Fetch levels based on the selected course and class
        $sqlLevels = "SELECT DISTINCT level FROM course_names WHERE courses = ? AND classes = ?";
        $stmt = $conn->prepare($sqlLevels);
        $stmt->bind_param("ss", $course, $class);
        $stmt->execute();
        $resultLevels = $stmt->get_result();
        $levels = [];
        while ($row = $resultLevels->fetch_assoc()) {
            $levels[] = $row['level'];
        }
        $response['levels'] = $levels;
    }

    // Fetch classes based on the selected course
    $sqlClasses = "SELECT DISTINCT classes FROM course_names WHERE courses = ?";
    $stmt = $conn->prepare($sqlClasses);
    $stmt->bind_param("s", $course);
    $stmt->execute();
    $resultClasses = $stmt->get_result();
    $classes = [];
    while ($row = $resultClasses->fetch_assoc()) {
        $classes[] = $row['classes'];
    }
    $response['classes'] = $classes;
}

echo json_encode($response);
?>
