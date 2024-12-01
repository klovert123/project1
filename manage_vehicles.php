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

// Handle form submission to add a new vehicle
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_vehicle'])) {
    $truckname = htmlspecialchars($_POST['truckname']);
    $truckid = htmlspecialchars($_POST['truckid']);
    $driversname = htmlspecialchars($_POST['driversname']);
    $capacity = htmlspecialchars($_POST['capacity']);
    $driverphone = htmlspecialchars($_POST['driverphone']);
    $depot = htmlspecialchars($_POST['depot']);

    // Insert data into the trucks table
    $stmt = $conn->prepare("INSERT INTO trucks (truckname, truckid, driversname, capacity, driverphone, depot) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $truckname, $truckid, $driversname, $capacity, $driverphone, $depot);

    if ($stmt->execute()) {
        $message = "Truck details saved successfully.";
    } else {
        $message = "Error saving truck details: " . $conn->error;
    }

    $stmt->close();
}

// Fetch all vehicles
$vehicles_query = "SELECT * FROM trucks";
$vehicles_result = $conn->query($vehicles_query);

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
    <title>Manage Vehicles</title>
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
    <div id="main">
    <button class="btn btn-primary" onclick="openNav()">&#9776;</button>
        <div class="container mt-5">
            <h1 class="text-center">Manage Vehicles</h1>

            <!-- Display feedback message -->
            <?php if (!empty($message)): ?>
                <div class="alert alert-info"><?php echo $message; ?></div>
            <?php endif; ?>

          

            <!-- Display Existing Vehicles -->
            <div class="content">
            <h2>Existing Vehicles</h2>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Truck Name</th>
                                <th>Truck ID</th>
                                <th>Driver's Name</th>
                                <th>Capacity</th>
                                <th>Driver's Phone</th>
                                <th>Depot</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($vehicles_result && $vehicles_result->num_rows > 0): ?>
                                <?php while ($vehicle = $vehicles_result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($vehicle['truckname']); ?></td>
                                        <td><?php echo htmlspecialchars($vehicle['truckid']); ?></td>
                                        <td><?php echo htmlspecialchars($vehicle['driversname']); ?></td>
                                        <td><?php echo htmlspecialchars($vehicle['capacity']); ?></td>
                                        <td><?php echo htmlspecialchars($vehicle['driverphone']); ?></td>
                                        <td><?php echo htmlspecialchars($vehicle['depot']); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">No vehicles found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <a href="truck.html" class="btn btn-danger">add truck</a>
            </div>
    <script src="dashboard.js"></script>
</body>
</html>
