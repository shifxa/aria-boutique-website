<?php
// Initialize session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("Server/connection.php");

// Get product ID from URL
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch product details
$product = null;
if ($product_id > 0) {
    $stmt = $conn->prepare("
        SELECT p.*, c.name as category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        WHERE p.id = ?
    ");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $product = $row;
    } else {
        // Redirect to home if product not found
        header("Location: index.php");
        exit();
    }
} else {
    // Redirect to home if no product ID
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
    <link rel="stylesheet" href="detail.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" type="image/png" href="./images/boutique logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/fe29f9dc19.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <title><?php echo htmlspecialchars($product['name']); ?> - Aria Boutique</title>
</head>

<body>
    <?php include("./navbar.php") ?>
    <div class="detail-wrapper">
        <div class="detail-container">
            <div class="images-section">
                <div class="main-image">
                    <img src="uploads/products/<?php echo htmlspecialchars($product['image']); ?>" 
                         alt="<?php echo htmlspecialchars($product['name']); ?>">
                </div>
            </div>
            <div class="detailed-info-section">
                <div class="info-headings">
                    <h5><?php echo htmlspecialchars($product['category_name']); ?></h5>
                    <h1 id="product-name"><?php echo htmlspecialchars($product['name']); ?></h1>
                </div>
                <div class="price">
                    <?php if (!empty($product['discounted_price'])): ?>
                        <h4 id="product-price">₹<?php echo htmlspecialchars($product['discounted_price']); ?></h4>
                        <h4 style="opacity: 0.5; text-decoration: line-through;">₹<?php echo htmlspecialchars($product['price']); ?></h4>
                    <?php else: ?>
                        <h4 id="product-price">₹<?php echo htmlspecialchars($product['price']); ?></h4>
                    <?php endif; ?>
                </div>
                <div class="description">
                    <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
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
        const productData = {
            id: <?php echo $product_id; ?>,
            name: <?php echo json_encode($product['name']); ?>,
            price: <?php echo !empty($product['discounted_price']) ? $product['discounted_price'] : $product['price']; ?>,
            image: <?php echo json_encode($product['image']); ?>
        };

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

                messageElement.animate([{
                    opacity: 0,
                    transform: 'translateY(-10px)'
                },
                {
                    opacity: 1,
                    transform: 'translateY(0)'
                }
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

            // Check if user is logged in
            <?php if (!isset($_SESSION['uemail'])) { ?>
                // Store current URL in session
                sessionStorage.setItem('returnUrl', window.location.href);
                window.location.href = 'auth/login.php';
                return;
            <?php } ?>

            // Add to cart functionality here
        }

        function buyNow() {
            if (!validateSelection()) return;



            // Check if user is logged in
            <?php if (!isset($_SESSION['uemail'])) { ?>
                // Store current URL in session
                sessionStorage.setItem('returnUrl', window.location.href);
                window.location.href = 'auth/login.php';
                return;
            <?php } ?>

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
                handler: async function (response) {
                    try {
                        console.log('Razorpay Response:', response);
                        // Prepare the order details
                        const orderData = {
                            payment_id: response.razorpay_payment_id,
                            product_id: productData.id,
                            product_name: productData.name,
                            image: productData.image,
                            size: selectedSize,
                            quantity: quantity,
                            amount: totalAmount
                        };

                        console.log('Sending order data:', orderData);

                        // First store the order details
                        const storeResponse = await fetch('store-order.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(orderData)
                        });

                        let data;
                        const responseText = await storeResponse.text();
                        console.log('Server response:', responseText);

                        try {
                            data = JSON.parse(responseText);
                        } catch (e) {
                            console.error('JSON Parse Error:', e);
                            console.error('Response text:', responseText);
                            throw new Error('Invalid response from server');
                        }

                        if (!storeResponse.ok) {
                            throw new Error(data.message || 'Server returned an error');
                        }

                        if (data.success) {
                            window.location.href = 'payment-success.php';
                        } else {
                            throw new Error(data.message || 'Failed to store order details');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Error processing your order: ' + error.message);
                    }
                },
                "modal": {
                    "ondismiss": function() {
                        console.log('Payment modal closed');
                    }
                },
                prefill: {
                    name: "<?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ''; ?>",
                    email: "<?php echo isset($_SESSION['uemail']) ? $_SESSION['uemail'] : ''; ?>",
                    contact: "<?php echo isset($_SESSION['phone']) ? $_SESSION['phone'] : ''; ?>"
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

            rzp.on('payment.failed', async function (response) {
                try {
                    // First store the error details
                    const storeResponse = await fetch('store-payment-error.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            error: {
                                code: response.error.code,
                                description: response.error.description,
                                source: response.error.source,
                                step: response.error.step,
                                reason: response.error.reason
                            }
                        })
                    });

                    if (!storeResponse.ok) {
                        throw new Error('Network response was not ok');
                    }

                    const data = await storeResponse.json();
                    
                    if (data.success) {
                        window.location.href = 'payment-failed.php';
                    } else {
                        throw new Error(data.message || 'Failed to store payment error details');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Error processing your payment failure: ' + error.message);
                }
            });

            rzp.open();
        }
    </script>
    <?php include "./footer.html" ?>
</body>
</html>