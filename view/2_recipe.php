<?php
if($class !== "선택필요" && $recipe !== "요리법"){
  $sql = "SELECT * FROM recipe_list WHERE class='$class' AND recipe='$recipe';";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);

?>

<script>
  function scroll(name) {
    $(document).ready(function () {
    $('html, body').animate({
    scrollTop: $(name).offset().top
    }, 'slow');
    });
  }

  scroll('#location');
</script>

<!--레시피 본문----------------------------------------------------------------->
  <div class="row" style="margin-bottom:20px">

<!--레시피 제목----------------------------------------------------------------->
    <div class='col-sm-12'>
      <div class="row">
        <div class="col-sm-4">
        </div>
        <div class="col-sm-4" style="margin-top:20px">
            <?php
              $random_sql = "SELECT class, recipe FROM recipe_list ORDER BY RAND() LIMIT 1";
              $random_result = mysqli_query($conn, $random_sql);
              if($random_row = mysqli_fetch_array($random_result)){
             ?>
             <a href="index.php?class=<?=$random_row[0]?>&recipe=<?=$random_row[1]?>">
                <button class='btn btn-warning btn-block' type="button" name="button">
                  <input id="alert_text" type="text" value="랜덤 레시피 보기" readonly="readonly"
                  style="cursor:default;border: none; background: transparent; text-align:center">
                </button>
              </a>
            <?php } ?>
        </div>
        <div class="col-sm-4">
        </div>
      </div>

      <hr>
      <div id="location" style="padding-top:20px">
        <h4 style="text-align:center; color:#f0ad4e"><b>레시피 개요</b></h4>
        <h5 style="text-align:center">Recipe summary</h5>
      </div>
      <div class="table-responsive panel panel-default">
        <table class="table">
          <!-- 표 카테고리 -->
          <thead>
            <tr>
              <th class='text-center'>크리에이터</th>
              <th class='text-center'>레시피</th>
              <th class='text-center'>기준 인분</th>
            </tr>
          </thead>
          <!-- 표 본문 -->
          <tbody>
            <tr>
              <td class='text-center'><?=$class?></td>
              <td class='text-center'><?=$recipe?></td>
              <td class='text-center'><?=$row['meal']?>인분 기준</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!--장볼리스트 담기------------------------------------------------------------->
        <form action="/shopping_process.php">
          <input type="hidden" name="class" value=<?=$class?>>
          <input type="hidden" name="recipe" value=<?=$recipe?>>
          <div class="col-sm-8 form-group ">
            <select class="form-control" id="sel1" name="meal">
              <?php
              for ($i=1; $i <11 ; $i++) {
                if($i == 2){
                  echo "<option selected value=".$i.">".$i."인분</option>";
                } else {
                  echo "<option value=".$i.">".$i."인분</option>";
                }
              }
              ?>
            </select>
          </div>

          <div class="col-sm-4">
            <?php
              if($nick === "게스트"){
                ?>
                  <a href="login.php">
                    <button type="button" class="btn btn-default btn-block"
                    onclick="alert('로그인이 필요합니다!')">
                      <span class='glyphicon glyphicon-shopping-cart'></span>
                      장볼리스트 담기</button>
                  </a>
                <?php
              } else {
                ?>
                  <button type="submit" class="btn btn-default btn-block"
                  onclick="recipe_save()">
                    <span class='glyphicon glyphicon-shopping-cart'></span>
                    장볼리스트 담기</button>
                <?php
              }
              ?>
          </div>
        </form>

<!--채팅---------------------------------------------------------------->

        <div class="col-sm-12">
          <hr>
          <!--채팅-->
          <?php
          //겟클래스 존재할때 : 크리에이터 선택 시
          if($class !== "선택필요"){
            //겟클래스와 닉네임세션이 다를때 : 크리에이터 본인이 아닐 시
            if($class !== $nick){
              //닉네임 세션 존재할때 : 로그인 시
              if($nick !== "게스트"){
          ?>
            <!-- 1대1 문의 가능 -->
            <form style="display:inline;" id='myform' name='myform' action="/chat.php"
              target="popup_window">
              <input type="hidden" name="nick" value=<?=$nick?>>
              <input type="hidden" name="receiver" value=<?=$class?>>
              <button type="button" class="btn btn-default btn-block" id="btn_submit">
                <span class='glyphicon glyphicon-comment'></span>　크리에이터에게 문의하기
              </button>
            </form>

            <!-- 채팅 팝업 로드 -->
            <script type="text/javascript">
              $(document).ready(function(){
                $("#btn_submit").on("click",function(){
                  window.open('','popup_window',
                  'width=360 height=530');
                  $("#myform").submit();
                });
              });
            </script>

            <?php
              } else {
                //닉네임이 게스트인 경우 : 게스트로 접속시
                ?>
                <a href="login.php">
                  <button type='button' class='btn btn-default btn-block'>
                      문의는 로그인 필요
                    </button>
                </a>
                <?php
              }
            } else {
              //크리에이터와 닉네임이 같을때 : 본인 페이지 접속시
              echo "<button type='button' class='btn btn-default btn-block'>
                  <span class='glyphicon glyphicon-user'></span>　본인 페이지
                </button>";
            }
          }
            ?>
        </div>


<!--영상레시피------------------------------------------------------------------>

    <div class="container col-sm-12">
      <hr>
      <h4 style="text-align:center; color:#f0ad4e"><b>레시피</b></h4>
      <h5 style="text-align:center">Recipe</h5>
      <div class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive-item"
        src="https://www.youtube.com/embed/<?=$row['video_code']?>?rel=0" allowfullscreen></iframe>
      </div>
    </div>

<!--장볼재료-------------------------------------------------------------------->
    <div class="container col-sm-12">
      <hr>
      <h4 style="text-align:center; color:#f0ad4e"><b>장볼 재료</b></h4>
      <h5 style="text-align:center">Item to buy</h5>
      <div class="table-responsive panel panel-default">
      <table class="table">
        <!-- 표 카테고리 -->
        <thead>
          <tr>
            <th>위키</th>
            <th>장볼재료</th>
            <th class='text-right'>칼로리</th>
            <th class='text-right'>계량</th>
            <th class='text-right'>그램</th>
            <th class='text-right'>가격</th>
          </tr>
        </thead>
        <!-- 표 본문 -->
        <tbody>
            <?php
              $total_calorie = 0;
              $total_price = 0;

              for ($i=0; $i < 6 ; $i++) {
                if($row['grocery'.$i]){
                  echo "<tr><td><a href='https://ko.wikipedia.org/wiki/"
                  .$row['grocery'.$i]."' target='_blank' class='btn btn-default btn-xs'>
                  <span class='glyphicon glyphicon-globe'></span>
                  </a></td><td>".$row['grocery'.$i]." </td>";

                  //재료별 데이터 로드
                  $grocery_load_sql = "SELECT * FROM grocery_list WHERE grocery_name='{$row['grocery'.$i]}';";
                  $grocery_load_result = mysqli_query($conn, $grocery_load_sql);
                  $grocery_load_row = mysqli_fetch_array($grocery_load_result);
                  $grocery_calorie = $grocery_load_row['calorie_100g']*$row['gram'.$i]/100;
                  echo "<td class='text-right'>".round($grocery_calorie)."kCal</td>";

                  //토탈 칼로리 계산
                  $total_calorie = $total_calorie + $grocery_calorie;

                  if($grocery_load_row['gram_unit'] != 0){
                    echo "<td class='text-right'>".round($row['gram'.$i]/$grocery_load_row['gram_unit'], 1)
                      .$grocery_load_row['unit']."</td>";
                  } else {
                    echo "<td class='text-right'>-</td>";
                  }
                  echo "<td class='text-right'>".number_format($row['gram'.$i])."g</td>";
                  $grocery_price = $grocery_load_row['price_100g']*$row['gram'.$i]/100;
                  echo "<td class='text-right'>".number_format($grocery_price)."원</td></tr>";
                  //토탈 가격 계산
                  $total_price = $total_price + $grocery_price;
                }
              }
             ?>
        </tbody>
      </table>
    </div>

<!--기본재료-------------------------------------------------------------------->
    <hr>
    <h4 style="text-align:center; color:#f0ad4e"><b>기본 재료</b></h4>
    <h5 style="text-align:center">Item to base</h5>
    <div class="table-responsive panel panel-default">
      <table class="table">
        <!-- 표 카테고리 -->
        <thead>
          <tr>
            <th>위키</th>
            <th>기본재료</th>
            <th class='text-right'>칼로리</th>
            <th class='text-right'>계량</th>
            <th class='text-right'>그램</th>
            <th class='text-right'>가격</th>
          </tr>
        </thead>
        <!-- 표 본문 -->
        <tbody>
            <?php
              $seasoning_array= array('간장', '설탕', '액젓', '고추장', '식용유', '참기름', '고춧가루', '다진마늘');
              for ($i=0; $i < 8 ; $i++) {
                if(substr($row['seasoning'],$i+1,1)!="0"){
                  echo "<tr><td><a href='https://ko.wikipedia.org/wiki/"
                  .$seasoning_array[$i]."' target='_blank' class='btn btn-default btn-xs'>
                  <span class='glyphicon glyphicon-globe'></span>
                  </a></td><td>".$seasoning_array[$i]."</td>";

                  //재료별 데이터 로드
                  $grocery_load_sql = "SELECT * FROM grocery_list WHERE grocery_name='$seasoning_array[$i]';";
                  $grocery_load_result = mysqli_query($conn, $grocery_load_sql);
                  $grocery_load_row = mysqli_fetch_array($grocery_load_result);

                  $gram = substr($row['seasoning'],$i+1,1)*0.5*$grocery_load_row['gram_unit'];
                  $calorie = round($grocery_load_row['calorie_100g']*$gram/100,1);
                  echo "<td class='text-right'>".round($calorie)."kCal</td>";

                  //토탈 칼로리 계산
                  $total_calorie = $total_calorie + $calorie;

                  echo "<td class='text-right'>".substr($row['seasoning'],$i+1,1)*0.5."T</td>";
                  echo "<td class='text-right'>".number_format($gram)."g</td>";
                  echo "<td class='text-right'>".number_format($grocery_load_row['price_100g']*$gram/100)."원</td></tr>";
                }
              }
             ?>
        </tbody>
      </table>
    </div>

<!--안내 및 양념계량-------------------------------------------------------------------->
    <!-- Trigger the modal with a button -->

    <button type="button" class="btn btn-default btn-block" data-toggle="modal" data-target="#myModal2"
    style="margin-bottom:10px">
      양념계량을 잘 모르겠다면?
    </button>

    <!-- Modal -->
    <div id="myModal2" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">양념계량을 잘 모르겠다면?</h4>
          </div>
          <div class="modal-body">
            <img src="image/onetspoon.png" width="100%">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>

    <!--출처----------------------------------------------------------------------->
        <hr>
        <h4 style="text-align:center; color:#f0ad4e"><b>출처 표시</b></h4>
        <h5 style="text-align:center">Reference</h5>
          <div class="table-responsive panel panel-default">
            <table class="table">
              <thead>
                <tr>
                  <th style="text-align:center">가격참고1</th>
                  <th style="text-align:center">가격참고2</th>
                  <th style="text-align:center">칼로리참고</th>
                </tr>
              </thead>
              <tbody>
                <tr style="text-align:center">
                  <td><a href="http://www.coupang.com/" target="_blank">소셜마켓쿠팡</a></td>
                  <td><a href="https://www.kamis.or.kr" target="_blank">KAMIS</a></td>
                  <td><a href="https://www.fatsecret.kr/%EC%B9%BC%EB%A1%9C%EB%A6%AC-%EC%98%81%EC%96%91%EC%86%8C/" target="_blank">팻시크릿</td>
              </tbody>
            </table>
          </div>

<!--합계----------------------------------------------------------------------->
    <hr>
    <h4 style="text-align:center; color:#f0ad4e"><b>합계 자료</b></h4>
    <h5 style="text-align:center">Total data</h5>
      <div class="table-responsive panel panel-default">
        <table class="table">
          <thead>
            <tr>
              <th>칼로리 (모든 재료 포함)</th>
              <th>가격 (기본재료 미포함)</th>
            </tr>
          </thead>
          <tbody>
              <?php
                echo "<td class='text-right'>".number_format($total_calorie)."kCal</td>";
                echo "<td class='text-right'>".number_format($total_price)."원</td>";
               ?>
          </tbody>
        </table>
      </div>
    </div>

    <!--장볼리스트 담기------------------------------------------------------------->
        <form action="/shopping_process.php">
          <input type="hidden" name="class" value=<?=$class?>>
          <input type="hidden" name="recipe" value=<?=$recipe?>>
          <input type="hidden" name="nick" value=<?=$nick?>>
          <div class="col-sm-8 form-group ">
            <select class="form-control" id="sel1" name="meal">
              <?php
              for ($i=1; $i <11 ; $i++) {
                if($i == 2){
                  echo "<option selected value=".$i.">".$i."인분</option>";
                } else {
                  echo "<option value=".$i.">".$i."인분</option>";
                }
              }
              ?>
            </select>
          </div>
          <div class="col-sm-4">
            <?php
              if($nick === "게스트"){
                ?>
                  <button type="button" class="btn btn-default btn-block"
                  onclick="alert('로그인이 필요합니다!')">
                    <span class='glyphicon glyphicon-shopping-cart'></span>
                    장볼리스트 담기</button>
                <?php
              } else {
                ?>
                  <button type="submit" class="btn btn-default btn-block">
                    <span class='glyphicon glyphicon-shopping-cart'></span>
                    장볼리스트 담기</button>
                <?php
              }
              ?>
          </div>

          <br>

          <div class="col-sm-12">
            <button class='btn btn-warning btn-block' type="button" name="button"
            onclick="window.location.href = '#top'">
              <input id="alert_text" type="text" value="다른 레시피 보기" readonly="readonly"
              style="cursor:default;border: none; background: transparent; text-align:center">
            </button>
          </div>
        </form>

  </div>

<!--장볼재료시작부분 끝---------------------------------------------------------->

    <?php
    } else {
      //크리에이터와 레시피 값이 없을 때 : 초기화면 혹은 크리에이터만 선택했을시
      ?>

      <div class="row">
        <div class="col-sm-4">
        </div>
        <div class="col-sm-4" style="margin-top:20px">
            <?php
              $random_sql = "SELECT class, recipe FROM recipe_list ORDER BY RAND() LIMIT 1";
              $random_result = mysqli_query($conn, $random_sql);
              if($random_row = mysqli_fetch_array($random_result)){
             ?>
             <a href="index.php?class=<?=$random_row[0]?>&recipe=<?=$random_row[1]?>">
                <button class='btn btn-warning btn-block' type="button" name="button">
                  <input id="alert_text" type="text" value="랜덤 레시피 보기" readonly="readonly"
                  style="cursor:default;border: none; background: transparent; text-align:center">
                </button>
              </a>
            <?php } ?>
        </div>
        <div class="col-sm-4">
        </div>
      </div>

      <hr>

      <div>
        <br>
        <h4 style="text-align:center; color:#f0ad4e"><b>필요한 순간</b></h4>
        <h5 style="text-align:center">The moment you need</h5>
      </div>

      <div class="row">
        <div class="col-sm-4" style="text-align:center">
          <div class="panel panel-default" style="margin:20px">
            <div class="row panel-body" style="padding-top:20px">
              <img class="img-responsive" src="image/people.png"
              style="margin:0 auto; width:30%; height:30%;">
              <br>여러 사람과 음식하고 싶어
              <br>많은 양을 장보고 싶을때?
              <br><b>#여행 #집들이 #홈파티</b>
              <br>　
            </div>
          </div>
        </div>

        <div class="col-sm-4" style="text-align:center">
          <div class="panel panel-default" style="margin:20px">
            <div class="row panel-body" style="padding-top:20px">
              <img class="img-responsive" src="image/youtube.png"
              style="margin:0 auto; width:30%; height:30%;">
              <br>유튜브 영상레시피를
              <br>활용해서 장보고 싶을때?
              <br><b>#백종원 #초간단 #자취요리</b>
              <br>　
            </div>
          </div>
        </div>

        <div class="col-sm-4" style="text-align:center">
          <div class="panel panel-default" style="margin:20px">
            <div class="row panel-body" style="padding-top:20px">
              <img class="img-responsive" src="image/list.png"
              style="margin:0 auto; width:30%; height:30%;">
              <br>장 보러가기전에
              <br>리스트를 써보고 싶을때?
              <br><b>#어차피 #더많이 #사겠지만</b>
              <br>　
            </div>
          </div>
        </div>
      </div>

      <div>
        <br>
        <h4 style="text-align:center; color:#f0ad4e"><b>활용 방법</b></h4>
        <h5 style="text-align:center">How to use</h5>
      </div>

      <div class="row">
        <div class="col-sm-4" style="text-align:center">
          <div class="panel panel-default" style="margin:20px">
            <div class="row panel-body" style="padding-top:20px">
              <img class="img-responsive" src="image/search.png"
              style="margin:0 auto; width:30%; height:30%;">
              <br><b>STEP1. Show recipe!</b>
              <br>유튜버 크리에이터의
              <br>레시피를 둘러본다
              <br>　
            </div>
          </div>
        </div>

        <div class="col-sm-4" style="text-align:center">
          <div class="panel panel-default" style="margin:20px">
            <div class="row panel-body" style="padding-top:20px">
              <img class="img-responsive" src="image/cart.png"
              style="margin:0 auto; width:30%; height:30%;">
              <br><b>STEP2. Add to cart!</b>
              <br>레시피 인분에 맞게
              <br>장볼리스트에 담는다
              <br>　
            </div>
          </div>
        </div>

        <div class="col-sm-4" style="text-align:center">
          <div class="panel panel-default" style="margin:20px">
            <div class="row panel-body" style="padding-top:20px">
              <img class="img-responsive" src="image/store.png"
              style="margin:0 auto; width:30%; height:30%;">
              <br><b>STEP3. Go to mart!</b>
              <br>장볼리스트를 캡쳐하고
              <br>장보기를 떠난다
              <br>　
            </div>
          </div>
        </div>

          <div class="col-sm-4">

          </div>
          <div class="col-sm-4">
            <?php
              if( $nick === "게스트"){
              ?>
              <div style="margin:40px" style="text-align:center">
                <button class='btn btn-warning btn-block' type="button" name="button"
                onclick="window.location.href = 'join.php'">
                  <input id="alert_text" type="text" value="초간단 회원가입" readonly="readonly"
                  style="cursor:default;border: none; background: transparent; text-align:center">
                </button>
                <p style="text-align:center">※로그인하지 않으면 일부기능 제한됩니다.</p>
              </div>
              <?php
              }
             ?>
          </div>
          <div class="col-sm-4">

          </div>

      </div>



      <?php
    }
    ?>
