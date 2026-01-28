<?php
session_start();
include "db.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>College Online Voting</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <h1>🎓 College Election</h1>
    <h2>Student Login</h2>

    <form method="POST">
        <input type="text" name="reg" placeholder="Register Number" required>
        <input type="password" name="pass" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>

    <a href="register.php">New Voter? Register Here</a><br>
    <a href="admin.php">Admin Login</a>

<?php
if(isset($_POST['login'])){
    $reg  = $_POST['reg'];
    $pass = $_POST['pass'];

    $q = mysqli_query($conn,
        "SELECT * FROM students WHERE reg_no='$reg' AND password='$pass'"
    );

    if(mysqli_num_rows($q) == 1){
        $row = mysqli_fetch_assoc($q);

        if($row['has_voted'] == 0){
            $_SESSION['student'] = $reg;
            header("Location: vote.php");
            exit();
        } else {
            echo "<p style='color:red'>❌ You have already voted</p>";
        }
    } else {
        echo "<p style='color:red'>❌ Invalid Register Number or Password</p>";
    }
}
?>

</div>
</body>
</html>
