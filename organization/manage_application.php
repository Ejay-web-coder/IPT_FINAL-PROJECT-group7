<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Manage Application</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <script>
    function showModal(action, applicationId) {
      const modal = document.getElementById(action + '-modal-' + applicationId);
      modal.classList.remove('hidden');
    }

    function closeModal(action, applicationId) {
      const modal = document.getElementById(action + '-modal-' + applicationId);
      modal.classList.add('hidden');
    }
  </script>
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

  <?php
session_start();
include '../controllers/connection.php';

// OPTIONAL: Filter applications only from jobs posted by the current organization
// $org_id = $_SESSION['organization_id'];

$query = "SELECT 
            a.id AS application_id,
            a.resume_path,
            a.status,
            a.applied_at,
            s.name AS student_name,
            s.email,
            s.phone,
            j.job_title,
            j.company_name
          FROM applications a
          JOIN signup_students s ON a.student_id = s.student_id
          JOIN jobs_list j ON a.job_id = j.id
          ORDER BY a.applied_at DESC";

$result = $conn->query($query);
?>

  <div class="max-w-6xl mx-auto py-10 px-4">
    <h1 class="text-2xl font-bold mb-6">Pending Job Applications</h1>

    <?php if ($result && $result->num_rows > 0): ?>
      <div class="grid gap-6">
        <?php while ($app = $result->fetch_assoc()): ?>
        <div class="bg-white rounded shadow p-6">
          <h2 class="text-lg font-semibold"><?= htmlspecialchars($app['student_name']) ?> applied for <span class="text-orange-600"><?= htmlspecialchars($app['job_title']) ?></span></h2>
          <p class="text-sm text-gray-600">Company: <?= htmlspecialchars($app['company_name']) ?> | Applied on: <?= htmlspecialchars($app['applied_at']) ?></p>
          <p class="text-sm mt-2">Email: <?= htmlspecialchars($app['email']) ?> | Phone: <?= htmlspecialchars($app['phone']) ?></p>
          <p class="text-sm mt-2">Resume: 
            <a href="../uploads/resumes/<?= urlencode($app['resume_path']) ?>" target="_blank" class="text-blue-600 underline">View</a>
          </p>
          <p class="mt-2 text-sm font-medium">Status: 
            <span class="<?= $app['status'] === 'pending' ? 'text-yellow-600' : ($app['status'] === 'approved' ? 'text-green-600' : 'text-red-600') ?>">
              <?= ucfirst($app['status']) ?>
            </span>
          </p>

          <?php if ($app['status'] === 'pending'): ?>
            <form action="../controllers/update_application.php" method="post" class="flex gap-2 mt-4">
              <input type="hidden" name="application_id" value="<?= $app['application_id'] ?>">
              <button type="button" onclick="showModal('approve', <?= $app['application_id'] ?>)" class="bg-green-500 text-white px-4 py-1 rounded">Approve</button>
              <button type="button" onclick="showModal('reject', <?= $app['application_id'] ?>)" class="bg-red-500 text-white px-4 py-1 rounded">Reject</button>
            </form>
          <?php endif; ?>
        </div>

       <!-- Approve Modal -->
<div id="approve-modal-<?= $app['application_id'] ?>" class="fixed inset-0 bg-black bg-opacity-30 z-50 hidden">
  <div class="fixed top-1/2 left-1/2 w-80 bg-white border-2 border-blue-500 rounded-lg p-6 transform -translate-x-1/2 -translate-y-1/2 z-50 text-center">
    <h3 class="text-lg font-bold">Approve Application</h3>
    <p class="text-sm mb-4">Add a message for the student:</p>
    <form action="../controllers/update_application.php" method="post">
      <textarea name="message" class="w-full h-24 p-2 border border-gray-300 rounded-md" placeholder="Your message to the student"></textarea>
      <input type="hidden" name="application_id" value="<?= $app['application_id'] ?>">
      <input type="hidden" name="status" value="approved">
      <div class="flex justify-center gap-4 mt-4">
        <button type="submit" class="bg-green-500 text-white px-4 py-1 rounded">Submit</button>
        <button type="button" onclick="closeModal('approve', <?= $app['application_id'] ?>)" class="bg-gray-300 px-4 py-1 rounded">Cancel</button>
      </div>
    </form>
  </div>
</div>

<!-- Reject Modal -->
<div id="reject-modal-<?= $app['application_id'] ?>" class="fixed inset-0 bg-black bg-opacity-30 z-50 hidden">
  <div class="fixed top-1/2 left-1/2 w-80 bg-white border-2 border-blue-500 rounded-lg p-6 transform -translate-x-1/2 -translate-y-1/2 z-50 text-center">
    <h3 class="text-lg font-bold">Reject Application</h3>
    <p class="text-sm mb-4">Add a message for the student:</p>
    <form action="../controllers/update_application.php" method="post">
      <textarea name="message" class="w-full h-24 p-2 border border-gray-300 rounded-md" placeholder="Your message to the student"></textarea>
      <input type="hidden" name="application_id" value="<?= $app['application_id'] ?>">
      <input type="hidden" name="status" value="rejected">
      <div class="flex justify-center gap-4 mt-4">
        <button type="submit" class="bg-red-500 text-white px-4 py-1 rounded">Submit</button>
        <button type="button" onclick="closeModal('reject', <?= $app['application_id'] ?>)" class="bg-gray-300 px-4 py-1 rounded">Cancel</button>
      </div>
    </form>
  </div>
</div>


        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <p class="text-gray-500">No applications found.</p>
    <?php endif; ?>
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
