<!-- php display_errors on -->
<!-- php opcache.enable = 0 -->
<?php require_once('view/0_top.php');?>

<div class="container">

<!-- 다음주소API -->
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script>
//본 예제에서는 도로명 주소 표기 방식에 대한 법령에 따라, 내려오는 데이터를 조합하여 올바른 주소를 구성하는 방법을 설명합니다.
function sample4_execDaumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {
                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 도로명 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var fullRoadAddr = data.roadAddress; // 도로명 주소 변수
                var extraRoadAddr = ''; // 도로명 조합형 주소 변수

                // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                    extraRoadAddr += data.bname;
                }
                // 건물명이 있고, 공동주택일 경우 추가한다.
                if(data.buildingName !== '' && data.apartment === 'Y'){
                   extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                }
                // 도로명, 지번 조합형 주소가 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                if(extraRoadAddr !== ''){
                    extraRoadAddr = ' (' + extraRoadAddr + ')';
                }
                // 도로명, 지번 주소의 유무에 따라 해당 조합형 주소를 추가한다.
                if(fullRoadAddr !== ''){
                    fullRoadAddr += extraRoadAddr;
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('sample4_postcode').value = data.zonecode; //5자리 새우편번호 사용
                document.getElementById('sample4_roadAddress').value = fullRoadAddr;
                document.getElementById('sample4_jibunAddress').value = data.jibunAddress;

                // 사용자가 '선택 안함'을 클릭한 경우, 예상 주소라는 표시를 해준다.
                if(data.autoRoadAddress) {
                    //예상되는 도로명 주소에 조합형 주소를 추가한다.
                    var expRoadAddr = data.autoRoadAddress + extraRoadAddr;
                    document.getElementById('guide').innerHTML = '(예상 도로명 주소 : ' + expRoadAddr + ')';

                } else if(data.autoJibunAddress) {
                    var expJibunAddr = data.autoJibunAddress;
                    document.getElementById('guide').innerHTML = '(예상 지번 주소 : ' + expJibunAddr + ')';

                } else {
                    document.getElementById('guide').innerHTML = '';
                }
            }
        }).open();
    }
</script>

<div class="row">

    <div class="col-sm-3">
    </div>

    <div class="col-sm-6" style="margin:20px">

          <?php
            $user_conf_sql = "SELECT * FROM user_list WHERE user_nickname = '$nick'";
            $user_conf_result = mysqli_query($conn, $user_conf_sql);
            $user_conf_row = mysqli_fetch_array($user_conf_result);
            $email = $user_conf_row['user_email'];
            $pn = $user_conf_row['user_phonenumber'];
           ?>

           <form action="payment_process.php" method="post">

             <input type="hidden" name="nick" value=<?=$nick?>>
             <input type="hidden" name="t_number" value=<?=$grocery_total_number?>>
             <input type="hidden" name="t_text" value=<?=$grocery_total_text?>>
             <input type="hidden" name="price" value=<?=$grocery_total_price+5000?>>

             <div class="form-group">
               <label for="email">이메일</label>
               <input id='email' class="form-control" type="email" name="user_email"
               value=<?=$email?>>
             </div>

             <div class="form-group">
               <label for="name">받는이</label>
               <input id='name' class="form-control" type="text" name="user_nickname"
               value=<?=$nick?>>
             </div>

             <div class="form-group">
               <label for="tel">핸드폰번호</label>
               <input id='tel' class="form-control" type="tel" name="user_phonenumber"
               value=<?=$pn?>>
             </div>

             <div class="form-group">

               <span id="guide" style="color:#999"></span>
               <label for="address">주소</label>
               <p><div class="row">
                 <div class="col-sm-8">
                   <input type="text" class="form-control" id="sample4_postcode" placeholder="우편번호" name="address_number">
                 </div>
                 <div class="col-sm-4">
                  <input type="button" class="btn btn-default btn-block" onclick="sample4_execDaumPostcode()" value="우편번호 찾기">
                 </div>
               </div></p>
               <p><input type="text" class="form-control" id="sample4_roadAddress" placeholder="도로명주소" name="address_new"></p>
               <p><input type="text" class="form-control" id="sample4_jibunAddress" placeholder="지번주소" name="address_old"></p>
               <p><input type="text" class="form-control" id="sample4_jibunAddress"
                 placeholder="나머지 주소를 적어주세요." name="address_etc"></p>
             </div>

             <!-- Trigger the modal with a button -->
            <label for="pay">레시피 및 식재료 리스트</label>
            <button type="button" class="btn btn-default btn-block" data-toggle="modal" data-target="#myModal">구매리스트 보기</button>
            <br>
            <label for="pay">결제수단</label>
            <img class="img-responsive img-rounded" src="/image/kakaopay.jpg" width="100%">
            <br>
            <label for="pay">결제금액</label>
            <p style="text-align:right"><?=number_format($grocery_total_price)?>원(+ 배송료 : 5,000원)</p>
            <br>
            <input class="btn btn-block btn-warning" type="submit" value="결제하기">
            <p style="text-align:center">※신선제품 특성상 재료 부족으로 인하여 안내 후 <u style="color:red">결제취소</u>될 수 있습니다.</p>
           </form>

        </div>
      </div>
    </div>

    <div class="col-sm-3">

    </div>

</div>

<!-- HTML 하단 영역 -->
<?php require_once('view/bottom.php');?>
