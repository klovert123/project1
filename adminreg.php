<?php
$fullname = $_POST['fullname'];
$Id = $_POST['Id'];
$email = $_POST['email'];
$dob = $_POST['dob'];
$gender = $_POST['gender'];
$phone = $_POST['phone'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Database connection
$conn = new mysqli('localhost', 'root', '', 'kca');
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
} else {
    $stmt = $conn->prepare("INSERT INTO admin (fullname, Id, email, dob, gender, phone, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die('Prepare failed: ' . $conn->error);
    }
    
    $stmt->bind_param("sssssss", $fullname, $Id, $email, $dob, $gender, $phone, $password);
    if ($stmt->execute()) {
        // Successful registration
        session_start();
        $_SESSION['user'] = [
            'fullname' => $fullname,
            'Id' => $Id,
            'email' => $email,
            'dob' => $dob,
            'gender' => $gender,
            'phone' => $phone
        ];
        $_SESSION['loggedin'] = true;
        header("Location: admin.html");
        exit();
    } else {
        echo "Registration failed.";
    }
    
    $stmt->close();
    $conn->close();
}
?>

