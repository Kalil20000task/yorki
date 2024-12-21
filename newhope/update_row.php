<?php
include "connection.php";
if (isset($_POST['batchname'], $_POST['id'])) {
    $batchname = $_POST['batchname'];
    $id = $_POST['id'];

    // Dynamically prepare update query
    $updateFields = [];
    $mark1 = 0;
    $mark2 = 0;
    foreach ($_POST as $key => $value) {
        if ($key != 'batchname' && $key != 'id') {
            if ($key == 'mark1') $mark1 = $value;
            if ($key == 'mark2') $mark2 = $value;

            // Skip total as it is calculated dynamically
            if ($key != 'total') {
                $updateFields[] = "$key = '$value'";
            }
        }
    }
    // Calculate total
    $total = $mark1 + $mark2;
    $updateFields[] = "total = '$total'";

    // Execute update query
    $updateQuery = "UPDATE $batchname SET " . implode(", ", $updateFields) . " WHERE id = $id";
    $conn->query($updateQuery);

    echo "Success";
}
?>
