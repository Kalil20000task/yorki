<?php
include "connection.php";
if (isset($_POST['id'], $_POST['batchname'])) {
    $id = $_POST['id'];
    $batchname = $_POST['batchname'];

    // Fetch column names dynamically
    $columnsQuery = "SHOW COLUMNS FROM $batchname";
    $columnsResult = $conn->query($columnsQuery);

    // Fetch row data
    $rowQuery = "SELECT * FROM $batchname WHERE id = $id";
    $rowResult = $conn->query($rowQuery);
    $rowData = $rowResult->fetch_assoc();

    $formFields = "";
    while ($col = $columnsResult->fetch_assoc()) {
        $field = $col['Field'];

        if ($field == 'id' || $field == 'name') {
            // Non-editable fields
            $formFields .= "<input type='hidden' name='$field' value='{$rowData[$field]}'>";
            $formFields .= "<div class='form-group'>
                <label for='edit_$field'>{$field}:</label>
                <input type='text' id='edit_$field' class='form-control' value='{$rowData[$field]}' readonly>
            </div>";
        } elseif ($field == 'total') {
            // Total field is calculated dynamically
            $formFields .= "<div class='form-group'>
                <label for='edit_$field'>{$field}:</label>
                <input type='text' id='edit_$field' name='$field' class='form-control' value='{$rowData[$field]}' readonly>
            </div>";
        } else {
            // Editable fields
            $formFields .= "<div class='form-group'>
                <label for='edit_$field'>{$field}:</label>
                <input type='text' name='$field' id='edit_$field' class='form-control' value='{$rowData[$field]}' required>
            </div>";
        }
    }
    echo $formFields;
}
?>
