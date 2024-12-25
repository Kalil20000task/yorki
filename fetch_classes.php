<?php
include('connection.php');
if (isset($_POST['coursename'])) {
    $coursename = $_POST['coursename'];
    $query = "SELECT DISTINCT classes FROM course_names WHERE courses = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $coursename);
    $stmt->execute();
    $result = $stmt->get_result();
    echo '<option value="">Select Class</option>';
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . htmlspecialchars($row['classes']) . '">' . htmlspecialchars($row['classes']) . '</option>';
    }
}
?>
