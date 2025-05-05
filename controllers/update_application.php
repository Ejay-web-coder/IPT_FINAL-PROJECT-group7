<?php
session_start();
include '../controllers/connection.php';

$org_id = $_SESSION['organization_id']; // ✅ Get current logged-in org ID

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['application_id'], $_POST['action'])) {
    $application_id = $_POST['application_id'];
    $action = $_POST['action'];

    $status = ($action === 'approve') ? 'approved' : 'rejected';

    // Get student_id from application
    $stmt = $conn->prepare("SELECT student_id FROM applications WHERE id = ?");
    $stmt->bind_param("i", $application_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $app = $result->fetch_assoc();
    $student_id = $app['student_id'];

    // Update application status
    $stmt = $conn->prepare("UPDATE applications SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $application_id);
    $stmt->execute();

    // Send notification
    $message = ($status === 'approved') ? 'Your application has been approved!' : 'Your application has been rejected.';
    $stmt = $conn->prepare("INSERT INTO notifications (student_id, message, organization_id) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $student_id, $message, $org_id);
    $stmt->execute();

    header("Location: ../organization/manage_application.php?status=success");
    exit;
}

?>
