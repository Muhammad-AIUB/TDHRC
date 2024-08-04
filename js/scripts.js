document.addEventListener("DOMContentLoaded", function() {
    const navToggle = document.getElementById("navToggle");
    const navMenu = document.getElementById("navMenu");

    // Toggle active class on menu toggle click
    navToggle.addEventListener("click", function() {
        navMenu.classList.toggle("active");
    });

    // Hide menu when a link is clicked
    const navLinks = document.querySelectorAll('.nav-menu ul li a');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            navMenu.classList.remove('active');
        });
    });

    // Hide menu when the page is refreshed
    window.addEventListener('beforeunload', () => {
        navMenu.classList.remove('active');
    });
});
