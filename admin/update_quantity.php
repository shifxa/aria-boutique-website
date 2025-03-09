<?php
include("../Server/connection.php");
include("check_admin.php");

// Get JSON data from request body
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['product_id']) || !isset($data['quantity'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

$product_id = (int)$data['product_id'];
$quantity = (int)$data['quantity'];

// Update the product quantity
$stmt = $conn->prepare("UPDATE products SET quantity = ? WHERE id = ?");
$stmt->bind_param("ii", $quantity, $product_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error']);
}

$stmt->close();
$conn->close();
?> 