<!-- php display_errors on -->
<!-- php opcache.enable = 0 -->
<?php require_once('view/0_top.php');?>

  <div class="container">
    <div class="row">
      <div class="col-sm-3">

      </div>

      <script>
        function isSame(){
          var pwd = document.getElementById("pwd").value;
          var pwdc = document.getElementById("pwdc").value;
          if(pwd.length < 8 || pwdc.length > 16 ){
            window.alert('비밀번호는 8글자 이상, 16글자 이하만 이용가능합니다.')
            document.getElementById("pwd").value='';
            document.getElementById("same").innerHTML='';
          }
          if(pwd != '' && pwdc !=''){
            if(pwd == pwdc){
              document.getElementById("same").innerHTML='　(비밀번호가 일치합니다.)';
              document.getElementById("same").style.color='#f0ad4e';
            } else {
              document.getElementById("same").innerHTML='　(비밀번호가 일치하지 않습니다.)';
              document.getElementById("same").style.color='red';
            }
          }
        }

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

        function isEmail(){
          var email = document.getElementById("email").value;
          if(email.indexOf('@')>0 && email.indexOf('.')>0){
            document.getElementById("email_check").innerHTML='　(이메일 형식에 이상없습니다.)';
            document.getElementById("email_check").style.color='#f0ad4e';
          } else {
            document.getElementById("email_check").innerHTML='　(이메일 형식이 올바르지 않습니다.)';
            document.getElementById("email_check").style.color='red';
          }
        }
      </script>

      <div class="col-sm-6" style="margin:20px">
        <form action="join_process.php" method="post">
          <div class="form-group">
            <label for="email">이메일<span id="email_check" style="font-size:14px"></span></label>
            <input id='email' class="form-control" type="email" name="user_email"
            placeholder="ex) friend@naver.com" onchange="isEmail()">
          </div>

          <div class="form-group">
            <label for="pwd">비밀번호</label>
            <input id='pwd'class="form-control"type="password" name="user_password"
            placeholder="8자리 이상 16자리 이상" onchange="isSame()">
          </div>

          <div class="form-group">
            <label for="pwdc">비밀번호 확인<span id="same" style="font-size:14px"></span></label>
            <input id='pwdc' class="form-control" type="password" name="user_password_confirm"
            onchange="isSame()">
          </div>

          <div class="form-group">
            <label for="nick">닉네임</label>
            <input id='nick' class="form-control" type="text" name="user_nickname"
            placeholder="한글 권장, 2자리 이상, 10자리 이하" onchange="isNick()">
          </div>

          <div class="form-group">
            <label for="tel">핸드폰번호</label>
            <input id='tel' class="form-control" type="tel" name="user_phonenumber"
            placeholder="ex) 01089451732" onchange="isEnabled()">
          </div>

          <br>

          <input class="btn btn-block btn-warning" type="submit" value="회원가입완료">

        </form>
      </div>
      <div class="col-sm-3">

      </div>
    </div>

  </div>

<!-- HTML 하단 영역 -->
<?php require_once('view/bottom.php');?>
