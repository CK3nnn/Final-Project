<?php
session_start();
@include '../login/db_config.php';

// Initialize session cart if it's not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Fetch cart items from database
$cartItems = array();
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $pro_id = $item['product_id'];
        $query = "SELECT p.*, c.quantity FROM byterage_data.products p JOIN cart c ON p.id = c.product_id WHERE c.product_id = $pro_id";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $product = mysqli_fetch_assoc($result);
            $product['quantity'] = $item['quantity'];
            $cartItems[] = $product;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <style>
        /* Your CSS styles for cart display */
    </style>
</head>

<body>
    <div class="cart">
        <h1>Your Cart</h1>
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item) { ?>
                    <tr>
                        <td><img src="../admin/uploaded_img/<?php echo $item['image']; ?>" height="50" alt=""></td>
                        <td><?php echo $item['name']; ?></td>
                        <td>$<?php echo $item['price']; ?></td>
                        <td>
                            <form action="cart.php" method="post">
                                <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1">
                                <input type="hidden" name="id" value="<?php echo $item['product_id']; ?>">
                                <input type="submit" name="update_quantity" value="Update">
                            </form>
                        </td>
                        <td>$<?php echo $item['price'] * $item['quantity']; ?></td>
                        <td>
                            <form action="cart.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $item['product_id']; ?>">
                                <input type="submit" name="remove_item" value="Remove">
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
            <!-- Include your subtotal, tax, shipping, and total calculations here -->
        </table>
    </div>
</body>

</html>