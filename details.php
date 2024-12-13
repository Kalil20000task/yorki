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
$dbname = "trainup"; // Update with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables for filtering
$startDate = isset($_POST['startDate']) ? $_POST['startDate'] : date('Y-m-01'); // Default to the first day of current month
$endDate = isset($_POST['endDate']) ? $_POST['endDate'] : date('Y-m-d'); // Default to today's date

// Fetch filtered data
// $sql = "SELECT * FROM acfns WHERE date BETWEEN '$startDate' AND '$endDate'";
// $result = $conn->query($sql);


// $sql2 = "SELECT expense FROM expenses_table WHERE date BETWEEN '$startDate' AND '$endDate'";
// $expensesResult = $conn->query($sql2);

// Initialize total sum
$totalSum = 0;

// Delete record if delete_id is set
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    $deleteSql = "DELETE FROM acfns WHERE id = $deleteId";
    if ($conn->query($deleteSql) === TRUE) {
        echo "<script>alert('Record deleted successfully');</script>";
        echo "<script>window.location.href='details.php?deleted=true';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('images/ice.jpg') no-repeat center center fixed; /* Ice background image */
            background-size: cover; /* Cover the entire background */
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
            width: 80%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            table-layout: fixed; /* Ensures table cells don't overlap */
        }
        table, th, td {
            border: 1px solid #555;
        }
        th, td {
            padding: 10px;
            text-align: center;
            word-break: break-word; /* Prevents overflowing text */
            vertical-align: middle; /* Ensures text stays centered vertically */
        }
        th {
            background-color: #555;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #444;
        }
        .filter {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }
        .filter input {
            padding: 10px;
            border: 1px solid #555;
            border-radius: 5px;
            background-color: #444;
            color: #fff;
            width: 30%;
        }
        .filter button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
        .filter button:hover {
            opacity: 0.9;
        }
        .search-form {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }
        .search-form input {
            padding: 10px;
            border: 1px solid #555;
            border-radius: 5px;
            background-color: #444;
            color: #fff;
            width: 70%;
        }
        .delete-btn {
            background-color: #dc3545;
            border: none;
            color: white;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
        }
        .delete-btn:hover {
            opacity: 0.8;
        }
        .export-btn {
            background-color: #28a745;
            border: none;
            color: white;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .export-btn:hover {
            opacity: 0.9;
        }
    </style>
    <script>
        function confirmDeletion(deleteUrl) {
            if (confirm("Are you sure you want to delete this record?")) {
                window.location.href = deleteUrl;
            }
        }

        // Function to open the drawer
        function openDrawer() {
            document.getElementById("drawer").style.width = "250px";
        }

        // Function to close the drawer
        function closeDrawer() {
            document.getElementById("drawer").style.width = "0";
        }
    </script>
</head>
<body>
<?php
include "header.php";
?>
    
    <!-- Filter Form -->
    <div class="container">
        <h2>Marklist</h2>
        <form method="POST" class="filter">
            <input type="date" name="startDate" value="<?php echo $startDate; ?>" required>
            <input type="date" name="endDate" value="<?php echo $endDate; ?>" required>
            <button type="submit">Filter</button>
        </form>
        
        <form method="post" action="export.php">
            <button type="submit" class="export-btn" name="export">Export to Excel</button>
        </form>
        
        <form method="POST" class="search-form">
            <input type="text" name="search" placeholder="Search by category..." value="<?php echo isset($_POST['search']) ? $_POST['search'] : ''; ?>">
            <button type="submit">Search</button>
        </form>

        <table>
            <thead>
                <tr>
                <th>Id</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Term1</th>
                    <th>Term2</th>
                    <th>Term3</th>
                   
                    <th>Total </th>
                    <th>Average</th>
                    <th>Set by</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //calculating expense fromexpense table
                // $totalexpenseSum = 0;

                //  if ($expensesResult->num_rows > 0) {
                //       while ($row = $expensesResult->fetch_assoc()) {
        
                //           $totalexpenseSum += $row['expense']; // Summing up expenses
                //           }
                //      }



                // Check for search input
                $search = isset($_POST['search']) ? $_POST['search'] : '';
                $sql = "SELECT * FROM acfns WHERE date BETWEEN '$startDate' AND '$endDate'";
                if ($search) {
                    $sql .= " AND category LIKE '%$search%'";
                }
                $result = $conn->query($sql);
                $totalSum = 0; // Reset total sum for filtered results

                if ($result->num_rows > 0) {
                    $currentDate = date('d/m/Y');
                    while ($row = $result->fetch_assoc()) {
                        $formattedTotal = number_format($row['total'], 0); // Format total with commas
                        echo "<tr>
                            <td>{$row['id']}</td>
                           
                            <td>{$row['name']}</td>
                            <td>{$row['course']}</td>
                            <td>{$row['term1']}</td>
                            <td>{$row['term2']}</td>
                            <td>{$row['term3']}</td>
                            <td>{$formattedTotal}</td>
                            <td>{$row['average']}</td>
                            <td>{$row['setby']}</td>
                             <td>{$currentDate}</td>
                            
                            <td>
                                <button class='delete-btn' onclick=\"confirmDeletion('details.php?delete_id={$row['id']}')\">Delete</button>
                            </td>
                        </tr>";
                        $totalSum += $row['total'];
                    }
                } else {
                    echo "<tr><td colspan='8'>No transactions found for the selected date range and search criteria.</td></tr>";
                }
                ?>
            </tbody>
            <tfoot>
                <!-- <tr>
                    <th style="color:yellow" colspan="7">Total Revenue</th>
                    <th style="color:yellow"></th>
                    <th  style="color:orange"></th>
                </tr> -->
               
            </tfoot>
        </table>
    </div>
</body>
</html>
