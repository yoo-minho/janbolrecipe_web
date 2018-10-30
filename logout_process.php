<?php include_once("analyticstracking.php"); ?>

<?php

  session_start();
  //세션과 쿠키를 소멸시킨다.
  $res = session_destroy();
  setcookie("user_check",NULL,0,"/");

  if($res){
    header('Location: index.php');
  }

?>
