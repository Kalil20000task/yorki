<?php
session_start(); // Start session management

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}
?>
<?php
// Connect to the database to get the prices
$servername = "localhost";
$username = "root"; // change to your database username
$password = ""; // change to your database password
$dbname = "icemaker_database"; // change to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get prices from the table
$sql = "SELECT * FROM prices";
$result = $conn->query($sql);

$prices = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $prices[$row['measurement']] = $row['prices'];
    }
} else {
    echo "No prices found";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: url('images/ice.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }
        .header {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .header .menu-icon {
            font-size: 24px;
            cursor: pointer;
        }
        .header a {
            color: #fff;
            margin: 0 15px;
            text-decoration: none;
            font-size: 18px;
        }
        .header a:hover {
            text-decoration: underline;
        }
        .header .logout-button {
            background-color: red;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
        }
        .drawer {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #333;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }
        .drawer a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 22px;
            color: #fff;
            display: block;
            transition: 0.3s;
        }
        .drawer a:hover {
            background-color: #575757;
        }
        .drawer .close-btn {
            position: absolute;
            top: 10px;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
            cursor: pointer;
        }
        .container {
            background: rgba(0, 0, 0, 0.7);
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
            padding: 20px;
            width: 350px;
            color: #fff;
            margin: 20px auto;
        }
        .container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #f8f8f8;
        }
        .input-group {
            margin-bottom: 15px;
        }
        .input-group label {
            display: block;
            margin-bottom: 5px;
            color: #ccc;
        }
        .input-group input, .input-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #555;
            border-radius: 5px;
            font-size: 16px;
            background-color: #444;
            color: #f8f8f8;
        }
        .input-group input:focus, .input-group select:focus {
            border-color: #007bff;
        }
        .buttons {
            display: flex;
            justify-content: space-between;
            gap: 15px; /* Add gap between buttons */
        }
        .buttons button {
            width: 48%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            background-color: #555;
            color: #f8f8f8;
        }
        .buttons .submit {
            background-color: #007bff;
            color: #fff;
        }
        .buttons .customer {
            background-color: #777; /* Faded background */
            color: #ccc; /* Faded text */
        }
        .buttons .customer.active {
            background-color: #ffc107; /* Bright background for active state */
            color: #000; /* Dark text for active state */
        }
        .buttons button:hover {
            opacity: 0.9;
        }
    </style>
    <script>
        // Function to open the drawer
        function openDrawer() {
            document.getElementById("drawer").style.width = "250px";
        }

        // Function to close the drawer
        function closeDrawer() {
            document.getElementById("drawer").style.width = "0";
        }

        // JavaScript to calculate the total price dynamically
        const prices = <?php echo json_encode($prices); ?>;
        let customerDiscount = false; // Track discount state

        // Function to calculate the total price
        function formatNumberWithCommas(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

// Function to calculate the total price
function calculateTotal() {
    const ton = parseFloat(document.getElementById('ton').value) || 0;
    const jerican = parseFloat(document.getElementById('jerican').value) || 0;
    const packet = parseFloat(document.getElementById('packet').value) || 0;
    const sacks = parseFloat(document.getElementById('sacks').value) || 0;

    let tonPrice = prices['ton'];

    // Apply discount if customer button is active
    if (customerDiscount) {
        tonPrice = Math.max(0, tonPrice - 10000); // Ensure the price does not go negative
    }

    let total = (ton * tonPrice) + (jerican * prices['jerican']) +
                (packet * prices['packet']) + (sacks * prices['sacks']);

    total = Math.round(total); // Round to nearest whole number

    // Display the formatted total in the 'total-display' field
    document.getElementById('total-display').value = formatNumberWithCommas(total);
    // Store the actual total in the hidden 'total' field
    document.getElementById('total-display').value = total;
}

        // Toggle the customer discount
        function toggleCustomerDiscount() {
            customerDiscount = !customerDiscount; // Toggle discount state
            const customerBtn = document.getElementById('customer-btn');
            if (customerDiscount) {
                customerBtn.classList.add('active');
            } else {
                customerBtn.classList.remove('active');
            }
            calculateTotal(); // Recalculate total with new discount state
        }

        function completeTransaction() {
            // Save the data to the database using AJAX
            const currentDate = new Date().toISOString().slice(0, 10);

            const ton = parseFloat(document.getElementById('ton').value) || 0;
            const jerican = parseFloat(document.getElementById('jerican').value) || 0;
            const packet = parseFloat(document.getElementById('packet').value) || 0;
            const sacks = parseFloat(document.getElementById('sacks').value) || 0;
            const category = document.getElementById('category').value;
            const total = parseFloat(document.getElementById('total-display').value)|| 0;

            // Make an AJAX request to save data to the database
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "save_transaction.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert("Transaction completed successfully!");
                    // Reset the form
                    document.getElementById('ton').value = '';
                    document.getElementById('jerican').value = '';
                    document.getElementById('packet').value = '';
                    document.getElementById('sacks').value = '';
                    document.getElementById('total-display').value = '';
                    document.getElementById('category').value = 'haben';
                    customerDiscount = false; // Reset discount
                    document.getElementById('customer-btn').classList.remove('active');
                }
            };
            xhr.send("ton=" + ton + "&jerican=" + jerican + "&packet=" + packet +
                     "&sacks=" + sacks + "&category=" + category + "&total=" + total +
                     "&date=" + currentDate);
        }

        // Event listeners for automatic calculation when input changes
        document.addEventListener('DOMContentLoaded', function () {
            const inputs = document.querySelectorAll('#ton, #jerican, #packet, #sacks');
            inputs.forEach(input => {
                input.addEventListener('input', calculateTotal);
            });
        });




        
    </script>
</head>
<body>
    <div class="header">
        <span class="menu-icon" onclick="openDrawer()">&#9776; Menu</span>
        <div class="menu">
            
        <a href="index.php">Home</a>
        <a href="details.php"> Details</a>
        <a href="attendance.php"> Attendance</a>
        
        </div>
        <a href="logout.php" class="logout-button">Logout</a>
    </div>

    <div id="drawer" class="drawer">
        <span class="close-btn" onclick="closeDrawer()">&times;</span>
        <a href="index.php">Home</a>
        <a href="details.php"> Details</a>
        <a href="attendance.php">Attendance</a>
        <a href="#" onclick="openSettingsModal()"> Settings</a>
        <a href="about.html">ብዛዕባና / About</a>
    </div>

    <div class="container">
        <h2>Mark List</h2>
        <div class="input-group">
            <label for="coursename">Course Name:</label>
            <select id="category" name="course">
                <option value="Accounting_ACFN24_C2L">Accounting_ACFN24_C2L</option>
                <option value="Accounting_ACFN24_C3L">Accounting_ACFN24_C3L</option>
                <option value="Accounting_ACFN24_C2L">Accounting_ACFN24_C4L</option>
                <option value="Accounting_ACFN24_C3L">Accounting_ACFN24_C5L</option>
            </select>
        </div><br/>



        <div class="input-group">
                <label for="StudentName">Student Name:</label>
                <input type="text" id="StudentName" name="name" placeholder="Student Name" required  ">
        </div>
        <div class="input-group">
            <label for="jerican">ጀሪካን  (<?php echo $prices['jerican']; ?> UGX/jerican):</label>
            <input type="number" id="jerican" min="0" step="1">
        </div>
        <div class="input-group">
            <label for="packet">ፓኬት (<?php echo $prices['packet']; ?> UGX/packet):</label>
            <input type="number" id="packet" min="0" step="1">
        </div>
        <div class="input-group">
            <label for="sacks">ሳክስ (<?php echo $prices['sacks']; ?> UGX/sack):</label>
            <input type="number" id="sacks" min="0" step="1">
        </div>
        <div class="input-group">
            <label for="category">ተቐባሊ  ገንዘብ / Received by:</label>
            <select id="category">
                <option value="haben">Haben</option>
                <option value="other">Other</option>
            </select>
        </div>
        <div class="input-group">
    <label for="total-display">ድምር ሕሳብ / Total Price (UGX):</label>
    <input type="text" id="total-display" value="" oninput="updateTotalFromInput()"> <!-- Editable total field -->
    <input type="hidden" id="total"> <!-- Store actual numeric total -->
</div>

        <div class="buttons">
            <button class="submit" onclick="completeTransaction()">ወድእ / Submit</button>
            <button id="customer-btn" class="customer" onclick="toggleCustomerDiscount()">Customer</button>
        </div>
    </div>
</body>
</html>
