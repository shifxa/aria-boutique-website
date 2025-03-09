<?php
// session_start();
include("../Server/connection.php");
include("check_admin.php");

// Initialize variables to store form data
$form_data = [
    'name' => '',
    'category' => '',
    'price' => '',
    'discounted_price' => '',
    'description' => '',
    'quantity' => ''
];

// If there was an error, restore the form data
if (isset($_SESSION['error_message'])) {
    $form_data = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : $form_data;
    unset($_SESSION['form_data']);
}

// Clear form data if success
if (isset($_SESSION['success_message'])) {
    $form_data = [
        'name' => '',
        'category' => '',
        'price' => '',
        'discounted_price' => '',
        'description' => '',
        'quantity' => ''
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Admin Panel</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="icon" type="image/png" href="../images/boutique logo.png">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
                <i class="fas fa-shopping-bag"></i>
                <span>Aria Admin</span>
            </div>
            <ul class="nav-links">
                <li class="nav-item">
                    <a href="add-product.php" class="nav-link active">
                        <i class="fas fa-box"></i>
                        <span>Products</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="add-category.php" class="nav-link">
                        <i class="fas fa-tags"></i>
                        <span>Categories</span>
                    </a>
                </li>
            </ul>
            <!-- Logout Link -->
            <div class="sidebar-footer">
                <a href="../auth/logout.php" class="nav-link logout-link">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>

        <style>
            .sidebar-footer {
                position: absolute;
                bottom: 0;
                width: 100%;
                padding: 1rem;
                border-top: 1px solid var(--border-color);
            }

            .logout-link {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                padding: 0.75rem 1rem;
                color: #dc3545;
                text-decoration: none;
                border-radius: 8px;
                transition: all 0.3s ease;
            }

            .logout-link:hover {
                background: rgba(220, 53, 69, 0.1);
                color: #dc3545;
            }

            @media (max-width: 768px) {
                .sidebar-footer span {
                    display: none;
                }
                
                .sidebar-footer {
                    padding: 0.5rem;
                }
                
                .logout-link {
                    justify-content: center;
                }
            }
        </style>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search...">
                </div>
                <div class="user-profile">
                    <div class="user-info">
                        <div class="user-name">Admin User</div>
                        <div class="user-role">Administrator</div>
                    </div>
                    <img src="https://ui-avatars.com/api/?name=Admin+User" alt="Admin" class="user-avatar">
                </div>
            </div>

            <!-- Content Area -->
            <div class="content-area">
                <h1 class="page-title">Add New Product</h1>
                
                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
                        <?php 
                        echo $_SESSION['success_message']; 
                        unset($_SESSION['success_message']);
                        ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
                        <?php 
                        echo $_SESSION['error_message']; 
                        unset($_SESSION['error_message']);
                        ?>
                    </div>
                <?php endif; ?>

                <div class="form-container">
                    <form action="process-product.php" method="POST" enctype="multipart/form-data" id="productForm">
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Product Name</label>
                                <input type="text" class="form-control" name="name" required value="<?php echo htmlspecialchars($form_data['name']); ?>">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Category</label>
                                <select class="form-control" name="category" required>
                                    <option value="">Select Category</option>
                                    <?php
                                    // Fetch categories from database
                                    $sql = "SELECT id, name FROM categories ORDER BY name ASC";
                                    $result = $conn->query($sql);
                                    
                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            $selected = ($form_data['category'] == $row['id']) ? 'selected' : '';
                                            echo '<option value="' . $row['id'] . '" ' . $selected . '>' . htmlspecialchars($row['name']) . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Price (₹)</label>
                                <input type="number" class="form-control" name="price" required value="<?php echo htmlspecialchars($form_data['price']); ?>">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Discounted Price (₹)</label>
                                <input type="number" class="form-control" name="discounted_price" value="<?php echo htmlspecialchars($form_data['discounted_price']); ?>">
                            </div>

                            <div class="form-group" style="grid-column: 1 / -1;">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" required><?php echo htmlspecialchars($form_data['description']); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Quantity</label>
                                <div class="size-quantities">
                                    <div class="size-row" style="display: flex; gap: 1rem; margin-bottom: 0.5rem;">
                                        <input type="number" class="form-control" name="quantity" placeholder="Quantity" min="0" value="<?php echo htmlspecialchars($form_data['quantity']); ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Product Image</label>
                                <div class="image-upload" onclick="document.getElementById('imageInput').click()">
                                    <input type="file" id="imageInput" name="image" accept="image/*" style="display: none;" required>
                                    <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                    <div class="upload-text">Click to upload image</div>
                                    <div class="upload-hint">Maximum file size: 5MB</div>
                                </div>
                            </div>
                        </div>

                        <div style="text-align: right; margin-top: 2rem;">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                                Add Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Handle image upload preview
        document.getElementById('imageInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const uploadDiv = document.querySelector('.image-upload');
                    uploadDiv.style.backgroundImage = `url(${e.target.result})`;
                    uploadDiv.style.backgroundSize = 'contain';
                    uploadDiv.style.backgroundPosition = 'center';
                    uploadDiv.style.backgroundRepeat = 'no-repeat';
                    uploadDiv.style.height = "200px"
                    // Hide the upload icons and text
                    uploadDiv.querySelector('.upload-icon').style.display = 'none';
                    uploadDiv.querySelector('.upload-text').style.display = 'none';
                    uploadDiv.querySelector('.upload-hint').style.display = 'none';
                }
                reader.readAsDataURL(file);
            }
        });

        // Add new size and quantity row
        function addSizeRow() {
            const sizeQuantities = document.querySelector('.size-quantities');
            const newRow = document.createElement('div');
            newRow.className = 'size-row';
            newRow.style = 'display: flex; gap: 1rem; margin-bottom: 0.5rem;';
            newRow.innerHTML = `
                <select class="form-control" style="width: 100px;">
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                </select>
                <input type="number" class="form-control" placeholder="Quantity" min="0">
                <button type="button" class="btn" onclick="this.parentElement.remove()" style="background: #fee;">
                    <i class="fas fa-minus"></i>
                </button>
            `;
            sizeQuantities.appendChild(newRow);
        }

        // Add form reset on success
        <?php if (isset($_SESSION['success_message'])): ?>
        document.getElementById('productForm').reset();
        const uploadDiv = document.querySelector('.image-upload');
        uploadDiv.style.backgroundImage = '';
        uploadDiv.style.height = '';
        uploadDiv.querySelector('.upload-icon').style.display = '';
        uploadDiv.querySelector('.upload-text').style.display = '';
        uploadDiv.querySelector('.upload-hint').style.display = '';
        <?php endif; ?>
    </script>
</body>
</html> 