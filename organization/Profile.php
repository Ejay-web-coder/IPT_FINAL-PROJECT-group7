<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Organization Profile</title>
  <script src="../view_c/js/tailwind.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body class="bg-white font-sans">
<?php
session_start(); 

include '../controllers/connection.php'; 

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../homepage.php"); 
    exit();
}

// Fetch organization details from the database
$email = $_SESSION['email'];
$sql = "SELECT * FROM signup_org WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $orgData = $result->fetch_assoc();
} else {
    echo "<p class='text-red-500 text-center'>No organization found.</p>";
    exit();
}

$stmt->close(); // Close the statement
$conn->close(); // Close the database connection
?>
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
      <a href="Profile.php" class="bg-green-500 text-white px-4 py-1 rounded-md font-semibold">Profile</a>
      <a href="job_post.php">Jobs Post</a>
      <a href="requirements.php">Requirements</a>
      <a href="manage_application.php">Manage Application</a>    
      <a href="notification_org.php">Notification</a>
      <a href="?showLogout=true" class="font-bold">Logout</a>
    </nav>
  </header>

  <!-- Profile Card -->
  <main class="max-w-4xl mx-auto mt-10 bg-white p-8 rounded-lg shadow flex gap-8">
    
    <!-- Logo Section -->
    <div class="flex-shrink-0">
      <img src="uploads/<?php echo htmlspecialchars($orgData['company_logo']); ?>" alt="Company Logo" class="w-40 h-40 object-cover rounded-full border border-gray-300 shadow">
    </div>

    <!-- Info Section -->
    <div class="flex-grow">
      <h2 class="text-2xl font-bold mb-4"><?php echo htmlspecialchars($orgData['organization_name']); ?></h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
        <div>
          <p class="font-semibold">Email</p>
          <p class="bg-gray-100 p-2 rounded"><?php echo htmlspecialchars($orgData['email']); ?></p>
        </div>
        <div>
          <p class="font-semibold">Phone Number</p>
          <p class="bg-gray-100 p-2 rounded"><?php echo htmlspecialchars($orgData['phone_number']); ?></p>
        </div>
        <div>
          <p class="font-semibold">Company Name</p>
          <p class="bg-gray-100 p-2 rounded"><?php echo htmlspecialchars($orgData['company_name']); ?></p>
        </div>
        <div>
          <p class="font-semibold">Address</p>
          <p class="bg-gray-100 p-2 rounded"><?php echo htmlspecialchars($orgData['address'] ?? '[Address not provided]'); ?></p>
        </div>
        <div class="col-span-2">
        <p class="font-semibold">Company Registration</p>
          <p class="bg-gray-100 p-2 rounded">
            📂 <a href="uploads/<?php echo htmlspecialchars($orgData['business_certificate']); ?>" class="text-blue-600 underline">View Certificate</a>
          </p>
        </div>
      </div>

      <!-- Edit Button -->
      <div class="mt-6 text-right">
        <a href="edit_profile.php" class="bg-green-500 text-white px-6 py-2 rounded font-semibold">Edit Profile</a>
      </div>
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