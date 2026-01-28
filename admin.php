<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <h1>🔐 Admin Panel</h1>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button name="login">Login</button>
    </form>

    <a href="index.php">⬅ Back to Student Login</a>

    <?php
    if (isset($_POST['login'])) {
        $u = $_POST['username'];
        $p = $_POST['password'];

        $q = mysqli_query($conn,
            "SELECT * FROM admin WHERE username='$u' AND password='$p'"
        );

        if (mysqli_num_rows($q) == 1) {
            $_SESSION['admin'] = $u;
            header("Location: admin_dashboard.php");
        } else {
            echo "<p class='error'>Invalid admin login</p>";
        }
    }
    ?>

</div>

</body>
</html>

