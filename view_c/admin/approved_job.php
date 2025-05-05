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
      <a href="approved_job.php" class="bg-blue-500 text-white px-4 py-1 rounded-md">Approve Job</a>
      <a href="monitor_system.php">Monitor System</a>
      <a href="?showLogout=true" class="font-bold">Logout</a>
    </nav>
  </header>

  

  <?php
include '../../controllers/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'], $_POST['job_id'], $_POST['message'])) {
        $job_id = $_POST['job_id'];
        $action = $_POST['action'];
        $message = $_POST['message'];
        
        // Fetch the organization ID to send the message to the correct organization
        $stmt = $conn->prepare("SELECT organization_id FROM jobs_list WHERE id = ?");
        $stmt->bind_param("i", $job_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $orgData = $result->fetch_assoc();
        $organization_id = $orgData['organization_id'];

        if ($action === 'approve') {
            $stmt = $conn->prepare("UPDATE jobs_list SET status = 'approved' WHERE id = ?");
            $stmt->bind_param("i", $job_id);
            $stmt->execute();

            // Send approval message
            $stmt = $conn->prepare("INSERT INTO notifications_org (organization_id, job_id, message) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $organization_id, $job_id, $message);
            $stmt->execute();
        } elseif ($action === 'reject') {
            $stmt = $conn->prepare("UPDATE jobs_list SET status = 'rejected' WHERE id = ?");
            $stmt->bind_param("i", $job_id);
            $stmt->execute();

            // Send rejection message
            $stmt = $conn->prepare("INSERT INTO notifications_org (organization_id, job_id, message) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $organization_id, $job_id, $message);
            $stmt->execute();
        }
    }
}

// Get all pending jobs
$result = $conn->query("SELECT * FROM jobs_list WHERE status = 'pending'");
?>

<h2 class="text-2xl font-semibold mb-6">Pending Job Listings</h2>

<?php if ($result->num_rows > 0): ?>
  <!-- The main structure -->
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
          
          <!-- Trigger Modal for Approve -->
          <button type="button" class="px-3 py-1 bg-green-500 text-white rounded" onclick="showModal('approve', <?php echo $row['id']; ?>)">Approve</button>
          
          <!-- Trigger Modal for Reject -->
          <button type="button" class="px-3 py-1 bg-red-500 text-white rounded" onclick="showModal('reject', <?php echo $row['id']; ?>)">Reject</button>
        </form>
      </div>
    <?php endwhile; ?>
</div>

<?php else: ?>
  <p class="text-gray-600">No pending jobs at the moment.</p>
<?php endif; ?>


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

<!-- Modal HTML -->
<div id="modal" class="fixed inset-0 bg-black bg-opacity-30 hidden z-50 flex items-center justify-center">
  <div class="bg-white p-6 rounded-lg w-1/3">
    <h2 class="text-xl mb-4">Enter Message</h2>
    <form id="modalForm" method="POST">
      <input type="hidden" name="job_id" id="modalJobId">
      <input type="hidden" name="action" id="modalAction">
      
      <textarea name="message" id="message" class="w-full p-2 border rounded" rows="4" placeholder="Type your message here..." required></textarea>
      
      <div class="flex justify-end mt-4">
        <button type="button" class="bg-gray-300 px-4 py-2 rounded text-black" onclick="closeModal()">Cancel</button>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded ml-2">Send</button>
      </div>
    </form>
  </div>
</div>

<!-- JavaScript to handle Modal -->
<script>
function showModal(action, jobId) {
  // Set form action and job ID
  document.getElementById('modalAction').value = action;
  document.getElementById('modalJobId').value = jobId;

  // Show modal
  document.getElementById('modal').classList.remove('hidden');
}

function closeModal() {
  // Close modal
  document.getElementById('modal').classList.add('hidden');
}
</script>

</body>
</html>
