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