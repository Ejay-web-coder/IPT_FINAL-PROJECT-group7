<?php
include '../controllers/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['logout'])) {
    // Get filenames
    $studentIdImg = basename($_FILES['student-id']['name']);
    $cor = basename($_FILES['cor']['name']);
    $barangayIndigency = basename($_FILES['barangay-indigency']['name']);

    $uploadDir = 'uploads/';

    // Ensure directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Move uploaded files
    $success = move_uploaded_file($_FILES['student-id']['tmp_name'], $uploadDir . $studentIdImg) &&
               move_uploaded_file($_FILES['cor']['tmp_name'], $uploadDir . $cor) &&
               move_uploaded_file($_FILES['barangay-indigency']['tmp_name'], $uploadDir . $barangayIndigency); 

    if ($success) {
        // Insert to DB (you may need to adjust the column names for your requirements)
        $sql = "INSERT INTO stu_requirements (student_id_img, cor, barangay_indigency, status) VALUES (?, ?, ?, 'pending')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $studentIdImg, $cor, $barangayIndigency);

        if ($stmt->execute()) {
            echo "<p class='text-green-600 text-center mt-4'>Requirements submitted successfully. Please wait for approval.</p>";
        } else {
            echo "<p class='text-red-600 text-center mt-4'>Database Error: {$stmt->error}</p>";
        }

        $stmt->close();
    } else {
        echo "<p class='text-red-600 text-center mt-4'>Failed to upload one or more files.</p>";
    }
}

$conn->close();
?>

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

<!-- Header -->
<header class="flex justify-between items-center bg-white shadow px-6 py-4">
  <div class="text-4xl font-extrabold">
    <img src="../image/logo.png" alt="" class="w-20 h-auto">
  </div>
  <nav class="text-sm font-medium space-x-6">
    <a href="Job_Listing.php">Job Listing</a>
    <a href="Requirements.php" class="bg-orange-500 text-white px-4 py-1 rounded-md">Requirements</a>
    <a href="My_Application.php">My Applications</a>
    <a href="Profile_Resume.php">Profile/Resume</a>
    <a href="Notification.php">Notifications</a>
    <a href="homepage.php" class="font-bold">Logout</a>
  </nav>
</header>

<!-- Form -->
<main class="flex justify-center p-6">
  <form class="border p-6 w-full max-w-xl" method="POST" enctype="multipart/form-data">
    <h2 class="text-xl font-semibold mb-6">Job Requirement Form</h2>

    <div class="mb-6">
      <label for="student-id" class="block text-sm mb-2">Student ID (Image)</label>
      <input type="file" id="student-id" name="student-id" class="border p-2 w-full" accept="image/*" required />
    </div>

    <div class="mb-6">
      <label for="cor" class="block text-sm mb-2">COR</label>
      <input type="file" id="cor" name="cor" class="border p-2 w-full" required />
    </div>

    <div class="mb-6">
      <label for="barangay-indigency" class="block text-sm mb-2">Barangay Indigency</label>
      <input type="file" id="barangay-indigency" name="barangay-indigency" class="border p-2 w-full" required />
    </div>

    <div class="text-red-600 mb-4">
      <p> Please make sure to submit all requirements to proceed with your job application.</p>
    </div>

    <button type="submit" class="bg-teal-500 text-white px-6 py-2 rounded-full float-right">Submit</button>
  </form>
</main>

</body>
</html>
