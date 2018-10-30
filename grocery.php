<!-- php display_errors on -->
<!-- php opcache.enable = 0 -->
<?php require_once('view/0_top.php');?>

<div class="container">

<div class="row">

    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-body ">

          <?php
            if(isset($_GET['page'])){
              $page = $_GET['page'];
            } else {
              $page = 1;
            }
          ?>

        <script>
          //초기출력
          window.setTimeout("grocery_show()", 100);
        </script>

        <h2 style="text-align:center;">식재료DB</h2>
        <br>
        <div class="alert alert-info">
           <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
           <p> ※ 기본 데이터는 KAMIS, 쿠팡, FAT-SECRET, 네이버지식백과 등을 활용하여 작성되었습니다.  </p>
           <p> ※ 식재료 데이터는 수정 및 추가하여 사용할 수 있습니다.  </p>
           <p> ※ 아래 정보는 참고용이지 모든 가격, 칼로리, 단위들을 보장하지 않습니다.  </p>
        </div>
        <br>

        <script>
          //리스트 보여주는 fetch api 연결
          function grocery_show(){

            var grocery_name = document.getElementById('grocery_name').value;
            if(grocery_name != ""){
              var price_100g = document.getElementById('price_100g').value;
              var reference = document.getElementById('reference').value;
              var gram_unit = document.getElementById('gram_unit').value;
              var unit = document.getElementById('unit').value;
              var calorie_100g = document.getElementById('calorie_100g').value;
              var etc = document.getElementById('etc').value;

              fetch("grocery_list.php", {
                  method : "POST",
                  headers : {
                    "Content-Type" : "application/x-www-form-urlencoded"
                  },
                  body : "grocery_name="+grocery_name+
                  "&price_100g="+price_100g+
                  "&reference="+reference+
                  "&gram_unit="+gram_unit+
                  "&unit="+unit+
                  "&calorie_100g="+calorie_100g+
                  "&etc="+etc+
                  "&page=<?=$page?>"
                })
              .then(function(response){
                response.text().then(function(text){
                  document.querySelector("#grocery_list").innerHTML = text;
                })
              });

              document.getElementById('grocery_name').value = "";
              document.getElementById('price_100g').value = 0;
              document.getElementById('reference').value = "";
              document.getElementById('gram_unit').value = 0;
              document.getElementById('unit').value = "";
              document.getElementById('calorie_100g').value = 0;
              document.getElementById('etc').value = "";
            } else {
              fetch("grocery_list.php?page=<?=$page?>")
              .then(function(response){
                response.text().then(function(text){
                  document.querySelector("#grocery_list").innerHTML = text;
                })
              });
            }

          }

        </script>

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
                <th></th>
              </tr>
            </thead>
            <!-- 표 본문 -->
            <tbody>
              <tr>
                <td>

                </td>
                <td>
                  <input id='grocery_name' class='form-control' type="text"
                  name="grocery_name" placeholder="식재료 이름">
                </td>
                <td>
                  <input id='price_100g' class='form-control' type="number"
                  name="price_100g" value="0" min="0">
                </td>
                <td>
                  <input id='reference' class='form-control' type="text"
                  name="reference" placeholder="가격 출처">
                </td>
                <td>
                  <input id='gram_unit' class='form-control' type="number"
                  name="gram_unit" value="0" min="0">
                </td>
                <td>
                  <input id='unit' class='form-control' type="text"
                  name="unit" placeholder="단위">
                </td>
                <td>
                  <input id='calorie_100g' class='form-control' type="number"
                  name="calorie_100g" value="0" min="0">
                </td>
                <td>
                  <input id='etc' class='form-control' type="text"
                  name="etc" placeholder="기타">
                </td>
                <td>
                  <input class="btn btn-success" type="submit" height="30px"
                  value="추가" onclick="grocery_show();">
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div id="grocery_list">
        </div>

      </div>
    </div>
  </div>
</div>

<!-- HTML 하단 영역 -->
<?php require_once('view/bottom.php');?>
