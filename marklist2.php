<?php
include "rolefilter.php";


// If filters are applied and data needs to be fetched
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['filter'])) {
    $courseFilter = $_POST['course'];
    $classFilter = $_POST['class'];
    $levelFilter = $_POST['level'] ?? '';

    // Dynamically create table name
    $batchname = "class" . $courseFilter . $levelFilter . "c" . $classFilter . "marklist";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JavaScript (important for modal functionality) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Your custom JS -->


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

        <!-- Modal Dialog -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Row</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
    <table id="tabledata">
    <?php if (isset($data)): ?>
       
            <?php
        if ($data->num_rows > 0) {
    // Fetch field names dynamically
    $fields = $data->fetch_fields(); 

    echo "<thead><tr>";
    foreach ($fields as $field) {
        echo "<th>" . htmlspecialchars($field->name) . "</th>";
    }
    echo "<th>Actions</th>";
    echo "</tr></thead>";

    echo "<tbody>";
    while ($row = $data->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>" . htmlspecialchars($value) . "</td>";
        }
        echo "<td>
        <button class='btn btn-primary editBtn' data-id='{$row['id']}'>Edit</button>
        
      </td>";
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

        <form method="POST" action="export2.php">
            <input type="hidden" name="batchname" class="export-btn" value="<?= $batchname ?>">
            <button type="submit" class="export-btn2">Export to CSV</button>
        </form>
    <?php endif; ?>

</body>

<script>
    // ajax to handel edit functionality
    $(document).ready(function () {
        $(document).on('click', '.editBtn', function () {
            const batchname = "<?php echo $batchname; ?>";

            const id = $(this).data('id');
            // const batchname = $('#batchname').val();
            $.ajax({
                url: 'fetch_row.php',
                type: 'POST',
                data: { id, batchname },
                success: function (data) {
                    $('#editFields').html(data);
                    $('#editModal').modal('show');

                    // Recalculate total dynamically
                    $('#edit_mark1, #edit_mark2').on('input', function () {
                        const mark1 = parseFloat($('#edit_mark1').val()) || 0;
                        const mark2 = parseFloat($('#edit_mark2').val()) || 0;
                        const total = mark1 + mark2;
                        $('#edit_total').val(total); // Update total field
                    });
                },
            });
        });

    $('#editForm').submit(function (e) {
    e.preventDefault();

    const formData = $(this).serialize();
    const batchname = "<?php echo $batchname; ?>";
    $.ajax({
        url: 'update_row.php',
        type: 'POST',
        data: {
            formData: formData,
            batchname: batchname,
        },
        success: function (response) {
            if (response.status === 'success') {
                alert(response.message); // Display success message
                $('#editModal').modal('hide');
                location.reload(); // Refresh table data
            } else {
                alert('Error: ' + response.message); // Display error message
            }
        },
        error: function (xhr, status, error) {
            alert('AJAX Error: ' + error); // Handle AJAX errors
        },
    });
});


    });
</script>
</html>
