<?php
// Database connection
require "connection.php";


// Update the row
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $columns = $_POST['columns'];

    $updateQueryParts = [];
    foreach ($columns as $column => $value) {
        $updateQueryParts[] = "$column = '" . $conn->real_escape_string($value) . "'";
    }

    $updateQuery = "UPDATE users SET " . implode(", ", $updateQueryParts) . " WHERE id = $id";
    if ($conn->query($updateQuery) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
}

$conn->close();
?>
