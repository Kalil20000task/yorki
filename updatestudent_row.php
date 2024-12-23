<?php
// Include database connection
include('connection.php');

// Debug to check received POST data
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!empty($_POST)) {
    // Parse form data
    $formData = $_POST;

    // Extract values from formData
    $id = $formData['ID'] ?? null;
    $studentname = $formData['studentname'] ?? null;
    $coursename = $formData['coursename'] ?? null;
    $classname = $formData['classname'] ?? null;
    $levelname = $formData['levelname'] ?? null;
    $batchname = $_POST['batchname'] ?? null;

    // Validate inputs
    if (!$id || !$batchname) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing required fields'
        ]);
        exit;
    }

    // Sanitize values0
    $id = intval($id);
    $studentname = $conn->real_escape_string($studentname);
    $coursename = $conn->real_escape_string($coursename);
    $classname = $conn->real_escape_string($classname);
    $levelname = intval($levelname);
    $batchname = $conn->real_escape_string($batchname);

    // Update query
    $sql = "UPDATE $batchname 
            SET 
                studentname = '$studentname', 
                coursename = '$coursename', 
                classname = '$classname', 
                levelname = $levelname
            WHERE ID = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Student record updated successfully.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update record. ' . $conn->error
        ]);
    }

    $conn->close();
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No data received'
    ]);
}
