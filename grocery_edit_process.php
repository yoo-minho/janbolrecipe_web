<?php include_once("analyticstracking.php"); ?>

<?php
  //db연결
	require_once('command/mysql_connect.php');

  //데이터베이스 업데이트
  $sql = "UPDATE grocery_list SET
     grocery_name = '{$_POST['grocery_name']}',
     price_100g = '{$_POST['price_100g']}',
     reference= '{$_POST['reference']}',
     gram_unit = '{$_POST['gram_unit']}',
     unit = '{$_POST['unit']}',
     calorie_100g = '{$_POST['calorie_100g']}',
     etc = '{$_POST['etc']}'
     WHERE id = '{$_POST['id']}'";

  $result = mysqli_query($conn, $sql);
  if($result === false){
    echo mysqli_error($conn);
  } else {
    header('Location: grocery.php');
  }


 ?>
