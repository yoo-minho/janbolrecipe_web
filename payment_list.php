<?php include_once("analyticstracking.php"); ?>

<!-- 부트스트랩 -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<?php
  //db연결
	require_once('command/mysql_connect.php');

  //변수
  $nick = $_GET['nick'];

  //결제 내역이 넘어온 경우
  if(isset($_POST["m_uid"])){
    ?>
    <div class="alert alert-success">
      <strong>결제성공!</strong> 빠른 시일내에 배송해드릴게요!
    </div>
    <?php
    $name = $_POST["name"];
    $m_uid = $_POST["m_uid"];
    $text = $_POST["text"];
    $price = number_format($_POST["price"]);
    $number = $_POST["number"];

    //상태는 결제완료, 결제취소, 취소완료 3가지가 있음
    $payment_insert_sql = "INSERT INTO payment_list
    (nick, name, m_uid, price, list_number, list_text, status) VALUES
    ('$nick','$name', '$m_uid', '$price', '$number', '$text', '결제완료');";
    $payment_insert_result = mysqli_query($conn, $payment_insert_sql);
  }

  ?>

  <div class="table-responsive panel panel-default">
    <table class="table">
      <thead>
        <tr>
          <th>구분</th>
          <th>계정</th>
          <th>받는이</th>
          <th>결제번호</th>
          <th>가격</th>
          <th>장본리스트</th>
          <th>결제상태</th>
          <th>날짜</th>
          <th>취소요청</th>
        </tr>
      </thead>
      <tbody>
        <?php
        //구분에 들어갈 상수 : 연변
        $serial_number = 1;

        //관리자는 전체 내역을 볼 수 있음
        if($nick === "관리자"){
          $payment_load_sql = "SELECT * FROM payment_list";
        } else {
          $payment_load_sql = "SELECT * FROM payment_list WHERE nick='$nick'";
        }
        $payment_load_result = mysqli_query($conn, $payment_load_sql);
				$check_num = 0;
        while($payment_load_row = mysqli_fetch_array($payment_load_result)){
						$check_num++;
        ?>
        <tr>
          <td style="text-align:center"><?=$serial_number?></td>
          <td><?=$payment_load_row['nick']?></td>
          <td><?=$payment_load_row['name']?></td>
          <td><?=$payment_load_row['m_uid']?></td>
          <td><?=$payment_load_row['price']."원"?></td>
          <td><?php
            $text = $payment_load_row['list_text'];
            for ($i=0; $i < mb_strlen($text); $i++) {
              if(mb_substr($text,$i,1) !== "(" ){
                echo mb_substr($text,$i,1);
              } else {
                $i = mb_strlen($text)+1;
              }
            }
            echo " 등 ".$payment_load_row['list_number']."종 ";
            ?>
              <!-- 더보기 모달 -->
              <button type="button" class="btn btn-link btn-xs" data-toggle="modal" data-target="#myModal5">더보기</button>

              <!-- Modal -->
              <div id="myModal5" class="modal fade" role="dialog">
                <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">세부내역</h4>
                    </div>
                    <div class="modal-body">
                      <p>
                        <?php
                          $text = $payment_load_row['list_text'];
                          echo "<button class='btn btn-default' style='margin:5px;'>";
                          for ($i=0; $i < mb_strlen($text) ; $i++) {
                            if(mb_substr($text,$i,1) === ")" ){
                              if(mb_substr($text,$i,2) !== ")/"){
                                echo mb_substr($text,$i,1)."</button></span> "
                                ."<button class='btn btn-default' style='margin:5px;'>";
                              }
                            } else {
                              echo mb_substr($text,$i,1);
                            }
                          }
                          echo "이상입니다</button>";
                         ?>
                      </p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
          </td>
          <td><?=$payment_load_row['status']?></td>
          <td><?=$payment_load_row['created_at']?></td>
          <td>
            <form action="payment_cancel_process.php" method="post">
              <input type="hidden" name="m_uid" value=<?=$payment_load_row['m_uid']?>>
              <input type="hidden" name="nick" value=<?=$nick?>>
              <?php
                //결제상태에 따른 버튼 상이
                if($payment_load_row['status'] === "결제완료"){
									  if($nick === "관리자"){
                  ?>
									<input class="btn btn-danger btn-xs" type="submit"
                  name="submit" value="결제취소" onclick="return confirm('고객의 동의를 받으셧습니까?')">
									<?php
								} else {
									?>
                  <input class="btn btn-danger btn-xs" type="submit"
                  name="submit" value="결제취소" onclick="return confirm('결제를 취소하시겠습니까?')">
                  <?php
									}
                } else if ($payment_load_row['status'] === "결제취소") {
                  if($nick === "관리자"){
                    ?>
                    <input class="btn btn-info btn-xs" type="submit" name="submit"
                    value="환불완료" onclick="return confirm('환불이 완료되었습니까?')">
                    <?php
                  } else {
                    ?>
                    <button class="btn btn-warning btn-xs" type="button">신속처리中</button>
                    <?php
                  }
                } else if ($payment_load_row['status'] === "환불완료") {
                  ?>
                    <button class="btn btn-warning btn-xs" type="button">처리된결제</button>
                  <?php
                }
              ?>
            </form>
          </td>
        </tr>
        <?php
          $serial_number++;
        }

				if($check_num == 0){
					?>
					<tr>
						<td>아직</td>
						<td>결제</td>
						<td>내역</td>
						<td>없어요</td>
						<td>상단</td>
						<td>장볼리스트</td>
						<td>보고서</td>
						<td><b>테스트</b>결제</td>
						<td>해보세요</td>
					</tr>
					<?php
				}
        ?>
      </tbody>
    </table>
  </div>

<?php
  //관리자 전용 문구
  if($nick === "관리자"){
    ?>
    <center>
      <a href = 'https://admin.iamport.kr/payments' target='_blank'> [관리자 전용 결제 페이지]</a>
      에서 결제번호를 활용하여 결제취소 후 취소요청 탭에 있는 환불완료 버튼을 누르면 결제상태가 변경됩니다.
    </center>
    <?php
  }
?>
