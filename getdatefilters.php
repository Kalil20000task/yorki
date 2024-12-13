<?php
if (isset($_GET['startDate']) && isset($_GET['endDate'])) {
    $startDate = $_GET['startDate'];
    $endDate = $_GET['endDate'];
    require "connection.php";

    // Prepare the SQL query
    $query = "SELECT * FROM attendance_table WHERE date BETWEEN ? AND ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $startDate, $endDate);

    // Execute the query
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $data = [];

        // Fetch data as an associative array
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode($data);
    } else {
        // Return error response
        header('Content-Type: application/json');
        echo json_encode(["error" => "Failed to fetch data"]);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Return error if required parameters are missing
    header('Content-Type: application/json');
    echo json_encode(["error" => "Invalid parameters"]);
}
?>
