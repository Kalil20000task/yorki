<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $table = $_POST['table'];
   echo $id;
   echo $table;

  $fields = [];
  $values = [];
  foreach ($_POST as $key => $value) {
    if ($key !== 'id' && $key !== 'table') {
      $fields[] = "$key = ?";
      $values[] = $value;
    }
  }
  $values[] = $id; // Add ID for WHERE clause

  $query = "UPDATE $table SET " . implode(', ', $fields) . " WHERE id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param(str_repeat('s', count($values)), ...$values);

  if ($stmt->execute()) {
    echo json_encode(['success' => true]);
  } else {
    echo json_encode(['success' => false]);
  }
}
?>
