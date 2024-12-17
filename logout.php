<?php
session_start();
session_destroy(); // Destroy the session
header('Location: login2.php'); // Redirect to login page
exit();
?>
