<?php
// session_start();
include("../Server/connection.php");
include("check_admin.php");

// Initialize variables to store form data
$form_data = [
    'name' => '',
    'description' => ''
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
        'description' => ''
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category - Admin Panel</title>
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
                    <a href="add-product.php" class="nav-link">
                        <i class="fas fa-plus"></i>
                        <span>Add Product</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="add-category.php" class="nav-link active">
                        <i class="fas fa-tags"></i>
                        <span>Categories</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="products.php" class="nav-link">
                        <i class="fas fa-box"></i>
                        <span>All Products</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="orders.php" class="nav-link ">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Orders</span>
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
                left: 0;
                width: 100%;
                padding: 0.5rem;

                border-top: 1px solid var(--border-color);
            }

            .logout-link {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                /* padding: 0.75rem 1rem; */
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
                        <div class="user-name"><?php echo isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : 'Admin User'; ?></div>
                        <div class="user-role"><?php echo isset($_SESSION['role']) && $_SESSION['role'] === 'admin' ? 'Administrator' : 'User'; ?></div>
                    </div>
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode(isset($_SESSION['name']) ? $_SESSION['name'] : 'Admin User'); ?>" alt="Admin" class="user-avatar">
                </div>
            </div>

            <!-- Content Area -->
            <div class="content-area">
                <div class="tabs">
                    <button class="tab-btn active" onclick="switchTab('add')" id="addTab">
                        <i class="fas fa-plus"></i> Add Category
                    </button>
                    <button class="tab-btn" onclick="switchTab('list')" id="listTab">
                        <i class="fas fa-list"></i> All Categories
                    </button>
                </div>

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

                <div id="addCategoryTab" class="tab-content active">
                    <div class="form-container">
                        <form action="process-category.php" method="POST" enctype="multipart/form-data" id="categoryForm">
                            <div class="form-grid">
                                <div class="form-group" style="grid-column: 1 / -1;">
                                    <label class="form-label">Category Name</label>
                                    <input type="text" class="form-control" name="name" required value="<?php echo htmlspecialchars($form_data['name']); ?>">
                                </div>

                                <div class="form-group" style="grid-column: 1 / -1;">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="description" required rows="4"><?php echo htmlspecialchars($form_data['description']); ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Category Image</label>
                                    <div class="image-upload" onclick="document.getElementById('categoryImageInput').click()">
                                        <input type="file" id="categoryImageInput" name="category_image" accept="image/*" style="display: none;" required>
                                        <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                        <div class="upload-text">Click to upload category image</div>
                                        <div class="upload-hint">Square image recommended (Maximum file size: 5MB)</div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Banner Image</label>
                                    <div class="image-upload" onclick="document.getElementById('bannerImageInput').click()">
                                        <input type="file" id="bannerImageInput" name="banner_image" accept="image/*" style="display: none;" required>
                                        <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                        <div class="upload-text">Click to upload banner image</div>
                                        <div class="upload-hint">Recommended size: 1920x400px (Maximum file size: 5MB)</div>
                                    </div>
                                </div>
                            </div>

                            <div style="text-align: right; margin-top: 2rem;">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus"></i>
                                    Add Category
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div id="listCategoryTab" class="tab-content">
                    <div class="categories-container" style="background: #fff; border-radius: 10px; padding: 2rem; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);">
                        <table class="categories-table" style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th style="background: #f8f9fa; padding: 1rem; text-align: left; font-weight: 600; color: #444; border-bottom: 2px solid #eee;">ID</th>
                                    <th style="background: #f8f9fa; padding: 1rem; text-align: left; font-weight: 600; color: #444; border-bottom: 2px solid #eee;">Category</th>
                                    <th style="background: #f8f9fa; padding: 1rem; text-align: left; font-weight: 600; color: #444; border-bottom: 2px solid #eee;">Description</th>
                                    <th style="background: #f8f9fa; padding: 1rem; text-align: left; font-weight: 600; color: #444; border-bottom: 2px solid #eee;">Images</th>
                                    <th style="background: #f8f9fa; padding: 1rem; text-align: left; font-weight: 600; color: #444; border-bottom: 2px solid #eee;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Fetch all categories
                                $sql = "SELECT * FROM categories ORDER BY id DESC";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td style="padding: 1rem; border-bottom: 1px solid #eee; color: #666;">
                                                #<?php echo str_pad($row['id'], 3, '0', STR_PAD_LEFT); ?>
                                            </td>
                                            <td style="padding: 1rem; border-bottom: 1px solid #eee; color: #666;">
                                                <div style="font-weight: 500; color: #333;">
                                                    <?php echo htmlspecialchars($row['name']); ?>
                                                </div>
                                            </td>
                                            <td style="padding: 1rem; border-bottom: 1px solid #eee; color: #666;">
                                                <?php 
                                                $description = htmlspecialchars($row['description']);
                                                echo strlen($description) > 100 ? substr($description, 0, 100) . '...' : $description;
                                                ?>
                                            </td>
                                            <td style="padding: 1rem; border-bottom: 1px solid #eee; color: #666;">
                                                <div style="display: flex; gap: 1rem; align-items: center;">
                                                    <img src="../uploads/categories/<?php echo htmlspecialchars($row['category_image']); ?>" 
                                                         alt="Category Image" 
                                                         style="width: 40px; height: 40px; border-radius: 6px; object-fit: cover;">
                                                    <img src="../uploads/categories/<?php echo htmlspecialchars($row['banner_image']); ?>" 
                                                         alt="Banner Image" 
                                                         style="width: 80px; height: 30px; border-radius: 6px; object-fit: cover;">
                                                </div>
                                            </td>
                                            <td style="padding: 1rem; border-bottom: 1px solid #eee; color: #666;">
                                                <div style="display: flex; gap: 0.5rem;">
                                                    <button class="action-btn delete-btn" onclick="deleteCategory(<?php echo $row['id']; ?>)" 
                                                            style="padding: 0.4rem; border-radius: 6px; border: none; cursor: pointer; background: #FFEBEE; color: #D32F2F;">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='5' style='text-align: center; padding: 1rem;'>No categories found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <style>
                .tabs {
                    display: flex;
                    gap: 0;
                    margin-bottom: 2rem;
                    border-bottom: 1px solid #dee2e6;
                    padding: 0;
                }

                .tab-btn {
                    padding: 0.75rem 1.5rem;
                    border: none;
                    background: none;
                    font-size: 0.95rem;
                    font-weight: 500;
                    color: #666;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                    position: relative;
                    margin-bottom: -1px;
                }

                .tab-btn:hover {
                    color: #0083fd;
                    background: transparent;
                }

                .tab-btn.active {
                    color: #0083fd;
                    background: transparent;
                    border: none;
                }

                .tab-btn.active::after {
                    content: '';
                    position: absolute;
                    bottom: 0;
                    left: 0;
                    width: 100%;
                    height: 2px;
                    background-color: #0083fd;
                    border-radius: 2px 2px 0 0;
                }

                .tab-content {
                    display: none;
                    background: #fff;
                    border-radius: 0 0 8px 8px;
                }

                .tab-content.active {
                    display: block;
                }

                /* Smooth transition for tab switching */
                .tab-content {
                    opacity: 0;
                    transform: translateY(10px);
                    transition: all 0.3s ease;
                }

                .tab-content.active {
                    opacity: 1;
                    transform: translateY(0);
                }
            </style>

            <script>
                function switchTab(tab) {
                    // Remove active class from all tabs and contents
                    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
                    document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

                    // Add active class to selected tab and content
                    if (tab === 'add') {
                        document.getElementById('addTab').classList.add('active');
                        document.getElementById('addCategoryTab').classList.add('active');
                    } else {
                        document.getElementById('listTab').classList.add('active');
                        document.getElementById('listCategoryTab').classList.add('active');
                    }
                }

                // Switch to list tab if there was a success message
                <?php if (isset($_SESSION['success_message'])): ?>
                    setTimeout(() => switchTab('list'), 100);
                <?php endif; ?>

                // Handle category image upload preview
                document.getElementById('categoryImageInput').addEventListener('change', function(e) {
                    handleImagePreview(e, this);
                });

                // Handle banner image upload preview
                document.getElementById('bannerImageInput').addEventListener('change', function(e) {
                    handleImagePreview(e, this);
                });

                // Generic function to handle image preview
                function handleImagePreview(e, input) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const uploadDiv = input.closest('.image-upload');
                            uploadDiv.style.backgroundImage = `url(${e.target.result})`;
                            uploadDiv.style.backgroundSize = input.id === 'categoryImageInput' ? 'contain' : 'cover';
                            uploadDiv.style.backgroundPosition = 'center';
                            uploadDiv.style.backgroundRepeat = 'no-repeat';
                            uploadDiv.style.height = "200px";
                            // Hide the upload icons and text
                            uploadDiv.querySelector('.upload-icon').style.display = 'none';
                            uploadDiv.querySelector('.upload-text').style.display = 'none';
                            uploadDiv.querySelector('.upload-hint').style.display = 'none';
                        }
                        reader.readAsDataURL(file);
                    }
                }

                // Add form reset on success
                <?php if (isset($_SESSION['success_message'])): ?>
                document.getElementById('categoryForm').reset();
                document.querySelectorAll('.image-upload').forEach(uploadDiv => {
                    uploadDiv.style.backgroundImage = '';
                    uploadDiv.style.height = '';
                    uploadDiv.querySelector('.upload-icon').style.display = '';
                    uploadDiv.querySelector('.upload-text').style.display = '';
                    uploadDiv.querySelector('.upload-hint').style.display = '';
                });
                <?php endif; ?>

                function deleteCategory(categoryId) {
                    if (confirm('Are you sure you want to delete this category? This will also delete all associated products.')) {
                        fetch('delete_category.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                category_id: categoryId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Remove the row from the table
                                const row = document.querySelector(`tr:has(button[onclick="deleteCategory(${categoryId})"])`);
                                row.remove();
                            } else {
                                alert('Failed to delete category: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error deleting category');
                        });
                    }
                }
            </script>
        </div>
    </div>
</body>
</html> 