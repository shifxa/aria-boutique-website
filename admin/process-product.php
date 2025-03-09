<?php
session_start();
include("../Server/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Store form data in session in case of error
    $_SESSION['form_data'] = [
        'name' => $_POST['name'],
        'category' => $_POST['category'],
        'price' => $_POST['price'],
        'discounted_price' => $_POST['discounted_price'],
        'description' => $_POST['description'],
        'quantity' => $_POST['quantity']
    ];

    // Get form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category_id = intval($_POST['category']);
    $price = floatval($_POST['price']);
    $discounted_price = !empty($_POST['discounted_price']) ? floatval($_POST['discounted_price']) : null;
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $quantity = intval($_POST['quantity']);

    // Verify that the category exists
    $category_check = $conn->prepare("SELECT id FROM categories WHERE id = ?");
    $category_check->bind_param("i", $category_id);
    $category_check->execute();
    $category_result = $category_check->get_result();

    if ($category_result->num_rows === 0) {
        $_SESSION['error_message'] = "Invalid category selected";
        header("Location: add-product.php");
        exit();
    }

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $file = $_FILES['image'];
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_size = $file['size'];
        $file_error = $file['error'];

        // Get file extension
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        // Allowed file extensions
        $allowed = array('jpg', 'jpeg', 'png', 'webp');

        if (in_array($file_ext, $allowed)) {
            if ($file_error === 0) {
                if ($file_size <= 5242880) { // 5MB max file size
                    // Generate unique filename with timestamp
                    $new_file_name = time() . '_' . str_replace(' ', '_', $name) . '.' . $file_ext;
                    $file_destination = '../uploads/products/' . $new_file_name;

                    // Create directory if it doesn't exist
                    if (!file_exists('../uploads/products')) {
                        mkdir('../uploads/products', 0777, true);
                    }

                    // Move uploaded file
                    if (move_uploaded_file($file_tmp, $file_destination)) {
                        // Insert product into database
                        $sql = "INSERT INTO products (name, category_id, price, discounted_price, description, quantity, image) 
                                VALUES (?, ?, ?, ?, ?, ?, ?)";
                        
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("siddsss", $name, $category_id, $price, $discounted_price, $description, $quantity, $new_file_name);

                        if ($stmt->execute()) {
                            $_SESSION['success_message'] = "Product added successfully!";
                            header("Location: add-product.php");
                            exit();
                        } else {
                            $_SESSION['error_message'] = "Error adding product: " . $conn->error;
                        }
                    } else {
                        $_SESSION['error_message'] = "Error uploading file";
                    }
                } else {
                    $_SESSION['error_message'] = "File size too large. Maximum size is 5MB";
                }
            } else {
                $_SESSION['error_message'] = "Error uploading file: " . $file_error;
            }
        } else {
            $_SESSION['error_message'] = "Invalid file type. Allowed types: " . implode(', ', $allowed);
        }
    } else {
        $_SESSION['error_message'] = "Please select an image";
    }

    // If there was an error, redirect back to add product page
    if (isset($_SESSION['error_message'])) {
        header("Location: add-product.php");
        exit();
    }
}

// If not POST request, redirect to add product page
header("Location: add-product.php");
exit();
?> 