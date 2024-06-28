document.addEventListener('DOMContentLoaded', (event) => {
    const filterButtons = document.querySelectorAll("#filter-buttons button");
    const filterableProducts = document.querySelectorAll("#filterable-products .product");
    const featureProducts = document.querySelector(".featured-products");
    const featuredMenuLink = document.querySelector('.menu a.active');
    const bestSellerMenuLink = document.getElementById('best-seller-link');
    const newArrivalMenuLink = document.getElementById('new-arrival-link');
    const featuredProducts = document.querySelector('.featured-products');
    const bestSellerProducts = document.querySelector('.best-seller');
    const newArrivalProducts = document.querySelector('.new-arrival');
    const scrollAmount = 500;
    let slideIndex = 0;
    let timer;

 

    // HOMEPAGE SLIDE
    const showSlides = () => {
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
    };

    const plusSlides = (n) => {
        clearTimeout(timer);
        showSlide(slideIndex += n); 
    };

    const showSlide = (n) => {
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
    };

    const currentSlide = (n) => {
        clearTimeout(timer);
        showSlide(slideIndex = n);
    };

    // FILTER PRODUCTS
    const filterProducts = (e) => {
        const activeButton = document.querySelector("#filter-buttons .active");
        if (activeButton) {
            activeButton.classList.remove("active");
        }
        e.target.classList.add("active");

        filterableProducts.forEach(product => {
            if (product.dataset.category === e.target.dataset.filter || e.target.dataset.filter === "all") {
                product.classList.remove("hide");
            } else {
                product.classList.add("hide");
            }
        });
    };

    filterButtons.forEach(button => button.addEventListener("click", filterProducts));
    document.querySelector(".prev").addEventListener("click", () => {
        plusSlides(-1);
    });

    document.querySelector(".next").addEventListener("click", () => {
        plusSlides(1);
    });

    showSlides();

    // FEATURE HOMEPAGE
    let currentSection = "feature"; 
    let scrollIndex = 0; 
    
    const scrollLeft = () => {
        if (scrollIndex > 0) {
            scrollIndex -= scrollAmount;
            scrollToIndex(scrollIndex);
        }
    };
    
    const scrollRight = () => {
        const maxScrollFeature = featureProducts.scrollWidth - featureProducts.clientWidth;
        const maxScrollBestSeller = bestSellerProducts.scrollWidth - bestSellerProducts.clientWidth;
        const maxScrollNewArrival = newArrivalProducts.scrollWidth - newArrivalProducts.clientWidth;
    
        switch (currentSection) {
            case "feature":
                if (scrollIndex < maxScrollFeature) {
                    scrollIndex += scrollAmount;
                } else {
                    currentSection = "bestSeller";
                    scrollIndex = 0;
                }
                break;
            case "bestSeller":
                if (scrollIndex < maxScrollBestSeller) {
                    scrollIndex += scrollAmount;
                } else {
                    currentSection = "newArrival";
                    scrollIndex = 0;
                }
                break;
            case "newArrival":
                if (scrollIndex < maxScrollNewArrival) {
                    scrollIndex += scrollAmount;
                }
                break;
            default:
                break;
        }
    
        scrollToIndex(scrollIndex);
    };
    
    const scrollToIndex = (index) => {
        switch (currentSection) {
            case "feature":
                featureProducts.scrollTo({
                    left: index,
                    behavior: 'smooth'
                });
                break;
            case "bestSeller":
                bestSellerProducts.scrollTo({
                    left: index,
                    behavior: 'smooth'
                });
                break;
            case "newArrival":
                newArrivalProducts.scrollTo({
                    left: index,
                    behavior: 'smooth'
                });
                break;
            default:
                break;
        }
    };
    
    document.querySelector(".prev-products").addEventListener("click", scrollRight);
    document.querySelector(".next-products").addEventListener("click", scrollLeft);

    const toggleProductSections = (activeLink) => {
        if (activeLink === featuredMenuLink) {
            bestSellerProducts.style.display = 'none';
            newArrivalProducts.style.display = 'none';
            featuredProducts.style.display = 'flex';
        } else if (activeLink === bestSellerMenuLink) {
            featuredProducts.style.display = 'none';
            newArrivalProducts.style.display = 'none';
            bestSellerProducts.style.display = 'flex';
        } else if (activeLink === newArrivalMenuLink) {
            featuredProducts.style.display = 'none';
            bestSellerProducts.style.display = 'none';
            newArrivalProducts.style.display = 'flex';
        }
    };

    const handleMenuLinkClick = (event) => {
        event.preventDefault();
        const clickedLink = event.target;
        document.querySelectorAll('.menu a').forEach(link => link.classList.remove('active'));
        clickedLink.classList.add('active');
        toggleProductSections(clickedLink);
    };

    bestSellerMenuLink.addEventListener('click', function(event) {
        event.preventDefault();
        
        featuredMenuLink.classList.remove('active');
        bestSellerMenuLink.classList.add('active');
        
        featuredProducts.style.display = 'none';
        bestSellerProducts.style.display = 'flex';
    });

    featuredMenuLink.addEventListener('click', function(event) {
        event.preventDefault();

        bestSellerMenuLink.classList.remove('active');
        featuredMenuLink.classList.add('active');

        bestSellerProducts.style.display = 'none';
        featuredProducts.style.display = 'flex';
    });

    bestSellerMenuLink.addEventListener('click', function(event) {
        event.preventDefault();

        featuredMenuLink.classList.remove('active');
        newArrivalMenuLink.classList.remove('active'); 
        bestSellerMenuLink.classList.add('active');
    
        featuredProducts.style.display = 'none';
        newArrivalProducts.style.display = 'none';
        bestSellerProducts.style.display = 'flex';
    });

    featuredMenuLink.addEventListener('click', function(event) {
        event.preventDefault();

        bestSellerMenuLink.classList.remove('active');
        newArrivalMenuLink.classList.remove('active'); 
        featuredMenuLink.classList.add('active');
    

        bestSellerProducts.style.display = 'none';
        newArrivalProducts.style.display = 'none'; 
        featuredProducts.style.display = 'flex';
    });

    newArrivalMenuLink.addEventListener('click', function(event) {
        event.preventDefault();

        bestSellerMenuLink.classList.remove('active');
        featuredMenuLink.classList.remove('active');
        newArrivalMenuLink.classList.add('active');
    
        bestSellerProducts.style.display = 'none';
        featuredProducts.style.display = 'none';
        newArrivalProducts.style.display = 'flex';
    });

    document.querySelectorAll('.menu a').forEach(link => {
        link.addEventListener('click', handleMenuLinkClick);
    });

    featuredMenuLink.click();

    // Admin
    const notification = document.getElementById('notification');
    if (notification) {
        setTimeout(() => {
            notification.classList.add('hidden');
        }, 2000); 
        setTimeout(() => {
            notification.remove();
        }, 2000); 
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const addToCartButtons = document.querySelectorAll('.add-to-cart');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', event => {
            event.preventDefault();
            const proId = button.getAttribute('data-pro-id');
            window.location.href = `store.php?pro_id=${proId}`;
        });
    });
});
