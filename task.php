<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Table with Edit</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
    </style>
</head>
<body>
    <h1>Users Table</h1>
    <table id="userTable">
        <thead></thead>
        <tbody></tbody>
    </table>

    <!-- Modal Dialog -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span id="closeModal" style="float:right; cursor:pointer;">&times;</span>
            <h2>Edit User</h2>
            <form id="editForm">
                <!-- Dynamic form content -->
            </form>
            <button id="updateButton">Update</button>
        </div>
    </div>

    <script>
        // Fetch users dynamically
        function fetchUsers() {
            $.ajax({
                url: "fetch_users.php",
                method: "GET",
                dataType: "json",
                success: function(data) {
                    let headers = Object.keys(data[0] || {});
                    let tableHead = '<tr>';
                    headers.forEach(header => {
                        tableHead += `<th>${header}</th>`;
                    });
                    tableHead += '<th>Actions</th></tr>';
                    $('#userTable thead').html(tableHead);

                    let tableBody = '';
                    data.forEach(row => {
                        tableBody += '<tr>';
                        headers.forEach(header => {
                            tableBody += `<td>${row[header]}</td>`;
                        });
                        tableBody += `<td><button class="editButton" data-row='${JSON.stringify(row)}'>Edit</button></td></tr>`;
                    });
                    $('#userTable tbody').html(tableBody);
                }
            });
        }

        // Open the modal with row data
        $(document).on('click', '.editButton', function() {
            let rowData = JSON.parse($(this).attr('data-row'));
            let formContent = '';
            for (let key in rowData) {
                formContent += `
                    <label>${key}:</label>
                    <input type="text" name="${key}" value="${rowData[key]}" ${key === 'id' ? 'readonly' : ''}><br>
                `;
            }
            $('#editForm').html(formContent);
            $('#editModal').show();
        });

        // Close the modal
        $('#closeModal').on('click', function() {
            $('#editModal').hide();
        });

        // Update the row
        $('#updateButton').on('click', function() {
            
            $('#editForm').append('<input type="hidden" name="id" value="1">');

            let formData = $('#editForm').serializeArray();
            let id = formData.find(item => item.name === 'id').value;
            let columns = {};
            formData.forEach(item => {
                if (item.name !== 'id') {
                    columns[item.name] = item.value;
                }
            });

            $.ajax({
                url: "update_user.php",
                method: "POST",
                data: { id, columns },
                success: function(response) {
                    if (response === 'success') {
                        alert('Data updated successfully');
                        fetchUsers();
                        $('#editModal').hide();
                    } else {
                        alert('Failed to update data');
                    }
                }
            });
        });

        // Initialize table
        fetchUsers();
    </script>
</body>
</html>
