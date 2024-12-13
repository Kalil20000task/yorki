<?php
session_start(); // Start session management

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

// Connect to the database
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

// Initialize variables for input
$expenseAmount = '';
$reason = '';
$currentDate = date('Y-m-d');

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete'])) {
        // Handle deletion
        $idToDelete = $_POST['delete'];
        $deleteSql = "DELETE FROM expenses_table WHERE id = $idToDelete";
        $conn->query($deleteSql);
    } elseif (isset($_POST['export'])) {
        // Handle CSV export
        $filename = "expenses_" . date('Y/m/d') . ".csv";
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // Output data to CSV
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Expense', 'Reason', 'Date']); // CSV header

        $sql = "SELECT * FROM expenses_table";
        $expensesResult = $conn->query($sql);
        if ($expensesResult->num_rows > 0) {
            while ($row = $expensesResult->fetch_assoc()) {
                fputcsv($output, $row);
            }
        }
        fclose($output);
        exit();
    } else {
        // Handle expense addition
       
        $name = $_POST['name'];
        $reason = $_POST['reason'];
        $course = $_POST['course'];
        
        
        // Remove commas for database storage
        $expenseAmount = str_replace(',', '', $expenseAmount);
        
        // Insert data into the database
        $sql = "INSERT INTO attendance_table (name,course, reason, date) VALUES ('$name', '$course', '$reason')";
        if ($conn->query($sql) === TRUE) {
            // Redirect after successful submission to prevent form resubmission on refresh
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit(); // Ensure no further code is executed
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Fetch existing expenses
$sql = "SELECT * FROM attendance_table";
$expensesResult = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Record</title>
    <style>
        /* Styles remain unchanged */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
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
        .header a {
            color: #fff;
            margin: 0 15px;
            text-decoration: none;
            font-size: 18px;
        }
        .header .logout-button {
            background-color: red; /* Red color for the logout button */
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none; /* Remove underline from link */
            display: inline-block; /* Allow padding and background */
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
            margin-left: 50px;
            cursor: pointer;
        }
        .container {
            margin: 20px auto;
            padding: 20px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 8px;
            color: #fff;
            width: 40%;
        }
        .container h2 {
            text-align: center;
        }
        .tablecontainer {
            margin: 20px auto;
            padding: 20px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 8px;
            color: #fff;
            width: 80%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            table-layout: fixed;
        }
        table, th, td {
            border: 1px solid #555;
        }
        th, td {
            padding: 10px;
            text-align: center;
            word-break: break-word;
            vertical-align: middle;
        }
        th {
            background-color: #555;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #444;
        }
        input[type="text"], input[type="number"] {
            padding: 10px;
            border: 1px solid #555;
            border-radius: 5px;
            width: calc(50% - 22px);
            margin-bottom: 10px;
            background-color: #444;
            color: #fff;
            display: inline-block;
        }
        button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            width: 150px;
            margin-top: 10px;
            align-self: center;
        }
        button:hover {
            opacity: 0.9;
        }
        /* Add this style to your existing <style> section */
        .delete-button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background-color: #dc3545; /* Red background color */
            color: #fff;
            cursor: pointer;
            width: 80px; /* Adjust width if needed */
        }

        .delete-button:hover {
            opacity: 0.9; /* Slightly darken on hover */
        }

        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .form-group label {
            margin-right: 10px;
            width: 30%;
            text-align: right;
        }
        .form-actions {
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>
 <!-- Drawer Navigation -->
 <?php
include "header.php";
?>
    

    <div class="container">
        <h2>Student Record</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="StudentName">Student Name:</label>
                <input type="text" id="StudentName" name="StudentName" placeholder="Student Name" required value="<?php echo $StudentName; ?>" oninput="formatNumber(this)">
            </div>
        
            <label for="coursename">Course Name:</label>
            <select id="category">
                <option value="Accounting_ACFN24_C2L">Accounting_ACFN24_C2L</option>
                <option value="Accounting_ACFN24_C3L">Accounting_ACFN24_C3L</option>
                <option value="Accounting_ACFN24_C2L">Accounting_ACFN24_C4L</option>
                <option value="Accounting_ACFN24_C3L">Accounting_ACFN24_C5L</option>
            </select>
            </div>
            <div class="input-group">
            <label for="category">Reason:</label>
            <select id="category">
                <option value="notprovided">Not provided</option>
                <option value="sick">Sick</option>
                <option value="acknowledged">Acknowledged</option>
            </select>
        </div>
            <div class="input-group">
            <input type="hidden" name="date" value="<?php echo $currentDate; ?>">
            <div class="form-actions">
                <button type="submit">Add Expense</button>
            </div>
        </form>
    </div>

    <!-- Expenses Table -->
    <div class="tablecontainer">
        <h2>Student Record</h2>
        <form method="POST" action="">
            <button type="submit" name="export" style="margin-bottom: 20px; background-color: #28a745;">Export to CSV</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Reason</th>
                    <th>Date</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch expenses from the database
                $totalSum = 0;
                if ($expensesResult->num_rows > 0) {
                    while ($row = $expensesResult->fetch_assoc()) {
                        
                               
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['name']} </td>
                                <td>{$row['course']} </td>
                                <td>{$row['reason']}</td>
                                <td>{$row['date']}</td>
                                <td>
                        <form method='POST' action='' style='display:inline;'>
                            <button type='submit' name='delete' value='{$row['id']}' class='delete-button' onclick=\"return confirm('Are you sure you want to delete this expense?');\">Delete</button>
                        </form>
                    </td>

                              </tr>";
                        // $totalSum += $row['expense']; // Summing up expenses
                    }
                } else {
                    echo "<tr><td colspan='5'>No expenses found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        
    </div>

    <script>
        function openDrawer() {
            document.getElementById("drawer").style.width = "250px";
        }

        // Function to close the drawer
        function closeDrawer() {
            document.getElementById("drawer").style.width = "0";
        }
        function formatNumber(input) {
            // Remove non-numeric characters and format number
            let value = input.value.replace(/,/g, '');
            input.value = new Intl.NumberFormat().format(value);
        }
    </script>
</body>
</html>

<?php
$conn->close(); // Close database connection
?>
