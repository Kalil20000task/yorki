<?php
session_start(); // Start session management

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    exit(); // Exit if the user is not logged in (comment this for debugging if needed)
}

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "icemaker_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if expense_id is set in the URL
if (isset($_GET['expense_id'])) {
    $expenseId = $_GET['expense_id'];
    echo "Expense ID: " . $expenseId; // Debugging output

    $updateSql = "UPDATE expenses_table SET pay_status = 'paid' WHERE id = $expenseId";
    echo "SQL Query: " . $updateSql; // Debugging output

    if ($conn->query($updateSql) === TRUE) {
        echo "success";
    } else {
        echo "error: " . $conn->error; // Show error message
    }
} else {
    echo "Expense ID not set"; // Debugging output if no expense_id is passed
}

$conn->close();
?>
