<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Job Requirement Form</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body class="bg-white font-sans">

<?php
include '../controllers/connection.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['bir-certification'])) {
    // Handle file uploads
    $birCertification = $_FILES['bir-certification']['name'];
    $businessPermit = $_FILES['business-permit']['name'];
    $taxDocuments = $_FILES['tax-documents']['name'];

    $uploadDir = 'uploads/';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Now move files safely
move_uploaded_file($_FILES['bir-certification']['tmp_name'], $uploadDir . $birCertification);
move_uploaded_file($_FILES['business-permit']['tmp_name'], $uploadDir . $businessPermit);
move_uploaded_file($_FILES['tax-documents']['tmp_name'], $uploadDir . $taxDocuments);


    // Insert into the database
    $sql = "INSERT INTO job_requirements (bir_certification, business_permit, tax_documents) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $birCertification, $businessPermit, $taxDocuments);

    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
<?php
$showModal = isset($_GET['showLogout']) && $_GET['showLogout'] === 'true';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
  header("Location: ../homepage.php"); exit;
}
?>
<header class="bg-white shadow px-10 py-6 flex justify-between items-center">
  <div class="text-4xl font-extrabold">
    <img src="../image/logo.png" alt="" class="w-20 h-auto">
  </div>
  <nav class="text-sm font-medium space-x-8">
    <a href="Profile.php">Profile</a>
    <a href="job_post.php">Jobs Post</a>
    <a href="requirements.php" class="bg-green-500 text-white px-4 py-1 rounded-md font-semibold">Requirements</a>
    <a href="manage_application.php">Manage Application</a>
    <a href="notification_org.php">Notification</a>
    <a href="?showLogout=true" class="font-bold">Logout</a>
  </nav>
</header>

<main class="flex justify-center p-6">
  <form class="border p-6 w-full max-w-xl" method="POST" enctype="multipart/form-data">
    <h2 class="text-xl font-medium mb-6">Job Requirement Form</h2>

    <div class="mb-6">
      <label for="bir-certification" class="block text-sm mb-2">BIR Certification</label>
      <input type="file" id="bir-certification" name="bir-certification" class="border p-2 w-full" required />
    </div>

    <div class="mb-6">
      <label for="business-permit" class="block text-sm mb-2">Business Licenses/Permits</label>
      <input type="file" id="business-permit" name="business-permit" class="border p-2 w-full" required />
    </div>

    <div class="mb-6">
      <label for="tax-documents" class="block text-sm mb-2">Tax Documents</label>
      <input type="file" id="tax-documents" name="tax-documents" class="border p-2 w-full" required />
    </div>

    <button type="submit" class="bg-teal-500 text-white px-6 py-2 rounded-full float-right">Submit</button>
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
