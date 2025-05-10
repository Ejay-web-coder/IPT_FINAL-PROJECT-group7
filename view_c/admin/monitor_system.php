<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Monitoring Dashboard</title>
  <script src="../../view_c/js/tailwind.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body class="bg-white font-sans min-h-screen">
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
      <a href="approved_job.php">Approve Job</a>
      <a href="monitor_system.php" class="bg-blue-500 text-white px-4 py-1 rounded-md">Monitor System</a>
      <a href="?showLogout=true" class="font-bold">Logout</a>
    </nav>
  </header>

<main class="max-w-6xl mx-auto px-6 py-8 flex flex-col lg:flex-row gap-8">
  <!-- Activity Table -->
  <section class="flex-1 space-y-8">
    <div class="overflow-x-auto border rounded shadow">
      <table class="w-full text-[11px] border-collapse">
        <thead class="bg-gray-100 text-[12px] font-semibold">
          <tr>
            <th class="border px-3 py-2 text-left">Date & Time</th>
            <th class="border px-3 py-2 text-left">Activity</th>
            <th class="border px-3 py-2 text-left">User Type</th>
            <th class="border px-3 py-2 text-left">User Name</th>
          </tr>
        </thead>
        <tbody class="text-gray-900">
          <tr class="hover:bg-gray-50">
            <td class="border px-3 py-2">2025-03-20 10:30 AM</td>
            <td class="border px-3 py-2">Chrisnaire applied for Retail Assistants</td>
            <td class="border px-3 py-2">Student</td>
            <td class="border px-3 py-2">Juan Dela Cruz</td>
          </tr>
          <tr class="hover:bg-gray-50">
            <td class="border px-3 py-2">2025-03-20 11:00 AM</td>
            <td class="border px-3 py-2">ABC Corporation posted a new job</td>
            <td class="border px-3 py-2">Organization</td>
            <td class="border px-3 py-2">ABC Corporation</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Chart -->
    <div class="bg-white rounded shadow p-4 text-center">
      <h2 class="text-lg font-semibold mb-4">System Overview</h2>
      <div class="grid grid-cols-4 gap-4 text-[10px]">
        <div class="flex flex-col items-center text-[#007AFF]"><div class="w-6 h-20 bg-current"></div>Verified Orgs</div>
        <div class="flex flex-col items-center text-[#00E0B8]"><div class="w-6 h-28 bg-current"></div>Active Students</div>
        <div class="flex flex-col items-center text-[#FF9B00]"><div class="w-6 h-36 bg-current"></div>Applications</div>
        <div class="flex flex-col items-center text-[#8B8BFF]"><div class="w-6 h-44 bg-current"></div>Job Listings</div>
      </div>
    </div>
  </section>

  <!-- Stats -->
  <aside class="w-full sm:w-80 flex flex-col gap-6">
    <?php
      $stats = [
        ['Total Job Listings:', '50', '#8B8BFF'],
        ['Applications Submitted:', '40', '#FF9B00'],
        ['Active Students:', '32', '#00E0B8'],
        ['Verified Organizations:', '20', '#007AFF'],
      ];
      foreach ($stats as [$label, $count, $color]) {
        echo "<div class='border p-5 rounded shadow-sm bg-white text-center'>
                <p class='text-sm text-gray-800 mb-2'>{$label}</p>
                <p class='text-3xl font-semibold select-none' style='color:{$color}'>{$count}</p>
              </div>";
      }
    ?>
  </aside>
</main>

<footer class="text-center text-gray-500 text-xs py-4 border-t mt-auto max-w-6xl mx-auto px-6">
  &copy; 2025 EOCS Monitoring System
</footer>

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
