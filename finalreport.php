<?php
include "rolefilter.php";


// If filters are applied and data needs to be fetched
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['filter'])) {
    $courseFilter = $_POST['course'];
    $classFilter = $_POST['class'];
    $levelFilter = $_POST['level'] ?? '';

    // Dynamically create table name
    $batchname = "class" . $courseFilter . $levelFilter . "c" . $classFilter . "marklist";
    // $sql = "SELECT distinct id,student_name,course_name,total FROM `$batchname`";  // Adjust this as per your actual schema
    $sql="SELECT
    id,
    student_name,
    course_name,
    class,
    MAX(CASE WHEN term = 1 THEN total END) AS Term1,
    MAX(CASE WHEN term = 2 THEN total END) AS Term2,
    MAX(CASE WHEN term = 3 THEN total END) AS Term3,
    MAX(CASE WHEN term = 4 THEN total END) AS Term4,
    MAX(CASE WHEN term = 5 THEN total END) AS Term5
FROM 
    `$batchname`
GROUP BY 
    student_name, course_name,class";
    $data = $conn->query($sql);
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
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            word-wrap:break-word;
            table-layout:fixed;
        }
        table, th, td {
            border: 1px solid #555;
        }
        th, td {
            padding: 10px;
            text-align: center;
            
        }
        td{
            white-space: nowrap;
        }
        td.long-text {
    white-space: normal; /* Allows breaking long text into multiple lines for specific cells */
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
        .export-btn2 {
            background-color: #28a745;
            border: none;
            color: white;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
    <?php include "header.php"; ?>
</head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Filter Page</title>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const courseFilter = document.getElementById('courseFilter');
            const classFilter = document.getElementById('classFilter');
            const levelFilter = document.getElementById('levelFilter');

            // Fetch classes and levels when course or class changes
            courseFilter.addEventListener('change', function () {
                fetchClasses(this.value);
            });

            classFilter.addEventListener('change', function () {
                fetchLevels(courseFilter.value, this.value);
            });

            // Fetch available classes based on course
            function fetchClasses(course) {
                fetch('get_filters2.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `course=${encodeURIComponent(course)}`
                })
                .then(response => response.json())
                .then(data => {
                    classFilter.innerHTML = '<option value="">All Classes</option>';
                    data.classes.forEach(cls => {
                        classFilter.innerHTML += `<option value="${cls}">${cls}</option>`;
                    });
                });
            }

            // Fetch available levels based on course and class
            function fetchLevels(course, classVal) {
                fetch('get_filters2.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `course=${encodeURIComponent(course)}&class=${encodeURIComponent(classVal)}`
                })
                .then(response => response.json())
                .then(data => {
                    levelFilter.innerHTML = '<option value="">Select Level</option>';
                    data.levels.forEach(level => {
                        levelFilter.innerHTML += `<option value="${level}">${level}</option>`;
                    });
                });
            }
        });
        function exportTableToExcel(tableID, filename = '') {
            let downloadLink;
            let dataType = 'application/vnd.ms-excel';
            let tableSelect = document.getElementById(tableID);
            let tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
            
            // Specify file name
            filename = filename ? filename + '.xls' : 'excel_data.xls';
            
            // Create download link element
            downloadLink = document.createElement("a");
            
            document.body.appendChild(downloadLink);
            
            if (navigator.msSaveOrOpenBlob) {
                let blob = new Blob(['\ufeff', tableHTML], {
                    type: dataType
                });
                navigator.msSaveOrOpenBlob(blob, filename);
            } else {
                // Create a link to the file
                downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
                
                // Setting the file name
                downloadLink.download = filename;
                
                // Trigger the function
                downloadLink.click();
            }
        }
    </script>
</head>
<body>
<div class="container">
    <form method="POST" class="filter">
        <select id="courseFilter" name="course">
            <option value="">Select Course</option>
            <?php foreach ($courses as $course): ?>
                <option value="<?= $course ?>"><?= $course ?></option>
            <?php endforeach; ?>
        </select>

        <select id="classFilter" name="class">
            <option value="">Select Class</option>
        </select>

        <select id="levelFilter" name="level">
            <option value="">Select Level</option>
        </select>

        <button type="submit" name="filter">Filter</button>
    </form>

    <?php if (isset($data)): ?>
        <table id="studentTable">
            <?php
            $stmt = $conn->prepare("SELECT COUNT(terms) AS term_count FROM course_names WHERE courses = ? AND classes = ? AND level = ?");
             $stmt->bind_param("sss", $courseFilter,$classFilter,$levelFilter);
        
        // Execute the query
             $stmt->execute();
             $result = $stmt->get_result();
        
        if ($data->num_rows > 0) {
    // Fetch field names dynamically
    // $fields = $data->fetch_fields(); 

    echo "<thead><tr>";
    echo "<th> ID </th>";
    echo "<th> Name </th>";
    echo "<th> CourseName </th>";
    echo "<th> Class </th>";
    // echo "<th>" . htmlspecialchars($field->name) . "</th>";
    $row = $result->fetch_assoc();
    $termcount=$row["term_count"];
    for ($i = 1; $i < $termcount+1; $i++) {
        echo "<th> Term".$i. "</th>";
    }
    echo "<th> Total </th>";
    echo "<th> Average </th>";
    // echo "<th> Rank </th>";
    
    echo "</tr></thead>";


    echo "<tbody>";
    
    
    // while ($row2 = $data->fetch_assoc()) {
    //     $total=$total + $row2['total'];
    // }
    while ($row2 = $data->fetch_assoc()) {
        //calculating the total sum of the term results
        $total=0;
        for ($i = 1; $i < $termcount+1; $i++) {
            $total=$total+ $row2['Term'.$i];
        }
        echo "<tr>";
        // foreach ($row as $value) {
            echo "<td>" . $row2['id'] . "</td>";
            echo "<td>" . $row2['student_name'] . "</td>";
            echo "<td>" . $row2['course_name'] . "</td>";
            echo "<td>" . $row2['class'] . "</td>";
            for ($i = 1; $i < $termcount+1; $i++) {
                echo "<td>" . $row2['Term'.$i] ."</td>";
            }
            echo "<td>" . $total . "</td>";
            //callculating the average
            echo "<td>" . $total/$termcount . "</td>";
          
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
</container>

        <!-- <form method="POST" action="export2.php"> -->
            <!-- <input type="hidden" name="batchname" class="export-btn" value="<?= $batchname ?>"> -->
            <!-- <button type="submit" class="export-btn2">Export to CSV</button> -->
            <button onclick="exportTableToExcel('studentTable', '<?php echo $batchname; ?>')" class="export-btn2" name="batchname">Export to Excel</button>

        <!-- </form> -->
    <?php endif; ?>

</body>
</html>
