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
    MAX(CASE WHEN term = 5 THEN total END) AS Term5,
    MAX(CASE WHEN term = 6 THEN total END) AS Term6
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
    <link href="liststyles.css" rel="stylesheet">

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
        $stmt->bind_param("sss", $courseFilter, $classFilter, $levelFilter);
        
        // Execute the query
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($data->num_rows > 0) {
            echo "<thead><tr>";
            echo "<th> ID </th>";
            echo "<th> Name </th>";
            echo "<th> CourseName </th>";
            echo "<th> Class </th>";
            $row = $result->fetch_assoc();
            $termcount = $row["term_count"];
            for ($i = 1; $i < $termcount + 1; $i++) {
                echo "<th> Term" . $i . "</th>";
            }
            echo "<th> Total </th>";
            echo "<th> Average </th>";
            echo "<th> Rank </th>";
            echo "</tr></thead>";
            
            // Step 1: Calculate averages for all students
            $students = [];
            while ($row2 = $data->fetch_assoc()) {
                $total = 0;
                if($courseFilter=="CNA24"){
                    for ($i = 1; $i < 5; $i++) {
                        $total += $row2['Term' . $i];
                    }
                    $total=$total/2;
                    $total=$total + $row2['Term5'];
                    $average = $total;
                }
                else{
                for ($i = 1; $i < $termcount + 1; $i++) {
                    $total += $row2['Term' . $i];
                }
                $average = $total / $termcount;
                }
                $students[] = [
                    'id' => $row2['id'],
                    'student_name' => $row2['student_name'],
                    'course_name' => $row2['course_name'],
                    'class' => $row2['class'],
                    'terms' => array_slice($row2, 4, $termcount), // Adjust index for terms
                    'total' => $total,
                    'average' => $average
                ];
            }
            
            // Step 2: Sort students by average in descending order
            usort($students, function($a, $b) {
                return $b['average'] <=> $a['average'];
            });
            
            // Step 3: Assign ranks
            $rank = 1;
            foreach ($students as $key => &$student) {
                if ($key > 0 && $students[$key - 1]['average'] == $student['average']) {
                    $student['rank'] = $students[$key - 1]['rank']; // Same rank for equal averages
                } else {
                    $student['rank'] = $rank;
                }
                $rank++;
            }
            
            // Step 4: Display data with ranks
            echo "<tbody>";
            foreach ($students as $student) {
                echo "<tr>";
                echo "<td>" . $student['id'] . "</td>";
                echo "<td>" . $student['student_name'] . "</td>";
                echo "<td>" . $student['course_name'] . "</td>";
                echo "<td>" . $student['class'] . "</td>";
                for ($i = 1; $i < $termcount + 1; $i++) {
                    echo "<td>" . $student['terms']['Term' . $i] . "</td>";
                }
                echo "<td>" . $student['total'] . "</td>";
                echo "<td>" . number_format($student['average'], 2) . "</td>";
                echo "<td>" . $student['rank'] . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
        } else {
            echo "<thead><tr><th colspan='100%'>No records found</th></tr></thead>";
            echo "<tbody><tr><td colspan='100%'>Please select both course and class.</td></tr></tbody>";
        }
        ?>
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
