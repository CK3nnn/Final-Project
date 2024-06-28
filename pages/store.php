<?php
include 'header.php';
@include '../login/db_config.php';

session_start();

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize an empty array for storing cart items in session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Check if a product is added to cart via GET request
if (isset($_GET['pro_id'])) {
    $pro_id = $_GET['pro_id'];

    // Query to fetch product details from the database
    $query = "SELECT * FROM byterage_data.products WHERE id = $pro_id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);

        // Add product to cart array in session if not already present
        $productExists = false;
        foreach ($_SESSION['cart'] as &$cartItem) {
            if ($cartItem['id'] == $product['id']) {
                $cartItem['quantity'] += 1;
                $productExists = true;
                break;
            }
        }
        if (!$productExists) {
            $product['quantity'] = 1;
            $_SESSION['cart'][] = $product;
        }
    }
}
?>

<section class="sec">
    <div id="filter-buttons" class="filter-buttons">
        <button class="filter-btn button-13" role="button" data-filter="all">All</button>
        <button class="filter-btn button-13" role="button" data-filter="keyboard">Keyboard</button>
        <button class="filter-btn button-13" role="button" data-filter="mouse">Mouse</button>
        <button class="filter-btn button-13" role="button" data-filter="headset">Headset</button>
        <button class="filter-btn button-13" role="button" data-filter="monitor">Monitor</button>
        <button class="filter-btn button-13" role="button" data-filter="chair">Chair</button>
    </div>

    <div id="filterable-products" class="products">
        <?php
        $select = mysqli_query($conn, "SELECT * FROM byterage_data.products");
        while ($row = mysqli_fetch_assoc($select)) {
        ?>
            <div class="card product" data-id="<?php echo $row['id']; ?>" data-category="<?php echo $row['category']; ?>">
                <div class="img"><img src="../admin/uploaded_img/<?php echo $row['image']; ?>" alt=""></div>
                <div class="title"><?php echo $row['name']; ?></div>
                <div class="box">
                    <div class="price">$<?php echo $row['price']; ?></div>
                    <button class="btn add-to-cart">Add to Cart</button>
                </div>
            </div>
        <?php } ?>
    </div>
</section>


<script src="../asset/script.js" defer></script>
</body>

</html>