<?php
// Include database connection
include('connection.php');

// Check if ID and batchname are passed
if (isset($_POST['id']) && isset($_POST['batchname'])) {
    $id = $_POST['id'];
    $batchname = $_POST['batchname'];

    // Query to fetch data for the specific ID and batchname
    $sql = "SELECT * FROM $batchname WHERE id = $id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Generate HTML for the modal dialog
        echo '<form id="editForm">';

        echo '<div class="form-group">';
        echo '<label for="ID">ID</label>';
        echo '<input type="number" class="form-control" id="ID" name="ID" value="' . htmlspecialchars($row['ID']) . '" required>';
        echo '</div>';

        echo '<div class="form-group">';
        echo '<label for="studentname">Name</label>';
        echo '<input type="text" class="form-control" id="studentname" name="studentname" value="' . htmlspecialchars($row['studentname']) . '" required>';
        echo '</div>';

        echo '<div class="form-group">';
        echo '<label for="coursename">Course Name</label>';
        echo '<input type="text" class="form-control" id="coursename" name="coursename" value="' . htmlspecialchars($row['coursename']) . '" readonly>';
        echo '</div>';

        echo '<div class="form-group">';
        echo '<label for="classname">Class Name</label>';
        echo '<input type="text" class="form-control" id="classname" name="classname" value="' . htmlspecialchars($row['classname']) . '" readonly>';
        echo '</div>';

        echo '<div class="form-group">';
        echo '<label for="levelname">Level Name</label>';
        echo '<input type="number" class="form-control" id="levelname" name="levelname" value="' . htmlspecialchars($row['levelname']) . '" readonly>';
        echo '</div>';

        echo '</form>';
    } else {
        echo '<p>No record found.</p>';
    }

    // Close the connection
    $conn->close();
} else {
    echo '<p>Invalid request.</p>';
}
?>
