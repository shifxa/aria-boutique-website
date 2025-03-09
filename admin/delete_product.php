<?php
include("../Server/connection.php");
include("check_admin.php");

// Get JSON data from request body
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['product_id'])) {
    echo json_encode(['success' => false, 'message' => 'Product ID is required']);
    exit;
}

$product_id = (int)$data['product_id'];

// First get the product image to delete it
$stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $image_path = "../uploads/products/" . $row['image'];
    if (file_exists($image_path)) {
        unlink($image_path); // Delete the image file
    }
}

// Delete the product from the database
$stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to delete product']);
}

$stmt->close();
$conn->close();
?> 