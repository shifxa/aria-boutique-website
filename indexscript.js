const scrollRevealOption = {
  distance: "50px",
  origin: "bottom",
  duration: 1030,
};

ScrollReveal().reveal(".quotes-header ", {
  ...scrollRevealOption,
});

ScrollReveal().reveal(".quotes", {
  ...scrollRevealOption,
  delay: 500,
});

//change navbar  styles on scroll

document.addEventListener("DOMContentLoaded", () => {
  // After the document i.e html content is loaded this function will execute
  const navbar = document.getElementById("sticky-navbar");
  const currentURL = window.location.href;
  console.log(currentURL);
  // Check if we're NOT on index.php
  if (window.innerWidth > 768) {
    if (!currentURL.endsWith("aria-boutique-website/") &&
      !currentURL.includes("index.php")) {
      // Set background color for all non-index pages
      navbar.style.backgroundColor = "#d8bfb4";
    }

  } else {
    navbar.style.backgroundColor = "#d8bfb4";

    // On index page, keep the scroll behavior
    window.addEventListener("scroll", () => {
      navbar.classList.toggle("window-scroll", window.scrollY > 0);
    });
  }
});


document.addEventListener("DOMContentLoaded", () => {
    // Toast notification function
    function showToast(message, isError = false) {
        const toast = document.createElement('div');
        toast.className = `toast-notification ${isError ? 'error' : ''}`;
        toast.textContent = message;
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.classList.add('show');
        }, 100);
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 3000);
    }

    // Share button functionality
    const shareButtons = document.querySelectorAll('.quick-action-btn[title="Share"], .share-button');
    shareButtons.forEach(button => {
        button.addEventListener('click', () => {
            let shareUrl;
            const productCard = button.closest('.product-card');
            if (productCard) {
                const productLink = productCard.querySelector('a');
                shareUrl = new URL(productLink.href, window.location.origin).href;
            } else {
                shareUrl = window.location.href; // Fallback for non-product pages
            }
            navigator.clipboard.writeText(shareUrl)
                .then(() => {
                    showToast('Link copied to clipboard!');
                })
                .catch(err => {
                    console.error('Failed to copy: ', err);
                    showToast('Failed to copy link.', true);
                });
        });
    });

    // Add to Wishlist functionality
    const addWishlistButtons = document.querySelectorAll('.quick-action-btn[title="Add to Wishlist"], .wishlist-button');
    addWishlistButtons.forEach(button => {
        button.addEventListener('click', async () => {
            let productId;

            // Check if on detail page (productData exists)
            if (typeof productData !== 'undefined' && productData.id) {
                productId = productData.id;
            } else {
                // Fallback for category page
                const productCard = button.closest('.product-card');
                if (productCard) {
                    const productLink = productCard.querySelector('a');
                    const productUrl = productLink.getAttribute('href');
                    productId = new URLSearchParams(productUrl.split('?')[1]).get('id');
                }
            }

            if (!productId) {
                showToast('Unable to identify product.', true);
                return;
            }

            try {
                // Check if user is logged in
                const loginResponse = await fetch('checklogin.php', {
                    method: 'GET',
                    credentials: 'same-origin'
                });
                const loginResult = await loginResponse.json();

                if (!loginResult.logged_in) {
                    sessionStorage.setItem('returnUrl', window.location.href);
                    window.location.href = './auth/login.php';
                    return;
                }

                // Add to wishlist
                const formData = new FormData();
                formData.append('product_id', productId);

                const wishlistResponse = await fetch('addToWishlist.php', {
                    method: 'POST',
                    body: formData
                });
                const wishlistResult = await wishlistResponse.json();

                showToast(wishlistResult.message, wishlistResult.status === 'error');

                if (wishlistResult.status === 'success') {
                    button.classList.add('added');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('An error occurred. Please try again.', true);
            }
        });
    });

    // Remove from Wishlist functionality
    const removeWishlistButtons = document.querySelectorAll('.quick-action-btn[title="Remove from Wishlist"]');
    removeWishlistButtons.forEach(button => {
        button.addEventListener('click', async () => {
            const productId = button.getAttribute('data-product-id');

            if (!productId) {
                showToast('Unable to identify product.', true);
                return;
            }

            try {
                // Remove from wishlist
                const formData = new FormData();
                formData.append('product_id', productId);

                const response = await fetch('remove_from_wishlist.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                showToast(result.message, result.status === 'error');

                if (result.status === 'success') {
                    const productCard = button.closest('.product-card');
                    productCard.remove();
                    // Check if wishlist is empty
                    const remainingCards = document.querySelectorAll('.wishlist-content .product-card');
                    if (remainingCards.length === 0) {
                        document.querySelector('.wishlist-content').innerHTML = `
                            <p  class="no-items">
                                Your wishlist is empty. <a href="index.php">Explore products</a> to add some!
                            </p>
                        `;
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('An error occurred. Please try again.', true);
            }
        });
    });
});