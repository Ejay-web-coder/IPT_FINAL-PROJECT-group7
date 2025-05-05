<?php
session_start();
include '../controllers/connection.php';

// Redirect to login if not logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: ../Login_signup/login_Student.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// Fetch student data
$stmt = $conn->prepare("SELECT name, email, phone, birthday, sex, address, course FROM signup_students WHERE student_id = ?");
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
} else {
    echo "<script>alert('Student not found.'); window.location.href='../Login_signup/login_Student.php';</script>";
    exit();
}
$stmt->close();

$uploadMessage = "";

// Handle requirement form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['logout'])) {
    $studentIdImg = basename($_FILES['student-id']['name']);
    $cor = basename($_FILES['cor']['name']);
    $barangayIndigency = basename($_FILES['barangay-indigency']['name']);
    $uploadDir = 'uploads/';

    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $success = move_uploaded_file($_FILES['student-id']['tmp_name'], $uploadDir . $studentIdImg) &&
               move_uploaded_file($_FILES['cor']['tmp_name'], $uploadDir . $cor) &&
               move_uploaded_file($_FILES['barangay-indigency']['tmp_name'], $uploadDir . $barangayIndigency);

    if ($success) {
      $sql = "INSERT INTO stu_requirements (student_id, student_id_img, cor, barangay_indigency, status) VALUES (?, ?, ?, ?, 'pending')";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssss", $student_id, $studentIdImg, $cor, $barangayIndigency);
      
        if ($stmt->execute()) {
            $uploadMessage = "<p class='text-green-600 text-center mt-4'>Requirements submitted successfully. Please wait for approval.</p>";
        } else {
            $uploadMessage = "<p class='text-red-600 text-center mt-4'>Database Error: {$stmt->error}</p>";
        }
        $stmt->close();
    } else {
        $uploadMessage = "<p class='text-red-600 text-center mt-4'>Failed to upload one or more files.</p>";
    }
}

$showModal = isset($_GET['showLogout']) && $_GET['showLogout'] === 'true';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_destroy();
    header("Location: ../homepage.php");
    exit();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Student Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body class="bg-white font-sans text-black">

<!-- Header -->
<header class="flex justify-between items-center bg-white shadow px-6 py-4">
  <div class="text-4xl font-extrabold">
    <img src="../image/logo.png" alt="" class="w-20 h-auto">
  </div>
  <nav class="text-sm font-medium space-x-6">
    <a href="Job_Listing.php">Job Listing</a>
    <a href="My_Application.php">My Applications</a>
    <a href="Profile_Requirements.php" class="bg-orange-500 text-white px-4 py-1 rounded-md">Profile/Requirements</a>
    <a href="Notification.php">Notifications</a>
    <a href="?showLogout=true" class="font-bold">Logout</a>
  </nav>
</header>

<!-- Student Profile -->
<section id="profile" class="flex items-center justify-center p-4">
  <div class="max-w-3xl w-full bg-white shadow-xl rounded-xl overflow-hidden flex flex-col md:flex-row mt-8">
    <div class="bg-orange-500 text-white p-6 flex flex-col justify-center items-center md:w-1/3">
      <img src="../image/profile-default.png" alt="Profile" class="w-24 h-24 rounded-full border-4 border-white mb-4 object-cover">
      <h2 class="text-xl font-semibold"><?= htmlspecialchars($student['name']) ?></h2>
      <p class="text-sm"><?= htmlspecialchars($student['course']) ?></p>
      <p class="text-xs mt-2">Student ID: <?= htmlspecialchars($student_id) ?></p>
    </div>
    <div class="p-6 md:w-2/3 space-y-4">
      <h3 class="text-lg font-semibold border-b pb-2 mb-2">Personal Information</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div><label class="block text-sm font-medium text-gray-600">Email</label><p><?= htmlspecialchars($student['email']) ?></p></div>
        <div><label class="block text-sm font-medium text-gray-600">Phone</label><p><?= htmlspecialchars($student['phone']) ?></p></div>
        <div><label class="block text-sm font-medium text-gray-600">Birthday</label><p><?= htmlspecialchars($student['birthday']) ?></p></div>
        <div><label class="block text-sm font-medium text-gray-600">Sex</label><p><?= htmlspecialchars($student['sex']) ?></p></div>
        <div class="md:col-span-2"><label class="block text-sm font-medium text-gray-600">Address</label><p><?= htmlspecialchars($student['address']) ?></p></div>
      </div>
    </div>
  </div>
</section>

<!-- Requirement Form -->
<section id="requirements" class="flex justify-center p-6">
  <form class="border p-6 w-full max-w-xl" method="POST" enctype="multipart/form-data">
    <h2 class="text-xl font-semibold mb-6">Job Requirement Form</h2>
    <div class="mb-6"><label for="student-id" class="block text-sm mb-2">Student ID (Image)</label><input type="file" id="student-id" name="student-id" class="border p-2 w-full" accept="image/*" required /></div>
    <div class="mb-6"><label for="cor" class="block text-sm mb-2">COR</label><input type="file" id="cor" name="cor" class="border p-2 w-full" required /></div>
    <div class="mb-6"><label for="barangay-indigency" class="block text-sm mb-2">Barangay Indigency</label><input type="file" id="barangay-indigency" name="barangay-indigency" class="border p-2 w-full" required /></div>
    <div class="text-red-600 mb-4"><p>Please make sure to submit all requirements to proceed with your job application.</p></div>
    <?= $uploadMessage ?>
    <button type="submit" class="bg-teal-500 text-white px-6 py-2 rounded-full float-right">Submit</button>
  </form>
</section>

<!-- Logout Modal -->
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
