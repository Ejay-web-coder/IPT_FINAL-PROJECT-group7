<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Notifications</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body class="font-sans bg-white text-black">
<?php
$showModal = isset($_GET['showLogout']) && $_GET['showLogout'] === 'true';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
  header("Location: ../homepage.php"); exit;
}
?>
  <header class="flex justify-between items-center bg-white shadow px-6 py-4">
  <div class="text-4xl font-extrabold">
    <img src="../image/logo.png" alt="" class="w-20 h-auto"> <!-- Adjusted image size -->
  </div>
    <nav class="text-sm font-medium space-x-6">
      <a href="Job_Listing.php">Job Listing</a>
      <a href="Requirements.php">Requirements</a>
      <a href="My_Application.php">My Applications</a>
      <a href="Profile_Resume.php">Profile/Resume</a>
      <a href="Notification.php" class="bg-orange-500 text-white px-4 py-1 rounded-md">Notifications</a>
      <a href="?showLogout=true" class="font-bold">Logout</a>
    </nav>
  </header>

<main class="px-6 md:px-20 pb-20">
  <section class="max-w-2xl border p-6 mx-auto space-y-6">
    <h2 class="text-xl font-bold">Notifications</h2>
    <div class="flex justify-between border-b pb-2 text-sm font-medium">
      <a href="#" class="text-blue-500 flex items-center gap-1">Today <span class="bg-blue-500 text-white text-xs px-2 py-0.5 rounded-full">3</span></a>
      <div class="flex gap-4 text-black">
        <span>Previous</span><span>Mark as read</span><a href="#" class="text-red-600">Clear all</a>
      </div>
    </div>

    <div class="flex items-center gap-4">
      <span class="w-3.5 h-3.5 bg-blue-900 rounded-full"></span>
      <img src="https://placehold.co/60x60/png?text=7-Eleven+Logo" alt="7-Eleven logo" class="w-14 h-14 rounded-full border" />
      <p>Congratulations! You've been selected for an interview.</p>
    </div>
    <hr />
    <div class="flex items-center gap-4 text-gray-600">
      <img src="https://placehold.co/60x60/png?text=BEPER+Logo" alt="BEPER logo" class="w-14 h-14 rounded-full border" />
      <p>We're sorry, this position has been filled.</p>
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
