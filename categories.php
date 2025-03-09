<?php
session_start();
// include("./connection.php")
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
    <title>Category Name</title>
</head>

<body>
    <?php include("./navbar.php") ?>
    <div class="category-wrapper">
        <div class="category-banner">
            <!-- <h1>Category Name</h1> -->
            <img src="./images/banner.webp" />
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
                /*
                    * Currently, products are stored in an associative array (array with key and value pairs) for testing purposes.
                    * The next step is to replace this array with data fetched from a database.
                    * Instead of checking against a hardcoded array, we will query the database
                    * using SQL to get products dynamically based on the selected category.
                */
                $products = [
                    "Bridal" => [ //* Category data, it includes key and value pairs of product image as image, product name as name, subheading, price
                        ["image" => "https://i.pinimg.com/736x/36/c9/81/36c98134bef18471830d9afca03c5a2e.jpg", "name" => "Bridal Dress 1", "subheading" => "Elegant Wedding Gown", "price" => "12999"],
                        ["image" => "https://i.pinimg.com/originals/79/64/4f/79644f4e9d44ed6fc648c17aa7a1ab19.jpg", "name" => "Bridal Dress 2", "subheading" => "Modern Bridal Wear", "price" => "14999"],
                    ],
                    "Dress" => [
                        ["image" => "https://i.pinimg.com/736x/ec/8b/a9/ec8ba94eaae0132149ea3e8a8cb22289.jpg", "name" => "Dress Outfit 1", "subheading" => "Comfy Everyday Wear", "price" => "2999"],
                        ["image" => "https://img.faballey.com/images/Product/ICD00123Z/d3.jpg", "name" => "Dress Outfit 2", "subheading" => "Stylish & Relaxed", "price" => "3499"],
                    ],
                    "Lehenga" => [
                        ["image" => "https://www.anantexports.in/cdn/shop/files/sky-blue-georgette-indo-western-lehenga-set-3_1024x1024_6cca15df-be7e-4e3d-82c4-2d16133e9d8e.jpg?v=1719428823&width=1946", "name" => "Lehenga 1", "subheading" => "Glamorous & Trendy", "price" => "8499"],
                        ["image" => "https://www.anantexports.in/cdn/shop/files/IMG-20240612-WA0011_1200x.jpg?v=1718133576", "name" => "Lehenga Choli", "subheading" => "Shiny & Elegant", "price" => "9999"],
                    ]
                ];


                // $_GET is a superglobal array in PHP that stores URL parameters (query string values).
                // We use $_GET['category'] to retrieve the value of the 'category' parameter from the URL.
                // Example: If the URL is http://localhost/aria-boutique-website/categories.php?category=Bridal
                // Then $_GET['category'] will return 'Bridal'.
                //
                // isset($_GET['category']) checks if 'category' exists in the URL parameters and is not NULL.
                // If it exists, we assign its value to $category variable otherwise, we set $category variable to null.

                $category = isset($_GET['category']) ? $_GET['category'] : null;

                // Check if $category variable is set and also if the selected category exists in the $products array
                if ($category && isset($products[$category])) {

                    // If it exists then -
                    // Loop through the array of products for the selected category
                    foreach ($products[$category] as $product) {
                        // 1. The echo statement generates HTML dynamically
                        // 2. We used single quotes in echo because we need to pass PHP variables inside the string and they require double quotes.  
                        // 3 .If we would have used double quotes, there would be a conflict since we can't use double quotes inside another double-quoted string.
                        // 4. Concatenation (.) is used to insert values from php variables into the string
                        echo '
                        <a href="./detail.php?product=' . $product["name"] . '" class="category-card-link">
                            <div class="category-card">
                                <img src="' . $product["image"] . '" />  
                                <!-- The image URL is inserted dynamically from the array -->
                                <h5>' . $product["name"] . '</h5> 
                                <!-- Product name is dynamically inserted from the array -->
                                <h6 class="category-card-subheading">' . $product["subheading"] . '</h6> 
                                <!-- Subheading is also inserted dynamically -->
                                <span class="price-share-span">
                                <p class="category-card-price">₹' . $product["price"] . '</p>
                                <i class="fa-solid fa-share-from-square share-icon"></i>
                                </span>
                                <button name="buy-btn" class="buy-btn">Buy now</button>
                            </div>
                        </a>';
                    }
                } else {
                    // If no valid category is selected or found, show a message
                    echo "<p>No products found for this category.</p>";
                    // Here, we use double quotes ("") because there's no variable inside the string
                }
                ?>
            </div>

        </div>
    </div>
    <script src="indexscript.js"></script>
</body>

</html>