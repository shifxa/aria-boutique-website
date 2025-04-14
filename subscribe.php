<?php
header('Content-Type: application/json'); // Set JSON response header

include("Server/connection.php"); // Include your database connection

// Initialize response array
$response = ["status" => "error", "message" => "Invalid request."];

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize the email input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Validate email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Check if email already exists
        $check_query = "SELECT email FROM community WHERE email = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Email already exists
            $response["message"] = "This email is already subscribed!";
        } else {
            // Insert email into the community table
            $insert_query = "INSERT INTO community (email, joining_date) VALUES (?, NOW())";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("s", $email);

            if ($stmt->execute()) {
                $response["status"] = "success";
                $response["message"] = "Thank you for subscribing!";
            } else {
                $response["message"] = "Error occurred. Please try again.";
            }
        }
        $stmt->close();
    } else {
        $response["message"] = "Please enter a valid email address.";
    }
}

// Output JSON response
echo json_encode($response);
exit();
?>