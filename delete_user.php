<?php
session_start();
if (!isset($_SESSION['admin_loggedin']) || $_SESSION['admin_loggedin'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'kca');
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

$user_id = $_GET['id'] ?? null;

if (!$user_id) {
    die('Invalid user ID');
}

// Delete user
$query = "DELETE FROM registration WHERE Id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    // Redirect back to the user management page after deleting the user
    header("Location: manage_users.php");
    exit();
} else {
    echo "Error deleting user: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
