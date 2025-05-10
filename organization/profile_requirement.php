<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Organization Profile & Requirements</title>
  <script src="../view_c/js/tailwind.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body class="bg-white font-sans">

<?php
session_start();
include '../controllers/connection.php';



$email = $_SESSION['email'];

// Fetch organization details
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
$stmt->close();

// Handle requirement form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['bir-certification'])) {
  $orgId = $orgData['id'];
  $status = 'pending';
  $uploadDir = 'uploads/';

  if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0777, true);
  }

  // Generate unique filenames
  $birFile = uniqid('bir_') . '_' . basename($_FILES['bir-certification']['name']);
  $permitFile = uniqid('permit_') . '_' . basename($_FILES['business-permit']['name']);
  $taxFile = uniqid('tax_') . '_' . basename($_FILES['tax-documents']['name']);

  $birPath = $uploadDir . $birFile;
  $permitPath = $uploadDir . $permitFile;
  $taxPath = $uploadDir . $taxFile;

  // Move uploaded files
  if (
      move_uploaded_file($_FILES['bir-certification']['tmp_name'], $birPath) &&
      move_uploaded_file($_FILES['business-permit']['tmp_name'], $permitPath) &&
      move_uploaded_file($_FILES['tax-documents']['tmp_name'], $taxPath)
  ) {
      // Insert into job_requirements
      $insert = $conn->prepare("INSERT INTO job_requirements (organization_id, bir_certification, business_permit, tax_documents, status) VALUES (?, ?, ?, ?, ?)");
      $insert->bind_param("issss", $orgId, $birFile, $permitFile, $taxFile, $status);

      if ($insert->execute()) {
          echo "<p class='text-green-600 text-center mt-4'>Requirements submitted successfully.</p>";
      } else {
          echo "<p class='text-red-500 text-center mt-4'>Submission failed: " . $insert->error . "</p>";
      }
      $insert->close();
  } else {
      echo "<p class='text-red-500 text-center mt-4'>Failed to upload files.</p>";
  }
}


// Logout Modal logic
$showModal = isset($_GET['showLogout']) && $_GET['showLogout'] === 'true';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_destroy();
    header("Location: ../homepage.php");
    exit();
}
?>

<!-- Header -->
<header class="bg-white shadow px-10 py-6 flex justify-between items-center">
  <div class="text-4xl font-extrabold">
    <img src="../image/logo.png" alt="" class="w-20 h-auto">
  </div>
  <nav class="text-sm font-medium space-x-8">
    <a href="profile_requirement.php" class="bg-green-500 text-white px-4 py-1 rounded-md font-semibold">Profile/Requirements</a>
    <a href="job_post.php">Jobs Post</a>
    <a href="manage_application.php">Manage Application</a>
    <a href="?showLogout=true" class="font-bold">Logout</a>
  </nav>
</header>

<!-- Profile Card -->
<main class="max-w-4xl mx-auto mt-10 bg-white p-8 rounded-lg shadow flex gap-8">
  <div class="flex-shrink-0">
    <img src="../Login_signup/uploads/<?php echo htmlspecialchars($orgData['company_logo']); ?>" alt="Company Logo" class="w-40 h-40 object-cover rounded-full border border-gray-300 shadow">
  </div>

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
          📂 <a href="../Login_signup/uploads/<?php echo htmlspecialchars($orgData['business_certificate']); ?>" class="text-blue-600 underline">View Certificate</a>
        </p>
      </div>
    </div>
  </div>
</main>

<!-- Job Requirement Form -->
<section class="flex justify-center p-10">
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
