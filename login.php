<!-- php display_errors on -->
<!-- php opcache.enable = 0 -->
<?php require_once('view/0_top.php');?>

<div class="container">
  <div class="row">
    <div class="col-sm-3">

    </div>
    <div class="col-sm-6" style="margin:20px">
      <form action="login_process.php" method="post">
        <div class="form-group">
          <label for="email">이메일</label>
          <input id='email' class="form-control" type="email" name="user_email"
          placeholder="ex) friend@naver.com">
        </div>

        <div class="form-group">
          <label for="pwd">비밀번호</label>
          <input id='pwd' class="form-control" type="password" name="user_password"
          placeholder="8자리 이상">
        </div>

        <input class="btn btn-block btn-warning" type="submit" value="로그인">
      </form>

      <a href="join.php">
        <button style="margin-top:10px;" class="btn btn-block btn-info" type="button" name="button">회원가입</button>
      </a>
    </div>
    <div class="col-sm-3">

    </div>
  </div>
</div>



<!-- HTML 하단 영역 -->
<?php require_once('view/bottom.php');?>
