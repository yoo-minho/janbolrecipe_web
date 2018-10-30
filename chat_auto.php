<?php include_once("analyticstracking.php"); ?>

<?php
	//db연결
	require_once('command/mysql_connect.php');

	//변수
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
	$room_check_sql = "SELECT chat_room_id FROM chat_room_list WHERE chat_name = '$chatspace'";
	$room_check_result = mysqli_query($conn, $room_check_sql);
	$room_check_row = mysqli_fetch_array($room_check_result);
	$room_check_sql_reverse = "SELECT chat_room_id FROM chat_room_list WHERE chat_name = '$rechatspace'";
	$room_check_result_reverse = mysqli_query($conn, $room_check_sql_reverse);
	$room_check_row_reverse = mysqli_fetch_array($room_check_result_reverse);

	//둘 사이 채팅방을 찾았으면 룸아이디로 저장
	if(isset($room_check_row)){
		$room_id = $room_check_row[0];
	} else if (isset($room_check_row_reverse)){
		$room_id = $room_check_row_reverse[0];
	}

	//채팅방이 둘중 하나 존재한다면 500개의 메시지를 꺼내줘
	if(isset($room_check_row) || isset($room_check_row_reverse)){
		$get_chat_sql = "SELECT user_id, message, created_at FROM chat
		WHERE chat_room_id = '$room_id' ORDER BY 'created_at' ASC LIMIT 500;";
		$get_chat_result = mysqli_query($conn, $get_chat_sql);

		while($get_chat_row = mysqli_fetch_array($get_chat_result)){

			//닉네임과 세션의 닉네임이 일치하는 데이터면 오른쪽에 보여줘
			if($get_chat_row['user_id'] === $n_load_row[0]){
				?>

				<div style="display:grid; grid-template-columns: 1fr 2fr;">
					<div></div>
					<div>
						<div style="float: right;">
							<p class='item-x'><?=$get_chat_row[1]?></p>
							<p style='margin:0px; text-align:right; font-size:9px; color:white; margin-bottom: 10px;'>
								<?=$get_chat_row[2]?></p>
						</div>
					</div>
				</div>

				<?php
			}

			//닉네임이 일치하지 않으면 왼쪽에 보여줘
			else
			{
				?>
				<div style="display:grid; grid-template-columns: 2fr 1fr;">
					<div>
						<div style="float: left;">
							<p style='margin:0px; font-size:14px; text-align:left; color:white;'><?=$receiver?></p>
							<p class="item"><?=$get_chat_row[1]?></p>
							<p style='margin-bottom: 10px; text-align:left;; color:white; font-size:9px;'><?=$get_chat_row[2]?></p>
						</div>
					</div>
					<div></div>
				</div>

			<?php
			}}} else {
			//일치하는 룸이 존재하지 않으면
			?>
			<p style="color:white;"> ⓘ 대화내역이 없습니다!</p>
		<?php
		}
		?>
