<?php
$isLoggedIn = isset($_SESSION['uemail']);
$redirectUrl = './auth/login.php'; // Default for not logged in users
if ($isLoggedIn) {
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        $redirectUrl = './admin/add-product.php';
    } else {
        $redirectUrl = 'profile.php';
    }
}
?>
<nav id="sticky-navbar" class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <div class="nav-brand-section">
            <a href="index.php" class="nav-logo">
                <img class="nav-logo1" src="./images/boutique logo.png" alt="Aria Boutique Logo">
            </a>
            <button class="navbar-toggler" type="button"
                aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fas fa-bars menu-icon"></i>
                <i class="fas fa-times close-icon" style="display: none;"></i>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Desktop Search -->
            <!-- <div class="nav-search-section desktop-only">
                <form class="search-form">
                    <div class="searchBar">
                        <i class="fa-solid fa-magnifying-glass nav-search-icon"></i>
                        <input class="nav-search" type="search" placeholder="Search products...">
                    </div>
                </form>
            </div> -->

            <!-- Navigation Links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">HOME</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="lookbook.php">LOOKBOOK</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Aboutus.html">ABOUT US</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">CONTACT</a>
                </li>
            </ul>

            <!-- Action Icons -->
            <div class="nav-actions">
                <a href="<?php echo $redirectUrl; ?>" class="nav-icon-link">
                    <i class="fa-solid fa-user nav-icon"></i>
                </a>
                <a href="#" class="nav-icon-link">
                    <i class="fa-regular fa-heart nav-icon"></i>
                </a>
                <a href="#" class="nav-icon-link">
                    <i class="fa-solid fa-cart-shopping nav-icon"></i>
                </a>
            </div>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Add scroll event listener for navbar background change
    window.addEventListener('scroll', () => {
        document.querySelector('.navbar').classList.toggle('window-scroll', window.scrollY > 0);
    });

    // Handle mobile menu
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    const menuIcon = document.querySelector('.menu-icon');
    const closeIcon = document.querySelector('.close-icon');

    // Function to toggle icons and menu state
    function toggleMenu(isOpen) {
        navbarCollapse.classList.toggle('show', isOpen);
        menuIcon.style.display = isOpen ? 'none' : 'block';
        closeIcon.style.display = isOpen ? 'block' : 'none';
    }

    // Handle toggler button click
    navbarToggler.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        const willBeOpen = !navbarCollapse.classList.contains('show');
        toggleMenu(willBeOpen);
    });

    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
        if (!navbarCollapse.contains(e.target) && !navbarToggler.contains(e.target) && navbarCollapse.classList.contains('show')) {
            toggleMenu(false);
        }
    });

    // Close menu when clicking on a nav link
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', () => {
            if (navbarCollapse.classList.contains('show')) {
                toggleMenu(false);
            }
        });
    });
</script>