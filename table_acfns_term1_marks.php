<?php
session_start(); // Start session management

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

// Database connection
require "connection.php";

// Initialize filters
// Initialize filters
$startDate = isset($_POST['startDate']) ? $_POST['startDate'] : date('Y-m-01'); // First day of the month
$endDate = isset($_POST['endDate']) ? $_POST['endDate'] : date('Y-m-d'); // Today's date
$courseFilter = isset($_POST['courseFilter']) ? $_POST['courseFilter'] : '';
$classFilter = isset($_POST['classFilter']) ? $_POST['classFilter'] : '';
$termFilter = isset($_POST['termFilter']) ? $_POST['termFilter'] : '';

// Base query to fetch all columns from acfns_term1_marks
$sql = "SELECT * FROM classacfns24c5marklist WHERE date BETWEEN '$startDate' AND '$endDate' " . (!empty($courseFilter) ? " AND course_name LIKE '%$courseFilter%'" : "") . (!empty($classFilter) ? " AND class = '$classFilter'" : "") . (!empty($termFilter) ? " AND term = '$termFilter'" : "") . " ORDER BY id DESC";


$result = $conn->query($sql);

// Export to Excel
if (isset($_POST['export'])) {
    // Execute the same filtered query for exporting data
    $exportResult = $conn->query($sql);

    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=filtered_data.xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    echo "ID\tStudent Name\tCourse Name\tClassName\tTerm\tClasswork 1\tClasswork 2\tTest 1\tTest 2\tGroup Assignment 1\tGroup Assignment 2\tParticipation\tAttendance\tFinal Exam\tTotal\tDate\n";

    while ($row = $exportResult->fetch_assoc()) {
        echo "{$row['id']}\t{$row['student_name']}\t{$row['course_name']}\t{$row['class']}\t{$row['term']}\t{$row['classwork1']}\t{$row['classwork2']}\t{$row['test1']}\t{$row['test2']}\t{$row['group_assignment1']}\t{$row['group_assignment2']}\t{$row['participation']}\t{$row['attendance']}\t{$row['final_exam']}\t{$row['total']}\t{$row['date']}\n";
    }
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marks List</title>
    <style>
        /* Your styling code */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('images/ice.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }
        .container {
            margin: 20px auto;
            padding: 20px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 8px;
            color: #fff;
            width: 90%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #555;
        }
        th, td {
            padding: 10px;
            text-align: center;
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
        .filter input, .filter select {
            padding: 10px;
            border: 1px solid #555;
            border-radius: 5px;
            background-color: #444;
            color: #fff;
        }
        .filter button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
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
    </style>
</head>
<?php
$sql2 = "SELECT courses FROM course_names";
$courseResult = $conn->query($sql2);
?>
<body>
    <div class="container">
        <h2>Marklist</h2>
    <form method="POST" class="filter">
    <input type="date" name="startDate" value="<?php echo $startDate; ?>">
    <input type="date" name="endDate" value="<?php echo $endDate; ?>">

    <select name="courseFilter">
        <option value="">All Courses</option>
        <?php
        if ($courseResult->num_rows > 0) {
            while ($row = $courseResult->fetch_assoc()) {
                $selected = ($row["courses"] === $courseFilter) ? "selected" : ""; // Check if this course is selected
                echo "<option value='" . $row["courses"] . "' $selected>" . $row["courses"] . "</option>";
            }
        } else {
            echo "<option value=''>No courses available</option>";
        }
        ?>
    </select>

    <select name="classFilter">
        <option value="">All Classes</option>
        <?php 
        for ($i = 1; $i <= 10; $i++) {
            $selected = ($i == $classFilter) ? "selected" : ""; // Check if this class is selected
            echo "<option value='" . $i . "' $selected>Class $i</option>";
        }
        ?>
    </select>

    <select name="termFilter">
        <option value="">All Terms</option>
        <?php 
        for ($j = 1; $j <= 10; $j++) {
            $selected = ($j == $termFilter) ? "selected" : ""; // Check if this term is selected
            echo "<option value='" . $j . "' $selected>Term $j</option>";
        }
        ?>
    </select>

    <button type="submit">Filter</button>
</form>


        <form method="POST">
            <button type="submit" name="export" class="export-btn">Export to Excel</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Student Name</th>
                    <th>Course Name</th>
                    <th> Class</th>
                    <th>Term</th>
                    <th>Classwork 1</th>
                    <th>Classwork 2</th>
                    <th>Test 1</th>
                    <th>Test 2</th>
                    <th>Group Assignment 1</th>
                    <th>Group Assignment 2</th>
                    <th>Participation</th>
                    <th>Attendance</th>
                    <th>Final Exam</th>
                    <th>Total Marks</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['student_name']}</td>
                            <td>{$row['course_name']}</td>
                            <td>{$row['class']}</td>
                            <td>{$row['term']}</td>
                            <td>{$row['classwork1']}</td>
                            <td>{$row['classwork2']}</td>
                            <td>{$row['test1']}</td>
                            <td>{$row['test2']}</td>
                            <td>{$row['group_assignment1']}</td>
                            <td>{$row['group_assignment2']}</td>
                            <td>{$row['participation']}</td>
                            <td>{$row['attendance']}</td>
                            <td>{$row['final_exam']}</td>
                            <td>{$row['total']}</td>
                            <td>{$row['date']}</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='14'>No records found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
