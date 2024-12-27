<?php
include "rolefilter.php";

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Redirect</title>
    <link href="menustyle.css" rel="stylesheet">





   
</head>
<body>
<?php
    include "header.php";
    ?>
    <div class="container">
    <div class="text-center" style="display: flex; align-items: center; justify-content: center; gap: 0;">
    <img src="images/logo.png" alt="Logo" style="width: 69px; height: auto; margin: 0;">
    <h2 style="margin: 0; line-height: 1;">Select a Course</h2>
</div>


        
        <form method="POST" action="">
    <div class="input-group">
        <label for="course">Course Name:</label>
        <select id="course" name="course" required>
            <option value="">Select a course</option>
            <?php
            // Populate course dropdown
            foreach ($courses as $course): ?>
                <option value="<?= htmlspecialchars($course) ?>"><?= htmlspecialchars($course) ?></option>
            <?php endforeach; ?>
            
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
        <button type="submit" class="btn">Go</button>
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
            case 'ACFN24-1':
            case 'ACFN24-2':    
            case 'ACFN24-3':
                            // header("Location: eng24marklistformatallterms.php?course=$selectedCourse&class=$class&level=$level&term=$term");
                        $url = "acfnmarklistformatterm12and3.php?course=$selectedCourse&class=$class&term=$term&level=$level";
    
                        echo "<script>window.location.href='$url';</script>";
                        exit;
            case 'ACFN24-4':
            case 'ACFN24-5':    
            case 'ACFN24-6':
                                            // header("Location: eng24marklistformatallterms.php?course=$selectedCourse&class=$class&level=$level&term=$term");
                    $url = "acfnmarklistformatterm45and6.php?course=$selectedCourse&class=$class&term=$term&level=$level";
                    
                    echo "<script>window.location.href='$url';</script>";
                    exit;            
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
            case 'PLMB24-1':  
                $url = "plmbmarklistformat.php?course=$selectedCourse&class=$class&term=$term&level=$level";
                echo "<script>window.location.href='$url';</script>";
                exit;
            case 'CNA24-1':
            case 'CNA24-2':
            case 'CNA24-3':
                    $url = "cnamarklistformatterm1to3.php?course=$selectedCourse&class=$class&term=$term&level=$level";
                     echo "<script>window.location.href='$url';</script>";
                    exit;       
            case 'CNA24-4':
                $url = "cnamarklistformatterm4.php?course=$selectedCourse&class=$class&term=$term&level=$level";
                echo "<script>window.location.href='$url';</script>";
               exit;
            case 'CNA24-5':
                $url = "cnamarklistformatterm5.php?course=$selectedCourse&class=$class&term=$term&level=$level";
                echo "<script>window.location.href='$url';</script>";
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
