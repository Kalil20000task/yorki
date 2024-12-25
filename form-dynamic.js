$(document).ready(function () {
    // Update classes based on selected course
    $('#coursename').change(function () {
        let courseName = $(this).val();
        $.ajax({
            url: 'fetch_classes.php',
            type: 'POST',
            data: { coursename: courseName },
            success: function (response) {
                $('#classname').html(response);
            }
        });
    });

    // Update levels based on selected course and class
    $('#classname').change(function () {
        let courseName = $('#coursename').val();
        let className = $(this).val();
        $.ajax({
            url: 'fetch_levels.php',
            type: 'POST',
            data: { coursename: courseName, classname: className },
            success: function (response) {
                $('#levelname').html(response);
            }
        });
    });
});
