<!-- php display_errors on -->
<!-- php opcache.enable = 0 -->
<?php require_once('view/0_top.php');?>
<?php require_once('view/1_filter.php');?>

<div class="row">

    <div class="col-sm-12">
      <?php require_once('view/2_recipe.php');?>
    </div>

</div>

<!-- HTML 하단 영역 -->
<?php require_once('view/bottom.php');?>
