<?php
session_start(); // Start session management

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "trainup";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Close connection (not used further in this file, but kept for completeness)
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACFNS Mark List</title>
    <style>
        /* Basic styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: url('images/ice.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }
        .header {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .header .menu-icon {
            font-size: 24px;
            cursor: pointer;
        }
        .header a {
            color: #fff;
            margin: 0 15px;
            text-decoration: none;
            font-size: 18px;
        }
        .header a:hover {
            text-decoration: underline;
        }
        .header .logout-button {
            background-color: red;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
        }
        .drawer {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #333;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }
        .drawer a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 22px;
            color: #fff;
            display: block;
            transition: 0.3s;
        }
        .drawer a:hover {
            background-color: #575757;
        }
        .drawer .close-btn {
            position: absolute;
            top: 10px;
            right: 25px;
            font-size: 36px;
            cursor: pointer;
        }
        .container {
            background: rgba(0, 0, 0, 0.7);
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            padding: 20px;
            width: 400px;
            color: #fff;
            margin: 20px auto;
        }
        .container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #f8f8f8;
        }
        .input-group {
            margin-bottom: 15px;
        }
        .input-group label {
            display: block;
            margin-bottom: 5px;
            color: #ccc;
        }
        .input-group input, .input-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #555;
            border-radius: 5px;
            font-size: 16px;
            background-color: #444;
            color: #f8f8f8;
        }
        .input-group input:focus, .input-group select:focus {
            border-color: #007bff;
        }
        .buttons {
            display: flex;
            justify-content: space-between;
            gap: 15px;
        }
        .buttons button {
            width: 48%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            background-color: #555;
            color: #f8f8f8;
        }
        .buttons .submit {
            background-color: #007bff;
            color: #fff;
        }
        .buttons button:hover {
            opacity: 0.9;
        }
    </style>
    <script>
        // Function to open the drawer
        function openDrawer() {
            document.getElementById("drawer").style.width = "250px";
        }

        // Function to close the drawer
        function closeDrawer() {
            document.getElementById("drawer").style.width = "0";
        }

        // Function to calculate the total
        function calculateTotal() {
            const term1 = parseFloat(document.getElementById('term1').value) || 0;
            const term2 = parseFloat(document.getElementById('term2').value) || 0;
            const term3 = parseFloat(document.getElementById('term3').value) || 0;

            const total = term1 + term2 + term3;
            document.getElementById('total-display').value = total.toFixed(2);
        }

        // Submit marks to the server using AJAX
        function submitMarks() {
            const name = document.getElementById('name').value;
            const term1 = document.getElementById('term1').value;
            const term2 = document.getElementById('term2').value;
            const term3 = document.getElementById('term3').value;
            const setby = document.getElementById('setby').value;
            const total = document.getElementById('total-display').value;
            const currentDate = new Date().toISOString().slice(0, 10);

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "save_marks.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert(xhr.responseText);
                    // Reset form after successful submission
                    document.getElementById('term1').value = '';
                    document.getElementById('term2').value = '';
                    document.getElementById('term3').value = '';
                    document.getElementById('total-display').value = '';
                    document.getElementById('name').value = '';
                }
            };
            xhr.send(`fullname=${encodeURIComponent(name)}&term1=${term1}&term2=${term2}&term3=${term3}&setby=${encodeURIComponent(setby)}&total=${total}&date=${currentDate}`);
        }
    </script>
</head>
<body>
<?php
include "header.php";
?>

    <div class="container">
        <h2>ACFNS Mark List</h2>
        <div class="input-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="fullname" placeholder="Enter student name" required>
        </div>
        <div class="input-group">
            <label for="term1">First Term</label>
            <input type="number" id="term1" placeholder="Enter marks" oninput="calculateTotal()" required>
        </div>
        <div class="input-group">
            <label for="term2">Second Term</label>
            <input type="number" id="term2" placeholder="Enter marks" oninput="calculateTotal()">
        </div>
        <div class="input-group">
            <label for="term3">Third Term</label>
            <input type="number" id="term3" placeholder="Enter marks" oninput="calculateTotal()">
        </div>
        <div class="input-group">
            <label for="setby">Prepared By</label>
            <select id="setby" required>
                <option value="haben">Yorkabiel</option>
                <option value="other">Other</option>
            </select>
        </div>
        <div class="input-group">
            <label for="total-display">Total</label>
            <input type="text" id="total-display" readonly>
        </div>
        <div class="buttons">
            <button class="submit" onclick="submitMarks()">Submit</button>
            <button type="reset">Reset</button>
        </div>
    </div>
</body>
</html>
