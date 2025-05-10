<?php
session_start();
include '../controllers/connection.php';

// Check if the form was submitted for approve/reject
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $application_id = $_POST['application_id'];
    $status = $_POST['status'];
    $message = $_POST['message'];

    // Update the application status
    $update_query = "UPDATE applications SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $status, $application_id);
    $stmt->execute();

    // Get the student_id associated with this application
    $select_query = "SELECT student_id FROM applications WHERE id = ?";
    $stmt = $conn->prepare($select_query);
    $stmt->bind_param("i", $application_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
    $student_id = $student['student_id'];

    // Insert a notification for the student
    $notification_query = "INSERT INTO notifications (student_id, message) VALUES (?, ?)";
    $stmt = $conn->prepare($notification_query);
    $stmt->bind_param("is", $student_id, $message);
    $stmt->execute();

    // Redirect back to the manage application page
    header("Location: ../organization/manage_application.php");
    exit();
}
?>
