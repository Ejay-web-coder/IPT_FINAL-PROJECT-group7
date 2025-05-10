<?php
include '../../controllers/connection.php';

// Handle approval/rejection
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'], $_POST['job_id'])) {
        $job_id = $_POST['job_id'];
        $action = $_POST['action'];

        if ($action === 'approve') {
            $stmt = $conn->prepare("UPDATE jobs_list SET status = 'approved' WHERE id = ?");
        } elseif ($action === 'reject') {
            $stmt = $conn->prepare("UPDATE jobs_list SET status = 'rejected' WHERE id = ?");
        }

        if (isset($stmt)) {
            $stmt->bind_param("i", $job_id);
            $stmt->execute();
            $stmt->close();
        }
    }
}
$showModal = isset($_GET['showLogout']) && $_GET['showLogout'] === 'true';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_destroy();
    header("Location: ../../homepage.php");
    exit();
}
// Get all pending jobs
$result = $conn->query("SELECT * FROM jobs_list WHERE status = 'pending'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Approve Job</title>
  <script src="../../view_c/js/tailwind.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body class="bg-gray-100 font-sans min-h-screen">

  <!-- Header -->
  <header class="flex justify-between items-center bg-white shadow px-6 py-4">
    <div class="text-4xl font-extrabold">
      <img src="../../image/logo.png" alt="Logo" class="w-20 h-auto">
    </div>
    <nav class="text-sm font-medium space-x-6">
      <a href="manage_user.php">Manage Users</a>
      <a href="approved_job.php" class="bg-blue-500 text-white px-4 py-1 rounded-md">Approve Job</a>
      <a href="monitor_system.php">Monitor System</a>
      <a href="?showLogout=true" class="font-bold">Logout</a>
    </nav>
  </header>

  <!-- Job Listings -->
  <main class="p-6">
    <h2 class="text-2xl font-semibold mb-6">Pending Job Listings</h2>

    <?php if ($result->num_rows > 0): ?>
      <div class="grid gap-4">
        <?php while ($row = $result->fetch_assoc()): ?>
          <div class="bg-white p-4 rounded shadow space-y-2">
            <h3 class="text-xl font-bold"><?php echo htmlspecialchars($row['job_title']); ?></h3>
            <p><strong>Company:</strong> <?php echo htmlspecialchars($row['company_name']); ?></p>
            <p><strong>Type:</strong> <?php echo htmlspecialchars($row['job_type']); ?></p>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
            <p><strong>Salary:</strong> <?php echo htmlspecialchars($row['salary']); ?></p>
            <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($row['job_description'])); ?></p>
            <p><strong>Deadline:</strong> <?php echo htmlspecialchars($row['deadline']); ?></p>

            <form method="POST" class="flex space-x-2 mt-2">
              <input type="hidden" name="job_id" value="<?php echo $row['id']; ?>">
              <button type="submit" name="action" value="approve" class="px-3 py-1 bg-green-500 text-white rounded">Approve</button>
              <button type="submit" name="action" value="reject" class="px-3 py-1 bg-red-500 text-white rounded">Reject</button>
            </form>
          </div>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <p class="text-gray-600">No pending jobs at the moment.</p>
    <?php endif; ?>
  </main>

<!-- Logout Modal -->
<?php if ($showModal): ?>
  <div class="fixed inset-0 bg-black bg-opacity-30 z-40"></div>
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
