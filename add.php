<!-- php display_errors on -->
<!-- php opcache.enable = 0 -->
<?php require_once('view/0_top.php');?>

<div class="container">

      <div class="panel panel-default" style="padding:10px;">
        <div class="panel-body" >
      <form name ="check_form" action="add_process.php?class=<?=$class?>" method="post" onsubmit="return checkform()">
          <input class='btn btn-warning' type="submit" value="작성 완료">

          <h3><b><?=$class?></b>의 레시피 추가</h3>
          <br>
          <div class="row">
            <div class="form-group col-sm-4">
              <label for="recipe">레시피 이름</label>
              <input id='recipe' class="form-control" type="text" name="recipe">
            </div>
            <div class="form-group col-sm-4">
              <label for="recipe">기준 인분</label>
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
            <div class="form-group col-sm-4">
              <label for="recipe">youtube.com/watch?v=</label>
                <input placeholder="ex) dRN75w1tYrY" class="form-control"
                type="text" name="video_code">
            </div>
          </div>

         <h4>여덟가지 기본재료</h4>
         <div class="panel panel-default" style="padding:10px;">
           <div class="panel-body" >
             <div class="row">

               <?php
                 $seasoning_array= array('간장', '설탕', '액젓', '고추장', '식용유', '참기름', '고춧가루', '다진마늘');
                   for ($i=0; $i < 8 ; $i++) {
                   ?>
                   <div class="col-sm-3">
                     <label for="recipe"><?=$seasoning_array[$i]?></label>
                     <select class="form-control" id="sel1" name="seasoning<?=$i?>">
                       <?php
                       for ($j=0; $j <11 ; $j++) {
                         if($j == 0){
                           echo "<option selected value=".($j*0.5).">".($j*0.5)." T</option>";
                         } else {
                           echo "<option value=".($j*0.5).">".($j*0.5)." T</option>";
                         }
                       }
                       ?>
                     </select>
                   </div>
                  <?php
                  }
                ?>
             </div>
            </div>
          </div>

         <h4>여섯가지 추가재료</h4>
         <div class="panel panel-default" style="padding:10px;">
           <div class="panel-body" >
             <div class="row">
               <?php for ($i=0; $i < 6 ; $i++) { ?>
                 <div class="col-sm-4">
                   <div class="panel" style="padding:10px;">
                     <div class="panel-body" >
                       <label for="recipe"><?=$i+1?>번째 추가재료 </label>
                       <input placeholder="예) 감자" class="form-control"
                       type="text" name="grocery<?=$i?>" style="margin-bottom:10px">
                       <label for="recipe">재료 용량 (gram)</label>
                       <input class="form-control"
                       type="number" name="gram<?=$i?>" value=0 min=0>
                     </div>
                   </div>
                 </div>
               <?php } ?>
             </div>
            </div>
          </div>

          <div class="alert alert-danger">
             <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
             <h5>※ <u>식재료DB에 있는 재료</u>들 이외 재료로 적으면 레시피 페이지에
               <b>에러</b>가 날 수 있으니 최대한 참고하여 작성해주시고 제한시 관리자에게
               문의 채팅(상단 닉네임 클릭 후 채팅리스트)주시길 바랍니다.  </h5>
           </div>

          <h4>식재료DB</h4>
          <div class="panel panel-default" style="padding:10px;">
            <div class="panel-body" >
              <div class="row">
                <?php
                $sql = "SELECT * FROM grocery_list ORDER BY grocery_name";
                $result = mysqli_query($conn, $sql);
                while ( $row = mysqli_fetch_array($result) ){
                  echo "<div class='col-sm-4'>";
                  if($row['gram_unit'] == 0){
                    echo "<u>".$row['grocery_name']."</u>";
                  } else {
                    echo "<u>".$row['grocery_name']."</u>(".$row['gram_unit']."g당 1".$row['unit'].")";
                  }
                  echo "</div>";
                }
                ?>
              </div>
             </div>
           </div>
         </form>
         </div>
    </div>
</div>

<!-- HTML 하단 영역 -->
<?php require_once('view/bottom.php');?>
