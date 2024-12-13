<?php
if (isset($_GET['id']) && isset($_GET['table'])) {
  $id = $_GET['id'];
  $table = $_GET['table'];

  include 'connection.php';
  $query = "SELECT * FROM $table WHERE id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
  } else {
    echo json_encode([]);
  }
}
?>
