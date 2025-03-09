<?php
session_start();
if (!isset($_SESSION['payment_success']) || !isset($_SESSION['order_details'])) {
    header("Location: index.php");
    exit();
}

$order_details = $_SESSION['order_details'];
// Clear the session data after retrieving it
unset($_SESSION['payment_success']);
unset($_SESSION['order_details']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful - Aria Boutique</title>
    <link rel="stylesheet" href="indexstyle.css">
    <link rel="stylesheet" href="navbar.css">
    <link rel="icon" type="image/png" href="./images/boutique logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://unpkg.com/scrollreveal"></script>

    <style>

        body {
            background-color: #f8f9fa;
        }

        .success-container {
            max-width: 800px;
            margin: 6rem auto 4rem;
            padding: 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .success-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: #E8F5E9;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .success-icon i {
            font-size: 2.5rem;
            color: #2E7D32;
        }

        .success-title {
            color: #2E7D32;
            margin-bottom: 0.5rem;
        }

        .success-subtitle {
            color: #666;
            margin-bottom: 2rem;
        }

        .order-details {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #eee;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #666;
            font-weight: 500;
        }

        .detail-value {
            color: #333;
            font-weight: 600;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1rem 0;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .product-image {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
        }

        .product-details h3 {
            margin: 0 0 0.5rem;
            font-size: 1.1rem;
            color: #333;
        }

        .product-details p {
            margin: 0;
            color: #666;
            font-size: 0.9rem;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }

        .action-button {
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            border: none;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .continue-shopping {
            background: #f8f9fa;
            color: #333;
        }

        .view-orders {
            background: #000;
            color: white;
        }

        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="success-container">
        <div class="success-header">
            <div class="success-icon">
                <i class="fas fa-check"></i>
            </div>
            <h1 class="success-title">Payment Successful!</h1>
            <p class="success-subtitle">Your order has been placed successfully</p>
        </div>

        <div class="order-details">
            <div class="product-info">
                <img src="uploads/products/<?php echo htmlspecialchars($order_details['image']); ?>" 
                     alt="<?php echo htmlspecialchars($order_details['product_name']); ?>" 
                     class="product-image">
                <div class="product-details">
                    <h3><?php echo htmlspecialchars($order_details['product_name']); ?></h3>
                    <p>Size: <?php echo htmlspecialchars($order_details['size']); ?></p>
                    <p>Quantity: <?php echo htmlspecialchars($order_details['quantity']); ?></p>
                </div>
            </div>

            <div class="detail-row">
                <span class="detail-label">Order ID</span>
                <span class="detail-value"><?php echo htmlspecialchars($order_details['order_id']); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Payment ID</span>
                <span class="detail-value"><?php echo htmlspecialchars($order_details['payment_id']); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Amount Paid</span>
                <span class="detail-value">₹<?php echo number_format($order_details['amount']); ?></span>
            </div>
        </div>

        <div class="action-buttons">
            <a href="index.php" class="action-button continue-shopping">
                <i class="fas fa-arrow-left"></i>
                Continue Shopping
            </a>
            <a href="profile.php" class="action-button view-orders">
                <i class="fas fa-box"></i>
                View Orders
            </a>
        </div>
    </div>

    <?php include 'footer.html'; ?>
    <script src="indexscript.js"></script>
</body>
</html> 