<?php
header('Content-Type: application/json'); // Set response type to JSON

$response = []; // Initialize the response array

try {
    // Database connection
    include 'connection.php';

    // Get the POST data
    parse_str($_POST['formData'], $formData);
    $batchname = $_POST['batchname'];
    $id = $formData['id']; // ID to identify the row
    $level = $formData['level'];
    $class = $formData['class'];
    $term = $formData['term'];
    $course_name = $formData['course_name'];
    $student_name = $formData['student_name'];
    $date = $formData['date'];

    // Remove non-editable fields (e.g., id, name, total) from $formData
    unset($formData['id'], $formData['student_name'], $formData['total'],
        $formData['level'], $formData['class'], $formData['term'], $formData['student_name'], $formData['date']);

    // Dynamically construct the SET part of the SQL query
    $updateFields = [];
    $updateValues = [];
    $total = 0; // Initialize total sum

    // Loop through form data and sum the values for columns that should be included in the total
    foreach ($formData as $column => $value) {
        // Sum the values of all the columns except those in the unset list
        $updateFields[] = "`$column` = ?";
        $updateValues[] = $value;
        
        // Dynamically calculate total based on numeric columns
        if (is_numeric($value)) {
            $total += $value;
        }
    }

    // Add total to the update query (set the total column dynamically)
    $updateFields[] = "`total` = ?"; // Add the total column
    $updateValues[] = $total; // Add the calculated total value to the values array

    // Add ID to the values array for the WHERE clause
    $updateValues[] = $id;

    // Create the SQL query dynamically
    $query = "UPDATE `$batchname` SET " . implode(", ", $updateFields) . " WHERE `id` = ?";
    $stmt = $conn->prepare($query);

    // Dynamically bind parameters
    $types = str_repeat("s", count($updateValues) - 1) . "i"; // Assuming all fields are strings, with the last parameter as integer (ID)
    $stmt->bind_param($types, ...$updateValues);

    // Execute the query
    if ($stmt->execute()) {
        // On success
        $response['status'] = 'success';
        $response['message'] = 'Row updated successfully!';
    } else {
        // On query error
        $response['status'] = 'error';
        $response['message'] = 'Failed to update row: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    // On exception
    $response['status'] = 'error';
    $response['message'] = 'Exception occurred: ' . $e->getMessage();
}

// Send JSON response
echo json_encode($response);
?>
