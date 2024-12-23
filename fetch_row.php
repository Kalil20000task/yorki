<?php
include("connection.php");
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $batchname=$_POST['batchname'];
    $columnsQuery = "SHOW COLUMNS FROM $batchname";
    $columnsResult = $conn->query($columnsQuery);

    // Fetch row data
    $rowQuery = "SELECT * FROM $batchname WHERE id = $id";
    $rowResult = $conn->query($rowQuery);
    $rowData = $rowResult->fetch_assoc();
    $formFields = "";
$columnCount = 0; // Keep track of the number of columns in a row
while ($col = $columnsResult->fetch_assoc()) {
    $field = $col['Field'];

    // Start a new row if it's the first field or every 2 fields
    if ($columnCount % 2 == 0) {
        $formFields .= "<div class='row'>";
    }

    // Generate the field input
    $formFields .= "<div class='col-md-6'>"; // Use 6 columns per field for 2 fields per row
    if ($field == 'id' || $field == 'student_name' || $field == 'course_name' || $field == 'class' || $field == 'term') {
        $formFields .= "
            <input type='hidden' name='$field' value='{$rowData[$field]}'>
            <div class='form-group'>
                <label for='edit_$field'>{$field}:</label>
                <input type='text' id='edit_$field' class='form-control' value='{$rowData[$field]}' readonly>
            </div>";
    } elseif ($field == 'total') {
        $formFields .= "
            <div class='form-group'>
                <label for='edit_$field'>{$field}:</label>
                <input type='text' id='edit_$field' name='$field' class='form-control' value='{$rowData[$field]}' readonly>
            </div>";
    } else {
        $formFields .= "
            <div class='form-group'>
                <label for='edit_$field'>{$field}:</label>
                <input type='text' name='$field' id='edit_$field' class='form-control' value='{$rowData[$field]}'>
            </div>";
    }
    $formFields .= "</div>"; // Close column

    $columnCount++;

    // Close the row after every 2 fields or at the end of all fields
    if ($columnCount % 2 == 0 || $columnsResult->num_rows == $columnCount) {
        $formFields .= "</div>"; // Close row
    }
}
echo $formFields;

}
?>
