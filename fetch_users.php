<?php
// Database connection
require "connection.php";

// Fetch all rows dynamically
$query = "SELECT * FROM users";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    echo json_encode($rows);
} else {
    echo json_encode([]);
}

$conn->close();
?>
