<?php
include("../Server/connection.php");
include("check_admin.php");

// Get JSON data from request body
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['category_id'])) {
    echo json_encode(['success' => false, 'message' => 'Category ID is required']);
    exit;
}

$category_id = (int)$data['category_id'];

// Start transaction
$conn->begin_transaction();

try {
    // First get the category images to delete them
    $stmt = $conn->prepare("SELECT category_image, banner_image FROM categories WHERE id = ?");
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Delete category image
        if (!empty($row['category_image'])) {
            $category_image_path = "../uploads/categories/" . $row['category_image'];
            if (file_exists($category_image_path)) {
                unlink($category_image_path);
            }
        }

        // Delete banner image
        if (!empty($row['banner_image'])) {
            $banner_image_path = "../uploads/categories/" . $row['banner_image'];
            if (file_exists($banner_image_path)) {
                unlink($banner_image_path);
            }
        }
    }

    // Delete all products in this category
    $stmt = $conn->prepare("SELECT image FROM products WHERE category_id = ?");
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Delete product images
    while ($row = $result->fetch_assoc()) {
        if (!empty($row['image'])) {
            $product_image_path = "../uploads/products/" . $row['image'];
            if (file_exists($product_image_path)) {
                unlink($product_image_path);
            }
        }
    }

    // Delete products
    $stmt = $conn->prepare("DELETE FROM products WHERE category_id = ?");
    $stmt->bind_param("i", $category_id);
    $stmt->execute();

    // Finally, delete the category
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param("i", $category_id);
    $stmt->execute();

    // Commit transaction
    $conn->commit();
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}

$conn->close();
?> 