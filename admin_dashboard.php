<?php
session_start();
include "db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
}

/* ADD CANDIDATE */
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $dept = $_POST['dept'];

    $img = $_FILES['photo']['name'];
    $tmp = $_FILES['photo']['tmp_name'];
    $path = "images/candidates/" . $img;

    move_uploaded_file($tmp, $path);

    mysqli_query($conn,
        "INSERT INTO candidates(name, department, photo) 
         VALUES('$name', '$dept', '$path')");
}

/* DELETE CANDIDATE */
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $img = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT photo FROM candidates WHERE id=$id")
    );
    if (file_exists($img['photo'])) {
        unlink($img['photo']);
    }

    mysqli_query($conn, "DELETE FROM candidates WHERE id=$id");
}

/* RESET ELECTION */
if (isset($_POST['reset'])) {
    mysqli_query($conn, "UPDATE candidates SET votes=0");
    mysqli_query($conn, "UPDATE students SET has_voted=0");
    echo "<script>alert('Election reset successful');</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<style>
body{
    margin:0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg,#1d2671,#c33764);
    min-height:100vh;
}

.container{
    width:90%;
    max-width:1100px;
    margin:30px auto;
    background:#fff;
    padding:30px;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
}

h2{
    text-align:center;
    margin-bottom:25px;
    color:#333;
}

.section{
    margin-bottom:40px;
}

.section h3{
    margin-bottom:15px;
    color:#444;
}

/* FORM */
.form-grid{
    display:grid;
    grid-template-columns: repeat(auto-fit,minmax(200px,1fr));
    gap:15px;
}

input[type="text"], input[type="file"]{
    padding:10px;
    border-radius:6px;
    border:1px solid #ccc;
    width:100%;
}

button{
    padding:10px 18px;
    border:none;
    border-radius:6px;
    cursor:pointer;
    font-weight:600;
}

.btn-add{
    background:#1d72f3;
    color:#fff;
}

.btn-delete{
    background:#e74c3c;
    color:#fff;
    text-decoration:none;
    padding:6px 12px;
    border-radius:4px;
}

.btn-reset{
    background:#c0392b;
    color:white;
    padding:12px 20px;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    padding:12px;
    text-align:center;
}

th{
    background:#f4f6f8;
}

tr:nth-child(even){
    background:#fafafa;
}

img{
    border-radius:6px;
}

/* TOP BAR */
.top-bar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.logout{
    text-decoration:none;
    background:#555;
    color:#fff;
    padding:8px 14px;
    border-radius:6px;
}
</style>
</head>
<body>

<div class="container">

<div class="top-bar">
    <h2>🗳️ Admin Dashboard</h2>
    <a class="logout" href="index.php">Logout</a>
</div>

<!-- ADD CANDIDATE -->
<div class="section">
<h3>Add Candidate</h3>
<form method="POST" enctype="multipart/form-data">
    <div class="form-grid">
        <input type="text" name="name" placeholder="Candidate Name" required>
        <input type="text" name="dept" placeholder="Department" required>
        <input type="file" name="photo" required>
    </div>
    <br>
    <button class="btn-add" name="add">Add Candidate</button>
</form>
</div>

<!-- CANDIDATE LIST -->
<div class="section">
<h3>Candidate List</h3>
<table>
<tr>
    <th>Photo</th>
    <th>Name</th>
    <th>Department</th>
    <th>Votes</th>
    <th>Action</th>
</tr>

<?php
$res = mysqli_query($conn, "SELECT * FROM candidates");
while ($r = mysqli_fetch_assoc($res)) {
?>
<tr>
    <td><img src="<?php echo $r['photo']; ?>" width="60"></td>
    <td><?php echo $r['name']; ?></td>
    <td><?php echo $r['department']; ?></td>
    <td><?php echo $r['votes']; ?></td>
    <td>
        <a class="btn-delete" href="?delete=<?php echo $r['id']; ?>"
           onclick="return confirm('Delete this candidate?')">
           Delete
        </a>
    </td>
</tr>
<?php } ?>
</table>
</div>

<!-- RESET -->
<div class="section" style="text-align:center;">
<h3>Reset Election</h3>
<form method="POST">
    <button class="btn-reset" name="reset"
    onclick="return confirm('Are you sure? This will reset all votes!')">
        Reset Election
    </button>
</form>
</div>

</div>
</body>
</html>
