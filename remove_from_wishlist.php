<?php
session_start();
header('Content-Type: application/json');

include("Server/connection.php");

$response = ["status" => "error", "message" => "Invalid request."];

if (!isset($_SESSION['user_id'])) {
    $response["message"] = "Please log in to remove from wishlist.";
    echo json_encode($response);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = (int)$_POST['product_id'];

    if ($product_id > 0) {
        $stmt = $conn->prepare("DELETE FROM wishlist WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("ii", $user_id, $product_id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $response["status"] = "success";
                $response["message"] = "Product removed from wishlist!";
            } else {
                $response["message"] = "Product not found in your wishlist.";
            }
        } else {
            $response["message"] = "Error occurred. Please try again.";
        }
        $stmt->close();
    } else {
        $response["message"] = "Invalid product.";
    }
}

echo json_encode($response);
exit();
?>