<?php
session_start();
header('Content-Type: application/json'); // Set JSON response header

include("Server/connection.php");

// Initialize response array
$response = ["status" => "error", "message" => "Invalid request."];

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $response["message"] = "Please log in to add to wishlist.";
    echo json_encode($response);
    exit();
}

// Check if the request is POST and product_id is provided
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = (int)$_POST['product_id'];

    // Validate product_id
    if ($product_id > 0) {
        // Check if product is already in wishlist
        $check_query = "SELECT id FROM wishlist WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Product already in wishlist
            $response["message"] = "This product is already in your wishlist!";
        } else {
            // Add to wishlist
            $insert_query = "INSERT INTO wishlist (user_id, product_id, timestamp) VALUES (?, ?, NOW())";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("ii", $user_id, $product_id);

            if ($stmt->execute()) {
                $response["status"] = "success";
                $response["message"] = "Product added to wishlist!";
            } else {
                $response["message"] = "Error occurred. Please try again.";
            }
        }
        $stmt->close();
    } else {
        $response["message"] = "Invalid product.";
    }
}

// Output JSON response
echo json_encode($response);
exit();
?>