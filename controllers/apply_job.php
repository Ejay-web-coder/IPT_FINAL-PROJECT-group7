<?php
session_start();
include '../controllers/connection.php'; // Adjust path if necessary

if (isset($_POST['submit_application'])) {
    $student_id = $_SESSION['student_id'] ?? null;
    $job_id = $_POST['job_id'] ?? null;
    $resume = $_FILES['resume'] ?? null;

    if ($student_id && $job_id && $resume && $resume['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/resumes/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $resumeName = uniqid() . '_' . basename($resume['name']);
        $resumePath = $uploadDir . $resumeName;

        if (move_uploaded_file($resume['tmp_name'], $resumePath)) {
            $stmt = $conn->prepare("INSERT INTO applications (student_id, job_id, resume_path, status) VALUES (?, ?, ?, 'pending')");
            $stmt->bind_param("iis", $student_id, $job_id, $resumeName);
            $stmt->execute();
            $stmt->close();

            echo "<script>
                alert('Please wait for the organization to approve your job application.');
                window.location.href = '../students/Job_Listing.php';
            </script>";
        } else {
            echo "<script>alert('Failed to upload resume.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Missing required fields or resume error.'); window.history.back();</script>";
    }
}
?>
