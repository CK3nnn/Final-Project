<?php
@include '../login/db_config.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


if (isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'] ?? '';
    $product_price = $_POST['product_price'] ?? '';
    $product_category = $_POST['product_category'] ?? '';
    $product_image = $_FILES['product_image']['name'] ?? '';
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'] ?? '';
    $product_image_folder = 'uploaded_img/' . $product_image;

    if (empty($product_name) || empty($product_price) || empty($product_category) || empty($product_image)) {
        $messageArray = 'Please fill out all fields.';
    } else {
        $insert = "INSERT INTO byterage_data.products (name, price, category, image) VALUES ('$product_name', '$product_price', '$product_category', '$product_image')";
        $upload = mysqli_query($conn, $insert);

        if ($upload) {
            if (move_uploaded_file($product_image_tmp_name, $product_image_folder)) {
                // Insert into new_arrival_products table
                $productId = mysqli_insert_id($conn); // Get the ID of the last inserted product
                $expiry_date = date('Y-m-d', strtotime('+1 day'));

                // Fetch product details using product_id
                $productQuery = "SELECT name, price, image FROM byterage_data.products WHERE id = '$productId'";
                $productResult = mysqli_query($conn, $productQuery);
                $productRow = mysqli_fetch_assoc($productResult);

                // Extract product details
                $productName = $productRow['name'];
                $productPrice = $productRow['price'];
                $productImage = $productRow['image'];

                // Insert into new_arrival_products table with additional details
                $insertNewArrival = "INSERT INTO new_arrival_products (product_id, name, price, image, expiry_date) VALUES ('$productId', '$productName', '$productPrice', '$productImage', '$expiry_date')";
                $uploadNewArrival = mysqli_query($conn, $insertNewArrival);

                if ($uploadNewArrival) {
                    echo '<div id="notification" class="notification">New product added successfully</div>';
                }
            } else {
                if (!$upload) {
                    echo '<div id="notification" class="notification">Failed to add product to new_arrival_products table: ' . mysqli_error($conn) . '</div>';
                } elseif (!move_uploaded_file($product_image_tmp_name, $product_image_folder)) {
                    echo '<div id="notification" class="notification">Failed to upload image: File may be too large or not supported</div>';
                } else {
                    echo '<div id="notification" class="notification">Could not add the product: Unknown error occurred</div>';
                }
            }
        } else {
            echo '<div id="notification" class="notification">Could not add the product</div>';
        }
    }
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_query = "DELETE FROM byterage_data.products WHERE id = '$delete_id'";
    $delete_result = mysqli_query($conn, $delete_query);
    if ($delete_result) {
        echo '<div id="notification" class="notification" style="background-color: red;">Product deleted successfully</div>';
    } else {
        echo '<div id="notification" class="notification" style="background-color: red;">Failed to delete product</div>';
    }
}

$select = mysqli_query($conn, "SELECT * FROM byterage_data.products");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="../asset/script.js"></script>
    <link rel="stylesheet" type="text/css" href="../asset/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .notification {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: green;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            z-index: 1000;
            opacity: 1;
            transition: opacity 1s ease-out;
        }

        .notification.hidden {
            opacity: 0;
        }
    </style>
</head>

<body>



    <div class="admin-container">
        <h1>Add a New Product</h1>
        <?php if (!empty($messageArray)) : ?>
            <div class="message"><?php echo $messageArray; ?></div>
        <?php endif; ?>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
            <input type="text" placeholder="Enter product name" name="product_name">
            <input type="number" placeholder="Enter product price" name="product_price">
            <input type="text" placeholder="Enter product category" name="product_category">
            <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image">
            <input type="submit" name="add_product" value="Add Product">
        </form>

        <div class="product-list">
            <h2>Product List</h2>
            <table>
                <thead>
                    <tr>
                        <th>Product Image</th>
                        <th>Product Name</th>
                        <th>Product Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($select)) { ?>
                        <tr>
                            <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
                            <td><?php echo $row['name']; ?></td>
                            <td>$<?php echo $row['price']; ?>/-</td>
                            <td>
                                <a href="admin_prod.php?edit=<?php echo $row['id']; ?>" class="btn-ad"> <i class="fas fa-edit"></i> edit </a>
                                <a href="admin.php?delete=<?php echo $row['id']; ?>" class="delete-ad"> <i class="fas fa-trash"></i> delete </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>




</body>

</html>