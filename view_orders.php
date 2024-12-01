<?php
session_start();
if (!isset($_SESSION['admin_loggedin']) || $_SESSION['admin_loggedin'] !== true) {
    header("Location: admin_login.php");
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

$message = '';

// Handle status and truck update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['status'], $_POST['truckid'])) {
    $order_id = intval($_POST['order_id']);
    $status = $conn->real_escape_string($_POST['status']);
    $truckid = $conn->real_escape_string($_POST['truckid']);

    // Debugging statement
    echo "Order ID: $order_id, Status: $status, Truck ID: $truckid";

    $update_query = "UPDATE orders SET status='$status', truckid='$truckid' WHERE order_id=$order_id";
    if ($conn->query($update_query)) {
        $message = "Order #$order_id updated successfully.";
    } else {
        $message = "Error updating order: " . $conn->error;
    }
}

// Fetch orders with truck info
$orders_query = "SELECT o.order_id, o.fullname, o.fuel_type, o.quantity, o.date, o.status, 
                        t.truckname, t.truckid, t.driversname, t.driverphone 
                 FROM orders o 
                 LEFT JOIN trucks t ON o.truckid = t.truckid";
$result = $conn->query($orders_query);

// Fetch available trucks
$trucks_query = "SELECT truckid, truckname, driversname, driverphone FROM trucks";
$trucks_result = $conn->query($trucks_query);
$trucks = [];
while ($truck = $trucks_result->fetch_assoc()) {
    $trucks[] = $truck;
}

$conn->close();
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
    <title>Manage Orders</title>
</head>
<body>
<!-- Sidebar -->
<div id="mySidebar" class="sidebar">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    <a href="manage_users.php"><i class="fas fa-users"></i> Manage Users</a>
    <a href="#"><i class="fas fa-box"></i> View Orders</a>
    <a href="manage_vehicles.php"><i class="fas fa-truck"></i> Manage Trucks</a>
    <a href="#" onclick="document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Logout</a>
    <form id="logout-form" method="post" style="display: none;">
        <input type="hidden" name="logout">
    </form>
</div>
<div id="main">
    <button class="btn btn-primary" onclick="openNav()">&#9776;</button>

    <div class="container mt-5">
        <h1 class="text-center">Manage Orders</h1>

        <!-- Display feedback message -->
        <?php if (!empty($message)): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>

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
                    <th>Actions</th>
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
                            <td>
                                <!-- Individual form for updating status and truck -->
                                <form method="POST" action="">
                                    <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                    <select name="status" class="form-control me-2">
                                        <option value="Pending" <?php if ($order['status'] === 'Pending') echo 'selected'; ?>>Pending</option>
                                        <option value="Processing" <?php if ($order['status'] === 'Processing') echo 'selected'; ?>>Processing</option>
                                        <option value="Shipped" <?php if ($order['status'] === 'Shipped') echo 'selected'; ?>>Shipped</option>
                                        <option value="Completed" <?php if ($order['status'] === 'Completed') echo 'selected'; ?>>Completed</option>
                                        <option value="Cancelled" <?php if ($order['status'] === 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                                    </select>
                                    <select name="truckid" class="form-control mt-2">
                                        <option value="">Select Truck</option>
                                        <?php foreach ($trucks as $truck): ?>
                                        <option value="<?php echo htmlspecialchars($truck['truckid']); ?>">
                                            <?php echo htmlspecialchars($truck['truckname'] . ' - ' . $truck['driversname'] . ' (' . $truck['driverphone'] . ')'); ?>
                                        </option>
                                    <?php endforeach; ?>
                                    </select>
                                    <button type="submit" class="btn btn-primary mt-2">Update</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11" class="text-center">No orders found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="dashboard.js"></script>
</body>
</html>
