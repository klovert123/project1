<?php
session_start();
if (!isset($_SESSION['admin_loggedin']) || $_SESSION['admin_loggedin'] !== true) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <!-- Sidebar -->
    <div id="mySidebar" class="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="manage_users.php"><i class="fas fa-users"></i> Manage Users</a>
        <a href="view_orders.php"><i class="fas fa-box"></i> View Orders</a>
        <a href="manage_vehicles.php"><i class="fas fa-truck"></i> Manage Trucks</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <!-- Main Content -->
    <div id="main">
        <button class="btn btn-primary" onclick="openNav()">&#9776;</button>

        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="container">
                    <div class="card shadow">
                        <div class="card-body card-border-info">
                            <h1>Welcome, Admin <?php echo $_SESSION['admin']['fullname']; ?>!</h1>
                        </div>
                        <div class="card-body">
                            <div class="profile-info">
                                <h2>Quick Links:</h2>
                                <p><a href="manage_users.php"><i class="fas fa-users"></i> Manage Users</a></p>
                                <p><a href="view_orders.php"><i class="fas fa-box"></i> View Orders</a></p>
                                <a href="manage_vehicles.php"><i class="fas fa-truck"></i> Manage Trucks</a>
                                <p><a href="admin.html" onclick="document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Logout</a></p>
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
