<?php
session_start();
include '../controllers/connection.php';

// Ensure the student is logged in
if (!isset($_SESSION['student_id'])) {
  header("Location: ../login_student.php");
  exit;
}

$student_id = $_SESSION['student_id'];

// Fetch notifications for this student
$query = "SELECT * FROM notifications WHERE student_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Student Notifications</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body class="bg-gray-100 font-sans">

  <div class="max-w-4xl mx-auto py-10 px-6">
    <h1 class="text-2xl font-bold mb-6">📬 Notifications</h1>

    <?php if ($result->num_rows > 0): ?>
      <div class="space-y-4">
        <?php while ($note = $result->fetch_assoc()): ?>
          <div class="bg-white p-4 rounded shadow-md flex justify-between items-center">
            <div>
              <p class="text-sm <?= $note['status'] === 'unread' ? 'font-semibold' : 'text-gray-600' ?>">
                <?= nl2br(htmlspecialchars($note['message'])) ?>
              </p>
              <p class="text-xs text-gray-500 mt-1"><?= date('F j, Y g:i A', strtotime($note['created_at'])) ?></p>
            </div>
            <?php if ($note['status'] === 'unread'): ?>
              <form action="mark_read.php" method="post">
                <input type="hidden" name="notification_id" value="<?= $note['notification_id'] ?>">
                <button type="submit" class="text-blue-500 text-sm hover:underline">Mark as Read</button>
              </form>
            <?php else: ?>
              <span class="text-green-500 text-xs">✓ Read</span>
            <?php endif; ?>
          </div>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <p class="text-gray-500">You have no notifications yet.</p>
    <?php endif; ?>
  </div>

</body>
</html>
