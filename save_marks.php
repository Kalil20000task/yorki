<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Update with your database username
$password = ""; // Update with your database password
$dbname = "trainup"; // Update with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode([
        "status" => "error",
        "message" => "Database connection failed: " . $conn->connect_error
    ]));
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method."
    ]);
    exit();
}

// Validate and sanitize POST data
$name = isset($_POST['fullname']) ? htmlspecialchars(trim($_POST['fullname'])) : null;
$term1 = isset($_POST['term1']) ? floatval($_POST['term1']) : null;
$term2 = isset($_POST['term2']) ? floatval($_POST['term2']) : null;
$term3 = isset($_POST['term3']) ? floatval($_POST['term3']) : null;
$setby = isset($_POST['setby']) ? htmlspecialchars(trim($_POST['setby'])) : null;
$total = isset($_POST['total']) ? floatval($_POST['total']) : null;
$date = isset($_POST['date']) ? htmlspecialchars(trim($_POST['date'])) : null;

// Perform input validation
if (empty($name) || is_null($term1) || is_null($term2) || is_null($term3) || empty($setby) || is_null($total) || empty($date)) {
    echo json_encode([
        "status" => "error",
        "message" => "All fields are required."
    ]);
    exit();
}

// Calculate average
$average = $total / 3;

// Prepare SQL statement
$sql = "INSERT INTO acfns (name, course, term1, term2, term3, total, average, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to prepare SQL statement: " . $conn->error
    ]);
    exit();
}

// Bind parameters to the prepared statement
$course = "acfns"; // Hardcoded course name
$stmt->bind_param("ssddddds", $name, $course, $term1, $term2, $term3, $total, $average, $date);

// Execute the statement
if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Marks saved successfully."
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to save marks: " . $stmt->error
    ]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
