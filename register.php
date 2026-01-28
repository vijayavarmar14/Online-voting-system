<?php include "db.php"; ?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2>New Voter Registration</h2>

<form method="POST">
 <input name="reg" placeholder="Register Number" required><br>
 <input name="pass" type="password" placeholder="Password" required><br>
 <button name="register">Register</button>
</form>

<?php
if(isset($_POST['register'])){
 $reg=$_POST['reg'];
 $pass=$_POST['pass'];

 $check=mysqli_query($conn,"SELECT * FROM students WHERE reg_no='$reg'");
 if(mysqli_num_rows($check)>0){
  echo "<p>Register number already exists</p>";
 }else{
  mysqli_query($conn,"INSERT INTO students(reg_no,password) VALUES('$reg','$pass')");
  echo "<p>Registered successfully <a href='index.php'>Login</a></p>";
 }
}
?>

</body>
</html>
