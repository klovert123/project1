<?php
session_start();

// Ensure the admin is logged in
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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <title>Manage Vehicles</title>
</head>
<body>
    <div class="container mt-5">
        <?php if (!empty($message)): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>
        <a href="manage_vehicles.php" class="btn btn-primary">Back to Manage Vehicles</a>
        
    </div>
</body>
</html>
