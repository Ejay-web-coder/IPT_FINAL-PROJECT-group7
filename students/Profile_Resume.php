<?php
session_start(); // Start the session
include '../controllers/connection.php'; // Include your database connection



// Fetch user data from the database
$student_id = $_SESSION['student_id'];

// Prepare the SQL statement
$stmt = $conn->prepare("SELECT name, email, phone, birthday, sex, address, course FROM signup_students WHERE student_id = ?");
if ($stmt === false) {
    // Handle error in preparing the statement
    die("Error preparing statement: " . htmlspecialchars($conn->error));
}

$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the student exists
if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
} else {
    // Handle case where student is not found
    echo "<script>alert('Student not found.'); window.location.href='../Login_signup/login_Student.php';</script>";
    exit();
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Student Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans bg-white text-black">
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
      <a href="Requirements.php">Requirements</a>
      <a href="My_Application.php">My Applications</a>
      <a href="Profile_Resume.php" class="bg-orange-500 text-white px-4 py-1 rounded-md">Profile/Resume</a>
      <a href="Notification.php">Notifications</a>
      <a href="?showLogout=true" class="font-bold">Logout</a>
    </nav>
    </header>

    <!-- Profile Content -->
    <div class="flex items-center justify-center p-4">
        <div class="max-w-3xl w-full bg-white shadow-xl rounded-xl overflow-hidden flex flex-col md:flex-row mt-8">
            <!-- Left Panel -->
            <div class="bg-orange-500 text-white p-6 flex flex-col justify-center items-center md:w-1/3">
                <img src="../image/profile-default.png" alt="Profile" class="w-24 h-24 rounded-full border-4 border-white mb-4 object-cover">
                <h2 class="text-xl font-semibold"><?= htmlspecialchars($student['name']) ?></h2>
                <p class="text-sm"><?= htmlspecialchars($student['course']) ?></p>
                <p class="text-xs mt-2">Student ID: <?= htmlspecialchars($student_id) ?></p>
            </div>

            <!-- Right Panel -->
            <div class="p-6 md:w-2/3 space-y-4">
                <h3 class="text-lg font-semibold border-b pb-2 mb-2">Personal Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Email</label>
                        <p class="text-gray-800"><?= htmlspecialchars($student['email']) ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Phone</label>
                        <p class="text-gray-800"><?= htmlspecialchars($student['phone']) ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Birthday</label>
                        <p class="text-gray-800"><?= htmlspecialchars($student['birthday']) ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Sex</label>
                        <p class="text-gray-800"><?= htmlspecialchars($student['sex']) ?></p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-600">Address</label>
                        <p class="text-gray-800"><?= htmlspecialchars($student['address']) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
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