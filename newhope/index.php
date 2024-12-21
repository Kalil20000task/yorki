<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Table Fetcher</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h3>Fetch Data from Dynamic Tables</h3>
        <div class="form-group">
            <label for="batchname">Select Table:</label>
            <select id="batchname" class="form-control">
                <option value="">-- Select Table --</option>
                <option value="newhope">newhope</option>
                <option value="dntgiveup">dntgiveup</option>
                <!-- Add more options as needed -->
            </select>
        </div>
        <table class="table table-bordered">
            <thead id="tableHeader">
                <!-- Dynamic columns go here -->
            </thead>
            <tbody id="tableData">
                <!-- Dynamic rows go here -->
            </tbody>
        </table>
    </div>

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

    <script>
    $(document).ready(function () {
        $('#batchname').change(function () {
            const batchname = $(this).val();
            if (batchname) {
                $.ajax({
                    url: 'fetch_table.php',
                    type: 'POST',
                    data: { batchname },
                    success: function (data) {
                        const result = JSON.parse(data);
                        $('#tableHeader').html(result.header);
                        $('#tableData').html(result.rows);
                    },
                });
            } else {
                $('#tableHeader').html('');
                $('#tableData').html('');
            }
        });

        $(document).on('click', '.editBtn', function () {
            const id = $(this).data('id');
            const batchname = $('#batchname').val();
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
            const formData = $(this).serialize() + '&batchname=' + $('#batchname').val();
            $.ajax({
                url: 'update_row.php',
                type: 'POST',
                data: formData,
                success: function (response) {
                    alert('Row updated successfully!');
                    $('#editModal').modal('hide');
                    $('#batchname').change(); // Refresh table data
                },
            });
        });
    });
</script>

</body>
</html>
