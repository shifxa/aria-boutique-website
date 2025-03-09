<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-header">
        <img src="../images/boutique logo.png" alt="Logo" class="logo">
        <h2>Admin Panel</h2>
    </div>
    <nav class="sidebar-nav">
        <a href="add-product.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'add-product.php' ? 'active' : ''; ?>">
            <i class="fas fa-plus"></i>
            <span>Add Product</span>
        </a>
        <a href="products.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'products.php' ? 'active' : ''; ?>">
            <i class="fas fa-box"></i>
            <span>Products</span>
        </a>
        <a href="add-category.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'add-category.php' ? 'active' : ''; ?>">
            <i class="fas fa-list"></i>
            <span>Categories</span>
        </a>
        <a href="orders.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'orders.php' ? 'active' : ''; ?>">
            <i class="fas fa-shopping-bag"></i>
            <span>Orders</span>
        </a>
    </nav>
    <div class="sidebar-footer">
        <a href="../auth/logout.php" class="logout-link">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </div>
</div> 