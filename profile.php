<?php
session_start();
include("Server/connection.php");

// Check if user is logged in
if (!isset($_SESSION['uemail'])) {
    header("Location: auth/login.php");
    exit();
}

// Fetch user's orders from database
$orders = [];
try {
    $stmt = $conn->prepare("
        SELECT 
            o.id as order_id,
            o.date,
            o.payment_id,
            o.amount as total,
            o.quantity,
            o.size,
            o.status,
            p.name as product_name,
            p.image
        FROM orders o
        JOIN products p ON o.product_id = p.id
        WHERE o.user_id = ?
        ORDER BY o.date DESC
    ");

    if (!$stmt) {
        throw new Exception("Failed to prepare statement: " . $conn->error);
    }

    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        // Format the order data
        $order = [
            'order_id' => 'ORD' . str_pad($row['order_id'], 3, '0', STR_PAD_LEFT),
            'date' => $row['date'],
            'payment_id' => $row['payment_id'],
            'total' => $row['total'],
            'status' => $row['status'],
            'items' => [[
                'name' => $row['product_name'],
                'quantity' => $row['quantity'],
                'price' => $row['total'] / $row['quantity'], // Calculate per-item price
                'image' => $row['image'],
                'size' => $row['size'],
                'status' => $row['status']
            ]]
        ];
        $orders[] = $order;
    }

    $stmt->close();
} catch (Exception $e) {
    // Log the error and show a user-friendly message
    error_log("Error fetching orders: " . $e->getMessage());
    $error_message = "Unable to fetch your orders at this time.";
}

// Calculate statistics
$total_spent = array_sum(array_column($orders, 'total'));
$delivered_orders = count(array_filter($orders, function($order) {
    return $order['status'] === 'Delivered';
}));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Aria Boutique</title>
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="indexstyle.css">
    <link rel="icon" type="image/png" href="./images/boutique logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://unpkg.com/scrollreveal"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }

        .sticky-navbar {
            background-color: #d8bfb4 !important;
        }

        .profile-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1.5rem;
            margin-top: 6rem;
        }

        .profile-header {
            background: white;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }

        .user-info {
            display: flex;
            align-items: flex-start;
            gap: 2.5rem;
        }

        .user-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: #666;
            font-weight: 600;
        }

        .user-details {
            flex: 1;
        }

        .user-details h1 {
            margin: 0;
            font-size: 2rem;
            color: #2d3436;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .user-details p {
            margin: 0.75rem 0;
            color: #636e72;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1rem;
        }

        .user-details p i {
            color: #0083fd;
            font-size: 1.1rem;
            width: 20px;
        }

        .logout-button {
            margin-top: 1.5rem;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            background-color: #fff2f2;
            color: #dc3545;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .logout-button:hover {
            background-color: #dc3545;
            color: white;
            transform: translateY(-2px);
        }

        .logout-button i {
            font-size: 1.1rem;
        }

        .user-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-top: 2.5rem;
            padding-top: 2.5rem;
            border-top: 1px solid #eef2f7;
        }

        .stat-card {
            text-align: center;
            padding: 1.5rem;
            background: #f8f9fa;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .stat-card h3 {
            margin: 0;
            font-size: 2rem;
            color: #0083fd;
            font-weight: 600;
        }

        .stat-card p {
            margin: 0.5rem 0 0;
            color: #636e72;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .orders-section {
            background: white;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
        }

        .orders-section h2 {
            margin: 0 0 2rem;
            color: #2d3436;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .order-card {
            border: 1px solid #eef2f7;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .order-card:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 1.5rem;
            background: #f8f9fa;
            border-bottom: 1px solid #eef2f7;
        }

        .order-id {
            font-weight: 600;
            color: #2d3436;
            font-size: 1.1rem;
        }

        .order-date {
            color: #636e72;
            font-size: 0.95rem;
        }

        .order-items {
            padding: 1.5rem;
        }

        .order-item {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding: 1rem 0;
            border-bottom: 1px solid #eef2f7;
        }

        .order-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .item-image {
            width: 90px;
            height: 90px;
            border-radius: 10px;
            object-fit: cover;
        }

        .item-details {
            flex: 1;
        }

        .item-name {
            font-weight: 500;
            color: #2d3436;
            margin: 0 0 0.5rem;
            font-size: 1.1rem;
        }

        .item-price {
            color: #636e72;
            font-size: 0.95rem;
        }

        .order-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 1.5rem;
            background: #f8f9fa;
            border-top: 1px solid #eef2f7;
        }

        .order-total {
            font-weight: 600;
            color: #2d3436;
            font-size: 1.1rem;
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

        .no-orders {
            text-align: center;
            padding: 4rem 2rem;
            color: #636e72;
        }

        .no-orders i {
            font-size: 3.5rem;
            color: #b2bec3;
            margin-bottom: 1.5rem;
        }

        .no-orders h3 {
            font-size: 1.5rem;
            color: #2d3436;
            margin-bottom: 0.75rem;
        }

        .no-orders p {
            font-size: 1rem;
            color: #636e72;
        }

        @media (max-width: 768px) {
            .profile-container {
                padding: 0 1rem;
                margin-top: 4rem;
            }

            .profile-header {
                padding: 1.5rem;
            }

            .user-info {
                flex-direction: column;
                text-align: center;
                align-items: center;
                gap: 1.5rem;
            }

            .user-details p {
                justify-content: center;
            }

            .user-stats {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
                margin-top: 2rem;
                padding-top: 2rem;
            }

            .orders-section {
                padding: 1.5rem;
            }

            .order-header {
                flex-direction: column;
                gap: 0.5rem;
                text-align: center;
            }

            .order-item {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .order-footer {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
        }
    </style>
    <script src="indexscript.js"></script>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="profile-container">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="user-info">
                <div class="user-avatar">
                    <?php echo strtoupper(substr($_SESSION['name'], 0, 2)); ?>
                </div>
                <div class="user-details">
                    <h1><?php echo htmlspecialchars($_SESSION['name']); ?></h1>
                    <p><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($_SESSION['uemail']); ?></p>
                    <p><i class="fas fa-phone"></i>
                        <?php echo isset($_SESSION['phone']) ? htmlspecialchars($_SESSION['phone']) : 'Not provided'; ?>
                    </p>
                    <a href="auth/logout.php" class="logout-button">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                </div>
            </div>
            <div class="user-stats">
                <div class="stat-card">
                    <h3><?php echo count($orders); ?></h3>
                    <p>Total Orders</p>
                </div>
                <div class="stat-card">
                    <h3>₹<?php echo number_format($total_spent); ?></h3>
                    <p>Total Spent</p>
                </div>
                <div class="stat-card">
                    <h3><?php echo $delivered_orders; ?></h3>
                    <p>Delivered Orders</p>
                </div>
            </div>
        </div>

        <!-- Orders Section -->
        <div class="orders-section">
            <h2>My Orders</h2>

            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php elseif (empty($orders)): ?>
                <div class="no-orders">
                    <i class="fas fa-shopping-bag"></i>
                    <h3>No orders yet</h3>
                    <p>Start shopping to see your orders here</p>
                </div>
            <?php else: ?>
                <?php foreach ($orders as $order): ?>
                    <div class="order-card">
                        <div class="order-header">
                            <span class="order-id"><?php echo htmlspecialchars($order['order_id']); ?></span>
                            <span class="order-date">Ordered on <?php echo date('d M Y', strtotime($order['date'])); ?></span>
                        </div>

                        <div class="order-items">
                            <?php foreach ($order['items'] as $item): ?>
                                <div class="order-item">
                                    <img src="uploads/products/<?php echo htmlspecialchars($item['image']); ?>"
                                        alt="<?php echo htmlspecialchars($item['name']); ?>" class="item-image">
                                    <div class="item-details">
                                        <h3 class="item-name"><?php echo htmlspecialchars($item['name']); ?></h3>
                                        <p class="item-price">
                                            Size: <?php echo htmlspecialchars($item['size']); ?> | 
                                            Quantity: <?php echo $item['quantity']; ?> ×
                                            ₹<?php echo number_format($item['price']); ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="order-footer">
                            <span class="order-total">Total: ₹<?php echo number_format($order['total']); ?></span>
                            <span class="order-status status-<?php echo strtolower(str_replace(' ', '-', $order['status'])); ?>">
                                <?php echo htmlspecialchars($order['status']); ?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <?php include 'footer.html'; ?>
</body>

</html>