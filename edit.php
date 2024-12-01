<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// Fetch user data from session
$user = $_SESSION['user'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'kca');
    if ($conn->connect_error) {
        die('Connection Failed: ' . $conn->connect_error);
    }

    // Update user information
    $fullname = trim($_POST['fullname']);
    $id = trim($_POST['Id']);
    $email = trim($_POST['email']);
    $dob = trim($_POST['dob']);
    $gender = trim($_POST['gender']);
    $phone = trim($_POST['phone']);

    $stmt = $conn->prepare("UPDATE admin SET fullname=?, Id=?, email=?, dob=?, gender=?, phone=? WHERE email=?");
    if ($stmt === false) {
        die('Prepare failed: ' . $conn->error);
    }
    $stmt->bind_param("sssssss", $fullname, $id, $email, $dob, $gender, $phone, $user['email']);
    if ($stmt->execute()) {
        // Update session data
        $_SESSION['user']['fullname'] = $fullname;
        $_SESSION['user']['Id'] = $id;
        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['dob'] = $dob;
        $_SESSION['user']['gender'] = $gender;
        $_SESSION['user']['phone'] = $phone;

        // Redirect to dashboard
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Update failed.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
    <div class="container">
        <h1>Edit Profile</h1>
        <form method="post">
            <div class="form-group">
                <label for="fullname">Full Name</label>
                <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $user['fullname']; ?>" required>
            </div>
            <div class="form-group">
                <label for="Id">ID Number</label>
                <input type="text" class="form-control" id="Id" name="Id" value="<?php echo $user['Id']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $user['dob']; ?>" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select class="form-control" id="gender" name="gender" required>
                    <option value="male" <?php echo ($user['gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
                    <option value="female" <?php echo ($user['gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
                    <option value="other" <?php echo ($user['gender'] == 'other') ? 'selected' : ''; ?>>Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $user['phone']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="admin_dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
