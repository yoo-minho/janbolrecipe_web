<!-- php display_errors on -->
<!-- php opcache.enable = 0 -->
<?php require_once('view/0_top.php');?>

<div class="container">

<div class="row">

    <div class="col-sm-12">
      <?php

        if (isset($_POST['edit'])) {

            ?>
            <h2 style="text-align:center;">식재료 수정</h2>
            <br>
            <div class="alert alert-info">
               <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
               <p> ※ 가격은 민감한 사항이므로 수정 시 가격출처를 꼭 확인해주세요.  </p>
               <p> ※ 기본 데이터에서 활용하는 사이트 외 정보를 활용했다면 기타에 적어주세요.  </p>
            </div>
            <br>

            <form action="grocery_edit_process.php" method="post">
              <div class="grocery_category">
                <div> </div>
                <div><strong>식재료이름</strong>
                  <input class='grocery_input' type="text" name="grocery_name"
                    value=<?=$_POST['grocery_name']?>></div>
                <div><strong>백그램당 won</strong>
                  <input class='grocery_input' type="number" name="price_100g"
                    value=<?=$_POST['price_100g']?> min="0"></div>
                <div><strong>가격 출처</strong>
                  <input class='grocery_input' type="text" name="reference"
                    value=<?=$_POST['reference']?>></div>
                <div><strong>단위당 gram</strong>
                  <input class='grocery_input' type="number" name="gram_unit"
                    value=<?=$_POST['gram_unit']?> min="0"></div>
                <div><strong>단위</strong>
                  <input class='grocery_input' type="text" name="unit"
                    value=<?=$_POST['unit']?>></div>
                <div><strong>백그램당 kcal</strong>
                  <input class='grocery_input' type="number" name="calorie_100g"
                   value=<?=$_POST['calorie_100g']?> min="0"></div>
                <div><strong>기타</strong>
                  <input class='grocery_input' type="text" name="etc"
                    value=<?=$_POST['etc']?>></div>
                <div>
                  <input type="hidden" name="id" value=<?=$_POST['id']?>>
                  <input class="btn btn-default btn-xs" type="submit" value="수정" style="height:40px"></div>
              </div>
            </form>
            <br>

          <?php

      }

      ?>
    </div>

</div>

<!-- HTML 하단 영역 -->
<?php require_once('view/bottom.php');?>
