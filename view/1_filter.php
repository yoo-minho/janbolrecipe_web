<div id="filter" class="container" style="margin: 0px auto; padding:0px;
background-image:url('image/grocery3.jpg');
background-repeat: no-repeat; background-size:100%;">
  <div class="container" style="max-height: 700px;">

    <div class="row">

      <div class="col-sm-2">

      </div>
      <div class="col-sm-8" style='padding:0px'>

        <div style="margin-left:30px; margin-right:30px; margin-top:60px">
          <div style="text-align: center; background-color:rgba(0,0,0,0.7);">
            <h4 style="padding:10px; margin-top: 0px; color:white"><b>"<?=$class_row[0]?>명의 크리에이터,
              <?=$recipe_row[0]?>개 레시피</b>"</h4>
          </div>
        </div>

        <div style="margin-left:30px; margin-right:30px; margin-bottom:60px">
          <select style='background-color:rgba(255,255,255,0.8);' class="form-control" id="recipe"
            name="forma" onchange="location = this.options[this.selectedIndex].value;">
            <option selected value="" disabled>레시피를 선택해주세요 (ㄱㄴㄷ순)</option>;
            <?php
              //크리에이터(클래스) 리스트 가져옴
              $class_list_sql = "SELECT DISTINCT class, recipe FROM recipe_list ORDER BY recipe;";
              $class_list_result = mysqli_query($conn, $class_list_sql);
              while($row = mysqli_fetch_array($class_list_result)){
                    ?>
                      <option value="index.php?class=<?=$row[0]?>&recipe=<?=$row[1]?>">
                        <a href="#">
                          <?=$row[1]?> by <span style="color:gray"><?=$row[0]?></span>
                        </a>
                      </option>
                    <?php
                ?>
          <?php } ?>
          </select>
        </div>

      </div>
      <div class="col-sm-2">
      </div>
    </div>
  </div>
</div>

<div class="container">
