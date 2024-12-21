<?php
include "connection.php";
if (isset($_POST['batchname'])) {
    $batchname = $_POST['batchname'];

    // Fetch column names dynamically
    $columnsQuery = "SHOW COLUMNS FROM $batchname";
    $columnsResult = $conn->query($columnsQuery);
    $columns = [];
    $header = "<tr>";
    while ($col = $columnsResult->fetch_assoc()) {
        $columns[] = $col['Field'];
        $header .= "<th>{$col['Field']}</th>";
    }
    $header .= "<th>Actions</th></tr>";

    // Fetch data from the table
    $dataQuery = "SELECT * FROM $batchname";
    $dataResult = $conn->query($dataQuery);
    $rows = "";
    while ($row = $dataResult->fetch_assoc()) {
        $rows .= "<tr>";
        foreach ($columns as $col) {
            $rows .= "<td>{$row[$col]}</td>";
        }
        $rows .= "<td><button class='btn btn-primary editBtn' data-id='{$row['id']}'>Edit</button></td></tr>";
    }

    echo json_encode(['header' => $header, 'rows' => $rows]);
}
?>
