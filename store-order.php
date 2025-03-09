<?php
// Prevent any unwanted output
error_reporting(0);
ini_set('display_errors', 0);

// Start session and set headers
session_start();
header('Content-Type: application/json');

try {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('User not logged in');
    }

    // Get the JSON data from the request
    $json = file_get_contents('php://input');
    if (!$json) {
        throw new Exception('No data received');
    }

    $data = json_decode($json, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON format: ' . json_last_error_msg());
    }

    // Log the received data for debugging
    error_log('Received data: ' . print_r($data, true));

    if (!$data) {
        throw new Exception('Empty data received');
    }

    if (empty($data['payment_id'])) {
        throw new Exception('Missing payment ID');
    }

    if (empty($data['product_id'])) {
        throw new Exception('Missing product ID');
    }

    if (empty($data['quantity'])) {
        throw new Exception('Missing quantity');
    }

    if (!isset($data['amount'])) {
        throw new Exception('Missing amount');
    }

    // Include database connection
    include("Server/connection.php");

    if (!$conn) {
        throw new Exception('Database connection failed');
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO orders (product_id, user_id, payment_id, amount, date, quantity, size, status) VALUES (?, ?, ?, ?, NOW(), ?, ?, 'Placed')");
    
    if (!$stmt) {
        throw new Exception('Failed to prepare statement: ' . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param(
        "iisdis", 
        $data['product_id'],
        $_SESSION['user_id'],
        $data['payment_id'],
        $data['amount'],
        $data['quantity'],
        $data['size']
    );

    // Execute the statement
    if (!$stmt->execute()) {
        throw new Exception('Failed to save order: ' . $stmt->error);
    }

    $order_id = $conn->insert_id;

    // Store order details in session for success page
    $_SESSION['payment_success'] = true;
    $_SESSION['order_details'] = [
        'order_id' => $order_id,
        'payment_id' => $data['payment_id'],
        'product_name' => $data['product_name'],
        'image' => $data['image'],
        'size' => $data['size'],
        'quantity' => $data['quantity'],
        'amount' => $data['amount']
    ];

    $stmt->close();
    $conn->close();

    error_log('Order stored successfully with ID: ' . $order_id);

    exit(json_encode([
        'success' => true,
        'message' => 'Order details stored successfully',
        'order_id' => $order_id
    ]));

} catch (Exception $e) {
    error_log('Error in store-order.php: ' . $e->getMessage());
    http_response_code(400);
    exit(json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]));
}
?> 