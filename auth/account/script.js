const main_content_section = document.querySelector("#main_content_section");
const order_content_section = document.querySelector("#order_content_section");
const wishlist_content_section = document.querySelector("#wishlist_content_section");
const cart_content_section = document.querySelector("#cart_content_section");
const payment_content_section = document.querySelector("#payment_content_section");

// hide all sections except main content
function hideAllSections() {
    main_content_section.style.display = "none";
    order_content_section.style.display = "none";
    wishlist_content_section.style.display = "none";
    cart_content_section.style.display = "none";
    payment_content_section.style.display = "none";
}

// show main content section
function showMainContent() {
    hideAllSections();
    main_content_section.style.display = "block";
}

// add event listener to show main content section on page load
window.addEventListener("load", showMainContent);
document.querySelectorAll(".nav-link").forEach(function(nav_link) {
    nav_link.style.cursor = "pointer";
});

// add event listener to all nav links
document.querySelectorAll(".nav-link").forEach(function(nav_link) {
    nav_link.addEventListener("click", function() {
    //    remove active class from all nav links
        document.querySelectorAll(".nav-link").forEach(function(nav_link) {
            nav_link.classList.remove("active");
        });
    //    add active class to clicked nav link
        this.classList.add("active");    
    //    hide all sections
        hideAllSections();
    //    show clicked section
        const section_id = this.getAttribute("data-section-id");
        document.querySelector(section_id).style.display = "block";
    })
    });