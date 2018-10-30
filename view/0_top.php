<!doctype html>
<html>

  <head>
    <?php include_once("analyticstracking.php"); ?>
    <title>장볼레시피 : 색다른 장보기의 시작</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="/css/style.css?ver=1">
    <link href="https://fonts.googleapis.com/css?family=Nanum+Gothic&amp;subset=korean" rel="stylesheet">

    <!-- 부트스트랩 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="/css/bootstrap.css?ver=1">
    <script src="/js/bootstrap.js"></script>

    <!-- 제이쿼리, 최초팝업, 팝업함수 js -->

    <script type="text/javascript" src="js/popup.js"></script>
    <!-- 팝업 로드 -->
    <!-- <script type="text/javascript">
      // 만들 팝업창 좌우 크기의 1/2 만큼 보정값으로 빼주었음
      var popupX = (window.screen.width / 2) - (340 / 2);
      var popupY= (window.screen.height /2) - (365 / 2);

      if( getCookie('popupcheck') != 'limit' ){
        window.open('popup.html','안녕',
        'width=340 height=365 menubar=no left='+ popupX + ', top='+ popupY + ', screenX='+ popupX + ', screenY= '+ popupY);
      }
    </script> -->

    <!-- 세션 및 mysql -->
    <?php
      session_start();
      require_once('command/mysql_connect.php');
    ?>
  </head>

  <!--------------------------------------------------------------------------->

  <?php
  //전역변수
  if(isset($_GET['class'])){
    $class = $_GET['class'];
  } else {
    $class = "선택필요";
  }
  if(isset($_GET['recipe'])){
    $recipe = $_GET['recipe'];
  } else {
    $recipe = "요리법";
  }

  //uri파악
  $request_uri = $_SERVER['REQUEST_URI'];

  //레시피 개수 계산
  $class_sql = "SELECT COUNT(DISTINCT class) FROM recipe_list;";
  $recipe_sql = "SELECT COUNT(*) FROM recipe_list;";
  $class_result = mysqli_query($conn, $class_sql);
  $recipe_result = mysqli_query($conn, $recipe_sql);
  $class_row = mysqli_fetch_array($class_result);
  $recipe_row = mysqli_fetch_array($recipe_result);

  ?>

<!----------------------------------------------------------------------------->

<?php
  //로그인 쿠키가 있다면 세션값을 전달하기
  if(isset($_COOKIE['user_check'])){
    $nick_cookie = $_COOKIE['user_check'];
    $user_check_sql = "SELECT user_id FROM user_list WHERE user_id='$nick_cookie'";
    $user_check_result = mysqli_query($conn, $user_check_sql);
    if( $user_check_row = mysqli_fetch_array($user_check_result)){
      $_SESSION['user_id'] = $user_check_row['user_id'];
    }
  }
?>

  <!-- 본문시작 -->
  <body>

    <div class="container-fluid" style="padding:0px;">
      <!----------------------------------------------------------------------------->

      <nav class="navbar navbar-inverse"
      style="border-radius:0px; border:0px solid; margin-bottom: 0px;
      text-align:right">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">
              <p style="color:white">장볼레시피 : <span style="font-size:16px; color:#f0ad4e">색다른 장보기의 시작</span></p>
            </a>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
              <?php
                //닉네임 값이 살아있다면 닉에 넣고
                if(isset($_SESSION['user_id'])){
                  $id = $_SESSION['user_id'];

                  $nick_load_sql = "SELECT user_nickname FROM user_list WHERE user_id='$id'";
                  $nick_load_result = mysqli_query($conn, $nick_load_sql);
                  if($nick_load_row = mysqli_fetch_array($nick_load_result)){
                      $nick = $nick_load_row[0];
                  }

                  //관리자모드시작
                    if($nick === '관리자' || $nick === $class){
                      ?>
                      <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                          <span class="glyphicon glyphicon-cog"></span>
                          관리자 권한
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu" style="text-align:right">
                          <li><a href='/user.php'>회원관리</a></li>
                          <li><a href='/grocery.php'>식재료관리</a></li>
                          <?php
                          if($class !== '선택필요'){
                            ?>
                              <li><a href='add.php?class=<?=$class?>'>레시피추가</a></li>
                            <?php
                            if($recipe !== '요리법'){
                              ?>
                              <li><a href='edit.php?class=<?=$class?>&recipe=<?=$recipe?>'>레시피수정</a></li>
                              <li><form action="delete_process.php" method="post">
                                <input type="hidden" name="class" value='<?=$class?>'>
                                <input type="hidden" name="recipe" value='<?=$recipe?>'>
                                <input type="submit" class='btn btn-danger btn-xs' value="레시피삭제" style="margin-right:18px"
                                onclick="return confirm('레시피를 삭제하겠습니다.')">
                              </form></li>
                              <?php
                            }
                          }
                          ?>
                        </ul>
                      </li>
                      <?php
                    }

                  if($request_uri !=="/payment.php"){
              ?>
              <li type="button" data-toggle="modal" data-target="#myModal">
                <a style="cursor:pointer">
                <span class='glyphicon glyphicon-shopping-cart'></span> 장볼리스트
                <span class="caret"></span>
              </a></li>
            <?php } ?>
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                  <span class="glyphicon glyphicon-heart"></span>
                  마이페이지
                <span class="caret"></span></a>
                <ul class="dropdown-menu" style="text-align:right">
                  <li><a href="chat_manager.php?nick=<?=$nick?>">채팅리스트</a></li>
                  <li><a href="payment_manager.php?nick=<?=$nick?>">결제페이지</a></li>
                  <li><a href="user_edit.php?nick=<?=$nick?>">회원정보수정</a></li>
                  <li><a href="logout_process.php?nick=<?=$nick?>">
                  <span class="glyphicon glyphicon-log-out"></span> 로그아웃</a></li>
                </ul>
              </li>


      <?php } else {

            $nick="게스트";

            ?>
            <li><a href="join.php"><span class="glyphicon glyphicon-user"></span> 회원가입</a></li>
            <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> 로그인</a></li>

      <?php } ?>
        </ul>
      </div>
    </div>
  </nav>
</div>

    <!-- The Modal -->
    <div class="modal modal fade " id="myModal">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title" style="display:inline"><b><?=$nick?></b>님의 리스트</h4>
            <button type="button" class="close" data-dismiss="modal">
              <span class='glyphicon glyphicon-remove' style="float:right"></span>
            </button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <?php require_once('view/3_shopping_list.php');?>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>

        </div>
      </div>
    </div>

<!--내비끝---------------------------------------------------------------------->
