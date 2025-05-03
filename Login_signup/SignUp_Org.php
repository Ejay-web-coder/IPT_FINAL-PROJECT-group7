<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Organization Sign Up</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body class="min-h-screen flex items-center justify-center bg-cover bg-center relative" style="background-image: url('../image/online-job-search.jpeg');">

  <!-- Back Button -->
  <a href="../homepage.php" class="absolute top-4 left-4 w-9 h-9 flex items-center justify-center bg-white/80 rounded-full shadow hover:bg-white z-10">
    <img src="../image/back.png" alt="Back" class="w-4 h-4">
  </a>

  <!-- Container -->
  <div class="w-full max-w-5xl bg-white/90 rounded-lg shadow-lg overflow-hidden flex flex-col md:flex-row">
    
    <!-- Left Section -->
    <div class="flex flex-col items-center justify-center p-8 md:w-1/2 bg-gray-100">
      <img src="../image/logo.png" alt="Logo" class="h-20 mb-4">
      <h1 class="text-center text-lg font-bold">Employment Opportunities for College Students at OMSC Mamburao Campus</h1>
    </div>

    <!-- Right Section -->
    <div class="p-8 md:w-1/2">
      <h2 class="text-2xl font-bold text-center mb-6">Sign Up</h2>
      <form action="SignUp_Org.php" method="POST" enctype="multipart/form-data" class="space-y-4">
        <input type="text" name="company_name" placeholder="Company Name" required class="w-full p-3 border rounded">
        <input type="text" name="organization_name" placeholder="Organization Name" required class="w-full p-3 border rounded">
        <input type="text" name="phone_number" placeholder="Phone Number" required class="w-full p-3 border rounded">
        <input type="email" name="email" placeholder="Email Address" required class="w-full p-3 border rounded">
        <input type="password" name="password" placeholder="Create a Password" required class="w-full p-3 border rounded">
        <input type="password" name="confirm_password" placeholder="Confirm Password" required class="w-full p-3 border rounded">

        <div>
          <label class="block font-semibold mb-1">Business Registration Certificate:</label>
          <label class="flex items-center justify-center border-2 border-dashed p-4 rounded cursor-pointer hover:bg-gray-100">
            <input type="file" name="business_certificate" class="hidden">
            <i class="fas fa-cloud-upload-alt text-xl text-gray-500 mr-2"></i>
            <span class="text-gray-600">Upload File</span>
          </label>
        </div>

        <div>
          <label class="block font-semibold mb-1">Company Logo (Optional):</label>
          <label class="flex items-center justify-center border-2 border-dashed p-4 rounded cursor-pointer hover:bg-gray-100">
            <input type="file" name="company_logo" class="hidden">
            <i class="fas fa-cloud-upload-alt text-xl text-gray-500 mr-2"></i>
            <span class="text-gray-600">Upload File</span>
          </label>
        </div>

        <button type="submit" class="w-full bg-purple-700 text-white py-3 rounded hover:bg-purple-800 transition">Submit</button>
      </form>

      <p class="text-center mt-4">Already have an account? <a href="login_Org.php" class="text-blue-600 hover:underline">Log in Here</a></p>
    </div>
  </div>
    <?php
    include '../connection/db_organization_login-signup.php';


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $company_name = $_POST['company_name'];
    $organization_name = $_POST['organization_name'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $business_certificate = $_FILES['business_certificate']['name'];
    $company_logo = $_FILES['company_logo']['name'];

    // Move uploaded files to a directory
    move_uploaded_file($_FILES['business_certificate']['tmp_name'], "uploads/" . $business_certificate);
    move_uploaded_file($_FILES['company_logo']['tmp_name'], "uploads/" . $company_logo);

    // Insert into database
    $sql = "INSERT INTO users (company_name, organization_name, phone_number, email, password, business_certificate, company_logo)
            VALUES ('$company_name', '$organization_name', '$phone_number', '$email', '$password', '$business_certificate', '$company_logo')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
</body>
</html>