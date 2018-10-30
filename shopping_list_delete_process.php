<?php include_once("analyticstracking.php"); ?>

<?php
//db연결
	require_once('command/mysql_connect.php');

//변수
$nick = $_POST['nick'];
$state = $_POST['delete'];
$class = $_POST['class'];
$recipe = $_POST['recipe'];
if(isset($_POST['num'])){
  $num = $_POST['num'];
}

//id찾기
$n_id_load_sql = "SELECT user_id FROM user_list WHERE user_nickname='$nick'";
$n_id_load_result = mysqli_query($conn, $n_id_load_sql);
$n_load_row = mysqli_fetch_array($n_id_load_result);

//개별선택삭제
if($state === "select"){

  $sql = "UPDATE shopping_list SET class".$num."= NULL, recipe".$num."= NULL, meal".$num."= NULL WHERE user_id='$n_load_row[0]'";
  $result = mysqli_query($conn, $sql);
  header("Location: index.php?class=".$class."&recipe=".$recipe);

//전체삭제
} else {

    for ($j=0; $j < 5 ; $j++) {
      $sql = "UPDATE shopping_list SET "
        ."class".$j."= NULL, recipe".$j."= NULL, meal".$j."= NULL  WHERE user_id='$n_load_row[0]'";
      $result = mysqli_query($conn, $sql);
    }
    header("Location: index.php?class=".$class."&recipe=".$recipe);

}

?>
