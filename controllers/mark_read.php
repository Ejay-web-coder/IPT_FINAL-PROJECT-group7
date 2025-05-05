<?php
include '../controllers/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['notification_id'])) {
  $id = intval($_POST['notification_id']);

  $stmt = $conn->prepare("UPDATE notifications SET status = 'read' WHERE notification_id = ?");
  $stmt->bind_param("i", $id);

  if ($stmt->execute()) {
    echo 'success';
  } else {
    echo 'error';
  }

  $stmt->close();
  $conn->close();
}
?>
