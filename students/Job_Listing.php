<?php
session_start(); // Ensure session is started before using $_SESSION
include '../controllers/connection.php'; // Already included

$student_id = $_SESSION['student_id'] ?? null;

if ($student_id) {
    $stmt = $conn->prepare("SELECT name, email, phone FROM signup_students WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        $student = ['name' => 'N/A', 'email' => 'N/A', 'phone' => 'N/A'];
    }

    $stmt->close();
} else {
    $student = ['name' => 'N/A', 'email' => 'N/A', 'phone' => 'N/A'];
}

  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Job Listing</title>
  <script src="../view_c/js/tailwind.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<style>
    .description {
        word-wrap: break-word; 
        overflow-wrap: break-word; 
        max-width: 100%; 
    }
</style>

<body class="font-sans bg-white text-black">

  <?php
  $showModal = isset($_GET['showLogout']) && $_GET['showLogout'] === 'true';
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
      header("Location: ../homepage.php"); exit;
  }

  include '../controllers/connection.php'; 


  $result = $conn->query("SELECT * FROM jobs_list WHERE status = 'approved'");
  if (!$result) {
      die("Query failed: " . $conn->error);
  }
  ?>
  
  <header class="flex justify-between items-center bg-white shadow px-6 py-4">
    <div class="text-4xl font-extrabold">
      <img src="../image/logo.png" alt="" class="w-20 h-auto"> 
    </div>
    <nav class="text-sm font-medium space-x-6">
      <a href="Job_Listing.php" class="bg-orange-500 text-white px-4 py-1 rounded-md">Job Listing</a>
      <a href="My_Application.php">My Applications</a>
      <a href="Profile_Requirements.php">Profile/Requirements</a>
      <a href="Notification.php">Notifications</a>
      <a href="?showLogout=true" class="font-bold">Logout</a>
    </nav>
  </header>

  <main class="max-w-screen-lg mx-auto px-4 pb-12 p-4">
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
    <form method="post" action="" class="mt-2">
  <button type="button" onclick="openApplyModal(<?= $job['id'] ?>)" class="bg-blue-500 text-white px-3 py-1 rounded text-sm">
    Apply
  </button>
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

<!-- Apply Modal -->
<div id="applyModal" class="hidden fixed inset-0 bg-black bg-opacity-30 z-50 flex items-center justify-center">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
    <button onclick="closeApplyModal()" class="absolute top-2 right-2 text-gray-500 text-xl">&times;</button>
    <h2 class="text-xl font-bold mb-4">Apply for Job</h2>

    <!-- Student Profile Preview -->
    <div class="bg-gray-100 p-4 rounded mb-4">
      <p><strong>Name:</strong> <?= htmlspecialchars($student['name']) ?></p>
      <p><strong>Email:</strong> <?= htmlspecialchars($student['email']) ?></p>
      <p><strong>Phone:</strong> <?= htmlspecialchars($student['phone']) ?></p>
      <!-- Add more if needed -->
    </div>

    <!-- Resume Upload Form -->
    <form action="../controllers/apply_job.php" method="post" enctype="multipart/form-data">
  <input type="hidden" id="jobIdInput" name="job_id" value="">
  <div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Upload Resume</label>
    <input type="file" name="resume" required class="mt-1 block w-full border rounded p-1">
  </div>
  <button type="submit" name="submit_application" class="bg-orange-500 text-white px-4 py-2 rounded">
    Submit Application
  </button>
</form>


  </div>
</div>
<script>
function openApplyModal(jobId) {
  document.getElementById('applyModal').classList.remove('hidden');
  document.getElementById('jobIdInput').value = jobId;
}

function closeApplyModal() {
  document.getElementById('applyModal').classList.add('hidden');
}
</script>

</body>
</html>