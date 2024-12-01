<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// Logout function
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: form.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div id="mySidebar" class="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="#"><i class="fas fa-user"></i>My Profile</a>
        <a href="order.html"><i class="fas fa-box"></i>Order</a>
        <a href="order_history.php"><i class="fas fa-concierge-bell"></i> Order History</a>
        <a href="edit_profile.php"><i class="fas fa-edit"></i> Edit Profile</a>
        <a href="form.html" onclick="document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Logout</a>
        <form id="logout-form" method="post" style="display: none;">
            <input type="hidden" name="logout">
        </form>
    </div>

    <div id="main">
        <button class="btn btn-primary" onclick="openNav()">&#9776;</button>

        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="container">
                    <div class="card shadow">
                        <div class="card-body card-border-info">
                            <h1>Welcome, <?php echo $_SESSION['user']['fullname']; ?>!</h1>
                        </div>
                        <div class="card-body">
                            <div class="profile-info">
                                <h2>Your Profile Information:</h2>
                                <p><strong>Full Name:</strong> <?php echo $_SESSION['user']['fullname']; ?></p>
                                <p><strong>ID Number:</strong> <?php echo $_SESSION['user']['Id']; ?></p>
                                <p><strong>Email:</strong> <?php echo $_SESSION['user']['email']; ?></p>
                                <p><strong>Date of Birth:</strong> <?php echo $_SESSION['user']['dob']; ?></p>
                                <p><strong>Gender:</strong> <?php echo $_SESSION['user']['gender']; ?></p>
                                <p><strong>Phone Number:</strong> <?php echo $_SESSION['user']['phone']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="dashboard.js"></script>
</body>
</html>
