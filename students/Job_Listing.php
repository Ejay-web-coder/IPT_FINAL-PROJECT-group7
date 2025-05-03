<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Job Listing</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<style>
    .description {
        word-wrap: break-word; /* Allows long words to be broken and wrap onto the next line */
        overflow-wrap: break-word; /* Ensures that the text wraps correctly */
        max-width: 100%; /* Ensures the description does not exceed the container width */
    }
</style>

<body class="font-sans bg-white text-black">

  <?php
  $showModal = isset($_GET['showLogout']) && $_GET['showLogout'] === 'true';
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
      header("Location: ../homepage.php"); exit;
  }

  include '../connection/db_job_list.php'; // Include your database connection

  // Fetch job listings from the database
  $result = $conn->query("SELECT * FROM jobs");
  if (!$result) {
      die("Query failed: " . $conn->error);
  }
  ?>
  
  <header class="flex justify-between items-center bg-white shadow px-6 py-4">
    <div class="text-4xl font-extrabold">
      <img src="../image/logo.png" alt="" class="w-20 h-auto"> <!-- Adjusted image size -->
    </div>
    <nav class="text-sm font-medium space-x-6">
      <a href="Job_Listing.php" class="bg-orange-500 text-white px-4 py-1 rounded-md">Job Listing</a>
      <a href="Requirements.php">Requirements</a>
      <a href="My_Application.php">My Applications</a>
      <a href="Profile_Resume.php">Profile/Resume</a>
      <a href="Notification.php">Notifications</a>
      <a href="?showLogout=true" class="font-bold">Logout</a>
    </nav>
  </header>

  <main class="max-w-screen-lg mx-auto px-4 pb-12">
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
    <?php
if ($result->num_rows > 0) {
    while ($job = $result->fetch_assoc()): ?>
<div class="border rounded-md shadow-sm p-4">
    <h3 class="font-bold text-sm mb-1"><strong>Type: </strong><?= htmlspecialchars($job['job_title']) ?></h3>
    <p class="text-xs"><strong>Company: </strong><?= htmlspecialchars($job['company_name']) ?></p>
    <p class="text-xs"><strong>Location: </strong><?= htmlspecialchars($job['location']) ?></p>
    <p class="text-xs"><strong>Type: </strong><?= htmlspecialchars($job['job_type']) ?></p>
    <p class="text-xs description"><strong>Description: </strong><?= htmlspecialchars($job['job_description']) ?></p> <!-- Updated key -->
    <p class="text-xs"><strong>Salary: </strong><?= htmlspecialchars($job['salary']) ?></p>
    <p class="text-xs mb-3"><strong>Deadline: </strong><?= htmlspecialchars($job['deadline']) ?></p> <!-- Updated key -->
    <form action="apply.php" method="POST">
        <input type="hidden" name="job_id" value="<?= $job['id'] ?>">
        <button type="submit" class="bg-orange-500 text-white text-xs font-semibold rounded-full px-4 py-1">Apply</button>
    </form>
    </div>
    <?php endwhile;
} else {
    echo '<p class="text-center">No job listings available.</p>';
}
?>
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