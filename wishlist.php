<?php
// Initialize session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("Server/connection.php");

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    // Store return URL in sessionStorage via JavaScript (handled in client-side)
    header("Location: auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch wishlist items for the user
$stmt = $conn->prepare("
    SELECT p.id, p.name, p.description, p.price, p.discounted_price, p.image
    FROM wishlist w
    JOIN products p ON w.product_id = p.id
    WHERE w.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$wishlist_items = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="indexstyle.css">
    <link rel="stylesheet" href="categories.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" type="image/png" href="./images/boutique logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/fe29f9dc19.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <title>Wishlist - Aria Boutique</title>
    <style>
        /* Additional styles for wishlist page */
        .wishlist-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .wishlist-header {
            text-align: center;
            margin-block: 30px;
        }

        .wishlist-header h1 {
            font-size: 2rem;
            font-family: 'Poppins', sans-serif;
            color: #333;
        }

        .wishlist-content {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .no-items {
            text-align: center;
            font-size: 1.2rem;
            color: #666;
            font-family: 'Poppins', sans-serif;
            margin: 50px 0;
        }

        .no-items a {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }

        .no-items a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php include("./navbar.php") ?>
    <div class="wishlist-header">
        <h1>My Wishlist</h1>
    </div>
    <?php if (empty($wishlist_items)): ?>
        <p class="no-items">
            Your wishlist is empty. <a href="index.php">Explore products</a> to add some!
        </p>
    <?php else: ?>
    <div class="wishlist-wrapper category-cards-wrapper">
        <div class="wishlist-content">
                <?php foreach ($wishlist_items as $product): ?>
                    <div class="product-card">
                        <div class="quick-actions">
                            <div class="quick-action-btn added" title="Remove from Wishlist" data-product-id="<?php echo $product['id']; ?>">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div class="quick-action-btn" title="Share">
                                <i class="fas fa-share-alt"></i>
                            </div>
                        </div>
                        <a href="detail.php?id=<?php echo $product['id']; ?>">
                            <div class="image-container">
                                <img src="Uploads/products/<?php echo htmlspecialchars($product['image']); ?>"
                                    alt="<?php echo htmlspecialchars($product['name']); ?>">
                            </div>
                            <div class="product-details">
                                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                                <p class="description"><?php echo htmlspecialchars($product['description']); ?></p>
                                <div class="price">
                                    <?php if (!empty($product['discounted_price'])): ?>
                                        <span class="original-price">₹<?php echo htmlspecialchars($product['price']); ?></span>
                                        <span class="discounted-price">₹<?php echo htmlspecialchars($product['discounted_price']); ?></span>
                                    <?php else: ?>
                                        <span class="price">₹<?php echo htmlspecialchars($product['price']); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <?php include "./footer.html" ?>
    <script src="indexscript.js"></script>
    <script>
        // Store return URL for login redirect
        if (!<?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>) {
            sessionStorage.setItem('returnUrl', window.location.href);
        }
    </script>
</body>
</html>