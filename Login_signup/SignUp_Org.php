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
        <input type="email" name="email" placeholder="Email" required class="w-full p-3 border rounded">
        <input type="text" name="address" placeholder="Address" required class="w-full p-3 border rounded">
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
    include '../controllers/connection.php';


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $company_name = $_POST['company_name'];
    $organization_name = $_POST['organization_name'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $business_certificate = $_FILES['business_certificate']['name'];
    $company_logo = $_FILES['company_logo']['name'];

    $uploadDir = "uploads/";

    // Ensure the uploads folder exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true); // create folder if it doesn't exist
    }
    
    // Handle business certificate upload
    $businessCertTmp = $_FILES['business_certificate']['tmp_name'];
    $businessCertName = uniqid() . '_' . basename($_FILES['business_certificate']['name']);
    $businessCertPath = $uploadDir . $businessCertName;
    
    // Handle company logo upload
    $companyLogoTmp = $_FILES['company_logo']['tmp_name'];
    $companyLogoName = uniqid() . '_' . basename($_FILES['company_logo']['name']);
    $companyLogoPath = $uploadDir . $companyLogoName;
    
    // Move the files
    if (move_uploaded_file($businessCertTmp, $businessCertPath)) {
      if ($companyLogoTmp && move_uploaded_file($companyLogoTmp, $companyLogoPath)) {
          // Insert into the database
          $sql = "INSERT INTO signup_org (company_name, organization_name, phone_number, email, password, address, business_certificate, company_logo)
                  VALUES ('$company_name', '$organization_name', '$phone_number', '$email', '$password', '$address', '$businessCertName', '$companyLogoName')";
  
          if ($conn->query($sql) === TRUE) {
              // Capture the newly inserted organization ID
              $org_id = $conn->insert_id;
  
              // Optionally, store the organization ID in session (if needed for later use)
              $_SESSION['organization_id'] = $org_id;
  
              echo "New record created successfully. Organization ID: " . $org_id;
  
          } else {
              echo "Database Error: " . $conn->error;
          }
      } else {
          echo "Failed to upload company logo.";
      }
  } else {
      echo "Failed to upload business certificate.";
  }
  
  }    

$conn->close();
?>
</body>
</html>