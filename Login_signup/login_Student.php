<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-cover bg-center relative" style="background-image: url('../image/online-job-search.jpeg');">

  <!-- Back Button -->
  <a href="../homepage.php" class="absolute top-4 left-4 w-9 h-9 flex items-center justify-center bg-white/80 rounded-full shadow hover:bg-white z-10">
    <img src="../image/back.png" alt="Back" class="w-4 h-4">
  </a>

  <!-- Container -->
  <div class="w-full max-w-4xl bg-white/90 rounded-lg shadow-lg overflow-hidden flex flex-col md:flex-row">

    <!-- Left Side -->
    <div class="p-8 md:w-1/2 bg-gray-100 border-r flex flex-col items-center justify-center">
      <img src="../image/logo.png" alt="Logo" class="w-72 h-28 object-contain mb-4">
      <p class="text-center font-semibold text-gray-700">Employment Opportunities for College Students at <br>OMSC — Mamburao Campus</p>
    </div>

    <!-- Right Side -->
    <div class="p-8 md:w-1/2 flex flex-col justify-center">
      <h2 class="text-2xl font-bold text-center mb-6">Student Login</h2>
      <form action="login_Student.php" method="POST" class="space-y-4">
        <div>
          <label for="email" class="block mb-1 font-medium">Email</label>
          <input type="email" id="email" name="email" required class="w-full p-3 border rounded">
        </div>
        <div>
          <label for="password" class="block mb-1 font-medium">Password</label>
          <input type="password" id="password" name="password" required class="w-full p-3 border rounded">
        </div>
        <button type="submit" class="w-full py-3 bg-purple-700 text-white rounded hover:bg-purple-800 transition">Login</button>
      </form>
      <p class="text-center mt-4">Don't have an account? <a href="../Login_signup/SignUp_Student.php" class="text-blue-600 hover:underline">Sign up Here</a></p>
    </div>
  </div>

<?php
include '../connection/db_students_login-signup.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT password FROM students WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    if (password_verify($password, $hashed_password)) {
      $_SESSION['email'] = $email;
      header("Location: ../students/Job_Listing.php");
      exit();
    } else {
      echo "<script>alert('Invalid password.');</script>";
    }
  } else {
    echo "<script>alert('No user found with that email.');</script>";
  }

  $stmt->close();
  $conn->close();
}
?>
</body>
</html>
