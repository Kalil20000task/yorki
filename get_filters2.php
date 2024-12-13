<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $courseFilter = $_POST['course'] ?? '';
    $classFilter = $_POST['class'] ?? '';
    $levelFilter = $_POST['level'] ?? '';

    // Fetch courses
    if ($courseFilter == '') {
        $sql = "SELECT DISTINCT courses FROM course_names";
    } else {
        $sql = "SELECT DISTINCT classes FROM course_names WHERE courses = ?";
    }
    $stmt = $conn->prepare($sql);
    if ($courseFilter) {
        $stmt->bind_param('s', $courseFilter);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $classes = [];
    while ($row = $result->fetch_assoc()) {
        $classes[] = $row['classes'];
    }

    // Fetch levels
    $levels = [];
    if ($courseFilter && $classFilter) {
        $sql = "SELECT DISTINCT level FROM course_names WHERE courses = ? AND classes = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $courseFilter, $classFilter);
    } elseif ($courseFilter) {
        $sql = "SELECT DISTINCT level FROM course_names WHERE courses = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $courseFilter);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $levels[] = $row['level'];
    }

    // Return JSON response
    echo json_encode(['classes' => $classes, 'levels' => $levels]);
}
?>
