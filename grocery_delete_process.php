<?php include_once("analyticstracking.php"); ?>

<?php

  //db연결
	require_once('command/mysql_connect.php');

  $sql = "DELETE FROM grocery_list WHERE id='{$_POST['id']}'";
  mysqli_query($conn, $sql);
  header("Location: grocery.php");

 ?>
