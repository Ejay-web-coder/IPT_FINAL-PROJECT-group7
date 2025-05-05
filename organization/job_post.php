<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Job Board</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
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
      <a href="Profile.php">Profile</a>
      <a href="job_post.php" class="bg-green-500 text-white px-4 py-1 rounded-md font-semibold">Jobs Post</a>
      <a href="requirements.php">Requirements</a>
      <a href="manage_application.php">Manage Application</a>
      <a href="notification_org.php">Notification</a>
      <a href="?showLogout=true" class="font-bold">Logout</a>
    </nav>
  </header>
<?php
include '../controllers/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_job'])) {
        if (isset($_POST['job_id'], $_POST['job_title'], $_POST['company_name'], $_POST['job_type'], $_POST['location'], $_POST['salary'], $_POST['job_description'], $_POST['deadline'])) {
            $job_id = $_POST['job_id'];
            $job_title = $_POST['job_title'];
            $company_name = $_POST['company_name'];
            $job_type = $_POST['job_type'];
            $location = $_POST['location'];
            $salary = $_POST['salary'];
            $job_description = $_POST['job_description'];
            $deadline = $_POST['deadline'];

            $update_stmt = $conn->prepare("UPDATE jobs_list SET job_title = ?, company_name = ?, job_type = ?, location = ?, salary = ?, job_description = ?, deadline = ? WHERE id = ?");
            $update_stmt->bind_param("sssssssi", $job_title, $company_name, $job_type, $location, $salary, $job_description, $deadline, $job_id);

            if ($update_stmt->execute()) {
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                echo "Error: " . $update_stmt->error;
            }
            $update_stmt->close();
        } else {
            echo "Please fill in all required fields.";
        }
    }

    if (isset($_POST['delete_job'])) {
        if (isset($_POST['job_id'])) {
            $job_id = $_POST['job_id'];
            $delete_stmt = $conn->prepare("DELETE FROM jobs_list WHERE id = ?");
            $delete_stmt->bind_param("i", $job_id);

            if ($delete_stmt->execute()) {
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                echo "Error: " . $delete_stmt->error;
            }
            $delete_stmt->close();
        }
    }

    if (!isset($_POST['update_job']) && !isset($_POST['delete_job'])) {
        if (isset($_POST['job_title'], $_POST['company_name'], $_POST['job_type'], $_POST['location'], $_POST['salary'], $_POST['job_description'], $_POST['deadline'])) {
            $job_title = $_POST['job_title'];
            $company_name = $_POST['company_name'];
            $job_type = $_POST['job_type'];
            $location = $_POST['location'];
            $salary = $_POST['salary'];
            $job_description = $_POST['job_description'];
            $deadline = $_POST['deadline'];

            $status = 'pending';
            $stmt = $conn->prepare("INSERT INTO jobs_list (job_title, company_name, job_type, location, salary, job_description, deadline, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $job_title, $company_name, $job_type, $location, $salary, $job_description, $deadline, $status);
            
            $show_modal = false;
            $modal_message = "";
            
            if ($stmt->execute()) {
                $show_modal = true;
                $modal_message = "Please wait for the approval for your vacant job.";
            }
             else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Please fill in all required fields.";
        }
    }
}

$result = $conn->query("SELECT * FROM jobs_list WHERE status = 'approved'");
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>
<?php if (isset($show_modal) && $show_modal): ?>
<div id="approvalModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
  <div class="bg-white p-6 rounded shadow-md max-w-md w-full">
    <h3 class="text-lg font-bold mb-2">Job Submission Received</h3>
    <p class="mb-4"><?php echo $modal_message; ?></p>
    <button onclick="document.getElementById('approvalModal').style.display='none'" class="px-4 py-2 bg-blue-500 text-white rounded">OK</button>
  </div>
</div>
<?php endif; ?>

<!-- Job Form -->
<form action="" method="POST" class="max-w-lg mx-auto bg-white p-6 border rounded shadow space-y-4 mt-10">
  <h2 class="text-xl font-semibold text-center">Add Job</h2>

  <div><label class="block text-sm font-medium">Job Title</label>
  <input type="text" name="job_title" class="w-full border p-2 rounded" placeholder="Job Title" required></div>

  <div><label class="block text-sm font-medium">Company Name</label>
  <input type="text" name="company_name" class="w-full border p-2 rounded" placeholder="Company Name" required></div>

  <div><label class="block text-sm font-medium">Job Type</label>
  <input type="text" name="job_type" class="w-full border p-2 rounded" placeholder="Full-time, Part-time, etc." required></div>

  <div><label class="block text-sm font-medium">Location</label>
  <input type="text" name="location" class="w-full border p-2 rounded" placeholder="Location" required></div>

  <div><label class="block text-sm font-medium">Salary</label>
  <input type="text" name="salary" class="w-full border p-2 rounded" placeholder="e.g. $50,000/year" required></div>

  <div><label class="block text-sm font-medium">Job Description</label>
  <textarea name="job_description" rows="3" class="w-full border p-2 rounded" placeholder="Enter job details here..." required></textarea></div>

  <div><label class="block text-sm font-medium">Deadline</label>
  <input type="date" name="deadline" class="w-full border p-2 rounded" required></div>

  <div class="flex justify-end space-x-2">
    <button type="reset" class="px-4 py-1 bg-gray-300 rounded">Cancel</button>
    <button type="submit" class="px-4 py-1 bg-green-500 text-white rounded">Add</button>
  </div>
</form>

<!-- Job Listings -->
<div class="space-y-6 mt-10 max-w-2xl mx-auto">
<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="p-6 border rounded shadow">';
        echo '<p><strong>Job Title:</strong> ' . htmlspecialchars($row['job_title']) . '</p>';
        echo '<p><strong>Company:</strong> ' . htmlspecialchars($row['company_name']) . '</p>';
        echo '<p><strong>Type:</strong> ' . htmlspecialchars($row['job_type']) . '</p>';
        echo '<p><strong>Location:</strong> ' . htmlspecialchars($row['location']) . '</p>';
        echo '<p><strong>Salary:</strong> ' . htmlspecialchars($row['salary']) . '</p>';
        echo '<p><strong>Description:</strong> ' . htmlspecialchars($row['job_description']) . '</p>';
        echo '<p><strong>Deadline:</strong> ' . htmlspecialchars($row['deadline']) . '</p>';
        echo '<div class="mt-4">';
        echo '<button 
                type="button" 
                class="edit-btn px-3 py-1 bg-blue-500 text-white text-sm rounded" 
                data-id="' . $row['id'] . '"
                data-title="' . htmlspecialchars($row['job_title'], ENT_QUOTES) . '"
                data-company="' . htmlspecialchars($row['company_name'], ENT_QUOTES) . '"
                data-type="' . htmlspecialchars($row['job_type'], ENT_QUOTES) . '"
                data-location="' . htmlspecialchars($row['location'], ENT_QUOTES) . '"
                data-salary="' . htmlspecialchars($row['salary'], ENT_QUOTES) . '"
                data-description="' . htmlspecialchars($row['job_description'], ENT_QUOTES) . '"
                data-deadline="' . $row['deadline'] . '"
                onclick="openEditModal(this)">
                Edit
              </button>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<p class="text-center">No job listings available.</p>';
}
?>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
  <form id="editForm" method="POST" class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg space-y-4">
    <h2 class="text-xl font-bold text-center">Edit Job</h2>
    <input type="hidden" name="job_id" id="edit_job_id">

    <div><label class="block text-sm font-medium">Job Title</label>
    <input type="text" name="job_title" id="edit_job_title" class="w-full border p-2 rounded" required></div>

    <div><label class="block text-sm font-medium">Company Name</label>
    <input type="text" name="company_name" id="edit_company_name" class="w-full border p-2 rounded" required></div>

    <div><label class="block text-sm font-medium">Job Type</label>
    <input type="text" name="job_type" id="edit_job_type" class="w-full border p-2 rounded" required></div>

    <div><label class="block text-sm font-medium">Location</label>
    <input type="text" name="location" id="edit_location" class="w-full border p-2 rounded" required></div>

    <div><label class="block text-sm font-medium">Salary</label>
    <input type="text" name="salary" id="edit_salary" class="w-full border p-2 rounded" required></div>

    <div><label class="block text-sm font-medium">Job Description</label>
    <textarea name="job_description" id="edit_job_description" rows="3" class="w-full border p-2 rounded" required></textarea></div>

    <div><label class="block text-sm font-medium">Deadline</label>
    <input type="date" name="deadline" id="edit_deadline" class="w-full border p-2 rounded" required></div>

    <div class="flex justify-end gap-2">
      <button type="button" onclick="closeEditModal()" class="bg-gray-300 px-4 py-1 rounded">Cancel</button>
      <button type="submit" name="update_job" class="bg-green-500 text-white px-4 py-1 rounded">Save</button>
      <button type="submit" name="delete_job" class="bg-red-500 text-white px-4 py-1 rounded">Delete</button>
    </div>
  </form>
</div>

<!-- Script -->
<script>
  function openEditModal(button) {
    document.getElementById('edit_job_id').value = button.dataset.id;
    document.getElementById('edit_job_title').value = button.dataset.title;
    document.getElementById('edit_company_name').value = button.dataset.company;
    document.getElementById('edit_job_type').value = button.dataset.type;
    document.getElementById('edit_location').value = button.dataset.location;
    document.getElementById('edit_salary').value = button.dataset.salary;
    document.getElementById('edit_job_description').value = button.dataset.description;
    document.getElementById('edit_deadline').value = button.dataset.deadline;

    document.getElementById('editModal').classList.remove('hidden');
  }

  function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
  }
</script>
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
