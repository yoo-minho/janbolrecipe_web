<?php include_once("analyticstracking.php"); ?>

<?php
  //db연결
	require_once('command/mysql_connect.php');

  //변수
  $email=$_POST['user_email'];
  $pw=md5($_POST['user_password']);

  if(isset($email)){
    $sql = "SELECT user_id, user_password FROM user_list WHERE user_email='$email'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    if($row['user_password']==$pw){

      //정보 세션화 : 이메일과 비번을 세션화 할 필요는 없다.
      $_SESSION['user_id']=$row['user_id'];

      //15일 동안 자동로그인 상태를 유지할 수 있도록 쿠키화
      setcookie("user_check",$row['user_id'],time()+ 86400 * 15,"/");

      header('Location: index.php');

    } else {

      echo "<script>";
      echo "alert('아이디 혹은 비밀번호가 잘못되었습니다!');";
      echo "window.location.replace('index.php');";
      echo "</script>";

    }
  }
 ?>
