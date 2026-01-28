<?php include "db.php"; ?>
<!DOCTYPE html>
<html>
<head>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<h2>Election Results</h2>
<canvas id="chart"></canvas>

<?php
$q=mysqli_query($conn,"SELECT name,votes FROM candidates");
$names=[]; $votes=[];
while($r=mysqli_fetch_assoc($q)){
 $names[]=$r['name'];
 $votes[]=$r['votes'];
}
?>

<script>
new Chart(document.getElementById("chart"),{
 type:"bar",
 data:{
  labels: <?php echo json_encode($names); ?>,
  datasets:[{
   label:"Votes",
   data: <?php echo json_encode($votes); ?>,
   backgroundColor:"green"
  }]
 }
});
</script>

</body>
</html>
