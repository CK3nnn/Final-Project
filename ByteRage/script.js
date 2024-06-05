document.addEventListener('DOMContentLoaded', (event) => {
    // Select relevant HTML elements
    const filterButtons = document.querySelectorAll("#filter-buttons button");
    const filterableProducts = document.querySelectorAll("#filterable-products .product");
     const productCards = document.querySelectorAll('.product');

    // Function to filter products based on filter buttons
    const filterProducts = (e) => {
        const activeButton = document.querySelector("#filter-buttons .active");
        if (activeButton) {
            activeButton.classList.remove("active");
        }
        e.target.classList.add("active");

        filterableProducts.forEach(product => {
            // Show the product if it matches the clicked filter or show all products if "all" filter is clicked
            if (product.dataset.name === e.target.dataset.filter || e.target.dataset.filter === "all") {
                product.classList.remove("hide");
            } else {
                product.classList.add("hide");
            }
        });
    };

    filterButtons.forEach(button => button.addEventListener("click", filterProducts));




    // Icon functionality
    document.querySelectorAll('.icons a').forEach(function(icon) {
        icon.addEventListener('mouseleave', function() {
            setTimeout(function() {
                icon.querySelector('::after').style.opacity = 0;
                icon.querySelector('::after').style.visibility = 'hidden';
            }, 10000); 
        });
    });

    let slideIndex = 0;
    let timer;
    
    function showSlides() {
        let slides = document.querySelectorAll(".homeSlides");
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slideIndex++;
        if (slideIndex > slides.length) {
            slideIndex = 1;
        }
        slides[slideIndex - 1].style.display = "block";
        timer = setTimeout(showSlides, 8000);
    }
    
    function plusSlides(n) {
        clearTimeout(timer);
        showSlide(slideIndex += n);
    }
    
    function showSlide(n) {
        let slides = document.querySelectorAll(".homeSlides");
        if (n > slides.length) {
            slideIndex = 1;
        }
        if (n < 1) {
            slideIndex = slides.length;
        }
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slides[slideIndex - 1].style.display = "block";
    }
    
    function currentSlide(n) {
        clearTimeout(timer);
        showSlide(slideIndex = n);
    }
    
    document.querySelector(".prev").addEventListener("click", () => {
        plusSlides(-1);
    });
    
    document.querySelector(".next").addEventListener("click", () => {
        plusSlides(1);
    });
    
    showSlides();




    
});
