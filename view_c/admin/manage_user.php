<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Page</title>
  <script src="../../view_c/js/tailwind.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body class="bg-gray-100 font-sans min-h-screen">

<?php
session_start();
include '../../controllers/connection.php';

$showModal = isset($_GET['showLogout']) && $_GET['showLogout'] === 'true';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_destroy();
    header("Location: ../../homepage.php");
    exit();
}
/* if (!isset($_SESSION['student_id'])) {
  // Redirect or show an error
  header("Location: login.php");
  exit;
} */

/* $student_id = $_SESSION['student_id']; */


// Handle Approve/Reject actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $reqId = $_POST['requirement_id'];
    $action = $_POST['action']; // 'approve' or 'reject'
    $status = ($action === 'approve') ? 'approved' : 'rejected';


    $stmt = $conn->prepare("UPDATE stu_requirements SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $reqId);
    $stmt->execute();
    $stmt->close();
}

// Handle Approve/Reject for organization requirements
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['org_action'])) {
  $orgReqId = $_POST['org_requirement_id'];
  $orgStatus = ($_POST['org_action'] === 'approve') ? 'approved' : 'rejected';

  $stmt = $conn->prepare("UPDATE job_requirements SET status = ? WHERE id = ?");
  $stmt->bind_param("si", $orgStatus, $orgReqId);
  $stmt->execute();
  $stmt->close();
}

// Fetch all organization requirements
$orgSql = "SELECT r.id, r.bir_certification, r.business_permit, r.tax_documents, r.status, r.submitted_at,
                o.organization_name, o.email
         FROM job_requirements r
         JOIN signup_org o ON r.organization_id = o.id
         ORDER BY r.id DESC";
$orgResult = $conn->query($orgSql);

// Fetch all requirements with student info
$sql = "SELECT r.id, r.student_id_img, r.cor, r.barangay_indigency, r.status, r.submitted_at,
               s.name, s.student_id, s.course 
        FROM stu_requirements r
        JOIN signup_students s ON r.student_id = s.student_id
        ORDER BY r.id DESC";
$result = $conn->query($sql);
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
  <h2 class="text-2xl font-semibold my-6">Manage Organization Requirements</h2>

<div class="overflow-x-auto mb-10">
  <table class="min-w-full border border-gray-300 bg-white shadow-md rounded-md">
    <thead class="bg-gray-100">
      <tr>
        <th class="p-3 border">Organization Name</th>
        <th class="p-3 border">Email</th>
        <th class="p-3 border">BIR Certification</th>
        <th class="p-3 border">Business Permit</th>
        <th class="p-3 border">Tax Documents</th>
        <th class="p-3 border">Submitted At</th>
        <th class="p-3 border">Status</th>
        <th class="p-3 border">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($org = $orgResult->fetch_assoc()): ?>
        <tr class="text-center hover:bg-gray-50">
          <td class="p-2 border"><?= htmlspecialchars($org['organization_name']) ?></td>
          <td class="p-2 border"><?= htmlspecialchars($org['email']) ?></td>
          <td class="p-2 border">
            <a href="../../organization/uploads/<?= htmlspecialchars($org['bir_certification']) ?>" target="_blank" class="text-blue-600 underline">View</a>
          </td>
          <td class="p-2 border">
            <a href="../../organization/uploads/<?= htmlspecialchars($org['business_permit']) ?>" target="_blank" class="text-blue-600 underline">View</a>
          </td>
          <td class="p-2 border">
            <a href="../../organization/uploads/<?= htmlspecialchars($org['tax_documents']) ?>" target="_blank" class="text-blue-600 underline">View</a>
          </td>
          <td class="p-2 border text-sm text-gray-600">
            <?= isset($org['submitted_at']) ? date("M d, Y H:i", strtotime($org['submitted_at'])) : '—' ?>
          </td>
          <td class="p-2 border font-semibold <?= $org['status'] === 'approved' ? 'text-green-600' : ($org['status'] === 'rejected' ? 'text-red-600' : 'text-yellow-600') ?>">
            <?= ucfirst($org['status']) ?>
          </td>
          <td class="p-2 border">
            <?php if ($org['status'] === 'pending'): ?>
              <form method="POST" class="flex gap-2 justify-center">
                <input type="hidden" name="org_requirement_id" value="<?= $org['id'] ?>">
                <button type="submit" name="org_action" value="approve" class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600">Approve</button>
                <button type="submit" name="org_action" value="reject" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">Reject</button>
              </form>
            <?php else: ?>
              <span class="italic text-gray-500">Reviewed</span>
            <?php endif; ?>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>



<main class="p-6">
  <h2 class="text-2xl font-semibold mb-4">Manage Student Requirements</h2>

  <div class="overflow-x-auto">
    <table class="min-w-full border border-gray-300 bg-white shadow-md rounded-md">
      <thead class="bg-gray-100">
        <tr>
          <th class="p-3 border">Student Name</th>
          <th class="p-3 border">Course</th>
          <th class="p-3 border">Student ID</th>
          <th class="p-3 border">Student ID Image</th>
          <th class="p-3 border">COR</th>
          <th class="p-3 border">Barangay Indigency</th>
          <th class="p-3 border">Submitted At</th>
          <th class="p-3 border">Status</th>
          <th class="p-3 border">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr class="text-center hover:bg-gray-50">
            <td class="p-2 border"><?= htmlspecialchars($row['name']) ?></td>
            <td class="p-2 border"><?= htmlspecialchars($row['course']) ?></td>
            <td class="p-2 border"><?= htmlspecialchars($row['student_id']) ?></td>
            <td class="p-2 border">
              <a href="../../students/uploads/<?= htmlspecialchars($row['student_id_img']) ?>" target="_blank" class="text-blue-600 underline">View</a>
            </td>
            <td class="p-2 border">
              <a href="../../students/uploads/<?= htmlspecialchars($row['cor']) ?>" target="_blank" class="text-blue-600 underline">View</a>
            </td>
            <td class="p-2 border">
              <a href="../../students/uploads/<?= htmlspecialchars($row['barangay_indigency']) ?>" target="_blank" class="text-blue-600 underline">View</a>
            </td>
            <td class="p-2 border text-sm text-gray-600">
              <?= isset($row['submitted_at']) ? date("M d, Y H:i", strtotime($row['submitted_at'])) : '—' ?>
            </td>
            <td class="p-2 border font-semibold <?= $row['status'] === 'approved' ? 'text-green-600' : ($row['status'] === 'rejected' ? 'text-red-600' : 'text-yellow-600') ?>">
              <?= ucfirst($row['status']) ?>
            </td>
            <td class="p-2 border">
              <?php if ($row['status'] === 'pending'): ?>
                <form method="POST" class="flex gap-2 justify-center">
                  <input type="hidden" name="requirement_id" value="<?= $row['id'] ?>">
                  <button type="submit" name="action" value="approve" class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600">Approve</button>
                  <button type="submit" name="action" value="reject" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">Reject</button>
                </form>
              <?php else: ?>
                <span class="italic text-gray-500">Reviewed</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
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

<?php $conn->close(); ?>
</body>
</html>
