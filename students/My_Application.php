<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>My Applications</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter&display=swap');
  </style>
</head>
<body class="bg-white overflow-x-hidden min-h-screen relative">
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
      <a href="My_Application.php" class="bg-orange-500 text-white px-4 py-1 rounded-md">My Applications</a>
      <a href="Profile_Resume.php">Profile/Resume</a>
      <a href="Notification.php">Notifications</a>
      <a href="?showLogout=true" class="font-bold">Logout</a>
    </nav>
  </header>

<main class="max-w-3xl mx-auto px-4 pb-12 space-y-8">
  <?php
    $apps = [
      ["title" => "Store Assistant", "org" => "7-Eleven", "status" => "✅ Submitted (March 2, 2025)", "cancel" => true],
      ["title" => "Sales Associate", "org" => "BEPER", "status" => "🟡 Under Review", "cancel" => true],
      ["title" => "Food Delivery Driver", "org" => "Local Business", "status" => "❌ Rejected (Lacking experience)", "cancel" => false],
    ];
    foreach ($apps as $app): ?>
    <section class="border border-gray-300 p-6 bg-white shadow text-sm leading-tight">
      <ul class="list-disc pl-5 space-y-1">
        <li><strong>Job Title:</strong> <?= $app['title'] ?></li>
        <li>Company/Organization: <?= $app['org'] ?></li>
        <li>Status: <?= $app['status'] ?></li>
        <li>Action: 🔍 <a href="#" class="text-blue-500">View Details</a></li>
        <?php if ($app['cancel']): ?>
          <li class="text-red-600">❌ Cancel Application</li>
        <?php endif; ?>
      </ul>
    </section>
  <?php endforeach; ?>
</main>

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
