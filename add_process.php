<?php include_once("analyticstracking.php"); ?>

<?php
  //db연결
  require_once('command/mysql_connect.php');

  //변수
  $class = $_GET['class'];
  $recipe = $_POST['recipe'];
  $meal = $_POST['meal'];
  $video_code = $_POST['video_code'];

  //소스 바코드화
  $seasoning_number = "1";
  for ($i=0; $i < 8 ; $i++) {
    $seasoning_number = $seasoning_number.$_POST['seasoning'.$i]/0.5;
  }

//데이터베이스 인서트
$sql = "INSERT INTO recipe_list
    (class, recipe, meal, video_code,
    seasoning,
    grocery0, gram0,
    grocery1, gram1,
    grocery2, gram2,
    grocery3, gram3,
    grocery4, gram4,
    grocery5, gram5) VALUES
    ('$class', '$recipe', '$meal', '$video_code',
    '$seasoning_number',
    '{$_POST['grocery0']}', '{$_POST['gram0']}',
    '{$_POST['grocery1']}', '{$_POST['gram1']}',
    '{$_POST['grocery2']}', '{$_POST['gram2']}',
    '{$_POST['grocery3']}', '{$_POST['gram3']}',
    '{$_POST['grocery4']}', '{$_POST['gram4']}',
    '{$_POST['grocery5']}', '{$_POST['gram5']}')";

$result = mysqli_query($conn, $sql);
if($result === false){
  echo mysqli_error($conn);
} else {
  header('Location: index.php?class='.$class."&recipe=".$recipe);
}

?>
