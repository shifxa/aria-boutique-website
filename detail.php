<!DOCTYPE html>
<html lang="en">
<?php
// Initialize session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="indexstyle.css">
    <link rel="stylesheet" href="detail.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" type="image/png" href="./images/boutique logo.png">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/fe29f9dc19.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <title>Product Details</title>
</head>

<body>
    <?php include("./navbar.html") ?>
    <div class="detail-wrapper">
        <div class="detail-container">
            <div class="images-section">
                <div class="main-image">
                    <img src="https://e0.pxfuel.com/wallpapers/63/914/desktop-wallpaper-traditional-indian-bridal-dresses.jpg"
                        alt="">
                </div>
            </div>
            <div class="detailed-info-section">
                <div class="info-headings">
                    <h5>Bridal</h5>
                    <h1 id="product-name">Red Bridal Studded Gown</h1>
                </div>
                <div class="price">
                    <h4 id="product-price">₹6999</h4>
                    <h4 style="opacity: 0.5; text-decoration: line-through;">₹10000</h4>
                </div>
                <div class="description">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero a officiis itaque inventore quia
                        optio quos sed similique qui aspernatur soluta aliquid expedita tempore doloribus et cupiditate,
                        praesentium amet iure.
                    </p>
                </div>
                <div class="size">
                    <h4>Select Size -</h4>
                    <div class="size-options">
                        <div class="size-option" data-size="S" onclick="selectSize(this)">S</div>
                        <div class="size-option" data-size="M" onclick="selectSize(this)">M</div>
                        <div class="size-option" data-size="L" onclick="selectSize(this)">L</div>
                        <div class="size-option" data-size="XL" onclick="selectSize(this)">XL</div>
                    </div>
                </div>
                <div class="size quantity">
                    <h4>Select Quantity -</h4>
                    <div class="quantity-options">
                        <div class="quantity-option">
                            <button class="quantity-button" onclick="decreaseQuantity()">-</button>
                            <input type="number" class="quantity-input" id="quantity-input" value="1" readonly>
                            <button class="quantity-button" onclick="increaseQuantity()">+</button>
                        </div>
                    </div>
                </div>
                <div class="add-to-cart-button">
                    <button class="add-to-cart-button-text" onclick="addToCart()">
                        <i class="fas fa-shopping-cart"></i>
                        Add to Cart
                    </button>
                </div>
                <div class="buy-now-button">
                    <button class="buy-now-button-text" onclick="buyNow()">
                        <i class="fas fa-shopping-bag"></i>
                        Buy Now
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script src="indexscript.js"></script>
    <script>
        let selectedSize = null;
        const priceStr = document.getElementById('product-price').innerText;
        const price = parseInt(priceStr.replace('₹', ''));

        function selectSize(element) {
            // Remove selected class from all size options
            document.querySelectorAll('.size-option').forEach(option => {
                option.style.backgroundColor = 'transparent';
                option.style.color = '#000';
            });

            // Add selected class to clicked option
            element.style.backgroundColor = '#000';
            element.style.color = '#fff';
            selectedSize = element.dataset.size;
        }

        function decreaseQuantity() {
            const input = document.getElementById('quantity-input');
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
            }
            hideWholesaleMessage();
        }

        function increaseQuantity() {
            const input = document.getElementById('quantity-input');
            const currentValue = parseInt(input.value);
            if (currentValue < 10) {
                input.value = currentValue + 1;
                hideWholesaleMessage();
            } else {
                showWholesaleMessage();
            }
        }

        function showWholesaleMessage() {
            let messageElement = document.getElementById('wholesale-message');
            if (!messageElement) {
                messageElement = document.createElement('div');
                messageElement.id = 'wholesale-message';
                messageElement.style.color = '#e74c3c';
                messageElement.style.marginTop = '15px';
                messageElement.style.fontSize = '14px';
                messageElement.style.padding = '12px 15px';
                messageElement.style.backgroundColor = '#fff3f3';
                messageElement.style.border = '1px solid #ffcdd2';
                messageElement.style.borderRadius = '6px';
                messageElement.style.boxShadow = '0 2px 4px rgba(231, 76, 60, 0.1)';
                messageElement.style.transition = 'all 0.3s ease';
                messageElement.style.display = 'flex';
                messageElement.style.alignItems = 'center';
                messageElement.style.gap = '8px';
                messageElement.style.maxWidth = '100%';
                messageElement.style.width = 'fit-content';

                messageElement.innerHTML = `
                    <i class="fas fa-info-circle" style="color: #e74c3c; font-size: 20px;padding-inline: 10px;"></i>
                                        <span>For wholesale orders, please 
                                            <a href="contact.php" style="color: #e74c3c; text-decoration: none; font-weight: 500; border-bottom: 1px solid #e74c3c; padding-bottom: 1px; transition: all 0.2s ease;">contact us to get a wholesale discount</a>
                                        </span>
                                    `;

                const link = messageElement.querySelector('a');
                link.addEventListener('mouseenter', () => {
                    link.style.color = '#c0392b';
                    link.style.borderBottomColor = '#c0392b';
                });
                link.addEventListener('mouseleave', () => {
                    link.style.color = '#e74c3c';
                    link.style.borderBottomColor = '#e74c3c';
                });

                document.querySelector('.quantity-options').appendChild(messageElement);

                messageElement.animate([
                    { opacity: 0, transform: 'translateY(-10px)' },
                    { opacity: 1, transform: 'translateY(0)' }
                ], {
                    duration: 300,
                    easing: 'ease-out'
                });
            }
        }

        function hideWholesaleMessage() {
            const messageElement = document.getElementById('wholesale-message');
            if (messageElement) {
                messageElement.remove();
            }
        }

        function validateSelection() {
            if (!selectedSize) {
                alert('Please select a size');
                return false;
            }
            return true;
        }

        function addToCart() {
            if (!validateSelection()) return;
            // Add to cart functionality here
        }

        function buyNow() {
            if (!validateSelection()) return;
            
            const quantity = parseInt(document.getElementById('quantity-input').value);
            const totalAmount = price * quantity;
            
            // Razorpay integration
            var options = {
                key: "rzp_test_J8YZAbvHFxFR5O", 
                amount: totalAmount * 100, 
                currency: "INR",
                name: "Aria Boutique",
                description: `${document.getElementById('product-name').innerText} - Size: ${selectedSize}`,
                image: "images/boutique logo.png",
                handler: function (response) {
                    // Handle successful payment
                    alert('Payment successful! Payment ID: ' + response.razorpay_payment_id);
                    // You should add server-side verification here
                },
                prefill: {
                    name: "", // Can be filled from user's session if available
                    email: "",
                    contact: ""
                },
                notes: {
                    size: selectedSize,
                    quantity: quantity,
                    product_name: document.getElementById('product-name').innerText
                },
                theme: {
                    color: "#000000"
                }
            };

            var rzp = new Razorpay(options);
            rzp.open();
        }
    </script>
    <?php include"./footer.html" ?>
</body>



</html>