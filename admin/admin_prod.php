<?php
@include '../login/db_config.php';

// Check if the 'edit' parameter is set in the URL
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    // Prepare and execute the SQL query using prepared statements
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Fetch the product data
        $row = $result->fetch_assoc();
    } else {
        // Redirect back to admin.php if no product found
        header('location:admin.php');
        exit;
    }

    $stmt->close();
} else {
    // If 'edit' parameter is not set, redirect back to admin.php
    header('location:admin.php');
    exit;
}

// Check if the update form is submitted
if (isset($_POST['update_product'])) {
    // Retrieve form data
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = 'uploaded_img/' . $product_image;

    // Check if any form fields are empty
    if (empty($product_name) || empty($product_price) || empty($product_image)) {
        $message[] = 'Please fill out all fields.';
    } else {
        // Update the product data in the database
        $update_data = "UPDATE products SET name='$product_name', price='$product_price', image='$product_image'  WHERE id = ?";
        $stmt = $conn->prepare($update_data);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            // Move uploaded image to the destination folder
            move_uploaded_file($product_image_tmp_name, $product_image_folder);
            // Redirect back to admin.php after successful update
            header('location:admin.php');
            exit;
        } else {
            $message[] = 'Could not update the product.';
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../asset/style.css">
</head>

<body>

    <?php
    // Display messages if any
    if (isset($message)) {
        foreach ($message as $message) {
            echo '<span class="message">' . $message . '</span>';
        }
    }
    ?>

    <div class="admin-container">

        <div class="admin-product-form-container centered">
            <form action="" method="post" enctype="multipart/form-data">
                <h3 class="title">Update Product</h3>
                <input type="text" class="box" name="product_name" value="<?php echo $row['name']; ?>" placeholder="Enter the product name">
                <input type="number" min="0" class="box" name="product_price" value="<?php echo $row['price']; ?>" placeholder="Enter the product price">
                <input type="file" class="box" name="product_image" accept="image/png, image/jpeg, image/jpg">
                <input type="submit" value="Update Product" name="update_product" class="btn">
                <a href="admin.php" class="btn-ad">Go Back</a>
            </form>
        </div>

    </div>

</body>

</html>