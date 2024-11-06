<?php
session_start();
if ($_SESSION['role'] !== 'manager') {
    echo "Access denied.";
    exit();
}

// Connect to the database
$servername = "localhost";
$username = "root"; // your db username
$password = ""; // your db password
$dbname = "icemaker_database"; // your db name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update prices
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ton = $_POST['ton'];
    $jerican = $_POST['jerican'];
    $packet = $_POST['packet'];
    $sacks = $_POST['sacks'];

    // Update prices in the database
    $sql = "UPDATE prices SET prices = CASE
                WHEN measurement = 'ton' THEN $ton
                WHEN measurement = 'jerican' THEN $jerican
                WHEN measurement = 'packet' THEN $packet
                WHEN measurement = 'sacks' THEN $sacks
            END
            WHERE measurement IN ('ton', 'jerican', 'packet', 'sacks')";

    if ($conn->query($sql) === TRUE) {
        echo "Prices updated successfully.";
    } else {
        echo "Error updating prices: " . $conn->error;
    }
}

$conn->close();
?>
