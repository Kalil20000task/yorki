<?php
session_start();
if ($_SESSION['role'] !== 'manager') {
    echo "Access denied.";
    exit();
}

// Connect to the database
$servername = "localhost";
$username = "root"; // your db username
$password = ""; // your db password
$dbname = "icemaker_database"; // your db name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch current users
$sql = "SELECT * FROM tbl_users";
$result = $conn->query($sql);
?>

<h3>Manage Users</h3>
<table>
    <tr>
        <th>Name</th>
        <th>Role</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['role']; ?></td>
        <td>
            <button onclick="editUser(<?php echo $row['id']; ?>)">Edit</button>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<script>
function editUser(userId) {
    // Logic to edit user (you can load a separate form or handle it in another way)
    alert("Edit user: " + userId);
}
</script>
