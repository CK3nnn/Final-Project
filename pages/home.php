<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
    @include '../login/db_config.php';
?>
    <?php include 'header.php'; ?>

    <div class="home-slide" style="margin-top: 150px; padding-top: 50px;">
        <div class="homeSlides fade">
            <img src="../asset/images/homeslide/homeSlide1.jpg" style="width: 100%">
        </div>
        <div class="homeSlides fade">
            <img src="../asset/images/homeslide/homeSlide2.jpg" style="width: 100%">
        </div>
        <div class="homeSlides fade">
            <img src="../asset/images/homeslide/homeSlide3.jpg" style="width: 100%">
        </div>
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>


    <div class="container">
        <div class="menu">
            <a href="#" class="active" id="featured-products-link">Featured</a>
            <a href="#" id="best-seller-link">Best Sellers</a>
            <a href="#" id="new-arrival-link">New Arrivals</a>
            <div class="next-prev-btn">
                <button class="next-products"><i class='fas fa-arrow-left' style="font-size: 25px;"></i></button>
                <button class="prev-products"><i class='fas fa-arrow-right' style="font-size: 25px;"></i></button>
            </div>
        </div>

        <div class="featured-products">
            <!-- Static content for the Featured section -->
            <div class="feat-products">
                <img src="../asset/images/keyboard/keyb1.jpg" alt="Redragon K552 RGB Lighting">
                <h3>Redragon K552 RGB Lighting</h3>
                <p>$45</p>
                <button>Add to Cart</button>
            </div>
            <!-- Add more static content for other featured products if needed -->
        </div>

        <div class="best-seller">
            <!-- Static content for the Best Seller section -->
            <div class="feat-products">
                <img src="data/images/mouse/mouse1.webp" alt="Razer Viper Mini">
                <h3>Razer Viper Mini</h3>
                <p>$38</p>
                <button>Add to Cart</button>
            </div>
            <!-- Add more static content for other best selling products if needed -->
        </div>

        <div class="new-arrival">
            <?php
            $select = mysqli_query($conn, "SELECT p.name, p.price, p.image, p.category FROM new_arrival_products n JOIN byterage_data.products p ON n.product_id = p.id");
            if (!$select) {
                // Query failed, display error message
                echo "Error: " . mysqli_error($conn);
            } else {
                // Query successful, fetch and display products
                while ($row = mysqli_fetch_assoc($select)) {
            ?>
                    <div class="feat-products">
                        <img src="../admin/uploaded_img/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                        <div class="product-info">
                            <h3><?php echo $row['name']; ?></h3>
                        </div>
                        <p class="price">$<?php echo $row['price']; ?></p>
                        <button>Add to Cart</button>
                    </div>
            <?php
                }
            }
            ?>
        </div>



    </div>

    <div class="banner">
        <div class="banner-left">
            <?php
            $imagePath = '../asset/images/team-pictures/frontpage.jpg';
            $altText = '#ByteRage';
            echo "<img src=\"$imagePath\" alt=\"$altText\">";
            ?>
        </div>
        <div class="banner-right">
            <h2>Who we are?</h2>
            <p>At Byterage, we don't just sell products — we empower you to unleash your full potential.
                Join us, and experience the difference that quality, affordability, and dedication to
                excellence can make in your tech journey.</p>
            <button onclick="window.location.href='AboutUs.php'">Learn More</button>

            <div class="byterageLogo"><img src="../asset/images/b2.png" alt="ByteRageLogo"></div>
        </div>
    </div>
    </div>

<?php
} else {
    header("Location: ../index.html");
    exit();
}
?>