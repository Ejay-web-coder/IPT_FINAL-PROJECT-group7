<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Organization Profile</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body class="bg-gray-50">
<?php
session_start();
if (!isset($_SESSION['profile'])) $_SESSION['profile'] = [
  'orgName' => '7-Eleven', 'email' => '7eleven@hhcorp.com', 'phone' => '09858787833',
  'contactPerson' => 'Arnold C. Galang', 'address' => 'Payompon, Mamburao, Occidental Mindoro',
  'resume' => '', 'logo' => ''
];
$profile = $_SESSION['profile']; $errors = []; $success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['cancel'])) header("Location: ".$_SERVER['PHP_SELF']) && exit;
  foreach (['orgName', 'email', 'phone', 'contactPerson', 'address'] as $field)
    if (empty(trim($_POST[$field] ?? ''))) $errors[] = ucfirst($field).' is required.';
  if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid Email is required.';
  if (!preg_match('/^\d+$/', $_POST['phone'])) $errors[] = 'Valid Phone Number is required.';
  if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
    $ext = strtolower(pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION));
    if ($ext === 'pdf') {
      $path = 'uploads/resume_' . time() . '.pdf'; if (!is_dir('uploads')) mkdir('uploads');
      move_uploaded_file($_FILES['resume']['tmp_name'], $path); $profile['resume'] = $path;
    } else $errors[] = 'Resume must be a PDF file.';
  }
  if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
    $ext = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
    if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
      $path = 'uploads/logo_' . time() . '.' . $ext; if (!is_dir('uploads')) mkdir('uploads');
      move_uploaded_file($_FILES['logo']['tmp_name'], $path); $profile['logo'] = $path;
    } else $errors[] = 'Logo must be an image file.';
  }
  if (!$errors) {
    foreach (['orgName','email','phone','contactPerson','address'] as $f)
      $profile[$f] = htmlspecialchars(trim($_POST[$f]));
    $_SESSION['profile'] = $profile; $success = 'Profile saved successfully!';
  }
}
$editing = isset($_POST['edit']) || ($_SERVER['REQUEST_METHOD'] === 'POST' && $errors);
?>

<body class="bg-white font-sans">
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

<main class="max-w-xl mx-auto my-10 bg-white p-8 rounded-lg shadow">
  <h2 class="text-2xl font-bold mb-6">Organization Profile</h2>

  <?php if ($errors): ?>
    <ul class="text-red-600 list-disc list-inside mb-5"><?php foreach ($errors as $e) echo "<li>$e</li>"; ?></ul>
  <?php endif; ?>

  <?php if ($success): ?><div class="text-green-600 mb-5"><?= $success ?></div><?php endif; ?>

  <?php if (!$editing): ?>
    <div class="space-y-4">
      <?php foreach (['orgName'=>'Organization Name','email'=>'Email','phone'=>'Phone Number','contactPerson'=>'Contact Person','address'=>'Address'] as $key=>$label): ?>
        <div><label class="font-bold"><?= $label ?></label><div class="bg-gray-100 p-2 rounded"><?= $profile[$key] ?></div></div>
      <?php endforeach; ?>
      <div>
        <label class="font-bold">Company Registration</label>
        <div class="bg-gray-100 p-2 rounded">
          <?= ($profile['resume'] && file_exists($profile['resume'])) ? '<a href="'.$profile['resume'].'" class="text-blue-600 underline" target="_blank">📂 View Resume</a>' : '📂 [View Resume]' ?>
        </div>
      </div>
      <div>
        <label class="font-bold">Company Logo</label>
        <div class="bg-gray-100 p-2 rounded">
          <?= ($profile['logo'] && file_exists($profile['logo'])) ? '<img src="'.$profile['logo'].'" class="max-h-20 rounded" />' : '🖼️ [View Picture]' ?>
        </div>
      </div>
    </div>
    <form method="post" class="text-right mt-6">
      <button name="edit" value="1" class="bg-blue-600 text-white px-6 py-2 rounded font-bold">Edit</button>
    </form>

  <?php else: ?>
    <form method="post" enctype="multipart/form-data" class="space-y-4">
      <?php foreach (['orgName'=>'Organization Name','email'=>'Email','phone'=>'Phone Number','contactPerson'=>'Contact Person','address'=>'Address'] as $key=>$label): ?>
        <div>
          <label class="font-bold" for="<?= $key ?>"><?= $label ?></label>
          <input name="<?= $key ?>" id="<?= $key ?>" value="<?= htmlspecialchars($profile[$key]) ?>" class="w-full p-2 border rounded" required />
        </div>
      <?php endforeach; ?>
      <div>
        <label class="font-bold">Company Registration</label>
        <?php if ($profile['resume'] && file_exists($profile['resume'])): ?>
          <a href="<?= $profile['resume'] ?>" class="text-blue-600 underline block mb-2" target="_blank">📂 View Resume</a>
        <?php endif; ?>
        <input type="file" name="resume" accept=".pdf" class="w-full" />
      </div>
      <div>
        <label class="font-bold">Company Logo</label>
        <?php if ($profile['logo'] && file_exists($profile['logo'])): ?>
          <img src="<?= $profile['logo'] ?>" class="max-h-20 rounded mb-2" />
        <?php endif; ?>
        <input type="file" name="logo" accept="image/*" class="w-full" />
      </div>
      <div class="text-right space-x-2 mt-6">
        <button class="bg-blue-600 text-white px-6 py-2 rounded font-bold">Save</button>
        <button name="cancel" value="1" class="bg-red-500 text-white px-6 py-2 rounded font-bold">Cancel</button>
      </div>
    </form>
  <?php endif; ?>
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
