<?php include_once("analyticstracking.php"); ?>

<?php
  //db연결
	require_once('command/mysql_connect.php');

  //변수
	$id = $_POST['id'];
  $pn = $_POST['user_phonenumber'];
	$nick = $_POST['user_nickname'];
	$pw=md5($_POST['user_password']);

	$pw_check_sql = "SELECT user_password FROM user_list WHERE user_id='$id'";
	$pw_check_result = mysqli_query($conn, $pw_check_sql);
	$pw_chcek_row = mysqli_fetch_array($pw_check_result);

	if( $pw_chcek_row[0] != $pw){
		echo "<script>";
		echo "alert('비밀번호가 일치하지않습니다!');";
		echo "window.location.replace('user_edit.php?nick=".$nick."');";
		echo "</script>";
		exit(); //php 기능 쓰지 않음.

	} else {

		//빈칸 체크
		if( $nick == NULL || $pn == NULL){
			echo "<script>";
			echo "alert('빈칸을 모두 채워주세요!');";
			echo "window.location.replace('user_edit.php?nick=".$nick."');";
			echo "</script>";
			exit(); //php 기능 쓰지 않음.

		} else {

				$my_check_sql = "SELECT user_nickname FROM user_list WHERE user_id='$id'";
				$my_check_result = mysqli_query($conn, $my_check_sql);
				$my_chcek_row = mysqli_fetch_array($my_check_result);

				$id_check_sql = "SELECT user_nickname FROM user_list WHERE user_nickname='$nick'";
				$id_check_result = mysqli_query($conn, $id_check_sql);

				if($id_chcek_row = mysqli_fetch_array($id_check_result)){

					//본인의 아이디를 제외하고
					if($my_chcek_row[0] != $id_chcek_row[0]){
						echo "<script>";
						echo "alert('중복되는 닉네임입니다.');";
						echo "window.location.replace('user_edit.php?nick=".$nick."');";
						echo "</script>";
						exit(); //php 기능 쓰지 않음.
					}
				}

				//핸드폰 번호 자리수 체크
				if(strlen($pn)!=11){
					echo "<script>";
					echo "alert('전화번호 11자리를 제대로 입력해주세요!');";
					echo "window.location.replace('user_edit.php?nick=".$nick."');";;
					echo "</script>";
					exit(); //php 기능 쓰지 않음.
				}

		}

		$user_edit_sql="UPDATE user_list SET
		user_nickname = '$nick', user_phonenumber = '$pn'
		WHERE user_id='$id'";
		$user_edit_result = mysqli_query($conn, $user_edit_sql);

		if($user_edit_result){
			echo "<script>";
			echo "alert('회원정보가 수정되었습니다!');";
			echo "window.location.replace('index.php');";
			echo "</script>";
			exit(); //php 기능 쓰지 않음.
		} else {
			echo "수정실패";
		}

	}
	 ?>
