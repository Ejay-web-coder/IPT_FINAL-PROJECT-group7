<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Page</title>
  <script src="https://cdn.tailwindcss.com"></script>
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
      <a href="manage_user.php" class="bg-blue-500 text-white px-4 py-1 rounded-md">Manage Users</a>
      <a href="approved_job.php">Approve Job</a>
      <a href="monitor_system.php">Monitor System</a>
      <a href="?showLogout=true" class="font-bold">Logout</a>
    </nav>
  </header>

<main class="max-w-4xl mx-auto px-4">
  <?php
    function renderTable($title, $rows) {
      echo "<section class='mb-12'><h2 class='text-lg font-semibold mb-4'>{$title}</h2>
      <table class='w-full border text-sm text-left'>
        <thead class='bg-gray-100'><tr>
          <th class='border px-2 py-1 w-1/5'>Name</th>
          <th class='border px-2 py-1 w-1/5'>Requirements</th>
          <th class='border px-2 py-1 w-1/5'>Contact</th>
          <th class='border px-2 py-1 w-1/5'>Status</th>
          <th class='border px-2 py-1 w-1/5 text-center'>Action</th>
        </tr></thead><tbody>";
      foreach ($rows as $row) {
        echo "<tr>
          <td class='border px-2 py-1'>{$row['name']}</td>
          <td class='border px-2 py-1'><a href='#' class='text-blue-600 text-xs flex items-center gap-1'><i class='fas fa-paperclip text-gray-400'></i>View</a></td>
          <td class='border px-2 py-1'><a href='mailto:{$row['contact']}' class='text-blue-600 text-xs'>{$row['contact']}</a></td>
          <td class='border px-2 py-1'>Pending</td>
          <td class='border px-2 py-1 text-center'><input type='checkbox' checked class='w-4 h-4 accent-teal-400' /></td>
        </tr>";
      }
      echo "</tbody></table>
      <div class='mt-4 flex justify-end gap-4'>
        <button class='bg-teal-400 text-white font-bold px-4 py-1 rounded-full'>Approve</button>
        <button class='bg-red-400 text-white font-bold px-4 py-1 rounded-full'>Reject</button>
      </div></section>";
    }

    renderTable("ORGANIZATION", [
      ["name" => "7-Eleven", "contact" => "7eleven@hhcorp.com"],
      ["name" => "Aling Inasal", "contact" => "alinginasal@kkcorp.com"]
    ]);

    renderTable("STUDENT", [
      ["name" => "Chrisnaire Jake Allado", "contact" => "jake@gmail.com"],
      ["name" => "Djoven Albao", "contact" => "djoven@gmail.com"]
    ]);
  ?>

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
</main>
</body>
</html>
