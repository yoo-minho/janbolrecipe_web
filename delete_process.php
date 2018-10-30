<?php include_once("analyticstracking.php"); ?>

<?php

  //db연결
	require_once('command/mysql_connect.php');

  //변수
  $class = $_POST['class'];
  $recipe = $_POST['recipe'];

  $sql = "DELETE FROM recipe_list WHERE class='$class' && recipe='$recipe'";
  mysqli_query($conn, $sql);
  header("Location: index.php?class=".$class);
 ?>
