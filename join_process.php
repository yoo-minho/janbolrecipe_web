<?php include_once("analyticstracking.php"); ?>

<?php
  //db연결
	require_once('command/mysql_connect.php');

  //변수
  $email=$_POST['user_email'];
  $pw=md5($_POST['user_password']);
  $pwc=md5($_POST['user_password_confirm']);
  $nick=$_POST['user_nickname'];
  $pn=$_POST['user_phonenumber'];

  //빈칸 체크
  if( $email==NULL && $pw == NULL && $nick == NULL || $pn == NULL){
    echo "<script>";
    echo "alert('빈칸을 모두 채워주세요!');";
    echo "window.location.replace('join.php');";
    echo "</script>";
    exit(); //php 기능 쓰지 않음.

  } else {
    //비번 체크
    if($pw!=$pwc){
      echo "<script>";
      echo "alert('비밀번호 확인란이 일치하지 않습니다');";
      echo "window.location.replace('join.php');";
      echo "</script>";
      exit(); //php 기능 쓰지 않음.

    } else {

      $id_check_sql = "SELECT user_email, user_nickname FROM user_list WHERE user_email='$email' OR user_nickname='$nick'";
      $id_check_result = mysqli_query($conn, $id_check_sql);
      if($id_chcek_row = mysqli_fetch_array($id_check_result)){
        echo "<script>";
        echo "alert('중복되는 이메일 혹은 닉네임입니다.');";
        echo "window.location.replace('join.php');";
        echo "</script>";
        exit(); //php 기능 쓰지 않음.
      }

      //비번 자리수 체크
      if( strlen($_POST['user_password']) < 8 ){
        echo "<script>";
        echo "alert('비밀번호를 8자리 이상으로 만들어주세요!');";
        echo "window.location.replace('join.php');";
        echo "</script>";
        exit(); //php 기능 쓰지 않음.
      }

      //닉네임 자리수 체크
      if(mb_strlen($nick, 'utf-8')<2 && mb_strlen($nick, 'utf-8')>10 && $nick == '관리자'){
        echo "<script>";
        echo "alert('닉네임 자릿수를 지켜주세요!');";
        echo "window.location.replace('join.php');";
        echo "</script>";
        exit(); //php 기능 쓰지 않음.
      }

      //핸드폰 번호 자리수 체크
      if(strlen($pn)!=11){
        echo "<script>";
        echo "alert('전화번호 11자리를 제대로 입력해주세요!');";
        echo "window.location.replace('join.php');";
        echo "</script>";
        exit(); //php 기능 쓰지 않음.
      }
    }
  }

  //데이터베이스 중복여부
  $sql="SELECT * FROM user_list WHERE user_email='$email'";
  $result=mysqli_query($conn, $sql);
  if($row=mysqli_fetch_array($result)){
    echo "<script>";
    echo "alert('중복된 아이디입니다!');";
    echo "window.location.replace('join.php');";
    echo "</script>";
    exit(); //php 기능 쓰지 않음.
  }

  $join_sql="INSERT INTO user_list
  (user_email, user_password, user_nickname, user_phonenumber) VALUES
  ('$email', '$pw', '$nick', '$pn')";
  $join_result=mysqli_query($conn, $join_sql);
  if($join_result){

		$sql = "SELECT user_id FROM user_list WHERE user_email='$email'";
		$result = mysqli_query($conn,$sql);
		if($row = mysqli_fetch_array($result)){
			//회원가입과 동시에 장바구니 생성
			$make_sl_sql="INSERT INTO shopping_list
			(user_id) VALUES ('$row[0]')";
			mysqli_query($conn, $make_sl_sql);

			echo "<script>";
			echo "alert('회원가입되었습니다!');";
			echo "window.location.replace('login.php');";
			echo "</script>";
			exit(); //php 기능 쓰지 않음.
		}
  }
 ?>
