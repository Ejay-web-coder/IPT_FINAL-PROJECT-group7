<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Notifications Page</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body class="bg-white font-sans">
<?php
$showModal = isset($_GET['showLogout']) && $_GET['showLogout'] === 'true';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
  header("Location: ../homepage.php"); exit;
}
?>
  <header class="bg-white shadow px-10 py-6 flex justify-between items-center">
  <div class="text-4xl font-extrabold">
    <img src="../image/logo.png" alt="" class="w-20 h-auto"> <!-- Adjusted image size -->
  </div>
    <nav class="text-sm font-medium space-x-8">
      <a href="Profile.php">Profile</a>
      <a href="job_post.php" >Jobs Post</a>
      <a href="requirements.php">Requirements</a>
      <a href="manage_application.php">Manage Application</a>
      <a href="notification_org.php" class="bg-green-500 text-white px-4 py-1 rounded-md font-semibold">Notification</a>
      <a href="?showLogout=true" class="font-bold">Logout</a>
    </nav>
  </header>
  <?php
session_start();
include '../../controllers/connection.php';

// Assume you're storing org ID in session after login
$org_id = $_SESSION['org_id']; // Update based on your session name

$query = $conn->prepare("SELECT n.*, j.job_title 
                         FROM notifications n 
                         JOIN jobs_list j ON n.job_id = j.id 
                         WHERE n.organization_id = ? 
                         ORDER BY n.created_at DESC");
$query->bind_param("i", $org_id);
$query->execute();
$result = $query->get_result();
?>
  <h2 class="text-2xl font-semibold mb-6">Notifications</h2>

  <?php if ($result->num_rows > 0): ?>
    <div class="space-y-4">
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="bg-white p-4 rounded shadow">
          <h3 class="text-lg font-bold text-blue-600">Job: <?= htmlspecialchars($row['job_title']) ?></h3>
          <p class="text-gray-700 mt-2"><?= nl2br(htmlspecialchars($row['message'])) ?></p>
          <p class="text-sm text-gray-500 mt-1">Sent on: <?= $row['created_at'] ?></p>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <p class="text-gray-500">No notifications at the moment.</p>
  <?php endif; ?>

  <?php if ($showModal): ?>
<div class="fixed inset-0 bg-black bg-opacity-30 z-50"></div>
<div class="fixed top-1/2 left-1/2 w-80 bg-white border-2 border-blue-500 rounded-lg p-6 transform -translate-x-1/2 -translate-y-1/2 z-50 text-center">
  <div class="text-4xl text-black mb-4"><i class="fas fa-sign-out-alt"></i></div>
  <p class="text-sm mb-6">Are you sure you want to log out?</p>
  <div class="flex justify-center gap-4">
    <form method="post"><input type="submit" name="logout" value="Logout" class="text-blue-600 font-bold" /></form>
    <form method="get"><input type="submit" value="Cancel" class="bg-blue-200 px-4 py-1 rounded font-bold" /></form>
  </div>
</div>
<?php endif; ?>
</body>
</html>
