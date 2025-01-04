<?php
// session_start();
include "rolefilter.php";

// If filters are applied and data needs to be fetched
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['filter'])) {
    $courseFilter = $_POST['course'];
    $classFilter = $_POST['class'];
    $levelFilter = $_POST['level'] ?? '';

    // Dynamically create table name
    $batchname = "class" . $courseFilter . $levelFilter . "c" . $classFilter ;
    $sql = "SELECT * FROM `$batchname`";  // Adjust this as per your actual schema
    $data = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marks List</title>
    <!-- <script src="table_edit.js"></script> -->
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JavaScript (important for modal functionality) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="liststyles.css" rel="stylesheet">


<!-- Your custom JS -->




   
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
    </script>
    
</head>
<body>
<?php include "header.php"; ?>

<div class="container">
    <div>
        <h2><?php 
        if(isset($_POST['course'])&& isset($_POST['class'])){
            echo $batchname;
        }
        else{
            echo "<h4>Select Batch</h4>";
        }
        
        ?> </h2>
    <div>
    <form method="POST" class="filter">
        <select id="courseFilter" name="course">
            <option value="">Select Course</option>
            <?php foreach ($courses as $course): ?>
                <option value="<?= htmlspecialchars($course) ?>"><?= htmlspecialchars($course) ?></option>
            <?php endforeach; ?>
        </select>

        <select id="classFilter" name="class">
            <option value="">Select Class</option>
        </select>

        <select id="levelFilter" name="level">
            <option value="">Select Level For English Course only</option>
        </select>

        <button type="submit" name="filter">Filter</button>
    </form>
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Row</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="border: none; background: transparent; color: #007bff; font-size: 1.5rem; padding: 0.5rem 1rem;">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
             

                <div class="modal-body">
                    <form id="editForm">
                        <div id="editFields">
                            <!-- Dynamic form fields go here -->
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($data)): ?>
        <table>
            <?php
        if ($data->num_rows > 0) {
    // Fetch field names dynamically
    $fields = $data->fetch_fields(); 

    echo "<thead><tr>";
    foreach ($fields as $field) {
        echo "<th>" . htmlspecialchars($field->name) . "</th>";
    }
    echo "<th>Edit</th>";
    echo "<th>Delete</th>";
    echo "</tr></thead>";

    echo "<tbody>";
    while ($row = $data->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>" . htmlspecialchars($value) . "</td>";
        }
        echo "<td>
              <button class='btn btn-primary editbtn' data-id='{$row['ID']}' data-table='$batchname'>Edit</button>
            </td>";
        echo "<td>
            <button class='btn btn-danger deletebtn' data-id='{$row['ID']}' data-table='$batchname'>Delete</button>
          </td>";
       
        echo "</tr>";
    }
    echo "</tbody>";
} else {
    echo "<thead><tr><th colspan='100%'>No records found</th></tr></thead>";
    echo "<tbody><tr><td colspan='100%'>Please select both course and class.</td></tr></tbody>";
}
include 'edit_modal.php';

        ?>
    </tbody>
</table>
</container>

        <form method="POST" action="export2.php">
            <input type="hidden" name="batchname" class="export-btn" value="<?= $batchname ?>">
            <button type="submit" class="export-btn2">Export to CSV</button>
        </form>
    <?php endif; ?>

</body>
<script>
    // ajax to handel edit functionality
    $(document).ready(function () {
        $(document).on('click', '.editbtn', function () {
            const batchname = "<?php echo $batchname; ?>";

            const id = $(this).data('id');
            // alert(id);
            // const batchname = $('#batchname').val();
            $.ajax({
                url: 'fetchstudent_row.php',
                type: 'POST',
                data: { id, batchname },
                success: function (data) {
                    $('#editFields').html(data);
                    $('#editModal').modal('show');

                },
            });
        });
        $('#editForm').on('submit', function (e) {
    e.preventDefault(); // Prevent default form submission

    const formData = $(this).serialize(); // Serialize form data
    const batchname = "<?php echo $batchname; ?>"; // Ensure this is properly set

    $.ajax({
        url: 'updatestudent_row.php',
        type: 'POST',
        data: formData + '&batchname=' + batchname, // Append batchname to formData
        success: function (response) {
            try {
                const res = JSON.parse(response); // Parse JSON response
                if (res.status === 'success') {
                    alert(res.message); // Display success message
                    $('#editModal').modal('hide');
                    location.reload(); // Refresh table data
                } else {
                    alert('Error: ' + res.message); // Display error message
                }
            } catch (e) {
                alert('Invalid response from server');
                console.error(response); // Log response for debugging
            }
        },
        error: function (xhr, status, error) {
            alert('AJAX Error: ' + status); // Handle AJAX errors
        },
    });
});
$(document).on('click', '.deletebtn', function () {
    const batchname = "<?php echo $batchname; ?>";
    const id = $(this).data('id');

    // Ask the user for confirmation before deleting
    const confirmDelete = confirm("Are you sure you want to delete this student?");

    if (confirmDelete) {
        // Proceed with the deletion if "Yes"
        $.ajax({
            url: 'deletstudent_row.php',
            type: 'POST',
            data: { id, batchname },
            success: function (data) {
                // You can modify this line to display a success message
                alert("The student record has been deleted successfully.");

                // Optionally, you can reload or update the UI if necessary
               location.reload();
            },
            error: function () {
                // Handle errors if any
                alert("There was an error deleting the record. Please try again.");
            }
        });
    } else {
        // If "No" is clicked, nothing happens
        return false;
    }
});




    });
</script>
</html>
