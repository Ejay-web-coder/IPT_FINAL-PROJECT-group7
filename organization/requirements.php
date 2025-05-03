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
include '../connection/db_requirements_org.php';

$showModal = isset($_GET['showLogout']) && $_GET['showLogout'] === 'true';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    header("Location: ../homepage.php"); exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle file uploads
    $studentId = $_POST['student-id'];
    $cor = $_FILES['cor']['name'];
    $barangayIndigency = $_FILES['barangay-indigency']['name'];
    $resume = $_FILES['resume']['name'];

    // Define the upload directory
    $uploadDir = 'uploads/'; // Make sure this directory exists and is writable

    // Move uploaded files to the upload directory
    move_uploaded_file($_FILES['cor']['tmp_name'], $uploadDir . $cor);
    move_uploaded_file($_FILES['barangay-indigency']['tmp_name'], $uploadDir . $barangayIndigency);
    move_uploaded_file($_FILES['resume']['tmp_name'], $uploadDir . $resume);

    // Insert into the database
    $sql = "INSERT INTO job_requirements (student_id, cor, barangay_indigency, resume) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $studentId, $cor, $barangayIndigency, $resume);

    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Close the database connection
$conn->close();
?>
  <header class="bg-white shadow px-10 py-6 flex justify-between items-center">
  <div class="text-4xl font-extrabold">
    <img src="../image/logo.png" alt="" class="w-20 h-auto"> <!-- Adjusted image size -->
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
        <label for="student-id" class="block text-sm mb-2">Student ID</label>
        <input type="text" id="student-id" name="student-id" class="border p-2 w-full" required />
      </div>

      <div class="mb-6">
        <label for="cor" class="block text-sm mb-2">COR</label>
        <input type="file" id="cor" name="cor" class="border p-2 w-full" required />
      </div>

      <div class="mb-6">
        <label for="barangay-indigency" class="block text-sm mb-2">Barangay Indigency</label>
        <input type="file" id="barangay-indigency" name="barangay-indigency" class="border p-2 w-full" required />
      </div>

      <div class="mb-6">
        <label for="resume" class="block text-sm mb-2">Resume</label>
        <input type="file" id="resume" name="resume" class="border p-2 w-full" required />
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
