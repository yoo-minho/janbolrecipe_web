<!-- php display_errors on -->
<!-- php opcache.enable = 0 -->
<?php require_once('view/0_top.php');?>

<div class="container">

<!-- 변수 -->
<?php $ncik = $_GET['nick']; ?>

<div style="margin:20px;">

  <div>
    <h2 style="text-align:center"><b><?=$nick?></b>님의 결제목록</h2>
    <br>
  </div>

  <div>
    <iframe src="payment_list.php?nick=<?=$nick?>"
        width="100%" height="600px"></iframe>
  </div>

</div>

<!-- HTML 하단 영역 -->
<?php require_once('view/bottom.php');?>
