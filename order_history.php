<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "kca";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user']['Id']; // Ensure this session variable is set correctly

// Fetch user orders with truck details
$orders_query = $conn->prepare("SELECT o.order_id, o.fullname, o.fuel_type, o.quantity, o.date, o.status, t.truckid, t.truckname, t.driversname, t.driverphone 
                                FROM orders o 
                                LEFT JOIN trucks t ON o.truckid = t.truckid 
                                WHERE o.id = ?");
$orders_query->bind_param("i", $user_id);
$orders_query->execute();
$result = $orders_query->get_result();
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
    <title>View Orders</title>
</head>
<body>
<!-- Sidebar -->
<div id="mySidebar" class="sidebar">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="dashboard.php"><i class="fas fa-user"></i>My Profile</a>
    <a href="order.html"><i class="fas fa-box"></i>Order</a>
    <a href="order_history.php"><i class="fas fa-concierge-bell"></i>Order History</a>
    <a href="edit_profile.php"><i class="fas fa-edit"></i> Edit Profile</a>
    <a href="form.html" onclick="document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Logout</a>
    <form id="logout-form" method="post" style="display: none;">
        <input type="hidden" name="logout">
    </form>
</div>
<div id="main">
    <button class="btn btn-primary" onclick="openNav()">&#9776;</button>

    <div class="container mt-5">
        <h1 class="text-center">Your Orders</h1>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Full Name</th>
                    <th>Fuel Type</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Truck ID</th>
                    <th>Truck Name</th>
                    <th>Driver Name</th>
                    <th>Driver Phone</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($order = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                            <td><?php echo htmlspecialchars($order['date']); ?></td>
                            <td><?php echo htmlspecialchars($order['fullname']); ?></td>
                            <td><?php echo htmlspecialchars($order['fuel_type']); ?></td>
                            <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($order['status']); ?></td>
                            <td><?php echo htmlspecialchars($order['truckid'] ?? 'No truck assigned'); ?></td>
                            <td><?php echo htmlspecialchars($order['truckname'] ?? 'No truck assigned'); ?></td>
                            <td><?php echo htmlspecialchars($order['driversname'] ?? 'No driver assigned'); ?></td>
                            <td><?php echo htmlspecialchars($order['driverphone'] ?? 'No phone assigned'); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" class="text-center">No orders found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="dashboard.js"></script>
</body>
</html>

