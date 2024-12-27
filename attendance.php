<?php
session_start(); // Start session management

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}
require "connection.php";

// Initialize variables for input
// $expenseAmount = '';
// $reason = '';
$currentDate = date('Y-m-d');

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete'])) {
        // Handle deletion
        $idToDelete = $_POST['delete'];
        $deleteSql = "DELETE FROM attendance_table WHERE id = $idToDelete";
        $conn->query($deleteSql);
    } elseif (isset($_POST['export'])) {
        // Handle CSV export
        $filename = "attendance_" . date('Y/m/d') . ".csv";
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // Output data to CSV
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Name', 'Course','Reason' ,'Date']); // CSV header

        $sql = "SELECT * FROM attendance_table";
        $attendanceResult = $conn->query($sql);
        if ($attendanceResult->num_rows > 0) {
            while ($row = $attendanceResult->fetch_assoc()) {
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
        // $expenseAmount = str_replace(',', '', $expenseAmount);
        
        // Insert data into the database
        $sql = "INSERT INTO attendance_table (name,course, reason, date) VALUES ('$name', '$course', '$reason','$currentDate')";
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
$sql = "SELECT * FROM attendance_table order by id desc limit 15 ";
$attendanceResult = $conn->query($sql);
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
            background: url('images/ices.jpg') no-repeat center center fixed;
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
        .input-group {
            margin-bottom: 15px;
        }
        .input-group label {
            margin-left: 50px;
            width: 30%;
            text-align: right;
        }
        .input-group input, .input-group select {
            
            width: 60%;
            padding: 10px;
            border: 1px solid #555;
            border-radius: 5px;
            font-size: 16px;
            background-color: #444;
            color: #f8f8f8;
            margin-left: 10px;
        }
        .input-group input:focus, .input-group select:focus {
            border-color: #007bff;
        }
    </style>
</head>
<body>
    <?php
    include "header.php";
    ?>
 <!-- Drawer Navigation -->
 
    

    <div class="container">
    <div class="text-center" style="display: flex; align-items: center; justify-content: center; gap: 10px;">
    <img src="images/logo.png" alt="Logo" style="width: 69px; height: auto;">
    <h2 style="margin: 0;">Sttudent Attendance</h2>
</div>
        <form method="POST" action="">
            <div class="form-group">
                <label for="StudentName">Student Name:</label>
                <input type="text" id="StudentName" name="name" placeholder="Student Name" required  ">
            </div>
            <div class="input-group">
            <label for="coursename">Course Name:</label>
            <select id="category" name="course">
              
                <option value="Accounting_ACFN24_C3L">Accounting_ACFN24_C3L</option>
                <option value="Accounting_ACFN24_C2L">Accounting_ACFN24_C4L</option>
                <option value="Accounting_ACFN24_C3L">Accounting_ACFN24_C5L</option>
                <option value="Accounting_ACFN24_C6L">Accounting_ACFN24_C6L</option>
                <option value="Accounting_ACFNS24_C5L">Accounting_ACFNS24_C5L</option>
                <option value="Nursing_CNA24_C4L">Nursing_CNA24_C4L</option>
                <option value="Nursing_CNA24_C5L">Nursing_CNA24_C5L</option>
                <option value="Nursing_CNA24_C6L">Nursing_CNA24_C6L</option>
                <option value="Nursing_CNA24_C7L">Nursing_CNA24_C7L</option>

                <option value="Digital Marketing_DMA24_C1L">Digital Marketing_DMA24_C1L</option>
                <option value="Digital Marketing_DMA24_C2L">Digital Marketing_DMA24_C2L</option>
                <option value="IT_IT24_C4L">IT_IT24_C4L</option> 
                <option value="IT_IT24_C5L">IT_IT24_C5L</option> 
                <option value="BM24_C1L">BM24_C1L</option> 
                <option value="CB24_C4L">CB24_C4L</option>
                <option value="CB24_C5L">CB24_C5L</option>

                <option value="PLMB_C1L">PLMB24_C1L</option> 
                <option value="PLMB_C2L">PLMB24_C2L</option> 

                <option value="AM24_C1L">AM24_C1L</option>
                <option value="AM24_C2L">AM24_C2L</option>

                <option value="ENG24_A0-C1L">ENG24_A0-C1L</option>
                <option value="ENG24_A0-C4L">ENG24_A1-C4L</option>
                <option value="ENG24_A1-C5L">ENG24_A1-C5L</option>
                <option value="ENG24_A1-C6L">ENG24_A1-C6L</option>
                <option value="ENG24_A2-C4L">ENG24_A2-C4L</option>
                <option value="ENG24_B1-C1L">ENG24_B1-C1L</option>
                <option value="ENG24_B2-C1L">ENG24_B2-C1L</option>
                <option value="IELTS24">IELTS</option>







            </select>
            </div>
            <div class="input-group">
            <label for="category">Reason:</label>
            <select id="category" name="reason">
                <option value="Notprovided">Not provided</option>
                <option value="Sick">Sick</option>
                <option value="Acknowledged">Acknowledged</option>
                <option value="Busy">Busy</option>
                <option value="Drop out">Drop Out</option>
                <option value="Pending">pending</option>
                <option value="Appointment">appointment</option>
                <option value="Couldnot contact">couldnot contact</option>
                <option value="Rain">Rain</option>
                <option value="Payment">Payment</option>
                <option value="Family issue">Family issue</option>
                
            </select>
           </div>

           
            <div class="input-group">
            <input type="hidden" name="date" value="<?php echo $currentDate; ?>">
            <div class="form-actions">
                <button type="submit" style="background-color: #ec971f;">Submit</button>
            </div>
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
                    <th>Manage</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch attendanceResult from the database
                $totalSum = 0;
                if ($attendanceResult->num_rows > 0) {
                    while ($row = $attendanceResult->fetch_assoc()) {
                        
                               
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
                    echo "<tr><td colspan='5'>No attendanceResult found.</td></tr>";
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
