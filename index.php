<?php
session_start();
// include("./connection.php")
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="./images/boutique logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/fe29f9dc19.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://unpkg.com/scrollreveal"></script>
    <link rel="stylesheet" href="indexstyle.css">
    <link rel="stylesheet" href="navbar.css">

    <title>BOUTIQUE MANAGEMENT SYSTEM</title>
</head>

<body>
    <!-- NAVBAR CODE STARTS HERE -->
    <?php include("./navbar.html") ?>
    <!-- NAVBAR CODE ENDS HERE -->
    <!-- IMAGE SLIDER CODE STARTS HERE -->
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://cdn.pixelbin.io/v2/black-bread-289bfa/81ub5U/t.resize(w:2000)/manish-banner/1734068594revised_evara_banner_desktop.webp"
                    class="object-fit-cover w-100 h-100" alt="...">
                <div class="carousel-caption ">
                    CLASSIC FEMININE <br />
                    CLOTHING
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://cdn.pixelbin.io/v2/black-bread-289bfa/81ub5U/t.resize(w:2000)/manish-banner/1732099214WORLD_COLLECTION_DESKTOP_BANNER.webp"
                    class="object-fit-cover w-100 h-100" alt="...">
                <!-- <div class="carousel-caption d-none d-md-block">
                    <h5>Second slide label</h5>
                    <p>Some representative placeholder content for the second slide.</p>
                </div> -->
            </div>
            <div class="carousel-item">
                <img src="https://cdn.pixelbin.io/v2/black-bread-289bfa/81ub5U/t.resize(w:2000)/manish-banner/1722246261Saree_banner_desktop_final.webp"
                    class="object-fit-cover w-100 h-100" alt="...">
                <!-- <div class="carousel-caption d-none d-md-block">
                    <h5>Third slide label</h5>
                    <p>Some representative placeholder content for the third slide.</p>
                </div> -->
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!-- IMAGE SLIDER CODE ENDS HERE -->

    <!-- CATEGORIES CODE START HERE -->
    <div class="categories">
        <div class="categories-header">
            <p>CATEGORIES</p>
        </div>
        <div class="categories-item">
            <ul class="categories-content">
                <li class="categories-list">
                    <a href="./categories.php?category=Bridal" class="categories-anchor">
                        <img class="categories-img"
                            src="https://i.pinimg.com/736x/36/c9/81/36c98134bef18471830d9afca03c5a2e.jpg" alt="">
                        BRIDAL</a>
                </li>

                <li class="categories-list">
                    <a href="./categories.php?category=Dress" class="categories-anchor">
                        <img class="categories-img"
                            src="https://i.pinimg.com/736x/ec/8b/a9/ec8ba94eaae0132149ea3e8a8cb22289.jpg" alt="">
                        DRESS</a>
                </li>

                <li class="categories-list">
                    <a href="./categories.php?category=Lehenga" class="categories-anchor">
                        <img class="categories-img"
                            src="https://i.pinimg.com/736x/15/0f/ab/150fab7779292930df2f7b4762fb9dac.jpg" alt="">
                        LEHENGA</a>
                </li>

                <li class="categories-list">
                    <a href="./categories.php?category=Blouse" class="categories-anchor">
                        <img class="categories-img"
                            src="https://i.pinimg.com/736x/a0/c5/a1/a0c5a1e7fefdf1ec92cf3233acafca89.jpg" alt="">
                        BLOUSE</a>
                </li>

                <li class="categories-list">
                    <a href="./categories.php?category=Kurta" class="categories-anchor">
                        <img class="categories-img"
                            src="https://i.pinimg.com/736x/2b/a9/a1/2ba9a1d6043f6249228ca09202588fc2.jpg" alt="">
                        KURTA</a>
                </li>

                <li class="categories-list">
                    <a href="./categories.php?category=Shirts" class="categories-anchor">
                        <img class="categories-img"
                            src="https://i.pinimg.com/736x/89/14/38/89143831b298a4677ba117eaf5def968.jpg" alt="">
                        SHIRTS</a>
                </li>


                <li class="categories-list">
                    <a href="./categories.php?category=Gowns" class="categories-anchor">
                        <img class="categories-img"
                            src="https://i.pinimg.com/736x/d7/46/53/d74653f9645dfa54de9ab4548fb2ba47.jpg" alt="">
                        GOWNS</a>
                </li>

                <li class="categories-list">
                    <a href="./categories.php?category=Bottom Wear" class="categories-anchor">
                        <img class="categories-img"
                            src="https://i.pinimg.com/736x/3e/39/c1/3e39c16a950e3be9f69567e872e6bc0e.jpg" alt="">
                        BOTTOM WEAR</a>
                </li>

                <li class="categories-list">
                    <a href="./categories.php?category=Skirts" class="categories-anchor">
                        <img class="categories-img"
                            src="https://i.pinimg.com/736x/46/4f/64/464f64b7eded4a6fd7127161911f5886.jpg" alt="">
                        SKIRTS</a>
                </li>

                <li class="categories-list">
                    <a href="./categories.php?category=Party Wear" class="categories-anchor">
                        <img class="categories-img"
                            src="https://i.pinimg.com/736x/d4/2b/b8/d42bb83a03e3503571cb2c23da1a8fbb.jpg" alt="">
                        PARTY WEAR</a>
                </li>

                <li class="categories-list">
                    <a href="./categories.php?category=Fusions" class="categories-anchor">
                        <img class="categories-img"
                            src="https://i.pinimg.com/736x/09/45/b9/0945b9d2f480e21940db1b047ca1ac32.jpg" alt="">
                        FUSIONS</a>
                </li>

                <li class="categories-list">
                    <a href="./categories.php?category=Cord Sets" class="categories-anchor">
                        <img class="categories-img"
                            src="https://i.pinimg.com/736x/2e/41/c5/2e41c599a9f842749f60455ffdaa8adf.jpg" alt="">
                        CORD SETS</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- CATEGORIES CODE ENDS HERE -->

    <!-- QUOTES CODE START HERE  -->

    <div class="quotes-content">
        <img class="quotes-img" src="https://i.pinimg.com/736x/f0/02/7b/f0027b0da91ad10a7e17dca983d1359f.jpg" alt="">
        <div class="quotes-wrapper">

            <p class="quotes-header">POWER DRESSING</p>
            <p class="quotes">Crisp blouses, tailored trousers & polished dresses that flatter your figure</p>
        </div>
    </div>

    <!-- QUOTES CODE ENDS HERE  -->

    <!-- NEW ARRIVALS CODE START HERE -->
    <div class="new-arrivals">

        <span class="new-arrivals-headings">
            <h1>New Arrivals</h1>
            <h3>Updated Products At special Prices</h3>
            <h4>Aria boutique</h4>
            <a href="#" class="explore-btn">Explore</a>
        </span>
        <div class="new-arrival-images-wrapper">
            <img src="./images/download (12).jpeg" class="new-arrivals-image" alt="">
            <img src="./images/golden.jpeg" class="new-arrivals-image" alt="">
            <img src="./images//download (14).jpeg" class="new-arrivals-image" alt="">
        </div>
    </div>

    <!-- NEW ARRIVALS CODE ENDS HERE -->


    <!-- OUR BESTSELLERS section CODE STARTS HERE -->
    <div class="our-bestsellers-wrapper">
        <div class="our-bestsellers-left-section">
            <h1>OUR BESTSELLERS</h1>
            <h5>Discover the styles our customers love the most! From timeless classics to trendy must-haves, our
                best-selling pieces are carefully curated to keep you looking chic and confident.</h5>
            <h6>Would you like a variation with a specific brand tone? </h6>
            <a href="#" class="get-yours-btn">Get Yours Now!</a>
        </div>
        <div class="our-bestsellers-right-section">
            <div class="our-bestsellers-images-wrapper">
                <img src="./images/download (15).jpeg" class="new-arrivals-image" alt="">
                <img src="./images/Lehenga blouse custom made of f white pure tissue silk Indian wedding dress for women - Made to measure outfit.jpeg"
                    class="new-arrivals-image" alt="">
                <img src="./images/download (16).jpeg" class="new-arrivals-image" alt="">
                <img src="./images/outfit.jpeg" class="new-arrivals-image" alt="">
                <img src="./images/sage green punjabi suit.jpeg" class="new-arrivals-image" alt="">
                <img src="./images/Ridhi Mehra - Buy Sarees, Lehengas, Anarkalis Online 2025.jpeg"
                    class="new-arrivals-image" alt="">
                <img src="./images/download (17).jpeg" class="new-arrivals-image" alt="">
            </div>
        </div>
    </div>

    <!-- OUR BESTSELLERS section CODE ENDS HERE -->


    <!-- Newsletter section CODE STARTS HERE -->
    <div class="newsletter-wrapper">

        <div class="newsletter-section">
            <h1>GET 10% OFF ON YOUR FIRST ORDER</h1>
            <p>Subscribe to get to know about special offers, free giveaways, and once-in-a-lifetime deals.</p>

            <form class="subscription-form">
                <input type="email" placeholder="Enter your email" required>
                <button type="submit">SUBSCRIBE</button>
            </form>
        </div>
    </div>
    <!-- Newsletter section CODE ENDS HERE -->

    <!-- INFO section CODE STARTS HERE -->
    <div class="info-wrapper">
        <div class="info-div info-div1">
            <div class="info-div-icon">
                <i class="fa-regular fa-face-smile nav-search-icon"></i>
            </div>
            <h4>HAPPY CUSTOMERS</h4>
            <p> Our customers love our services! We are committed to delivering excellence, ensuring satisfaction, and building long-lasting relationships.</p>
        </div>
        <div class="info-div info-div2">
            <div class="info-div-icon">
                <i class="fa-solid fa-headset nav-search-icon"></i>
            </div>
            <h4>PRIORITY CUSTOMER SERVICES</h4>
            <p>
                We're here to help you with any questions or concerns you may have. Our customer service team
                is available 24/7 to ensure you have a seamless shopping experience.
            </p>
        </div>
        <div class="info-div info-div3">
            <div class="info-div-icon">
                <i class="fa-solid fa-lock nav-search-icon"></i>
            </div>
            <h4>SECURE PAYMENTS</h4>
            <p>
                Shop confidently at Aria Boutique with our commitment to providing a secure and trustworthy online shopping environment.
            </p>
        </div>

    </div>
    <!-- INFO section CODE ENDS HERE -->

    <!-- FOOTER CODE STARTS HERE -->

    <footer class="footer">
        <div class="footer-content-wrapper">

            <div class="footer-logo-section">
                <img src="./images/boutique logo.png" alt="">
                <h3>ARIA BOUTIQUE</h3>
            </div>
            <span class="footer-link-group">
                <h4>HELPFUL LINKS</h4>
                <ul class="footer-links">
                    <li>
                        <a href="#">About Us</a>
                    </li>
                    <li>
                        <a href="#">Dummy</a>
                    </li>
                    <li>
                        <a href="#">Support</a>
                    </li>
                    <li>
                        <a href="#">Contact Us</a>
                    </li>
                </ul>
            </span>
            <span class="contact-info">
                <h4>CONTACTS</h4>
                <span class="footer-links">
                    <a href="tel:9321756424"><i class="fa-solid fa-phone "></i>&nbsp;&nbsp; +91 9321756424</a>
                    <a href="mailto:khanshifa122004@gmail.com"> <i
                            class="fa-regular fa-envelope "></i>&nbsp;&nbsp;khanshifa122004@gmail.com</a>
                </span>
            </span>
            <span class="footer-map">
                <h4>STORE LOCATION</h4>
                <div class="mapouter">
                    <div class="gmap_canvas"><iframe class="gmap_iframe" width="100%" frameborder="0" scrolling="no"
                            marginheight="0" marginwidth="0"
                            src="https://maps.google.com/maps?width=658&amp;height=250&amp;hl=en&amp;q=Anand Vishwagurukul Senior Night&amp;t=&amp;z=15&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
                    </div>
                </div>
            </span>
        </div>
        <div class="divider"></div>
        <span class="footer-bottom-info">
            <!-- <span> -->
            <p> &copy; Copyright 2023 Aria Boutique. All rights reserved.</p>
            <!-- </span> -->
        </span>
    </footer>

    <!-- FOOTER CODE ENDS HERE -->




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="indexscript.js"></script>
</body>

</html>