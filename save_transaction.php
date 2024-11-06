<?php
$servername = "localhost";
$username = "root"; // Update with your database username
$password = ""; // Update with your database password
$dbname = "icemaker_database"; // Update with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data from AJAX request
$ton = $_POST['ton'];
$jerican = $_POST['jerican'];
$packet = $_POST['packet'];
$sacks = $_POST['sacks'];
$category = $_POST['category'];
$total = $_POST['total'];
$date = $_POST['date']; // Get the date value

// Insert data into the transactions table
$sql = "INSERT INTO transactions (ton, jerican, packet, sacks, category, total, date) VALUES (?, ?, ?, ?, ?, ?, ?) ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ddddsds", $ton, $jerican, $packet, $sacks, $category, $total, $date);

if ($stmt->execute()) {
    echo "Transaction saved successfully!";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
