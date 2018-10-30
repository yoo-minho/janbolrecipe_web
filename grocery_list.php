<?php include_once("analyticstracking.php"); ?>

<?php

  //db연결
	require_once('command/mysql_connect.php');

  //변수

  if(isset($_GET['page'])){
    $page = $_GET['page'];
  } else {
    $page = 1;
  }

  if(isset($_POST['grocery_name'])){
    $grocery_name = $_POST['grocery_name'];
    $price_100g = $_POST['price_100g'];
    $reference = $_POST['reference'];
    $gram_unit = $_POST['gram_unit'];
    $unit = $_POST['unit'];
    $calorie_100g = $_POST['calorie_100g'];
    $etc = $_POST['etc'];

    //데이터베이스 인서트
    $sql = "INSERT INTO grocery_list
            (grocery_name,
            price_100g,
            gram_unit,
            unit,
            calorie_100g,
            reference,
            etc) VALUES
            ('$grocery_name',
              '$price_100g',
              '$gram_unit',
              '$unit',
              '$calorie_100g',
              '$reference',
              '$etc')";

    $result = mysqli_query($conn, $sql);
    if($result === false){
      echo mysqli_error($conn);
    }
  }

  //콘텐츠 클래스 속 리스트 나열 - 게시판 페이징
  $total_check_sql = "SELECT count(*) FROM grocery_list";
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

  //한 화면 출력될 페이지 수 12345678910 이케
  $count_page = 5;

  //오프셋 상수
  $offset_n = $count_list*($page-1);

  //페이지 개수 : 나머지가 있으면 페이지를 하나 더해라.
  $cal_total_page = $total_count/$count_list;
  if($cal_total_page-(int)$cal_total_page > 0 ){
    $total_page = (int)$cal_total_page + 1;
  } else {
    $total_page = (int)$cal_total_page;
  }

  //페이지하단바
  $start_page = (int)(($page-1)/$count_page)*$count_page+1;
  $end_page = $start_page + $count_page - 1;

  if ($end_page > $total_page) {
    $end_page = $total_page;
  }

?>


<br>
<hr>

<?php

$sql = "SELECT * FROM grocery_list ORDER BY grocery_name LIMIT $count_list OFFSET $offset_n;";
$result = mysqli_query($conn, $sql);
$serial_number = 1+($page-1)*10;

?>

<div class="table-responsive panel panel-default">
  <table class="table">
    <!-- 표 카테고리 -->
    <thead>
      <tr>
        <th>#</th>
        <th>식재료이름</th>
        <th>백그램당won</th>
        <th>가격출처</th>
        <th>단위당gram</th>
        <th>단위</th>
        <th>백그램당kCal</th>
        <th>기타</th>
        <th>관리</th>
      </tr>
    </thead>
    <!-- 표 본문 -->
    <tbody>
      <?php while ( $row = mysqli_fetch_array($result) ){ ?>
      <tr>
        <td><?=$serial_number?></td>
        <td><?=$row['grocery_name']?></td>
        <td><?=$row['price_100g']?>원</td>
        <td><?=$row['reference']?></td>
        <td><?=$row['gram_unit']?>g(그램)</td>
        <td><?=$row['unit']?></td>
        <td><?=$row['calorie_100g']?>kcal(칼로리)</td>
        <td><?=$row['etc']?></td>
        <td>
          <form action="grocery_edit.php" method="post" style="display:inline; margin:0px">
            <input type="hidden" name="id" value=<?=$row['id']?>>
            <input type="hidden" name="grocery_name" value=<?=$row['grocery_name']?>>
            <input type="hidden" name="price_100g" value=<?=$row['price_100g']?>>
            <input type="hidden" name="reference" value=<?=$row['reference']?>>
            <input type="hidden" name="gram_unit" value=<?=$row['gram_unit']?>>
            <input type="hidden" name="unit" value=<?=$row['unit']?>>
            <input type="hidden" name="calorie_100g" value=<?=$row['calorie_100g']?>>
            <input type="hidden" name="etc" value=<?=$row['etc']?>>
            <input class="btn btn-warning btn-xs" type="submit" name="edit" value="수정">
          </form>

          <form action="grocery_delete_process.php" method="post" style="display:inline; margin:0px">
            <input type="hidden" name="id" value=<?=$row['id']?>>
            <input class="btn btn-danger btn-xs" type="submit" name="edit" value="삭제" onclick="return confirm('식재료 내용을 삭제할까요?')">
          </form>
        </td>
      </tr>
      <?php
      $serial_number = $serial_number + 1;
      } ?>
    </tbody>
  </table>
</div>
<?php
?>

<center>

  <?php

  //페이지 번호를 나열한다.
  echo '<span><ul class="pagination">';
  for ($i=$start_page; $i <= $end_page ; $i++) {
    if( $i === (int)$page ){
      echo "<li class='active'><a href='?page=$i'>".$i;
    } else {
      echo "<li><a href='?page=$i'>".$i;
    }
    echo "</a></li>";
  }
  echo '</ul></span>';

  //현재 페이지가 1번이 아니면 이전을 표기한다.
  echo "<ul class='pager'>";
  if ($page > 1) {
    $page_m = $page-1;
    echo "<li><a href='?page=$page_m'>이전</a></li>";
  }

  //전체 페이지 개수 보다 현재 번호가 작으면 다음을 표기한다.
  if ($page < $total_page) {
    $page_p = $page+1;
    echo "<li><a href='?page=$page_p'>다음</a></li>";
  }
  echo "</ul>";
  ?>

</center>
