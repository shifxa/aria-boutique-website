let images = document.querySelectorAll(".thumbnail");
let mainImage = document.getElementById("main-image");
let currentIndex = 0;

document.getElementById("prev-btn").addEventListener("click", () => {
    currentIndex = (currentIndex === 0) ? images.length - 1 : currentIndex - 1;
    mainImage.src = images[currentIndex].src;
});

document.getElementById("next-btn").addEventListener("click", () => {
    currentIndex = (currentIndex === images.length - 1) ? 0 : currentIndex + 1;
    mainImage.src = images[currentIndex].src;
});

document.getElementById("increase").addEventListener("click", () => {
    let qty = document.getElementById("quantity");
    qty.textContent = parseInt(qty.textContent) + 1;
});

document.getElementById("decrease").addEventListener("click", () => {
    let qty = document.getElementById("quantity");
    if (parseInt(qty.textContent) > 1) {
        qty.textContent = parseInt(qty.textContent) - 1;
    }
});
