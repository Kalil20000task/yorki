<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json'); // Tell the client to expect JSON
    $data = $_POST;
    $id = $data['id'];
    $tablename = "class" . $data['course'] . $data['level'] . "c" . $data['class'] . "marklist";

    $updateQuery = "UPDATE `$tablename` SET ";
    $setValues = [];
    foreach ($data as $key => $value) {
        if ($key !== 'id') {
            $setValues[] = "`$key` = '" . $conn->real_escape_string($value) . "'";
        }
    }
    $updateQuery .= implode(", ", $setValues);
    $updateQuery .= " WHERE id = $id";

    if ($conn->query($updateQuery)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update record']);
    }
}
?>
