<?php
require "connection.php";
$tablename = "users";

header('Content-Type: application/json'); // Ensure JSON response

$response = []; // Initialize response array

try {
    if (isset($_POST['fullName'])) {
        $fullName = $_POST['fullName'];
        $username = $_POST['userName'];
        $password = $_POST['password'];
        $selectedRoles = isset($_POST['roles']) ? $_POST['roles'] : [];

        if (!empty($fullName)) {
            // Check if a user with the same username and password already exists
            $stmt_check = $conn->prepare("SELECT * FROM $tablename WHERE username = ? AND password = ?");
            $stmt_check->bind_param("ss", $username, $password);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if ($result_check->num_rows > 0) {
                // User with the same username and password exists
                $response = ["status" => "error", "message" => "User with the same username and password already exists."];
            } else {
                // Insert the new user
                $stmt_insert = $conn->prepare("INSERT INTO $tablename (fullname, username, password) VALUES (?, ?, ?)");
                $stmt_insert->bind_param("sss", $fullName, $username, $password);

                if ($stmt_insert->execute()) {
                    // Retrieve the user_id of the newly inserted user
                    $stmt_user_id = $conn->prepare("SELECT user_id FROM $tablename WHERE username = ?");
                    $stmt_user_id->bind_param("s", $username);
                    $stmt_user_id->execute();
                    $result_user_id = $stmt_user_id->get_result();
                    $user_id = $result_user_id->fetch_assoc()['user_id'];
                    $stmt_user_id->close();

                    $response = ["status" => "success", "message" => "User registered successfully!", "user_id" => $user_id];

                    // Process roles
                    if (!empty($selectedRoles)) {
                        // Fetch existing roles
                        $existingRoles = [];
                        $query = "SELECT role_name FROM roles";
                        $result = $conn->query($query);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $existingRoles[] = $row['role_name'];
                            }
                        }

                        // Identify and add new roles
                        $newRoles = array_diff($selectedRoles, $existingRoles);

                        if (!empty($newRoles)) {
                            $stmt = $conn->prepare("INSERT INTO roles (role_name) VALUES (?)");
                            foreach ($newRoles as $role) {
                                $stmt->bind_param("s", $role);
                                $stmt->execute();
                            }
                            $stmt->close();
                        }

                        // Map user to roles in the userroles table
                        foreach ($selectedRoles as $role) {
                            // Get the role_id for the current role
                            $stmt_role_id = $conn->prepare("SELECT role_id FROM roles WHERE role_name = ?");
                            $stmt_role_id->bind_param("s", $role);
                            $stmt_role_id->execute();
                            $result_role_id = $stmt_role_id->get_result();
                            $role_id = $result_role_id->fetch_assoc()['role_id'];
                            $stmt_role_id->close();

                            // Insert the user_id and role_id into the userroles table
                            $stmt_userroles = $conn->prepare("INSERT INTO userroles (user_id, role_id) VALUES (?, ?)");
                            $stmt_userroles->bind_param("ii", $user_id, $role_id);
                            $stmt_userroles->execute();
                            $stmt_userroles->close();
                        }

                        $response["roles_message"] = "Roles processed and linked to the user successfully!";
                    }
                } else {
                    $response = ["status" => "error", "message" => $stmt_insert->error];
                }
                $stmt_insert->close();
            }
            $stmt_check->close();
        } else {
            $response = ["status" => "error", "message" => "Invalid user configuration."];
        }
    } else {
        $response = ["status" => "error", "message" => "Invalid request."];
    }
} catch (Exception $e) {
    $response = ["status" => "error", "message" => "An error occurred: " . $e->getMessage()];
}

$conn->close();

// Output the JSON response
echo json_encode($response);
?>
