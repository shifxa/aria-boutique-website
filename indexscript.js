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

window.addEventListener('scroll', () => {
    document.querySelectorAll('navbar').classList.toggle('window-scroll',window.scrollY > 0)
    })