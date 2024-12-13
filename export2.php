<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $batchname = $_POST['batchname'];

    // Query data from the dynamic table
    $sql = "SELECT * FROM `$batchname`";
    $result = $conn->query($sql);

    // Open the file for output
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $batchname . '.csv"');

    $output = fopen('php://output', 'w');
    
    // Fetch column names for the header
    $fields = $result->fetch_fields();
    $columns = [];
    foreach ($fields as $field) {
        $columns[] = $field->name;
    }
    fputcsv($output, $columns); // Write the header

    // Write data rows
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }

    fclose($output);
    exit();
}
?>
