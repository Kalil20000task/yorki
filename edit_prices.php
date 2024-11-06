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

// Fetch current prices
$sql = "SELECT * FROM prices";
$result = $conn->query($sql);
$prices = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $prices[$row['measurement']] = $row['prices'];
    }
}
$conn->close();
?>

<h3>Edit Prices</h3>
<form id="edit-prices-form">
    <label for="ton">Ton (UGX):</label>
    <input type="number" id="ton" name="ton" value="<?php echo $prices['ton']; ?>"><br>
    <label for="jerican">Jerican (UGX):</label>
    <input type="number" id="jerican" name="jerican" value="<?php echo $prices['jerican']; ?>"><br>
    <label for="packet">Packet (UGX):</label>
    <input type="number" id="packet" name="packet" value="<?php echo $prices['packet']; ?>"><br>
    <label for="sacks">Sacks (UGX):</label>
    <input type="number" id="sacks" name="sacks" value="<?php echo $prices['sacks']; ?>"><br>
    <button type="button" onclick="updatePrices()">Update Prices</button>
</form>

<script>
function updatePrices() {
    const form = document.getElementById('edit-prices-form');
    const formData = new FormData(form);

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "update_prices.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert(xhr.responseText);
        }
    };
    xhr.send(formData);
}
</script>
