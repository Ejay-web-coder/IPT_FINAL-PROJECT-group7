<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Manage Application</title>
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
      <a href="job_post.php">Jobs Post</a>
      <a href="requirements.php">Requirements</a>
      <a href="manage_application.php" class="bg-green-500 text-white px-4 py-1 rounded-md font-semibold">Manage Application</a>
      <a href="notification_org.php">Notification</a>
      <a href="?showLogout=true" class="font-bold">Logout</a>
    </nav>
  </header>

  <main class="px-20 mt-6">
    <table class="w-full border text-sm">
      <thead class="bg-gray-200 text-left text-xs font-semibold text-gray-900">
        <tr>
          <th class="border px-3 py-2">Student Name</th>
          <th class="border px-3 py-2">Resume</th>
          <th class="border px-3 py-2">Application Date</th>
          <th class="border px-3 py-2">Status</th>
          <th class="border px-3 py-2">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr class="border">
          <td class="px-3 py-2">Chrisnaire Jake Allado</td>
          <td class="px-3 py-2 text-blue-500 flex items-center gap-1">
            <i class="fas fa-paperclip"></i>
            <a href="#" class="hover:underline">View Resume</a>
          </td>
          <td class="px-3 py-2">March 30, 2025</td>
          <td class="px-3 py-2">Pending</td>
          <td class="px-3 py-2">
            <label class="inline-flex items-center gap-2">
              <input type="checkbox" class="w-4 h-4 text-emerald-500 border-gray-300 rounded" checked>
              <span>Approved</span>
            </label>
          </td>
        </tr>

        <!-- Duplicate row -->
        <tr class="border">
          <td class="px-3 py-2">Chrisnaire Jake Allado</td>
          <td class="px-3 py-2 text-blue-500 flex items-center gap-1">
            <i class="fas fa-paperclip"></i>
            <a href="#" class="hover:underline">View Resume</a>
          </td>
          <td class="px-3 py-2">March 30, 2025</td>
          <td class="px-3 py-2">Pending</td>
          <td class="px-3 py-2">
            <label class="inline-flex items-center gap-2">
              <input type="checkbox" class="w-4 h-4 text-emerald-500 border-gray-300 rounded" checked>
              <span>Approved</span>
            </label>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="flex justify-end gap-4 mt-4">
      <button class="bg-emerald-400 text-white font-bold rounded-full px-5 py-2 hover:bg-emerald-500 transition">
        Approve
      </button>
      <button class="bg-red-400 text-white font-bold rounded-full px-5 py-2 hover:bg-red-500 transition">
        Reject
      </button>
    </div>
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
