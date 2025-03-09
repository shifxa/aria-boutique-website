<?php
session_start();
include("Server/connection.php");

// Get category ID from URL
$category_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch category details
$category_name = '';
$category_banner = '';
if ($category_id > 0) {
    $stmt = $conn->prepare("SELECT name, banner_image FROM categories WHERE id = ?");
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $category_name = $row['name'];
        $category_banner = $row['banner_image'];
    }
}

// If category not found, redirect to home
if (empty($category_name)) {
    header("Location: index.php");
    exit();
}
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/fe29f9dc19.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <title><?php echo htmlspecialchars($category_name); ?> - Aria Boutique</title>
</head>

<body>
    <?php include("./navbar.php") ?>
    <div class="category-wrapper">
        <div class="category-banner">
            <img src="uploads/categories/<?php echo htmlspecialchars($category_banner); ?>" alt="<?php echo htmlspecialchars($category_name); ?> Banner">
            <h1><?php echo htmlspecialchars($category_name); ?></h1>
        </div>
        <div class="mid-header">
            <h4>Catalog</h4>
            <h4>99 Products</h4>
            <h4 role="button">Sort by ↓</h4>
        </div>
        <div class="category-content">
            <div class="catalog-sidebar">
                <!-- Sidebar links to the category page to update category url parameters -->
                <a href="./categories.php?category=Bridal" class="sidebar-link">Bridal</a>
                <a href="./categories.php?category=Dress" class="sidebar-link">Dress</a>
                <a href="./categories.php?category=Lehenga" class="sidebar-link">Lehenga</a>
                <a href="./categories.php?category=Blouse" class="sidebar-link">Blouse</a>
                <a href="./categories.php?category=Kurti" class="sidebar-link">Kurti</a>
                <a href="./categories.php?category=Shirts" class="sidebar-link">Shirts</a>
                <a href="./categories.php?category=Gowns" class="sidebar-link">Gowns</a>
                <a href="./categories.php?category=Bottom Wear" class="sidebar-link">Bottom Wear</a>
                <a href="./categories.php?category=Skirts" class="sidebar-link">Skirts</a>
                <a href="./categories.php?category=Fusions" class="sidebar-link">Fusions</a>
                <a href="./categories.php?category=Cord Sets" class="sidebar-link">Cord Sets</a>
            </div>

            <div class="category-cards-wrapper">
                <?php
                // Fetch products for this category
                $stmt = $conn->prepare("SELECT * FROM products WHERE category_id = ? ORDER BY name ASC");
                $stmt->bind_param("i", $category_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while($product = $result->fetch_assoc()) {
                        ?>
                        <div class="product-card">
                            <?php if (isset($product['is_new']) && $product['is_new']): ?>
                                <div class="product-badge">New</div>
                            <?php endif; ?>
                            <div class="quick-actions">
                                <div class="quick-action-btn" title="Add to Wishlist">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <div class="quick-action-btn" title="Quick View">
                                    <i class="fas fa-eye"></i>
                                </div>
                                <div class="quick-action-btn" title="Share">
                                    <i class="fas fa-share-alt"></i>
                                </div>
                            </div>
                            <a href="detail.php?id=<?php echo $product['id']; ?>">
                                <div class="image-container">
                                    <img src="uploads/products/<?php echo htmlspecialchars($product['image']); ?>" 
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
                        <?php
                    }
                } else {
                    echo "<p class='no-products'>No products found in this category.</p>";
                }
                ?>
            </div>

        </div>
    </div>
    <script src="indexscript.js"></script>
</body>

</html>