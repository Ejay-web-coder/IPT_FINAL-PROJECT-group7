<?php
include '../controllers/connection.php';

$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $student_id = $_POST['student_id'];
    $course = $_POST['course'];
    $birthday = $_POST['birthday'];
    $sex = $_POST['sex'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($errors)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO signup_students (student_id, name, phone, email, course, birthday, sex, address, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $student_id, $name, $phone, $email, $course, $birthday, $sex, $address, $hashed_password);

        if ($stmt->execute()) {
            // Start the session
            session_start(); // Start the session

            // Store user data in session
            $_SESSION['student_id'] = $student_id; // Store student ID
            $_SESSION['name'] = $name; // Store student name
            $_SESSION['email'] = $email; // Store student email

        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Sign Up</title>
  <script src="../view_c/js/tailwind.js"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-cover bg-center relative" style="background-image: url('../image/online-job-search.jpeg');">

  <!-- Back Button -->
  <a href="../homepage.php" class="absolute top-4 left-4 w-9 h-9 flex items-center justify-center bg-white/80 rounded-full shadow hover:bg-white z-10">
    <img src="../image/back.png" alt="Back" class="w-4 h-4">
  </a>

  <!-- Container -->
  <div class="w-full max-w-4xl bg-white/90 rounded-lg shadow-lg overflow-hidden flex flex-col md:flex-row">

    <!-- Left Panel -->
    <div class="p-8 md:w-1/2 flex flex-col items-center justify-center bg-gray-100 border-r">
      <img src="../image/logo.png" alt="Logo" class="w-36 h-36 object-contain mb-4">
      <h1 class="text-lg font-semibold text-center text-gray-700">Employment Opportunities for College Students at OMSC Mamburao Campus</h1>
    </div>

    <!-- Right Panel -->
    <div class="p-8 md:w-1/2 flex flex-col justify-center">
      <h2 class="text-2xl font-bold text-center mb-6">Sign Up</h2>

      <!-- Error Display -->
      <?php if (!empty($errors)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4">
          <?php foreach ($errors as $error): ?>
            <p><?= htmlspecialchars($error) ?></p>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <form action="" method="POST" class="space-y-4">

        <div>
          <label for="name" class="block text-sm font-medium">Complete Name</label>
          <input type="text" name="name" id="name" required class="w-full p-3 border rounded" />
        </div>

        <div>
          <label for="phone" class="block text-sm font-medium">Phone Number</label>
          <input type="text" name="phone" id="phone" required class="w-full p-3 border rounded" />
        </div>

        <div>
          <label for="email" class="block text-sm font-medium">Email Address</label>
          <input type="email" name="email" id="email" required class="w-full p-3 border rounded" />
        </div>

        <div>
          <label for="student_id" class="block text-sm font-medium">Student ID</label>
          <input type="text" name="student_id" id="student_id" required class="w-full p-3 border rounded" />
        </div>

        <div>
          <label for="course" class="block text-sm font-medium">Course</label>
          <input type="text" name="course" id="course" required class="w-full p-3 border rounded" />
        </div>

        <div>
          <label for="birthday" class="block text-sm font-medium">Birthday</label>
          <input type="date" name="birthday" id="birthday" required class="w-full p-3 border rounded" />
        </div>

        <div>
          <label class="block text-sm font-medium">Sex</label>
          <div class="flex gap-4">
            <label class="flex items-center">
              <input type="radio" name="sex" value="Male" required class="mr-2" /> Male
            </label>
            <label class="flex items-center">
              <input type="radio" name="sex" value="Female" required class="mr-2" /> Female
            </label>
          </div>
        </div>

        <div>
          <label for="address" class="block text-sm font-medium">Current Address</label>
          <input type="text" name="address" id="address" required class="w-full p-3 border rounded" />
        </div>

        <div>
          <label for="password" class="block text-sm font-medium">Create a Password</label>
          <input type="password" name="password" id="password" required class="w-full p-3 border rounded" />
        </div>

        <div>
          <label for="confirm_password" class="block text-sm font-medium">Confirm Password</label>
          <input type="password" name="confirm_password" id="confirm_password" required class="w-full p-3 border rounded" />
        </div>

        <button type="submit" class="w-full py-3 bg-purple-700 text-white rounded hover:bg-purple-800 transition">Submit</button>
      </form>

      <div class="mt-4 text-center">
        <p>Already have an account?
          <a href="../Login_signup/login_Student.php" class="text-blue-600 hover:underline">Log in Here</a>
        </p>
      </div>
    </div>
  </div>

</body>
</html>
