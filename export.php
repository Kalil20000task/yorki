<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
?>

<?php
// Connect to the database
require "connection.php";

// Check if the export button was clicked
if (isset($_POST['export'])) {
    // Define headers for CSV export
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="xebxab_' . date('Y-m-d') . '.csv"');

    // Create a file pointer connected to the output stream
    $output = fopen('php://output', 'w');

    // Output the column headings
    fputcsv($output, array('id', 'student_name', 'class', 'term'));

    // // Initialize variables for filtering dates
    // $startDate = isset($_POST['startDate']) ? $_POST['startDate'] : date('Y-m-01');
    // $endDate = isset($_POST['endDate']) ? $_POST['endDate'] : date('Y-m-d');

    // // Fetch the filtered data from the database
    // $sql = "SELECT * FROM transactions WHERE date BETWEEN '$startDate' AND '$endDate'";
    $startDate = isset($_POST['startDate']) ? $_POST['startDate'] : date('Y-m-01'); // First day of the month
$endDate = isset($_POST['endDate']) ? $_POST['endDate'] : date('Y-m-d'); // Today's date
$courseFilter = isset($_POST['courseFilter']) ? $_POST['courseFilter'] : '';
$classFilter = isset($_POST['classFilter']) ? $_POST['classFilter'] : '';
$termFilter = isset($_POST['termFilter']) ? $_POST['termFilter'] : '';
    //  $sql2 = "SELECT expense FROM expenses_table WHERE date BETWEEN '$startDate' AND '$endDate'";

// Base query to fetch all columns from acfns_term1_marks
// $sql = "SELECT * FROM acfns_term1 WHERE date BETWEEN '$startDate' AND '$endDate' " . (!empty($courseFilter) ? " AND course_name LIKE '%$courseFilter%'" : "") . (!empty($classFilter) ? " AND class = '$classFilter'" : "") . (!empty($termFilter) ? " AND term = '$termFilter'" : "") . " ORDER BY id DESC";
$sql = "SELECT * FROM acfns_term1 WHERE date BETWEEN '$startDate' AND '$endDate'" .
    (!empty($courseFilter) ? " AND course_name LIKE '%$courseFilter%'" : "") .
    (!empty($classFilter) ? " AND class = '$classFilter'" : "") .
    (!empty($termFilter) ? " AND term = '$termFilter'" : "");

    $result = $conn->query($sql);

    // $sql2 = "SELECT expense FROM expenses_table WHERE date BETWEEN '$startDate' AND '$endDate'";
    // $expensesResult = $conn->query($sql2);
    //getting the total expenses
    // $totalexpenseSum = 0;

    // if ($expensesResult->num_rows > 0) {
    //      while ($row = $expensesResult->fetch_assoc()) {

    //          $totalexpenseSum += $row['expense']; // Summing up expenses
    //          }
    //     }

    // // Initialize total sum variable
    // $totalSum = 0;

    // Check if any rows returned and write them to the CSV file
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Write each row to the CSV file
            
            $filteredRow = array(
                'id' => $row['id'],
                'student_name' => $row['student_name'],
                'class' => $row['class'],
                'term' => $row['term'],

                // 'packet' => $row['packet'],
                // 'sacks' => $row['sacks'],
                // 'category' => $row['category'],
                // 'total' => number_format($row['total'], 0), // Format without decimals
                
            );
        
            // Write the filtered row to the CSV file
            fputcsv($output, $filteredRow);

            // Add the total price of each row to the total sum
            // $totalSum += $row['total'];
        }

        // Add a blank line for separation
        fputcsv($output, array());
        //$net=$totalSum-$totalexpenseSum
        // Add the total sum row at the end
        // fputcsv($output, array('Total', '', '', '', '', '', number_format($totalSum, 0)));
        //$net=$totalSum-$totalexpenseSum
        // fputcsv($output, array('Expense', '', '', '', '', '', number_format("-".$totalexpenseSum, 0)));
        // fputcsv($output, array('Net Income', '', '', '', '', '', number_format($totalSum-$totalexpenseSum, 0)));
    } else {
        // In case no data matches the filter, add a message to the CSV
        fputcsv($output, array('No data found for the given date range'));
    }

    // Close the file pointer
    fclose($output);

    // Close the database connection
    $conn->close();

    // End the script to avoid further execution
    exit();
} else {
    echo "No data to export";
}
?>
