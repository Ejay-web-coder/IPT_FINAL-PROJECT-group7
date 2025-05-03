<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Approve Job</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <style>
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 0.5rem; text-align: left; }
    th { background-color: #f3f4f6; }
    .action-checkbox { width: 18px; height: 18px; cursor: pointer; accent-color: #00E6B8; }
    #logoutModal { display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); padding: 1rem; background: white; border-radius: 8px; z-index: 9999; }
    .buttons { display: flex; justify-content: flex-end; gap: 1rem; }
    .buttons button { padding: 0.5rem 1.25rem; border-radius: 9999px; cursor: pointer; color: white; font-weight: 800; }
    .approve { background-color: #00e6b8; }
    .reject { background-color: #ff6b6b; }
  </style>
</head>
<body>
<?php
$showModal = isset($_GET['showLogout']) && $_GET['showLogout'] === 'true';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
  header("Location: ../../homepage.php"); exit;
}
?>
  <header class="flex justify-between items-center bg-white shadow px-6 py-4">
  <div class="text-4xl font-extrabold">
    <img src="../../image/logo.png" alt="" class="w-20 h-auto"> <!-- Adjusted image size -->
  </div>
    <nav class="text-sm font-medium space-x-6">
      <a href="manage_user.php">Manage Users</a>
      <a href="approved_job.php" class="bg-blue-500 text-white px-4 py-1 rounded-md">Approve Job</a>
      <a href="monitor_system.php">Monitor System</a>
      <a href="?showLogout=true" class="font-bold">Logout</a>
    </nav>
  </header>

  <main class="p-4">
    <table class="mb-4">
      <thead>
        <tr>
          <th>Job Title</th>
          <th>Organization</th>
          <th>Details</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Retail Assistants</td>
          <td>7-Eleven</td>
          <td><button class="text-blue-600">View Details</button></td>
          <td>Pending</td>
          <td><input type="checkbox" checked class="action-checkbox" /></td>
        </tr>
        <tr>
          <td>Sales Associate</td>
          <td>Beper</td>
          <td><button class="text-blue-600">View Details</button></td>
          <td>Pending</td>
          <td><input type="checkbox" checked class="action-checkbox" /></td>
        </tr>
      </tbody>
    </table>

    <div class="buttons">
      <button class="approve">Approve</button>
      <button class="reject">Reject</button>
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
