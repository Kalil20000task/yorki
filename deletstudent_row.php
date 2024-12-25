<?php
// Include your database connection file
include('connection.php'); // Replace with your actual file to connect to the database

// Check if id and batchname are received via POST
if (isset($_POST['id']) && isset($_POST['batchname'])) {
    $id = $_POST['id'];
    $batchname = $_POST['batchname'];

    // Sanitize the inputs to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $id);
    $batchname = mysqli_real_escape_string($conn, $batchname);

    // Build the SQL query to delete the record
    $sql = "DELETE FROM `$batchname` WHERE ID = '$id'";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        // If deletion is successful, send a success response
        echo "Record deleted successfully.";
    } else {
        // If there's an error, send an error response
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    // If the required data is not received, send an error response
    echo "Invalid request. Missing data.";
}

// Close the database connection
mysqli_close($conn);
?>
