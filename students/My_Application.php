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
      <a href="My_Application.php" class="bg-orange-500 text-white px-4 py-1 rounded-md">My Applications</a>
      <a href="Profile_Requirements.php">Profile/Requirements</a>
      <a href="Notification.php">Notifications</a>
      <a href="?showLogout=true" class="font-bold">Logout</a>
    </nav>
  </header>

  <?php
session_start();
include '../controllers/connection.php';

$student_id = $_SESSION['student_id'] ?? null;

if (!$student_id) {
    echo "<p>Please log in to view your applications.</p>";
    exit;
}

$query = "SELECT 
            a.resume_path,
            a.status,
            a.applied_at,
            j.job_title,
            j.company_name,
            j.location,
            j.salary
          FROM applications a
          JOIN jobs_list j ON a.job_id = j.id
          WHERE a.student_id = ?
          ORDER BY a.applied_at DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
?>

  <div class="max-w-6xl mx-auto py-10 px-4">
    <h1 class="text-2xl font-bold mb-6">My Job Applications</h1>

    <?php if ($result->num_rows > 0): ?>
      <div class="space-y-6">
        <?php while ($row = $result->fetch_assoc()): ?>
          <div class="bg-white shadow p-6 rounded">
            <h2 class="text-lg font-bold"><?= htmlspecialchars($row['job_title']) ?></h2>
            <p class="text-sm text-gray-600">
              Company: <?= htmlspecialchars($row['company_name']) ?> | Location: <?= htmlspecialchars($row['location']) ?>
            </p>
            <p class="text-sm">Salary: <?= htmlspecialchars($row['salary']) ?></p>
            <p class="text-sm">Applied on: <?= htmlspecialchars($row['applied_at']) ?></p>
            <p class="text-sm">Resume: 
              <a href="../uploads/resumes/<?= urlencode($row['resume_path']) ?>" target="_blank" class="text-blue-600 underline">View</a>
            </p>
            <p class="mt-2 text-sm font-medium">Status: 
              <span class="<?= 
                $row['status'] === 'pending' ? 'text-yellow-600' : 
                ($row['status'] === 'approved' ? 'text-green-600' : 'text-red-600') ?>">
                <?= ucfirst($row['status']) ?>
              </span>
            </p>
          </div>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <p class="text-gray-500">You haven't applied to any jobs yet.</p>
    <?php endif; ?>

  </div>


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
