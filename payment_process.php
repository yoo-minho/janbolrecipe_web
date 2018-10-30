<!-- 상단 영역 -->
<?php require_once('view/0_top.php');?>

<?php

  //받는이
  $name = $_POST['user_nickname'];
  $email = $_POST['user_email'];
  $pn = $_POST['user_phonenumber'];
  $adr_nb = $_POST['address_number'];
  $adr_new = $_POST['address_new'];
  $adr_old = $_POST['address_old'];
  $adr_etc = $_POST['address_etc'];

  if($name === ""
  || $email === ""
  || $pn === ""
  || $adr_nb === ""
  || $adr_new === "" ){
    ?>
    <script type="text/javascript">
      alert('빈칸이 존재하여 결제가 불가합니다.');
      document.location.href='payment.php';
    </script>
    <?php
  }

  //히든영역
  $nick = $_POST['nick'];
  $price = $_POST['price'];
  $t_number = $_POST['t_number'];
  $t_text = $_POST['t_text'];

  //네임은 받는이, 닉은 닉네임
 ?>

  <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js" ></script>
  <script type="text/javascript" src="https://cdn.iamport.kr/js/iamport.payment-1.1.5.js"></script>

  <script type="text/javascript">

    //천단위 컴마
    function numberWithCommas(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    //초기화
    var IMP = window.IMP;
    IMP.init('imp38634633');

    //결제요청
    IMP.request_pay({
        pg : 'kakaopay', // version 1.1.0부터 지원.
        pay_method : 'card',
        merchant_uid : 'merchant_' + new Date().getTime(),
        name : '<?=$nick?>님의 주문(TEST)',
        amount : <?=$price?>,
        buyer_email : '<?=$email?>',
        buyer_name : '<?=$name?>',
        buyer_tel : '<?=$pn?>',
        buyer_addr : '<?=$adr_new?>',
        buyer_postcode : '<?=$adr_nb?>',
        m_redirect_url : 'payment_complete.php'
    }, function(rsp) {
        if ( rsp.success ) {
            var msg = '<?=$nick?>님의 결제가 완료되었습니다.';
            msg += ' / 결제 금액 : ' + numberWithCommas(rsp.paid_amount) + '원';

            fetch('/payment_list.php?nick=<?=$nick?>', {
                method : "POST",
                headers : {
                  "Content-Type" : "application/x-www-form-urlencoded"
                },
                body : "&m_uid=" + rsp.merchant_uid +
                "&price=" + rsp.paid_amount +
                "&text=" + "<?=$t_text?>" +
                "&number=" + "<?=$t_number?>" +
                "&name=" + "<?=$name?>"
              })
              .then(function(response){
              response.text().then(function(text){
                location.href = "payment_manager.php?nick=<?=$nick?>";
                document.querySelector('#payment_list_div').innerHTML = text;
              })
            });

        } else {
            var msg = '결제에 실패하였습니다.';
            msg += ' / 에러내용 : ' + rsp.error_msg;
        }
        alert(msg);

    });

  </script>

  <div class="container">
    <div class="panel panel-default" style="padding:10px;">
      <div class="panel-body">
        <p><form action="index.php" >
          <input class='btn btn-default' type="submit" value="홈으로가기">
        </form></p>
        <div id = "payment_list_div">
        </div>
      </div>
    </div>
  </div>

  <!-- HTML 하단 영역 -->
  <?php require_once('view/bottom.php');?>
