<?php
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

// Database connection
$conn = new mysqli('localhost', 'root', '', 'kca');
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

// Fetch user by email
$stmt = $conn->prepare("SELECT * FROM registration WHERE email = ?");
if ($stmt === false) {
    die('Prepare failed: ' . $conn->error);
}
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Check if the user exists
if ($user) {
    // Verify the password against the stored hashed password
    if (password_verify($password, $user['password'])) {
        // Successful login
        $_SESSION['user'] = $user;
        $_SESSION['loggedin'] = true;
        header("Location: dashboard.php");
        exit();
    } else {
        // Output for debugging
        echo "Password verification failed. ";
        echo "Entered password: " . $password . " ";
        echo "Stored hash: " . $user['password'];
    }
} else {
    echo "User not found with email: $email";
}

$stmt->close();
$conn->close();
?>
