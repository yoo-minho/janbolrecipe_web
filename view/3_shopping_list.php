<!--장볼리스트 부분------------------------------------------------------------->

<!--장볼리스트 헤드------------------------------------------------------------->
<div class="panel panel-default">

<!--장볼리스트 바디------------------------------------------------------------->
  <div class="panel-body">
    <?php
      if($nick !== "게스트"){

        $shopping_list_load_sql = "SELECT * FROM shopping_list WHERE user_id='$id';";
        $shopping_list_load_result = mysqli_query($conn, $shopping_list_load_sql);
        $shopping_list_load_row = mysqli_fetch_array($shopping_list_load_result);
        $shopping_number = 0;
        for ($i=0; $i <5 ; $i++) {
          if(isset($shopping_list_load_row['class'.$i])){
            $shopping_number = $shopping_number+1;
          }
        }

        //페이먼트 아닐때만 보여줘
        if($request_uri !=="/payment.php"){

          if($shopping_number === 5){
            ?>
              <button type="button" class="btn btn-danger btn-block">
                <span class='glyphicon glyphicon-shopping-cart'></span>
                장볼리스트 공간 : <b><?=$shopping_number?></b> / 5
              </button>
            <?php
            } else {
            ?>
              <button type="button" class="btn btn-default btn-block">
                <span class='glyphicon glyphicon-shopping-cart'></span>
                장볼리스트 공간 : <b><?=$shopping_number?></b> / 5
              </button>
            <?php
          }

        ?>
        <p><form action="shopping_list_delete_process.php" method="post"
          style="display:inline;">
          <input type="hidden" name="nick" value=<?=$nick?>>
          <input type="hidden" name="class" value=<?=$class?>>
          <input type="hidden" name="recipe" value=<?=$recipe?>>
          <input type="hidden" name="delete" value="all">
          <button class="btn btn-default btn-block" type="submit" onclick="return confirm('장볼리스트를 전체 지웁니까?')">
            <span class='glyphicon glyphicon-trash'></span>
            전체 리스트 비우기
          </button>
        </form></p><hr>
        <?php } ?>

<!--레시피 리스트--------------------------------------------------------------->
    <h4 style="text-align:center; color:#f0ad4e"><b>레시피 목록</b></h4>
    <h5 style="text-align:center">Recipe list</h5>
    <div class="table-responsive panel panel-default">
      <table class="table">
        <thead>
          <tr>
            <th>크리에이터</th>
            <th>레시피(링크)</th>
            <th>인분</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php
            //레시피리스트를 꺼냄
            for ($i=0; $i <5 ; $i++) {
              if(isset($shopping_list_load_row['class'.$i])){
                $grocery_list_load_sql = "SELECT * FROM recipe_list
                WHERE class='{$shopping_list_load_row['class'.$i]}' &&
                recipe='{$shopping_list_load_row['recipe'.$i]}'";
                $grocery_list_load_result = mysqli_query($conn, $grocery_list_load_sql);
                $grocery_list_load_row = mysqli_fetch_array($grocery_list_load_result);

                //레시피별 재료들을 꺼내서 배열화 함 : 차후 합산 작업을 위하여
                for ($j=0; $j < 6 ; $j++) {
                  if($grocery_list_load_row['grocery'.$j]){
                    $gram_result = $grocery_list_load_row['gram'.$j]
                    *$shopping_list_load_row['meal'.$i]
                    /$grocery_list_load_row['meal'];

                    //재료별 데이터 로드
                    $grocery_load_sql = "SELECT * FROM grocery_list WHERE grocery_name='{$grocery_list_load_row['grocery'.$j]}';";
                    $grocery_load_result = mysqli_query($conn, $grocery_load_sql);
                    $grocery_load_row = mysqli_fetch_array($grocery_load_result);
                    $grocery_array[] = $grocery_list_load_row['grocery'.$j];
                    $gram_array[] = $gram_result;
                  }
                }
          ?>
          <tr>
            <?php
              echo "<td>".$shopping_list_load_row['class'.$i]."</td>";
              echo "<td>"."<a class='btn btn-xs btn-link' href='index.php?class="
              .$shopping_list_load_row['class'.$i]."&recipe="
              .$shopping_list_load_row['recipe'.$i]
              ."'>".$shopping_list_load_row['recipe'.$i]."</a></td>";
              echo "<td>".$shopping_list_load_row['meal'.$i]."인분</td>";

              if($request_uri !=="/payment.php"){
              ?>

            <td>
              <form action="shopping_list_delete_process.php" method="post"
                style="display:inline;">
                 <input type="hidden" name="nick" value=<?=$nick?>>
                 <input type="hidden" name="delete" value="select">
                 <input type="hidden" name="num" value=<?=$i?>>
                 <input type="hidden" name="class"
                  value=<?=$shopping_list_load_row['class'.$i]?>>
                 <input type="hidden" name="recipe"
                  value=<?=$shopping_list_load_row['recipe'.$i]?>>
                 <button class="btn btn-default btn-xs" type="submit" onclick="return confirm('장볼리스트 해당 내역을 지웁니까?')">
                   <span class='glyphicon glyphicon-trash'></span></button>
              </form>
            </td>
          <?php } ?>
          </tr>
          <?php
              }
            }
          ?>
          </tbody>
        </table>
      </div>

<!--안내----------------------------------------------------------------------->

      <div>
        ※ 위 레시피들에 필요한 모든 재료를 중복하여 아래 <b>'GROCERY LIST'</b>에 표시합니다.
          세부 재료는 각 레시피를 클릭하여 확인해주세요.
      </div>

<!--식재료 리스트--------------------------------------------------------------->
          <hr>
          <h4 style="text-align:center; color:#f0ad4e"><b>식재료 목록</b></h4>
          <h5 style="text-align:center">Grocery list</h5>
          <div class="table-responsive panel panel-default">
            <table class="table">
              <thead>
                <tr>
                  <th>장볼재료</th>
                  <th>양</th>
                  <th class='text-right'>가격</th>
                </tr>
              </thead>
              <tbody>
                  <?php
                  //식재료 토탈 가격
                  $grocery_total_price = 0;
                  //식재료 몇종 인지
                  $grocery_total_number = 0;
                  //식재료 전체 텍스트
                  $grocery_total_text = "";

                  if(isset($grocery_array)){
                    for ($i=0; $i < count($grocery_array) ; $i++) {
                      for ($j=0; $j < count($grocery_array) ; $j++) {
                        if($j!=$i && $grocery_array[$i]===$grocery_array[$j]){
                          $gram_array[$i] = $gram_array[$i] + $gram_array[$j];
                          $grocery_array[$j] = "없음";
                          $gram_array[$j] = 0;
                        }
                      }
                      if($gram_array[$i]!=0){

                        $grocery_total_number++;
                        $grocery_total_text = $grocery_total_text.$grocery_array[$i]."(";

                        echo "<tr><td>".$grocery_array[$i]."</td>";

                        //재료별 데이터 로드
                        $grocery_load_sql = "SELECT * FROM grocery_list WHERE grocery_name='{$grocery_array[$i]}';";
                        $grocery_load_result = mysqli_query($conn, $grocery_load_sql);
                        $grocery_load_row = mysqli_fetch_array($grocery_load_result);

                        if($grocery_load_row['gram_unit'] != 0){
                          echo "<td>".number_format($gram_array[$i])."g";
                          echo "(".round($gram_array[$i]/$grocery_load_row['gram_unit'], 1)
                            .$grocery_load_row['unit'].")</td>";
                        } else {
                          echo "<td>".number_format($gram_array[$i])."g</td>";
                        }
                        $grocery_total_text = $grocery_total_text.number_format($gram_array[$i])."g/";

                        $grocery_price = round($gram_array[$i]*$grocery_load_row['price_100g']/100,0);
                        $grocery_total_price = $grocery_total_price + $grocery_price;
                        echo "<td class='text-right'>".number_format($grocery_price)."원</td></tr>";
                        $grocery_total_text = $grocery_total_text.number_format($grocery_price)."원)";

                        }
                      }
                    }
                    ?>

                  </tbody>
                </table>
              </div>

<!--합계----------------------------------------------------------------------->
              <hr>
              <h4 style="text-align:center; color:#f0ad4e"><b>총합 가격</b></h4>
              <h5 style="text-align:center">Total Price</h5>
              <div class="table-responsive panel panel-default">
                <table class="table">
                  <thead>
                    <tr>
                      <th>장볼재료 총 가격</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                        echo "<td class='text-right'>".number_format($grocery_total_price)."원</td>";
                       ?>
                  </tbody>
                </table>
              </div>
              <?php
              //페이먼트 아닐때만 보여줘
              if($request_uri !=="/payment.php"){
                if($grocery_total_price>0){
                  $payment_check_sql = "SELECT count(*) FROM payment_list";
                  $payment_check_result = mysqli_query($conn, $payment_check_sql);
                  $payment_check_row = mysqli_fetch_array($payment_check_result);
                  if($grocery_total_price>20000){
                    ?>
                    <a href="payment.php">
                      <button class='btn btn-warning btn-block' type="button" name="button"
                      onclick="alert('실제로 결제되지 않으니 걱정하지 않으셔도 됩니다.')">
                        <span class='glyphicon glyphicon-usd'></span> 온라인 장보기
                        (TEST 누적횟수 : <?=$payment_check_row[0]?>회)
                      </button>
                    </a>
                    <?php
                  } else {
                    ?>
                    <button class='btn btn-warning btn-block' type="button" name="button"
                    onclick="alert('온라인 장보기는 20,000원 이상부터 가능합니다.');">
                      <span class='glyphicon glyphicon-usd'></span> 온라인 장보기
                      (TEST 누적횟수 : <?=$payment_check_row[0]?>회)
                    </button>
                    <?php
                  }
                }

               ?>
 <!--안내----------------------------------------------------------------------->
            <br>
            <div>
               <h5 style="text-align:center">※ 온라인 장보기 기능이 추가된다면 좋을까요?<br>여러분의 <b>테스트</b> 결제 누적횟수가 많아지면<br>실제 적용해보려 합니다. </h5>
             </div>
             <?php
             }
             ?>
            </div>
          </div>

              <?php
              } else {
                    //닉네임 세션값이 없다면 : 로그인 하지 않았다면
                    ?>
                      <a href="login.php">
                        <button type='button' class='btn btn-info btn-block'>
                          장볼리스트를 활용하려면 로그인 필요
                        </button>
                      </a>
        </div>
      </div>
    <div class="panel panel-default" style="padding:10px;">
      <p style='text-align:center'><button class='btn btn-warning btn-xs'>
        도움말</button></p>
      <h6 style='text-align:center'>레시피를 장볼리스트에 담으면 <br>레시피에
        필요한 식재료 리스트와 <br>총 가격을 알려드립니다.</h6>
    </div>

    <?php

  }
?>

<div class="panel panel-default" style="padding:10px;">
  <a href="https://goo.gl/forms/xt5ZIUttk4Gr8mBN2" target="_blank">
    <button class="btn btn-default btn-block" type="button" name="button">
      <h4 style="text-align:center; color:#f0ad4e"><b>피드백은 더 나은 서비스를 만듭니다.</b></h4>
      <h5 style="text-align:center">Please participate in the <b>survey</b></h5>
    </button>
  </a>
</div>
