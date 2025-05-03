<header>
    <div class="logo" aria-label="EQCS Logo">
      <span>E</span><span>Q</span><span>C</span><span>S</span>
      <i class="fas fa-search"></i>
    </div>
    <nav aria-label="Primary Navigation">
      <a href="#" >Profile</a>
      <a href="#" class="btn-green active">Jobs Post</a>
      <a href="#">Requirements</a>
      <a href="#">Manage Application</a>
      <a href="#">Notification</a>
      <a href="#" class="logout">Logout</a>
    </nav>
  </header>
<style>
     header {
      background: white;
      box-shadow: 0 2px 6px rgb(0 0 0 / 0.1);
      padding: 1.5rem 2.5rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .logo {
      display: flex;
      align-items: center;
      gap: 0.25rem;
      font-weight: 800;
      font-size: 2.5rem;
      user-select: none;
    }
    .logo span:nth-child(1) { color: #818cf8; }
    .logo span:nth-child(2) { color: #fb923c; }
    .logo span:nth-child(3) { color: #4ade80; }
    .logo span:nth-child(4) { color: #0ea5e9; }
    .logo .fa-search {
      position: relative;
      left: -0.25rem;
      top: -0.25rem;
      color: #fb923c;
    }
    nav a {
      margin-left: 2rem;
      text-decoration: none;
      color: black;
      font-weight: 500;
      font-size: 1rem;
    }
    nav a.active, nav a.btn-green {
      background-color: #22c55e;
      color: white;
      padding: 0.25rem 1rem;
      border-radius: 0.375rem;
      font-weight: 600;
    }
    nav a.logout {
      font-weight: 700;
    }
</style>

<header class="bg-white shadow px-10 py-6 flex justify-between items-center">
  <div class="text-4xl font-extrabold">
    <img src="../image/logo.png" alt="" class="w-20 h-auto"> <!-- Adjusted image size -->
  </div>
    <nav class="text-sm font-medium space-x-8">
      <a href="Profile.php">Profile</a>
      <a href="job_post.php" class="bg-green-500 text-white px-4 py-1 rounded-md font-semibold">Jobs Post</a>
      <a href="requirements.php">Requirements</a>
      <a href="manage_application.php">Manage Application</a>
      <a href="notification_org.php">Notification</a>
      <a href="?showLogout=true" class="font-bold">Logout</a>
    </nav>
  </header>


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