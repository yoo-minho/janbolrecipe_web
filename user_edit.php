<!-- php display_errors on -->
<!-- php opcache.enable = 0 -->
<?php require_once('view/0_top.php');?>

  <div class="container">
    <div class="row">
      <div class="col-sm-3">

      </div>

      <script>
        function isEnabled(){
          var tel = document.getElementById("tel").value;
          if(tel.length < 11 || tel.length > 11){
            window.alert('핸드폰 번호를 정확히 적어주세요!');
            document.getElementById("tel").value='';
          }
        }

        function isNick(){
          var nick = document.getElementById("nick").value;
          if(nick.length < 2 || nick.length > 10 ){
            window.alert('닉네임은 2글자 이상, 10글자 이하만 이용가능합니다.');
            document.getElementById("nick").value='';
          }
        }
      </script>

      <?php

        $nick = $_GET['nick'];
        $nick_sql = "SELECT user_id, user_email, user_nickname, user_phonenumber FROM user_list WHERE user_nickname='$nick'";
        $nick_result = mysqli_query($conn, $nick_sql);
        $nick_row = mysqli_fetch_array($nick_result);
       ?>

      <div class="col-sm-6" style="margin:20px">
        <form action="user_edit_process.php" method="post">

          <input type="hidden" name="id" value=<?=$nick_row[0]?>>
          <div class="form-group">
            <label for="email">이메일 (수정 불가)<span id="email_check" style="font-size:14px"></span></label>
            <input id='email' class="form-control" type="email" name="user_email"
            value="<?=$nick_row[1]?>" onchange="isEmail()" disabled>
          </div>

          <div class="form-group">
            <label for="nick">닉네임</label>
            <input id='nick' class="form-control" type="text" name="user_nickname"
            value="<?=$nick_row[2]?>" onchange="isNick()">
          </div>

          <div class="form-group">
            <label for="tel">핸드폰번호</label>
            <input id='tel' class="form-control" type="tel" name="user_phonenumber"
            value="<?=$nick_row[3]?>" onchange="isEnabled()">
          </div>

          <hr>

          <div class="form-group">
            <label for="pwd" style="color:red">회원정보 수정을 위해서 비밀번호가 필요합니다.</label>
            <input id='pwd'class="form-control"type="password" name="user_password">
          </div>

          <br>

          <input class="btn btn-block btn-warning" type="submit" value="회원정보수정">

        </form>
      </div>
      <div class="col-sm-3">

      </div>
    </div>

  </div>

<!-- HTML 하단 영역 -->
<?php require_once('view/bottom.php');?>
