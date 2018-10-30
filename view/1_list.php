<!--크리에이터 이름, 채팅-------------------------------------------------------->

<div class="panel panel-default" style="padding:10px;">
  <!--크리에이터 이름-->
  <div class="panel-body" style="text-align:center;">
      creator
      <h3><?=$class?></h3>
  </div>

  <!--채팅-->
  <?php
  //겟클래스 존재할때 : 크리에이터 선택 시
  if($class !== "선택필요"){
    //겟클래스와 닉네임세션이 다를때 : 크리에이터 본인이 아닐 시
    if($class !== $nick){
      //닉네임 세션 존재할때 : 로그인 시
      if($nick !== "게스트"){
  ?>
    <!-- 1대1 문의 가능 -->
    <form style="display:inline;" id='myform' name='myform' action="/chat.php"
      target="popup_window">
      <input type="hidden" name="nick" value=<?=$nick?>>
      <input type="hidden" name="receiver" value=<?=$class?>>
      <button type="button" class="btn btn-info btn-block" id="btn_submit">
        <span class='glyphicon glyphicon-comment'></span>　1:1 문의하기
      </button>
    </form>

    <!-- 채팅 팝업 로드 -->
    <script type="text/javascript">
      $(document).ready(function(){
        $("#btn_submit").on("click",function(){
          window.open('','popup_window',
          'width=360 height=530');
          $("#myform").submit();
        });
      });
    </script>

    <?php
      } else {
        //닉네임이 게스트인 경우 : 게스트로 접속시
        ?>
        <a href="login.php">
          <button type='button' class='btn btn-info btn-block'>
              문의는 로그인 필요
            </button>
        </a>
        <?php
      }
    } else {
      //크리에이터와 닉네임이 같을때 : 본인 페이지 접속시
      echo "<button type='button' class='btn btn-info btn-block'>
          <span class='glyphicon glyphicon-user'></span>　본인 페이지
        </button>";
    }

    ?>
</div>
<!--크리에이터 이름, 채팅 끝----------------------------------------------------->

<!--레시피 목록 시작------------------------------------------------------------>
<?php

  //크리에이터 레시피 개수 확인 : 게시판 페이징
  $total_check_sql = "SELECT count(*) FROM recipe_list WHERE class='$class'";
  $total_check_result = mysqli_query($conn, $total_check_sql);
  $total_check_row = mysqli_fetch_array($total_check_result);

  //전체 게시물 개수
  $total_count = $total_check_row[0];

  //한 페이지 보여줄 게시물 개수
  $count_list = 10;

  //현재 페이지 번호, 없으면 1로 처리
  if(isset($_GET['page'])){
    $page = $_GET['page'];
  }else{
    $page = 1;
  }

  //한 화면 출력될 페이지 수 : 12345 아래바
  $count_page = 5;

  //오프셋 상수 :  SQL문 필요, 어디부터 몇 개를 나열하는지
  $offset_n = $count_list*($page-1);

  //페이지 개수 : 나머지가 있으면 페이지수 + 1
  $cal_total_page = $total_count/$count_list;
  if($cal_total_page-(int)$cal_total_page > 0 ){
    $total_page = (int)$cal_total_page + 1;
  } else {
    $total_page = (int)$cal_total_page;
  }

  //페이지 하단바의 시작과 끝
  $start_page = (int)(($page-1)/$count_page)*$count_page+1;
  $end_page = $start_page + $count_page - 1;

  //하단바 끝 설정
  if ($end_page > $total_page) {
    $end_page = $total_page;
  }

  //크리에이터의 레시피를 모두 가져옴
  $sql = "SELECT recipe FROM recipe_list WHERE class='$class' ORDER BY id DESC LIMIT $count_list OFFSET $offset_n";
  $result = mysqli_query($conn, $sql);

  //크리에이터의 레시피를 리스트로 표현함
  echo '<div class="list-group">
  <a href="#" class="list-group-item disabled">레시피목록</a>';

    while ($row = mysqli_fetch_array($result) ){
      ?>
        <a href="cookie.php?class=<?=$class?>&recipe=<?=$row['recipe']?>"
          class="list-group-item"><?=$row['recipe']?></a>
      <?php
    }

    //페이징 하단바 생성
    echo '<center><ul class="pagination pagination-sm" style="text-align:center;">';
    for ($i=$start_page; $i <= $end_page ; $i++) {
      echo "<li><a href='?class=$class&recipe=$recipe&page=$i'>";
      if( $i === (int)$page ){
        echo "<strong>".$i."</strong>";
      } else { echo $i;}
      echo "</a></li>";}
    echo '</ul></center></div>';

} else {
  //크리에이터가 만든이일때 : 최초 접속시
  ?>
  </div>

  <div class="panel panel-default" style="padding:10px;">
    <p style='text-align:center'><button class='btn btn-warning btn-xs'>
      도움말</button></p>
    <h6 style='text-align:center'>최상단의 크리에이터를 선택하면
      해당 크리에이터의 레시피목록이 이 공간에 표시됩니다.</h6>
  </div>

  <?php
}
?>

<!--레시피 목록 끝-------------------------------------------------------------->

<!--최근조회시작---------------------------------------------------------------->

<div class="panel panel-default">
  <div class="panel-heading">
    최근 조회
  </div>
  <div class="panel-body">
    <?php
    //최근 조회 관련 쿠키가 있다면
    if(isset($_COOKIE['number'])){
      $limit_number = 0;
      for ($i = $_COOKIE['number']-1 ; $i > -1 ; $i--) {
        //최근 5개항목의 크리에이터와 레시피를 조회해서
        if($limit_number !== 5){
          if(isset($_COOKIE['class'.$i]) && isset($_COOKIE['recipe'.$i])){
            $limit_number = $limit_number + 1;
            ?>
              <!-- 유알엘을 담아 나열해줘 -->
              <p><a href="index.php?class=<?=$_COOKIE['class'.$i]?>&recipe=<?=$_COOKIE['recipe'.$i]?>">
                <button type="button" class="btn btn-default btn-xs">
                  <?php echo mb_substr($_COOKIE['class'.$i],0,4)."-".mb_substr($_COOKIE['recipe'.$i],0,4);?>
                </button></a></p>
            <?php
          }
        }
      }
      ?>

    </div>
  </div>


      <?php
    } else {
      ?>
      <p style='text-align:center'><button class='btn btn-warning btn-xs'>
        도움말</button></p>
      <h6 style='text-align:center'>최근 조회한 크리에이터의 레시피가 최대 5개까지
        이 공간에 표시됩니다.</h6>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-body">
        <a href="https://goo.gl/forms/wXNx82rQ2hKbW0n33" target="_blank">
          <img class="img-responsive img-rounded" src="image/banner4.png" width="100%">
        </a>
      </div>
    </div>
  <?php
}
?>


<!--최근조회끝------------------------------------------------------------------>
