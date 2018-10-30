<!-- php display_errors on -->
<!-- php opcache.enable = 0 -->

<!-- 상단 영역 -->
<?php require_once('view/0_top.php'); ?>

<div class="container">

<?php
  $nick = $_GET['nick'];

  //id찾기
  $n_id_load_sql = "SELECT user_id FROM user_list WHERE user_nickname='$nick'";
  $n_id_load_result = mysqli_query($conn, $n_id_load_sql);
  $n_load_row = mysqli_fetch_array($n_id_load_result);
?>

<div class="row">

    <div class="col-sm-4">
      <div class="panel panel-default" style="padding:10px;">
        <!--채팅목록-->
        <div class="panel-body" style="text-align:center;">
            <h3 style="margin:0px"><?=$nick?>님의 채팅목록</h3>
        </div>
        <div class="list-group">
          <?php
          if($nick !== "관리자"){
            ?>
          <span class="list-group-item">
            <strong>관리자</strong>에게 문의하기
            <form style="display:inline; float:right; margin-right:10px;" action="/chat_manager.php" method="get">
              <input type="hidden" name="nick" value=<?=$nick?>>
              <input type="hidden" name="receiver"value="관리자">
              <button class='btn btn-success btn-xs' type="submit">채팅
                <span class='glyphicon glyphicon-comment'></span></button>
            </form>
          </span>
          <?php
          }
          //리시버 찾기
          $room_check_sql = "SELECT chat_name FROM chat_room_list;";
          $room_check_result = mysqli_query($conn, $room_check_sql);
          $no_data = 0;
          while($room_check_row = mysqli_fetch_array($room_check_result)){;
            $strp = strpos($room_check_row['chat_name'], $n_load_row[0]);
            //채팅방 개수 추적 상수 : 0개이면 말을 꺼내도록

            //리시버가 존재한다면
            if(strpos($room_check_row['chat_name'], $n_load_row[0])
            || strpos($room_check_row['chat_name'], $n_load_row[0]) === 0 ){
              $no_data++;
              $pre_receiver = str_replace($n_load_row[0],'',$room_check_row['chat_name']);
              $num_receiver = str_replace('-','',$pre_receiver);

              $sql = "SELECT user_nickname FROM user_list WHERE user_id='$num_receiver'";
              $result = mysqli_query($conn, $sql);
              $row = mysqli_fetch_array($result);

              $receiver = $row[0];

              if($receiver !== "관리자"){
          ?>
          <span class="list-group-item">
            <strong><?=$receiver?></strong>님과 채팅방
            <form style="display:inline; float:right; margin-right:10px;" action="/chat_manager.php" method="get">
              <input type="hidden" name="nick" value=<?=$nick?>>
              <input type="hidden" name="receiver"value=<?=$receiver?>>
              <button class='btn btn-success btn-xs' type="submit">채팅
                <span class='glyphicon glyphicon-comment'></span></button>
            </form>
          </span>
          <?php
            }
          }
        }
        if($no_data == 0){
          echo "<span class='list-group-item'> 채팅내역이 존재하지 않습니다 </span>";
        }
        ?>
        </div>
      </div>
    </div>

    <?php
        if(isset($_GET['receiver'])){
          $receiver = $_GET['receiver'];
        } else {
          $receiver = "선택바람";
        }
     ?>

    <div class="col-sm-8">
      <div class="panel panel-default" style="padding:10px;">
        <iframe src="/chat.php?nick=<?=$nick?>&receiver=<?=$receiver?>"
            width="100%" height="520px">
        </iframe>
      </div>
    </div>

</div>

<!-- HTML 하단 영역 -->
<?php require_once('view/bottom.php');?>
