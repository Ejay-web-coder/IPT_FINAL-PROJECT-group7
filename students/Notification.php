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
$query = "SELECT n.*, o.organization_name 
          FROM notifications n
          LEFT JOIN signup_org o ON n.organization_id = o.id
          WHERE n.student_id = ?
          ORDER BY n.created_at DESC";

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

<body class="bg-white overflow-x-hidden min-h-screen relative">

<?php
$showModal = isset($_GET['showLogout']) && $_GET['showLogout'] === 'true';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
  header("Location: ../homepage.php");
  exit;
}

include '../controllers/connection.php';

// Ensure the student is logged in
if (!isset($_SESSION['student_id'])) {
  header("Location: ../login_student.php");
  exit;
}

$student_id = $_SESSION['student_id'];

// ✅ Step 1: Handle mark as read action before loading notifications
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_as_read'])) {
  $notification_id = intval($_POST['notification_id']);
  $stmt = $conn->prepare("UPDATE notifications SET status = 'read' WHERE notification_id = ?");
  $stmt->bind_param("i", $notification_id);
  $stmt->execute();
  $stmt->close();
}

// Fetch notifications for this student
$query = "SELECT n.*, o.organization_name 
          FROM notifications n
          LEFT JOIN signup_org o ON n.organization_id = o.id
          WHERE n.student_id = ?
          ORDER BY n.created_at DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<header class="flex justify-between items-center bg-white shadow px-6 py-4">
  <div class="text-4xl font-extrabold">
    <img src="../image/logo.png" alt="" class="w-20 h-auto">
  </div>
  <nav class="text-sm font-medium space-x-6">
    <a href="Job_Listing.php">Job Listing</a>
    <a href="My_Application.php">My Applications</a>
    <a href="Profile_Requirements.php">Profile/Requirements</a>
    <a href="Notification.php" class="bg-orange-500 text-white px-4 py-1 rounded-md">Notifications</a>
    <a href="?showLogout=true" class="font-bold">Logout</a>
  </nav>
</header>

<div class="max-w-4xl mx-auto py-10 px-6">
  <h1 class="text-2xl font-bold mb-6">📬 Notifications</h1>

  <?php if ($result->num_rows > 0): ?>
    <div class="space-y-4">
      <?php while ($note = $result->fetch_assoc()): ?>
        <div class="bg-white p-4 rounded shadow-md flex justify-between items-center notification-box" data-id="<?= $note['notification_id'] ?>">
          <div>
          <p class="text-sm message-text <?= $note['status'] === 'unread' ? 'font-semibold' : 'text-gray-600' ?>">

  <?= nl2br(htmlspecialchars($note['message'])) ?>
</p>

            </p>
            <p class="text-xs text-gray-500 mt-1">
              From: <span class="text-black font-medium"><?= htmlspecialchars($note['organization_name'] ?? 'Unknown') ?></span><br>
              <?= date('F j, Y g:i A', strtotime($note['created_at'])) ?>
            </p>
          </div>
          <div>
            <?php if ($note['status'] === 'unread'): ?>
              <form method="post" class="inline">
  <input type="hidden" name="notification_id" value="<?= $note['notification_id'] ?>">
  <button type="submit" name="mark_as_read" class="text-blue-500 text-sm hover:underline">Mark as Read</button>
</form>


            <?php else: ?>
              <span class="text-green-500 text-xs">✓ Read</span>
            <?php endif; ?>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <p class="text-gray-500">You have no notifications yet.</p>
  <?php endif; ?>
</div>

<?php if ($showModal): ?>
  <div class="fixed inset-0 bg-black bg-opacity-30 z-50 flex items-center justify-center">
    <div class="bg-white border-2 border-blue-500 rounded-lg p-6 w-80 text-center space-y-4">
      <div class="text-3xl"><i class="fas fa-sign-out-alt"></i></div>
      <p class="text-xs">Are you sure to log-out?</p>
      <div class="flex justify-center gap-4">
        <form method="post"><button name="logout" class="text-blue-600 font-bold">Logout</button></form>
        <form method="get"><button class="bg-blue-200 px-3 py-1 rounded font-bold">Cancel</button></form>
      </div>
    </div>
  </div>
<?php endif; ?>

</body>
</html>
