<?php
include("../Server/connection.php");
include("check_admin.php");

// Fetch all products with their categories
$sql = "SELECT p.*, c.name as category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        ORDER BY p.id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Management - Admin Panel</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="icon" type="image/png" href="../images/boutique logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .products-container {
            background: #fff;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .search-bar {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: #f5f5f5;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            width: 300px;
        }

        .search-bar input {
            border: none;
            background: none;
            outline: none;
            width: 100%;
            font-size: 0.9rem;
        }

        .add-new-btn {
            background: #4CAF50;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .add-new-btn:hover {
            background: #43A047;
            transform: translateY(-2px);
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .products-table th {
            background: #f8f9fa;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #444;
            border-bottom: 2px solid #eee;
        }

        .products-table td {
            padding: 1rem;
            border-bottom: 1px solid #eee;
            color: #666;
        }

        .product-image {
            width: 50px;
            height: 50px;
            border-radius: 6px;
            object-fit: cover;
        }

        .product-name {
            font-weight: 500;
            color: #333;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .action-btn {
            padding: 0.4rem;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .edit-btn {
            background: #E3F2FD;
            color: #1976D2;
        }

        .delete-btn {
            background: #FFEBEE;
            color: #D32F2F;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .quantity-btn {
            padding: 0.25rem 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: white;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .quantity-btn:hover {
            background: #f5f5f5;
        }

        .quantity-display {
            font-weight: 500;
            min-width: 40px;
            text-align: center;
        }

        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid #eee;
        }

        .page-info {
            color: #666;
            font-size: 0.9rem;
        }

        .page-controls {
            display: flex;
            gap: 0.5rem;
        }

        .page-btn {
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            background: white;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .page-btn:hover {
            background: #f5f5f5;
        }

        .page-btn.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
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
                    <a href="add-category.php" class="nav-link">
                        <i class="fas fa-tags"></i>
                        <span>Categories</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="products.php" class="nav-link active">
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
            <div class="header">
                <h1>Products</h1>
                <div class="user-profile">
                    <div class="user-info">
                        <div class="user-name"><?php echo isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : 'Admin User'; ?></div>
                        <div class="user-role">Administrator</div>
                    </div>
                    <img src="https://ui-avatars.com/api/?name=Admin+User" alt="Admin" class="user-avatar">
                </div>
            </div>

            <div class="products-container">
                <div class="header-actions">
                    <div class="search-bar">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search products..." id="searchInput" onkeyup="searchProducts()">
                    </div>
                    <a href="add-product.php" class="add-new-btn">
                        <i class="fas fa-plus"></i>
                        Add New
                    </a>
                </div>

                <table class="products-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Inventory</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td>#<?php echo str_pad($row['id'], 3, '0', STR_PAD_LEFT); ?></td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 1rem;">
                                            <img src="../uploads/products/<?php echo htmlspecialchars($row['image']); ?>" 
                                                 alt="<?php echo htmlspecialchars($row['name']); ?>" 
                                                 class="product-image">
                                            <span class="product-name"><?php echo htmlspecialchars($row['name']); ?></span>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                                    <td>
                                        <div class="quantity-controls">
                                            <button class="quantity-btn" onclick="updateQuantity(<?php echo $row['id']; ?>, 'decrease')">-</button>
                                            <span class="quantity-display" id="quantity-<?php echo $row['id']; ?>"><?php echo $row['quantity']; ?></span>
                                            <button class="quantity-btn" onclick="updateQuantity(<?php echo $row['id']; ?>, 'increase')">+</button>
                                        </div>
                                    </td>
                                    <td>₹<?php echo htmlspecialchars($row['price']); ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <!-- <button class="action-btn edit-btn" onclick="editProduct(<?php echo $row['id']; ?>)">
                                                <i class="fas fa-edit"></i>
                                            </button> -->
                                            <button class="action-btn delete-btn" onclick="deleteProduct(<?php echo $row['id']; ?>)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='6' style='text-align: center;'>No products found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <div class="pagination">
                    <span class="page-info">1-14 of 100 items</span>
                    <div class="page-controls">
                        <button class="page-btn disabled"><i class="fas fa-chevron-left"></i></button>
                        <button class="page-btn"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function searchProducts() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toUpperCase();
            const table = document.querySelector('.products-table');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const nameColumn = rows[i].getElementsByClassName('product-name')[0];
                if (nameColumn) {
                    const txtValue = nameColumn.textContent || nameColumn.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            }
        }

        function updateQuantity(productId, action) {
            const quantityElement = document.getElementById(`quantity-${productId}`);
            let currentQuantity = parseInt(quantityElement.textContent);

            if (action === 'increase') {
                currentQuantity++;
            } else if (action === 'decrease' && currentQuantity > 0) {
                currentQuantity--;
            }

            // Send AJAX request to update quantity
            fetch('update_quantity.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: currentQuantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    quantityElement.textContent = currentQuantity;
                } else {
                    alert('Failed to update quantity');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating quantity');
            });
        }

        function editProduct(productId) {
            window.location.href = `edit-product.php?id=${productId}`;
        }

        function deleteProduct(productId) {
            if (confirm('Are you sure you want to delete this product?')) {
                fetch('delete_product.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the row from the table
                        const row = document.querySelector(`tr:has(button[onclick="deleteProduct(${productId})"])`);
                        row.remove();
                    } else {
                        alert('Failed to delete product');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting product');
                });
            }
        }
    </script>
</body>
</html> 