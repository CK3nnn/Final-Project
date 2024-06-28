<!DOCTYPE html>
<html>

<head>
    <title>SIGN UP</title>
    <link rel="stylesheet" type="text/css" href="../asset/login.css">
</head>

<body>
    <form action="signup-check.php" method="post">
        <h2>SIGN UP</h2>

        <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php } ?>

        <?php if (isset($_GET['success'])) { ?>
            <p class="success"><?php echo htmlspecialchars($_GET['success']); ?></p>
        <?php } ?>

        <label>Name</label>
        <input type="text" name="name" placeholder="Name" value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?>"><br>

        <label>Username</label>
        <input type="text" name="uname" placeholder="Username" value="<?php echo isset($_GET['uname']) ? htmlspecialchars($_GET['uname']) : ''; ?>"><br>

        <label>Password</label>
        <input type="password" name="password" placeholder="Password"><br>

        <label>Confirm Password</label>
        <input type="password" name="con_password" placeholder="Confirm Password"><br>

        <button type="submit">Sign Up</button>
        <a href="login.php" class="ca">Already have an account?</a>
    </form>
</body>

</html>