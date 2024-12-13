<?php
session_start();
require "connection.php";
if ($_SESSION['role']=='admin' ){
    $sql = "SELECT DISTINCT courses FROM course_names";
}
elseif($_SESSION['role']=='office'){
$sql = "SELECT DISTINCT courses FROM course_names";
}
else{
    $courserole=$_SESSION['role'];
    $sql = "SELECT DISTINCT courses FROM course_names where courses='$courserole'";
}
$courseResult = $conn->query($sql);

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Redirect</title>
    <style>
        /* Copy the styles from your HTML */
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
            width: 40%;
        }
        .container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .input-group {
            margin-bottom: 15px;
        }
        .input-group label {
            display: block;
            margin-bottom: 5px;
            color: #ccc;
        }
        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #555;
            border-radius: 5px;
            font-size: 16px;
            background-color: #444;
            color: #f8f8f8;
        }
        .input-group input:focus {
            border-color: #007bff;
        }
        .buttons {
            display: flex;
            justify-content: space-between;
        }
        .buttons button {
            width: 48%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .buttons .submit {
            background-color: #007bff;
            color: #fff;
        }
        .input-group select, .input-group button {
            width: 100%;
            padding: 10px;
            border: 1px solid #555;
            border-radius: 5px;
            background-color: #444;
            color: #fff;
            font-size: 16px;
        }
        button:hover {
            opacity: 0.9;
        }
    </style>
   
</head>
<body>
<?php
    include "header.php";
    ?>
    <div class="container">
        <h2>Select a Course</h2>
        <form method="POST" action="">
    <div class="input-group">
        <label for="course">Course Name:</label>
        <select id="course" name="course" required>
            <option value="">Select a course</option>
            <?php
            // Populate course dropdown
            if ($courseResult->num_rows > 0) {
                while ($row = $courseResult->fetch_assoc()) {
                    $selected = isset($_POST['course']) && $_POST['course'] === $row['courses'] ? 'selected' : '';
                    echo "<option value='" . $row['courses'] . "' $selected>" . $row['courses'] . "</option>";
                }
            } else {
                echo "<option value=''>No courses available</option>";
            }
            ?>
        </select>
    </div>

    <div class="input-group">
        <label for="class">Class:</label>
        <select id="class" name="class" required>
            <option value="">Select a class</option>
            <?php
            if (isset($_POST['course'])) {
                $sqlClasses = "SELECT DISTINCT classes FROM course_names WHERE courses = ?";
                $stmt = $conn->prepare($sqlClasses);
                $stmt->bind_param("s", $_POST['course']);
                $stmt->execute();
                $resultClasses = $stmt->get_result();
                while ($row = $resultClasses->fetch_assoc()) {
                    $selected = isset($_POST['class']) && $_POST['class'] === $row['classes'] ? 'selected' : '';
                    echo "<option value='" . $row['classes'] . "' $selected>" . $row['classes'] . "</option>";
                }
            }
            ?>
        </select>
    </div>

    <div class="input-group">
        <label for="term">Term:</label>
        <select id="term" name="term" required>
            <option value="">Select a term</option>
            <?php
            if (isset($_POST['class'])) {
                $sqlTerms = "SELECT DISTINCT terms FROM course_names WHERE courses = ? AND classes = ?";
                $stmt = $conn->prepare($sqlTerms);
                $stmt->bind_param("ss", $_POST['course'], $_POST['class']);
                $stmt->execute();
                $resultTerms = $stmt->get_result();
                while ($row = $resultTerms->fetch_assoc()) {
                    $selected = isset($_POST['term']) && $_POST['term'] === $row['terms'] ? 'selected' : '';
                    echo "<option value='" . $row['terms'] . "' $selected>" . $row['terms'] . "</option>";
                }
            }
            ?>
        </select>
    </div>
    <!-- <div class="input-group">
            <label for="level">Level Name:</label>
            <select id="level" name="level">
            <option value="">Select level only for English course</option>
            <option value="A0">A0</option>
            <option value="A1">A1</option>

            <option value="A2">A2</option>

            <option value="A3">A3</option>

            <option value="B1">B1</option>

            <option value="B2">B2</option>

            <option value="B3">B3</option>



            </select>



     </div> -->
     <div class="input-group">
    <label for="level">Level Name:</label>
    <select id="level" name="level">
        <option value="">Select level only for English Course</option>
        <?php
        // Check if both course and class are selected
        if (isset($_POST['course']) && isset($_POST['class'])) {
            // Query to get dynamic levels based on the course and class
            $sqlLevels = "SELECT DISTINCT level FROM course_names WHERE courses = ? AND classes = ?";
            $stmt = $conn->prepare($sqlLevels);
            $stmt->bind_param("ss", $_POST['course'], $_POST['class']);
            $stmt->execute();
            $resultLevels = $stmt->get_result();
            while ($row = $resultLevels->fetch_assoc()) {
                echo "<option value='" . $row['level'] . "'>" . $row['level'] . "</option>";
            }
        }
        ?>
    </select>
</div>

     

    <div class="input-group">
        <button type="submit">Go</button>
    </div>
</form>

    </div>

    <?php


         
    // Handle form submission and redirect
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $selectedCourse = $_POST['course'];
        // $selectedCourse = $_POST['course'];
        $class = $_POST['class'];
        $term = $_POST['term'];
        $level = isset($_POST['level']) ? $_POST['level'] : '';

        $selectedCourseterm=$selectedCourse.'-'.$term;
        
        switch ($selectedCourseterm) {
            case 'ACFNs24-1':
            case 'ACFNs24-2':
                    $url = "acfnsmarklistformat_term_1and2.php?course=$selectedCourse&class=$class&term=$term";

                    echo "<script>window.location.href='$url';</script>";
                    exit;

                  
            case 'ACFNs24-3' :
                    // header('Location: acfns_term_1.php');
                    // header("Location: acfnsmarklistformat_term_3.php?course=$selectedCourse&class=$class&term=$term");
                    // echo "<script>window.location.href='acfnsmarklistformat_term_3.php.php';</script>";
                    $url = "acfnsmarklistformat_term_3.php?course=$selectedCourse&class=$class&term=$term";

                    echo "<script>window.location.href='$url';</script>";

                exit;    
            //for all english classes
            case 'ENG24-1':
            case 'ENG24-2':    
            case 'ENG24-3':
                        // header("Location: eng24marklistformatallterms.php?course=$selectedCourse&class=$class&level=$level&term=$term");
                    $url = "eng24marklistformatallterms.php?course=$selectedCourse&class=$class&term=$term&level=$level";

                    echo "<script>window.location.href='$url';</script>";
                    exit;
            case 'DMA24-1':
            case 'DMA24-2':
            case 'DMA24-3':
                $url = "dmmarklistformat.php?course=$selectedCourse&class=$class&term=$term&level=$level";

                echo "<script>window.location.href='$url';</script>";
                exit;

            case 'BM24-1':
                $url = "bmmarklistformat.php?course=$selectedCourse&class=$class&term=$term&level=$level";

                echo "<script>window.location.href='$url';</script>";
                exit;
            case 'AM24-1':
                $url = "ammarklistformat.php?course=$selectedCourse&class=$class&term=$term&level=$level";
    
                echo "<script>window.location.href='$url';</script>";
                exit;    
            case 'CB24-1':
            case 'CB24-2':
            case 'CB24-3':
                    $url = "cbmarklistformat.php?course=$selectedCourse&class=$class&term=$term&level=$level";
        
                    echo "<script>window.location.href='$url';</script>";
                    exit;
            case 'IT24-1':
            case 'IT24-2':
            case 'IT24-3':
                    $url = "itmarklistformat.php?course=$selectedCourse&class=$class&term=$term&level=$level";
                    
                    echo "<script>window.location.href='$url';</script>";
                    exit;        

            case 'IT':
                header('Location: it.php');
                exit;
            default:
                echo '<p style="color: red; text-align: center;">invalid course selection!</p>';
        }
    }
    ?>
</body>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const courseSelect = document.getElementById("course");
    const classInput = document.getElementById("class");
    const termInput = document.getElementById("term");
    const levelInput = document.getElementById("level");

    // Check if the user is revisiting the page
    if (courseSelect.value) {
        fetchClasses(courseSelect.value);
    }

    courseSelect.addEventListener("change", () => {
        const course = courseSelect.value;
        if (course) {
            fetchClasses(course);
        } else {
            classInput.innerHTML = '<option value="">Select a class</option>';
            termInput.innerHTML = '<option value="">Select a term</option>';
            levelInput.innerHTML = '<option value="">Select level (Optional)</option>';
        }
    });

    classInput.addEventListener("change", () => {
        const course = courseSelect.value;
        const selectedClass = classInput.value;
        if (course && selectedClass) {
            fetchTerms(course, selectedClass);
            fetchLevels(course, selectedClass); // Fetch levels when both course and class are selected
        } else {
            termInput.innerHTML = '<option value="">Select a term</option>';
            levelInput.innerHTML = '<option value="">Select level (Optional)</option>';
        }
    });

    function fetchClasses(course) {
        fetch("get_options.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `course=${encodeURIComponent(course)}`
        })
            .then(response => response.json())
            .then(data => {
                classInput.innerHTML = '<option value="">Select a class</option>';
                if (data.classes) {
                    data.classes.forEach(classOption => {
                        const option = document.createElement("option");
                        option.value = classOption;
                        option.textContent = classOption;
                        classInput.appendChild(option);
                    });
                }
            });
    }

    function fetchTerms(course, selectedClass) {
        fetch("get_options.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `course=${encodeURIComponent(course)}&class=${encodeURIComponent(selectedClass)}`
        })
            .then(response => response.json())
            .then(data => {
                termInput.innerHTML = '<option value="">Select a term</option>';
                if (data.terms) {
                    data.terms.forEach(termOption => {
                        const option = document.createElement("option");
                        option.value = termOption;
                        option.textContent = termOption;
                        termInput.appendChild(option);
                    });
                }
            });
    }

    // Fetch the dynamic levels based on course and class
    function fetchLevels(course, selectedClass) {
        fetch("get_options.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `course=${encodeURIComponent(course)}&class=${encodeURIComponent(selectedClass)}`
        })
            .then(response => response.json())
            .then(data => {
                levelInput.innerHTML = '<option value="">Select level (Optional)</option>'; // Reset level options
                if (data.levels) {
                    data.levels.forEach(levelOption => {
                        const option = document.createElement("option");
                        option.value = levelOption;
                        option.textContent = levelOption;
                        levelInput.appendChild(option);
                    });
                }
            });
    }
});


</script>

</html>
