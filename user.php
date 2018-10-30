<!-- php display_errors on -->
<!-- php opcache.enable = 0 -->
<?php require_once('view/0_top.php');?>

<div class="container">
<?php
$sql = "SELECT * FROM user_list";
$result = mysqli_query($conn, $sql);

?>

<h4 style="text-align:center; color:#f0ad4e"><b>회원 목록</b></h4>
<h5 style="text-align:center">User list</h5>
<div class="table-responsive panel panel-default">
  <table class="table">
    <thead>
      <tr>
        <th>유저번호</th>
        <th>이메일</th>
        <th>닉네임</th>
        <th>핸드폰번호</th>
      </tr>
    </thead>
    <tbody>
      <?php
      while($row = mysqli_fetch_array($result)){
        ?>
        <tr>
          <td><?=$row[0]?></td>
          <td><?=$row[1]?></td>
          <td><?=$row[3]?></td>
          <td><?=$row[4]?></td>
        </tr>
        <?php
      }
       ?>

      </tbody>
    </table>
  </div>

<?php





 ?>
</div>



<!-- HTML 하단 영역 -->
<?php require_once('view/bottom.php');?>
