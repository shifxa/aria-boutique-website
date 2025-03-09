<?php
include("check_admin.php");
include("../Server/connection.php");

// Update order status if form is submitted
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];
    
    $update_stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $update_stmt->bind_param("si", $new_status, $order_id);
    
    if ($update_stmt->execute()) {
        $_SESSION['success_message'] = "Order status updated successfully!";
    } else {
        $_SESSION['error_message'] = "Failed to update order status.";
    }
    
    $update_stmt->close();
    header("Location: orders.php");
    exit();
}

// Fetch all orders with user and product details
$orders_query = "
    SELECT 
        o.id,
        o.date,
        o.payment_id,
        o.amount,
        o.quantity,
        o.size,
        o.status,
        p.name as product_name,
        p.image as product_image,
        u.name as customer_name,
        u.email as customer_email,
        u.phone as customer_phone
    FROM orders o
    JOIN products p ON o.product_id = p.id
    JOIN users u ON o.user_id = u.id
    ORDER BY o.date DESC
";

$orders_result = $conn->query($orders_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders - Admin Panel</title>
    <link rel="icon" type="image/png" href="../images/boutique logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
    <style>
        .header {
            background: white;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #eef2f7;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .header h1 {
            font-size: 1.5rem;
            color: #2d3436;
            margin: 0;
            font-weight: 600;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-weight: 500;
            color: #2d3436;
        }

        .user-role {
            font-size: 0.85rem;
            color: #636e72;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .orders-container {
            padding: 0 2rem;
            width: 100%;
        }

        .orders-header {
            display: grid;
            grid-template-columns: 100px 180px 1fr 150px 120px 50px;
            align-items: center;
            padding: 1rem 2rem;
            color: #636e72;
            font-weight: 500;
            font-size: 0.9rem;
            background: white;
            border-radius: 8px 8px 0 0;
            margin-bottom: 0.5rem;
        }

        .order-card {
            background: white;
            border-radius: 8px;
            margin-bottom: 0.5rem;
        }

        .order-header {
            padding: 1rem 2rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            transition: background-color 0.3s;
        }

        .order-header:hover {
            background: #f8f9fa;
        }

        .order-basic-info {
            display: grid;
            grid-template-columns: 100px 180px 1fr 150px 120px;
            align-items: center;
            flex: 1;
            gap: 0;
        }

        .order-id {
            font-weight: 600;
            color: #2d3436;
        }

        .order-date {
            color: #636e72;
            font-size: 0.9rem;
        }

        .customer-name {
            color: #2d3436;
            font-weight: 500;
        }

        .order-amount {
            color: #2d3436;
            font-weight: 500;
            text-align: left;
        }

        .order-status {
            padding: 0.25rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            text-align: center;
            width: fit-content;
        }

        .status-placed {
            background: #fff3cd;
            color: #856404;
        }

        .status-in-transit {
            background: #cce5ff;
            color: #004085;
        }

        .status-delivered {
            background: #d4edda;
            color: #155724;
        }

        /* Add hover effect for better interactivity */
        .order-status:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            transition: all 0.2s ease;
        }

        /* Add subtle shadow for better depth */
        .status-placed, .status-in-transit, .status-delivered {
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .expand-icon {
            width: 50px;
            text-align: center;
            color: #636e72;
            transition: transform 0.3s;
        }

        .order-card.expanded .expand-icon {
            transform: rotate(180deg);
        }

        .order-details {
            display: none;
            padding: 1.5rem 2rem;
            border-top: 1px solid #eef2f7;
            background: white;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
        }

        .order-card.expanded .order-details {
            display: block;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            background: white;
        }

        .detail-section {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid #eef2f7;
        }

        .detail-section h4 {
            margin: 0 0 1rem 0;
            color: #2d3436;
            font-size: 0.95rem;
            font-weight: 600;
        }

        .product-info {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .product-info img {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
        }

        .product-name {
            font-weight: 500;
            color: #2d3436;
            margin-bottom: 0.5rem;
        }

        .product-meta {
            color: #636e72;
            font-size: 0.9rem;
        }

        .customer-details {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .customer-details div {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #636e72;
        }

        .customer-details i {
            width: 16px;
            color: #636e72;
        }

        .status-form {
            display: flex;
            gap: 0.75rem;
        }

        .status-select {
            flex: 1;
            padding: 0.5rem;
            border: 1px solid #dfe6e9;
            border-radius: 6px;
            font-size: 0.9rem;
            color: #2d3436;
            background: white;
        }

        .update-btn {
            padding: 0.5rem 1.5rem;
            background: #0083fd;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background 0.3s;
        }

        .update-btn:hover {
            background: #0066cc;
        }

        @media (max-width: 768px) {
            .orders-header {
                display: none; /* Hide headers on mobile */
            }
            .order-basic-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .order-header {
                flex-direction: column;
                gap: 1rem;
            }

            .expand-icon {
                margin-left: 0;
            }

            .status-form {
                flex-direction: column;
            }

            .order-id, .order-date, .customer-name, .order-amount {
                min-width: unset;
            }
        }

        .alert {
            margin: 0 2rem 1rem 2rem;
            padding: 1rem;
            border-radius: 8px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .main-content {
            flex: 1;
            background: #f8f9fa;
            min-height: 100vh;
        }
    </style>
</head>
<body>
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
                    <a href="products.php" class="nav-link ">
                        <i class="fas fa-box"></i>
                        <span>All Products</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="orders.php" class="nav-link active">
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

    <div class="main-content">
        <div class="header">
            <h1>Manage Orders</h1>
            <div class="user-profile">
                <div class="user-info">
                    <div class="user-name"><?php echo isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : 'Admin User'; ?></div>
                    <div class="user-role">Administrator</div>
                </div>
                <img src="https://ui-avatars.com/api/?name=Admin+User" alt="Admin" class="user-avatar">
            </div>
        </div>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?php 
                echo $_SESSION['success_message']; 
                unset($_SESSION['success_message']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?php 
                echo $_SESSION['error_message']; 
                unset($_SESSION['error_message']);
                ?>
            </div>
        <?php endif; ?>

        <div class="orders-container">
            <?php if ($orders_result->num_rows > 0): ?>
                <div class="orders-header">
                    <div class="order-id-header">ID</div>
                    <div class="order-date-header">Date</div>
                    <div class="customer-name-header">Customer</div>
                    <div class="order-amount-header">Amount</div>
                    <div class="order-status-header">Status</div>
                    <div class="expand-header">Expand</div>
                </div>
                <?php while ($order = $orders_result->fetch_assoc()): ?>
                    <div class="order-card">
                        <div class="order-header" onclick="toggleOrderDetails(this)">
                            <div class="order-basic-info">
                                <div class="order-id">#<?php echo str_pad($order['id'], 3, '0', STR_PAD_LEFT); ?></div>
                                <div class="order-date"><?php echo date('d M Y, h:i A', strtotime($order['date'])); ?></div>
                                <div class="customer-name"><?php echo htmlspecialchars($order['customer_name']); ?></div>
                                <div class="order-amount">₹<?php echo number_format($order['amount'], 2); ?></div>
                                <div class="order-status status-<?php echo strtolower(str_replace(' ', '-', $order['status'])); ?>"><?php echo htmlspecialchars($order['status']); ?></div>
                            </div>
                            <i class="fas fa-chevron-down expand-icon"></i>
                        </div>
                        <div class="order-details">
                            <div class="details-grid">
                                <div class="detail-section">
                                    <h4>Product Details</h4>
                                    <div class="product-info">
                                        <img src="../uploads/products/<?php echo htmlspecialchars($order['product_image']); ?>" alt="<?php echo htmlspecialchars($order['product_name']); ?>">
                                        <div>
                                            <div class="product-name"><?php echo htmlspecialchars($order['product_name']); ?></div>
                                            <div class="product-meta">
                                                Size: <?php echo htmlspecialchars($order['size']); ?> | Quantity: <?php echo $order['quantity']; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="detail-section">
                                    <h4>Customer Details</h4>
                                    <div class="customer-details">
                                        <div><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($order['customer_email']); ?></div>
                                        <div><i class="fas fa-phone"></i> <?php echo htmlspecialchars($order['customer_phone']); ?></div>
                                    </div>
                                </div>
                                <div class="detail-section">
                                    <h4>Update Status</h4>
                                    <form class="status-form" method="POST">
                                        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                        <select name="new_status" class="status-select">
                                            <option value="Placed" <?php echo $order['status'] === 'Placed' ? 'selected' : ''; ?>>Placed</option>
                                            <option value="In Transit" <?php echo $order['status'] === 'In Transit' ? 'selected' : ''; ?>>In Transit</option>
                                            <option value="Delivered" <?php echo $order['status'] === 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                                        </select>
                                        <button type="submit" name="update_status" class="update-btn">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-orders">
                    <i class="fas fa-shopping-bag"></i>
                    <h3>No orders found</h3>
                    <p>There are no orders in the system yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function toggleOrderDetails(header) {
            const card = header.closest('.order-card');
            card.classList.toggle('expanded');
        }

        // Handle status update form submission
        document.querySelectorAll('.status-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                // Remove preventDefault to allow normal form submission
                const newStatus = this.querySelector('select[name="new_status"]').value;
                const statusDiv = this.closest('.order-card').querySelector('.order-status');
                
                // Update the status class immediately for better UX
                statusDiv.className = 'order-status status-' + newStatus.toLowerCase().replace(' ', '-');
                statusDiv.textContent = newStatus;
            });
        });
    </script>
</body>
</html> 