<?php
require "connection.php";
$tablename = "users";

if (isset($_POST['fullName'])) {
    $fullName = $_POST['fullName'];
    $username = $_POST['userName'];
    $password = $_POST['password'];
    // $role = $_POST['role'];

    if (!empty($fullName)) {
        // Check if a user with the same username and password already exists
        $stmt_check = $conn->prepare("SELECT * FROM $tablename WHERE username = ? AND password = ?");
        $stmt_check->bind_param("ss", $username, $password);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            // User with same username and password exists
            echo json_encode(["status" => "error", "message" => "Incorrect user configuration. User with the same username and password already exists."]);
        } else {
            // If no match is found, insert the new user
            $stmt_insert = $conn->prepare("INSERT INTO $tablename (fullname, username, password) VALUES (?, ?, ?)");
            $stmt_insert->bind_param("sss", $fullName, $username, $password);

            if ($stmt_insert->execute()) {
                echo json_encode(["status" => "success", "message" => "Record inserted successfully!"]);
            } else {
                echo json_encode(["status" => "error", "message" => $stmt_insert->error]);
            }
            $stmt_insert->close();
        }

        $stmt_check->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid user configuration."]);
    }

    $conn->close();
}
?>
