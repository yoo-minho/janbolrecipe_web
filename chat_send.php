<?php include_once("analyticstracking.php"); ?>

<?php
  //db연결
	require_once('command/mysql_connect.php');

  //변수
  $msg = $_POST['txt'];
  $nick = $_POST["nick"];
	$receiver = $_POST['receiver'];

	//id찾기
	$n_id_load_sql = "SELECT user_id FROM user_list WHERE user_nickname='$nick'";
	$n_id_load_result = mysqli_query($conn, $n_id_load_sql);
	$n_load_row = mysqli_fetch_array($n_id_load_result);

	$r_id_load_sql = "SELECT user_id FROM user_list WHERE user_nickname='$receiver'";
	$r_id_load_result = mysqli_query($conn, $r_id_load_sql);
	$r_load_row = mysqli_fetch_array($r_id_load_result);

	$chatspace = $r_load_row[0]."-".$n_load_row[0];
	$rechatspace = $n_load_row[0]."-".$r_load_row[0];

  //채팅방을 뒤져서
  $check_sql = "SELECT chat_room_id FROM chat_room_list WHERE chat_name = '$chatspace'";
  $check_result = mysqli_query($conn, $check_sql);
  $check_row = mysqli_fetch_array($check_result);
  $check_sql_reverse = "SELECT chat_room_id FROM chat_room_list WHERE chat_name = '$rechatspace'";
  $check_result_reverse = mysqli_query($conn, $check_sql_reverse);
  $check_row_reverse = mysqli_fetch_array($check_result_reverse);

  //둘다 없으면
  if(!isset($check_row) && !isset($check_row_reverse)){

    //신규채팅방 생성
    $create_sql = "INSERT INTO chat_room_list (chat_name) VALUES ('$chatspace')";
    $create_result = mysqli_query($conn, $create_sql);

    //채팅방 번호 확인해서 룸 아이디로
    $confirm_sql = "SELECT chat_room_id FROM chat_room_list WHERE chat_name ='$chatspace'";
    $confirm_result = mysqli_query($conn, $confirm_sql);
    $confirm_row = mysqli_fetch_array($confirm_result);
    $room_id = $confirm_row[0];

    //존재하면 해당 번호 룸 아이디로
    } else if(isset($check_row) && !isset($check_row_reverse)) {
      $room_id = $check_row[0];
    } else if(!isset($check_row) && isset($check_row_reverse)) {
      $room_id = $check_row_reverse[0];
    }

    //메시지 생성
    $msg_sql = "INSERT INTO chat (chat_room_id, user_id, message)
    VALUES ('$room_id', '$n_load_row[0]', '$msg' )";
    $msg_result = mysqli_query($conn, $msg_sql);

?>
