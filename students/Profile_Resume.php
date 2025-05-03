<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Profile/Resume</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body class="font-sans bg-white">

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
      <a href="Profile_Resume.php" class="bg-orange-500 text-white px-4 py-1 rounded-md">Profile/Resume</a>
      <a href="Notification.php">Notifications</a>
      <a href="?showLogout=true" class="font-bold">Logout</a>
    </nav>
  </header>

<main class="max-w-4xl mx-auto p-4">
  <table class="w-full border text-sm">
    <thead class="bg-gray-200">
      <tr><th class="p-2 border">Field</th><th class="p-2 border">Current Information</th><th class="p-2 border">Action</th></tr>
    </thead>
    <tbody>
      <tr><td class="p-2 border">Full Name</td><td class="p-2 border">Chrisnaire Jake Allado</td><td class="p-2 border">📝 Edit</td></tr>
      <tr><td class="p-2 border">Email</td><td class="p-2 border">alladoej@gmail.com</td><td class="p-2 border">📝 Edit</td></tr>
      <tr><td class="p-2 border">Phone Number</td><td class="p-2 border">09858787833</td><td class="p-2 border">📝 Edit</td></tr>
      <tr><td class="p-2 border">Course</td><td class="p-2 border">BS Information Technology</td><td class="p-2 border">📝 Edit</td></tr>
      <tr><td class="p-2 border">Location</td><td class="p-2 border">Balansay, Mamburao, Occidental Mindoro</td><td class="p-2 border">📝 Edit</td></tr>
      <tr><td class="p-2 border">Resume</td><td class="p-2 border">📄 [View Resume] (resume.pdf)</td><td class="p-2 border">📤 Upload New</td></tr>
      <tr><td class="p-2 border">Profile Picture</td><td class="p-2 border">🖼️ [View Picture]</td><td class="p-2 border">📤 Upload New</td></tr>
      <tr><td colspan="3" class="p-2 text-right border font-semibold">💾 Save</td></tr>
    </tbody>
  </table>
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
