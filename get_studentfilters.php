<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $courseFilter = $_POST['course'];
    $query = "SELECT DISTINCT classes FROM course_names WHERE courses = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $courseFilter);
    $stmt->execute();
    $result = $stmt->get_result();



    // $courseFilter = $_POST['course'] ?? '';
    // // $classFilter = $_POST['class'] ?? '';
   
    // // Fetch courses
    // if ($courseFilter !='') {
    //     $sql = "SELECT distinct classes from course_names where courses= '$courseFilter'";
       
    // } else {
    //     // $sql = "SELECT DISTINCT courses FROM course_names";
    // }
    // $stmt = $conn->prepare($sql);
    // // if ($courseFilter) {
    // //     $stmt->bind_param('s', $courseFilter);
    // // }
    // $stmt->execute();
    // $result = $stmt->get_result();
    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = $row['classes'];
    }
    echo json_encode(['students' => $students]);
}
?>