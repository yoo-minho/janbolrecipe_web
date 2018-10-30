<?php include_once("analyticstracking.php"); ?>

<!-- 쿠키영역 -->
<?php
  $i = 0;
  //이미 쿠키가 있다면 원래 있던 쿠키를 없애서 중복되지 않게 한다.
  if(isset($_GET['class']) && isset($_GET['recipe'])){
    if(isset($_COOKIE['number'])){
      $i = $_COOKIE['number'];
      for ($j=0; $j < $i ; $j++) {
        if(isset($_COOKIE["class".$j]) && isset($_COOKIE["recipe".$j])){
          if($_COOKIE["class".$j] === $_GET['class']
          && $_COOKIE["recipe".$j] === $_GET['recipe']){
            setcookie("class".$j,NULL,0,"/");
            setcookie("recipe".$j,NULL,0,"/");
          }
        }
      }
    }
    setcookie("class".$i,$_GET['class'],time()+3600,"/");
    setcookie("recipe".$i,$_GET['recipe'],time()+3600,"/");
    setcookie("number",$i+1,time()+3600,"/");

  }
  header('Location: index.php?class='.$_GET['class']."&recipe=".$_GET['recipe']);
?>

<!-- HTML 하단 영역 -->
<?php require_once('view\bottom.php');?>
