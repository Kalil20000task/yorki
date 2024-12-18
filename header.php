<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session only if it hasn't started yet
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Record</title>
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('images/ice.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #333;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background: linear-gradient(90deg, #007bff, #5a3e36);
            color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header .menu-icon {
            font-size: 26px;
            cursor: pointer;
            display: none;
            color: #fff;
        }

        .header .title h2 {
            margin: 0;
            font-size: 22px;
            font-weight: bold;
            color: #fff;
        }

        .header a {
            color: #fff;
            margin: 0 15px;
            text-decoration: none;
            font-size: 16px;
            padding: 8px 12px;
            border-radius: 4px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .header a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: #ffeb3b;
        }

        .header .logout-button {
            background-color: #e63946;
            color: white;
            padding: 8px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .header .logout-button:hover {
            background-color: #c1272d;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .drawer {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #242424;
            overflow-x: hidden;
            transition: width 0.5s ease;
            padding-top: 60px;
            box-shadow: 4px 0 6px rgba(0, 0, 0, 0.1);
        }

        .drawer a {
            padding: 10px 30px;
            text-decoration: none;
            font-size: 18px;
            color: #fff;
            display: block;
            transition: all 0.3s ease;
        }

        .drawer a:hover {
            background-color: #575757;
            color: #ffeb3b;
        }

        .drawer .close-btn {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 30px;
            cursor: pointer;
            color: #fff;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .header a {
                display: none;
            }
            .header .menu-icon {
                display: block;
            }
        }

        @media (max-width: 768px) {
            .drawer {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Drawer Navigation -->
    <!-- <div id="drawer" class="drawer"> -->
        <!-- <span class="close-btn" onclick="closeDrawer()">&times;</span> -->
        <!-- <a href="index.php">Home</a>
        <a href="details.php">Details</a>
        <a href="attendance.php">Attendance</a> -->
        <!-- <a href="#" onclick="openSettingsModal()">Settings</a> -->
        <!-- <a href="about.html">ብዛዕባና / About</a> -->
    <!-- </div> -->

    <!-- Header Navigation -->
    <div class="header">
        <span class="menu-icon" onclick="openDrawer()">&#9776;</span>
        <div class="title">
            <h2>TrainUp Student Sytem</h2>
        </div>
        
        <!-- <a href="index.php">Home</a> -->

        <?php
        // session_start();
        // Check user role and display links accordingly
        if (isset($_SESSION['role'])) {
            $role = $_SESSION['role'];

            // Admin role - show all links
            if (in_array('admin', $role)) {
                echo '<a href="attendance.php">Attendance</a>';
                echo '<a href="marklistmenu.php">Add Mark</a>';
                echo '<a href="studentlist.php">Students</a>';
                echo '<a href="marklist2.php">Mark List</a>';
                echo '<a href="finalreport.php">Final Report</a>';
                echo '<a href="register_student.php">Register Student</a>';
                echo '<a href="register_staffs.php">Register Staff</a>';
              
            }

            // Manager role - show only some links
            if (in_array('office', $role)) {
                echo '<a href="attendance.php">Attendance</a>';
                echo '<a href="marklistmenu.php">Add Mark</a>';
                echo '<a href="studentlist.php">Students</a>';
                echo '<a href="marklist2.php">Mark List</a>';
                echo '<a href="finalreport.php">Final Report</a>';

                echo '<a href="register_student.php">Register Student</a>';
              
            }

            // Other roles - show restricted links
            else {
                if (!in_array('admin', $role)) {
                echo '<a href="marklistmenu.php">Add Mark</a>';
                echo '<a href="studentlist.php">Students</a>';
                echo '<a href="marklist2.php">Mark List</a>';
                echo '<a href="finalreport.php">Final Report</a>';

            }
        }
    }
        ?>

        <a class="logout-button" href="logout.php">Logout</a>
    </div>

    <script>
        function openDrawer() {
            document.getElementById("drawer").style.width = "250px";
        }

        function closeDrawer() {
            document.getElementById("drawer").style.width = "0";
        }
    </script>
</body>
</html>
