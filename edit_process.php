<?php include_once("analyticstracking.php"); ?>

<?php
  //db연결
	require_once('command/mysql_connect.php');

  //변수
  $class = $_GET['class'];
  $recipe = $_GET['recipe'];
  $new_recipe = $_POST['recipe'];
  $meal = $_POST['meal'];
  $video_code = $_POST['video_code'];

  //소스 바코드화
  $seasoning_number = "1";
  for ($i=0; $i < 8 ; $i++) {
    $seasoning_number = $seasoning_number.$_POST['seasoning'.$i]/0.5;
  }

//데이터베이스 업데이트
$sql = "UPDATE recipe_list SET
    class = '$class',
    recipe = '$new_recipe',
    meal= '$meal',
    video_code = '$video_code',
    seasoning = '$seasoning_number',
    grocery0 = '{$_POST['grocery0']}',
    gram0 = '{$_POST['gram0']}',
    grocery1 = '{$_POST['grocery1']}',
    gram1 = '{$_POST['gram1']}',
    grocery2 = '{$_POST['grocery2']}',
    gram2 = '{$_POST['gram2']}',
    grocery3 = '{$_POST['grocery3']}',
    gram4 = '{$_POST['gram3']}',
    grocery4 = '{$_POST['grocery4']}',
    gram4 = '{$_POST['gram4']}',
    grocery5 = '{$_POST['grocery5']}',
    gram5 = '{$_POST['gram5']}'
    WHERE class = '$class' && recipe = '$recipe'";

$result = mysqli_query($conn, $sql);
if($result === false){
  echo mysqli_error($conn);
} else {
  header('Location: index.php?class='.$class."&recipe=".$new_recipe);
}
?>
