<?php
session_start();
include "db.php";

/* Check login */
if(!isset($_SESSION['student'])){
    header("Location: index.php");
    exit();
}

$reg = $_SESSION['student'];

/* Check if already voted */
$check = mysqli_query($conn,
    "SELECT has_voted FROM students WHERE reg_no='$reg'"
);
$row = mysqli_fetch_assoc($check);

if($row['has_voted'] == 1){
    echo "<h2>You have already voted</h2>";
    exit();
}

/* Fetch candidates */
$candidates = mysqli_query($conn, "SELECT * FROM candidates");

/* Vote action */
if(isset($_POST['vote'])){
    $cid = $_POST['vote'];

    mysqli_query($conn,
        "UPDATE candidates SET votes = votes + 1 WHERE id='$cid'"
    );

    mysqli_query($conn,
        "UPDATE students SET has_voted = 1 WHERE reg_no='$reg'"
    );

    session_destroy();
    echo "<h2>✅ Vote submitted successfully</h2>";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cast Your Vote</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <h1>🗳 Cast Your Vote</h1>

    <form method="POST">
        <div class="candidates-grid">
            <?php
            $candidates = mysqli_query($conn, "SELECT * FROM candidates");
            while($row = mysqli_fetch_assoc($candidates)){
            ?>
                <div class="candidate-card">
                    <img src="<?php echo $row['photo']; ?>" alt="Candidate">
                    <h3><?php echo $row['name']; ?></h3>
                    <p><?php echo $row['department']; ?></p>
                    <button name="vote" value="<?php echo $row['id']; ?>">
                        Vote
                    </button>
                </div>
            <?php } ?>
        </div>
    </form>
</div>


</body>
</html>
