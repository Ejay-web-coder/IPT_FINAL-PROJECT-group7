<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Job Requirement Form</title>
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
      <a href="Requirements.php" class="bg-orange-500 text-white px-4 py-1 rounded-md">Requirements</a>
      <a href="My_Application.php">My Applications</a>
      <a href="Profile_Resume.php">Profile/Resume</a>
      <a href="Notification.php">Notifications</a>
      <a href="?showLogout=true" class="font-bold">Logout</a>
    </nav>
  </header>

<main class="max-w-2xl mx-auto p-6">
  <form class="border border-gray-300 p-6 space-y-6">
    <h1 class="text-lg font-medium">Job Requirement Form</h1>

    <?php
      $fields = [
        'student-id' => 'Student ID',
        'cor' => 'COR',
        'barangay-indigency' => 'Barangay Indigency',
        'resume' => 'Resume'
      ];
      foreach ($fields as $id => $label): ?>
        <div>
          <label class="text-xs font-medium mb-1 block" for="<?= $id ?>"><?= $label ?></label>
          <label for="<?= $id ?>" class="border border-gray-300 h-16 flex flex-col justify-center items-center cursor-pointer space-y-1">
            <img src="https://storage.googleapis.com/a1aa/image/b8a860bc-37a9-47b0-b5f7-6ca4fac3dbf5.jpg" alt="Upload" class="w-5 h-5" />
            <span class="text-xs font-bold leading-none">Upload a File</span>
            <span class="text-[10px] leading-none">Drag and drop files here</span>
            <input type="file" id="<?= $id ?>" name="<?= $id ?>" class="hidden" />
          </label>
        </div>
    <?php endforeach; ?>

    <div class="text-right">
      <button type="submit" class="bg-orange-400 text-white text-xs font-semibold px-6 py-1 rounded-full shadow-md">Submit</button>
    </div>
  </form>
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
