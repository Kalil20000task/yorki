<?php
require "connection.php";

// Fetch distinct course names
$selectSql = "SELECT * FROM tbl_users";
$courseResult = $conn->query($selectSql);

if ($courseResult->num_rows > 0) {
    while ($row = $courseResult->fetch_assoc()) {
        $selected1 = $row['name'];
        $selected2 = $row['username'];
        $selected3 = $row['password'];



        // Use prepared statement to prevent SQL injection
        $insertSql = $conn->prepare("INSERT INTO users (fullname,username,password) VALUES (?,?,?)");
        $insertSql->bind_param("sss", $selected1,$selected2,$selected3);

        if ($insertSql->execute()) {
            echo "Inserted role: $selected1.$selected2.$selected3<br>";
        } else {
            echo "Error inserting role: " . $conn->error . "<br>";
        }
    }
} else {
    echo "No courses found.";
}

$conn->close();
?>
