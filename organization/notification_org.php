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

  <main class="px-6 md:px-20 pb-20">
    <section class="border border-gray-300 max-w-2xl mx-auto p-6 mt-6">
      <h2 class="text-xl mb-4 font-semibold">Notifications</h2>

      <div class="flex justify-between items-center text-sm font-normal border-b border-black pb-2 mb-4">
        <div class="flex items-center gap-2 text-blue-500">
          <a href="#" class="flex items-center gap-1">
            Today 
            <span class="bg-blue-500 text-white text-xs font-bold w-4 h-4 flex items-center justify-center rounded-full">3</span>
          </a>
        </div>
        <div class="flex gap-6 text-black">
          <span>Previous</span>
          <span>Mark as read</span>
          <a href="#" class="text-red-600">Clear all</a>
        </div>
      </div>

      <div class="flex items-center gap-6 mb-6">
        <span class="w-4 h-4 bg-blue-900 rounded-full"></span>
        <img src="https://placehold.co/60x60/png?text=7-Eleven+Logo" alt="7-Eleven logo" class="w-14 h-14 rounded-full border border-gray-300 bg-white object-contain">
        <p class="text-base m-0">Congratulations! You've been selected for an interview.</p>
      </div>

      <hr class="border-t border-black mb-6" />

      <div class="flex items-center gap-6 text-gray-600">
        <img src="https://placehold.co/60x60/png?text=BEPER+Logo" alt="BEPER logo" class="w-14 h-14 rounded-full border border-gray-300 bg-white object-contain">
        <p class="text-base m-0">We're sorry, this position has been filled.</p>
      </div>
    </section>
  </main>
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
