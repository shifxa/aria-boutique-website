<?php
session_start();
include("../Server/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Store form data in session in case of error
    $_SESSION['form_data'] = [
        'name' => $_POST['name'],
        'description' => $_POST['description']
    ];

    // Get form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category_image = '';
    $banner_image = '';

    // Function to handle image upload
    function handleImageUpload($file, $prefix, $directory) {
        if (isset($file) && $file['error'] == 0) {
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
                        $new_file_name = time() . '_' . $prefix . '_' . str_replace(' ', '_', $_POST['name']) . '.' . $file_ext;
                        $file_destination = '../uploads/categories/' . $new_file_name;

                        // Create directory if it doesn't exist
                        if (!file_exists('../uploads/categories')) {
                            mkdir('../uploads/categories', 0777, true);
                        }

                        // Move uploaded file
                        if (move_uploaded_file($file_tmp, $file_destination)) {
                            return $new_file_name;
                        }
                    }
                }
            }
        }
        return false;
    }

    // Handle category image upload
    $category_image = handleImageUpload($_FILES['category_image'], 'category', '../uploads/categories');
    if ($category_image === false) {
        $_SESSION['error_message'] = "Error uploading category image";
        header("Location: add-category.php");
        exit();
    }

    // Handle banner image upload
    $banner_image = handleImageUpload($_FILES['banner_image'], 'banner', '../uploads/categories');
    if ($banner_image === false) {
        $_SESSION['error_message'] = "Error uploading banner image";
        header("Location: add-category.php");
        exit();
    }

    // Insert category into database
    $sql = "INSERT INTO categories (name, description, category_image, banner_image) VALUES (?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $description, $category_image, $banner_image);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Category added successfully!";
        unset($_SESSION['form_data']);
        header("Location: add-category.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error adding category: " . $conn->error;
        header("Location: add-category.php");
        exit();
    }
}

// If not POST request, redirect to add category page
header("Location: add-category.php");
exit();
?> 