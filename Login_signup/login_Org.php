<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Organization Login</title>
  <script src="../view_c/js/tailwind.js"></script>
  <style>
    body {
      background: url('../image/online-job-search.jpeg') no-repeat center center fixed;
      background-size: cover;
      height: 100vh;
      margin: 0;
    }
  </style>
</head>
<body class="flex justify-center items-center min-h-screen">

  <!-- Back Button -->
  <a href="../homepage.php" class="absolute top-4 left-4 w-9 h-9 flex items-center justify-center bg-white/80 rounded-full shadow hover:bg-white z-10">
    <img src="../image/back.png" alt="Back" class="w-4 h-4">
  </a>

  <!-- Main Container -->
  <div class="bg-white/90 rounded-lg shadow-lg flex flex-col md:flex-row w-full max-w-4xl">

    <!-- Left Panel -->
    <div class="flex flex-col justify-center items-center p-8 md:w-1/2 bg-gray-100 border-r">
      <img src="../image/logo.png" alt="Logo" class="w-72 h-28 object-contain mb-4">
      <p class="text-center text-xl font-semibold">Employment Opportunities for College Students at OMSC — Mamburao Campus</p>
    </div>

    <!-- Right Panel -->
    <div class="flex flex-col justify-center items-center p-8 md:w-1/2">
      <h2 class="text-2xl font-bold mb-6 text-center">Organization Log In</h2>
      <form method="POST" class="w-full space-y-4">
        
        <!-- Email Input -->
        <div class="input-group">
          <label for="email" class="text-sm font-medium">Email</label>
          <input type="email" id="email" name="email" required class="w-full p-3 border rounded-lg"/>
        </div>

        <!-- Password Input -->
        <div class="input-group">
          <label for="password" class="text-sm font-medium">Password</label>
          <input type="password" id="password" name="password" required class="w-full p-3 border rounded-lg"/>
        </div>

        <!-- Error Message -->
        <?php if (isset($error_message)): ?>
          <div class="text-red-500 text-sm text-center"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <!-- Submit Button -->
        <button type="submit" class="w-full py-3 bg-purple-700 text-white rounded-lg hover:bg-purple-800 transition">Submit</button>
      </form>

      <!-- Sign Up Link -->
      <div class="mt-4 text-center">
        <p class="text-sm">Don't have an account? <a href="../Login_signup/SignUp_Org.php" class="text-blue-500 hover:underline">Sign Up</a></p>
      </div>
    </div>
  </div>

  <?php
  session_start(); // Start the session

  include '../controllers/connection.php';

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $email = $_POST['email'];
      $password = $_POST['password'];

      // Prepare and execute the SQL statement
      $sql = "SELECT * FROM signup_org WHERE email=?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();

          // Verify the password
          if (password_verify($password, $row['password'])) {
              // Set session variables
              $_SESSION['user_id'] = $row['id'];
              $_SESSION['email'] = $row['email'];
              header("Location: ../organization/profile_requirement.php");
              exit();
          } else {
              $error_message = "Invalid password.";
          }
      } else {
          $error_message = "No user found with that email.";
      }

      $stmt->close(); // Close the statement
  }

  $conn->close(); // Close the database connection
  ?>

</body>
</html>