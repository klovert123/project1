<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $fullname = htmlspecialchars($_POST['fullname']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $location = htmlspecialchars($_POST['location']);
    $date = htmlspecialchars($_POST['date']);
    $fuel_type = htmlspecialchars($_POST['fuel_type']);
    $quantity = htmlspecialchars($_POST['quantity']);
    $payment_method = htmlspecialchars($_POST['payment_method']);
    $id = htmlspecialchars($_POST['id']);

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'kca');
    if ($conn->connect_error) {
        die('Connection Failed: ' . $conn->connect_error);
    }

    // Insert data into the orders table
    $stmt = $conn->prepare("INSERT INTO orders (fullname, email, phone, location, date, fuel_type, quantity, payment_method, id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssiss", $fullname, $email, $phone, $location, $date, $fuel_type, $quantity, $payment_method, $id);

    if ($stmt->execute()) {
        // Get the last inserted ID for order number
        $order_id = $stmt->insert_id;
        $success_message = "Your order has been placed successfully. Your order number is: " . $order_id . ". Full Name: " . $fullname . ", Fuel Type: " . $fuel_type . ", Quantity: " . $quantity . " liters."; }
         else {
             $error_message = "There was an error placing your order. Please try again later."; }

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
    <title>Order Submission</title>
</head>
<body>
    <div class="container mt-5">
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success_message; ?>
            </div>
        <?php elseif (isset($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        <a href="dashboard.php" class="btn btn-primary">Back to dashboard</a>
    </div>
</body>
</html>
