<?php include_once("analyticstracking.php"); ?>

<?php

//db연결
	require_once('command/mysql_connect.php');

//변수
	session_start();
	$id = $_SESSION['user_id'];
	$class = $_GET['class'];
	$recipe = $_GET['recipe'];
	$meal = $_GET['meal'];

	$nick_check_sql = "SELECT * FROM shopping_list WHERE user_id='$id'";
	$nick_check_result =  mysqli_query($conn, $nick_check_sql);
	$nick_check_row = mysqli_fetch_array($nick_check_result);

	$shopping_list_load_sql = "SELECT * FROM shopping_list WHERE user_id='$id'";
	$shopping_list_load_result = mysqli_query($conn, $shopping_list_load_sql);
	$shopping_list_load_row = mysqli_fetch_array($shopping_list_load_result);
	$shopping_number = 0;
	for ($i=0; $i <5 ; $i++) {
		if(isset($shopping_list_load_row['class'.$i])){
			$shopping_number = $shopping_number+1;
		}
	}

	if($shopping_number === 5){
	?>
		<script>
			alert('장볼리스트 공간이 모두 찼습니다.\n장볼리스트에서 삭제 후 담아주세요!');
			location="index.php?class=<?=$class?>&recipe=<?=$recipe?>";
		</script>
	<?php
	}

for ($i=0; $i < 5 ; $i++) {
    if(!isset($nick_check_row['class'.$i])){
      $sql = "UPDATE shopping_list SET class".$i
      ." = '$class', recipe".$i." = '$recipe',meal".$i
      ." = '$meal' WHERE user_id='$id'";
      $i = 6;
    } else {
      $sql = "SELECT * FROM shopping_list";
      if($nick_check_row['class'.$i] === $class){
        if($nick_check_row['recipe'.$i] === $recipe){
        ?>
        <script>
          alert('중복된 레시피입니다! 장볼리스트에서 삭제 후 추가해주세요!');
          location="index.php?class=<?=$class?>&recipe=<?=$recipe?>";
        </script>
        <?php
        exit();
        }
      }
    }
}

$result = mysqli_query($conn, $sql);
if($result === false){
  echo mysqli_error($conn);
} else {
		?>
		<script>
			alert('<?=$class?>의 <?=$recipe?> 레시피가 장볼리스트에 저장되었습니다.\n장볼리스트는 사이트 상단에 있는 버튼을 눌러주세요!');
			location="index.php?class=<?=$class?>&recipe=<?=$recipe?>";
		</script>
		<?php
}
?>
