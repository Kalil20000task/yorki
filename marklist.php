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
$levelFilter = isset($_POST['levelFilter']) ? $_POST['levelFilter'] : '';

$termFilter = isset($_POST['termFilter']) ? $_POST['termFilter'] : '';

// Base query to fetch all columns from acfns_term1_marks
// Check if both course and class are selected
if (!empty($courseFilter) && !empty($classFilter)) {
    $batchname = "class" . $courseFilter . $levelFilter . "c" . $classFilter."marklist";
    $sql = "SELECT * FROM $batchname ORDER BY id ASC";
} else {
    $sql = ""; // Set query to empty if filters are not selected
}

$result = !empty($sql) ? $conn->query($sql) : null;



// $result = $conn->query($sql);

// Export to Excel
if (isset($_POST['export'])) {
    // Use the same SQL query as used to fetch the data for the HTML table
    $exportResult = !empty($sql) ? $conn->query($sql) : null;

    if ($exportResult) {
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=filtered_data.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        // Output the header row
        $fields = $exportResult->fetch_fields();
        foreach ($fields as $field) {
            echo htmlspecialchars($field->name) . "\t";
        }
        echo "\n";

        // Output the data rows
        while ($row = $exportResult->fetch_assoc()) {
            foreach ($row as $value) {
                echo htmlspecialchars($value) . "\t";
            }
            echo "\n";
        }
        exit();
    } else {
        echo "No data available for export.";
        exit();
    }
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
$sql2 = "SELECT DISTINCT courses FROM course_names";
$courseResult = $conn->query($sql2);
?>
<body>
    <?php 
    include "header.php";
    ?>
    <div class="container">
        <h2>Marklist</h2>
        <form method="POST" class="filter" id="filterForm">
    <input type="date" name="startDate" value="<?php echo $startDate; ?>">
    <input type="date" name="endDate" value="<?php echo $endDate; ?>">

    <!-- Course Filter -->
    <select name="courseFilter" id="courseFilter">
        <option value="">All Courses</option>
        <?php
        if ($courseResult->num_rows > 0) {
            while ($row = $courseResult->fetch_assoc()) {
                $selected = ($row["courses"] === $courseFilter) ? "selected" : "";
                echo "<option value='" . $row["courses"] . "' $selected>" . $row["courses"] . "</option>";
            }
        } else {
            echo "<option value=''>No courses available</option>";
        }
        ?>
    </select>

    <!-- Class Filter -->
    <select name="classFilter" id="classFilter">
        <option value="">All Classes</option>
        <?php
        // Populate class filter with previously selected value
        if (!empty($classFilter)) {
            echo "<option value='" . $classFilter . "' selected>Class " . $classFilter . "</option>";
        }
        ?>
    </select>

    <!-- Level Filter -->
    <select name="levelFilter" id="levelFilter">
        <option value="">Select Levels Only For English Course</option>
        <?php
        // Populate level filter with previously selected value
        if (!empty($levelFilter)) {
            echo "<option value='" . $levelFilter . "' selected>Level " . $levelFilter . "</option>";
        }
        ?>
    </select>

    <button type="submit">Filter</button>
</form>


        <form method="POST">
            <button type="submit" name="export" class="export-btn">Export to Excel</button>
        </form>

        <table>
            <?php
        if ($result->num_rows > 0) {
    // Fetch field names dynamically
    $fields = $result->fetch_fields(); 

    echo "<thead><tr>";
    foreach ($fields as $field) {
        echo "<th>" . htmlspecialchars($field->name) . "</th>";
    }
    echo "</tr></thead>";

    echo "<tbody>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>" . htmlspecialchars($value) . "</td>";
        }
        echo "</tr>";
    }
    echo "</tbody>";
} else {
    echo "<thead><tr><th colspan='100%'>No records found</th></tr></thead>";
    echo "<tbody><tr><td colspan='100%'>Please select both course and class.</td></tr></tbody>";
}

        ?>
    </tbody>
</table>

    </div>
</body>
<script>
    // Handle changes in the course filter
    document.addEventListener('DOMContentLoaded', function () {
    const courseFilter = document.getElementById('courseFilter');
    const classFilter = document.getElementById('classFilter');
    const levelFilter = document.getElementById('levelFilter');

    // Prepopulate the class and level filters based on selected values
    if (courseFilter.value) {
        fetchClasses(courseFilter.value, classFilter.value);
    }

    if (classFilter.value) {
        fetchLevels(courseFilter.value, classFilter.value);
    }

    // Fetch classes dynamically
    courseFilter.addEventListener('change', function () {
        fetchClasses(this.value, "");
    });

    classFilter.addEventListener('change', function () {
        fetchLevels(courseFilter.value, this.value);
    });

    function fetchClasses(course, selectedClass) {
        fetch('get_filters.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `course=${encodeURIComponent(course)}&class=`,
        })
        .then(response => response.json())
        .then(data => {
            classFilter.innerHTML = '<option value="">All Classes</option>';
            data.classes.forEach(cls => {
                const selected = cls === selectedClass ? "selected" : "";
                classFilter.innerHTML += `<option value="${cls}" ${selected}>Class ${cls}</option>`;
            });
        })
        .catch(error => console.error('Error fetching classes:', error));
    }

    function fetchLevels(course, selectedClass) {
        fetch('get_filters.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `course=${encodeURIComponent(course)}&class=${encodeURIComponent(selectedClass)}`,
        })
        .then(response => response.json())
        .then(data => {
            levelFilter.innerHTML = '<option value="">Select Levels Only For English Course</option>';
            data.levels.forEach(level => {
                const selected = level === levelFilter.value ? "selected" : "";
                levelFilter.innerHTML += `<option value="${level}" ${selected}>Level ${level}</option>`;
            });
        })
        .catch(error => console.error('Error fetching levels:', error));
    }
});

</script>
</html>