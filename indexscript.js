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

  // Check if we're NOT on index.php
  if (!currentURL.includes("index.php")) {
    // Set background color for all non-index pages
    navbar.style.backgroundColor = "#d8bfb4";
  } else {
    // On index page, keep the scroll behavior
    window.addEventListener("scroll", () => {
      navbar.classList.toggle("window-scroll", window.scrollY > 0);
    });
  }
});
