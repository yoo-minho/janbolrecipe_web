<?php
  //발신자, 수신자 설정
  $nick = $_GET['nick'];
  $receiver = $_GET['receiver'];
?>

<!doctype html>
<html>
  <?php include_once("analyticstracking.php"); ?>
  <head>
  	<title><?=$receiver?>에게 도움요청</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/style.css?ver=1">

    <!-- 부트스트랩 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- 제이쿼리, 최초팝업, 팝업함수 js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- 세션 및 mysql -->
    <?php
	   require_once('command/mysql_connect.php');
    ?>

  </head>

  <body>
      <script>
          //첫 접속시 체크
          var first_number = true;

          //1.5초마다 챗오토 갱신
          window.setInterval("chat_auto()", 1000);

          //챗오토 fetch api 연결
          function chat_auto(){
            fetch('chat_auto.php', {
                method : "POST",
                headers : {
                  "Content-Type" : "application/x-www-form-urlencoded"
                },
                body : "nick=<?=$nick?>&receiver=<?=$receiver?>"
              })
              .then(function(response){
              response.text().then(function(text){
                document.querySelector('#chatbox').innerHTML = text;
                if( first_number ){
                  scroll_bottom();
                  first_number = false;
                }
              })
            });
          }

          //챗센드 fetch api 연결
          function chat_send(){
            var i = document.getElementById('txtarea').value;
            fetch("chat_send.php", {
                method : "POST",
                headers : {
                  "Content-Type" : "application/x-www-form-urlencoded"
                },
                body : "txt="+i+"&nick=<?=$nick?>&receiver=<?=$receiver?>"
              })
            .then(function(response){
              response.text().then(function(text){
                document.querySelector("#hiddenbox").innerHTML = text;
                first_number = true;
              })
            });
            document.getElementById("txtarea").value = "";
            window.setTimeout("chat_auto()", 10);
          }

          //스크롤 아래로 가는 함수
          function scroll_bottom(){
            var objDiv = document.getElementById("chatbox");
            objDiv.scrollTop = objDiv.scrollHeight;
          }

          //엔터치면 문자 보내지는 함수
          function enter_key_press(){
            if(event.keyCode == 13){
              chat_send();
              return false;
            }
          }
      </script>

      <div class="container">
        <div class="panel-body" style="text-align:center;">
          <center>
            <button class="btn btn-success btn-block" style="text-align:center">
              채팅방 : From. <?=$nick?> --> To. <?=$receiver?>
            </button>

            <?php

            if($receiver !== "선택바람"){

            ?>
            <!-- fetch api로 챗오토연결 지점 -->
            <div id="chatbox" class="list-group">
            </div>

            <!-- 전송 -->
            <div id="chat_input">
              <input id="txtarea" class="form-control" type="text" name="txtarea"
              onkeypress="enter_key_press()">
          		<button class='btn btn-info' type="button" onclick='chat_send();'
              style="margin-left:10px;">
                전송
              </button>
            </div>

            <!-- fetch api로 채팅보내기함수div -->
            <div id="hiddenbox" style="display: block;">
            </div>
            <?php
            }
             ?>
          </center>
        </div>
        </div>
      </body>
  </html>
