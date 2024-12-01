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

// Fetch the user's current information
$query = "SELECT * FROM registration WHERE Id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Update user details
    $update_query = "UPDATE registration SET fullname = ?, email = ?, phone = ? WHERE Id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssi", $fullname, $email, $phone, $user_id);
    
    if ($stmt->execute()) {
        $message = "User updated successfully!";
    } else {
        $message = "Error updating user: " . $conn->error;
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>Edit User</title>
</head>
<body>
<div class="container mt-5">
    <h2>Edit User</h2>
    <?php if (isset($message)): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <div class="mb-3">
            <label for="fullname" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="manage_users.php" class="btn btn-danger">Cancel</a>
    </form>
</div>
</body>
</html>
