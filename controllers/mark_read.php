<?php
session_start();
include '../controllers/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['notification_id'])) {
  $notification_id = $_POST['notification_id'];

  // Optional: Verify notification belongs to student
  $student_id = $_SESSION['student_id'];
  $query = "UPDATE notifications SET status = 'read' WHERE notification_id = ? AND student_id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("ii", $notification_id, $student_id);
  $stmt->execute();
}

header("Location: student_notifications.php");
exit;