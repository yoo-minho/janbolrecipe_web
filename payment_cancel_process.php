<?php include_once("analyticstracking.php"); ?>

<?php
  //db연결
	require_once('command/mysql_connect.php');

  //변수
  $m_uid = $_POST['m_uid'];
  $nick = $_POST['nick'];

  if($_POST['submit'] === "결제취소"){
    $status_sql = "UPDATE payment_list SET status='결제취소' WHERE m_uid='$m_uid'";
    $status_result = mysqli_query($conn, $status_sql);
    if($status_result){
      header('Location: /payment_list.php?nick='.$nick);
    } else {
      echo mysqli_error($conn);
    }
  }else if($_POST['submit'] === "환불완료"){
    $status_sql = "UPDATE payment_list SET status='환불완료' WHERE m_uid='$m_uid'";
    $status_result = mysqli_query($conn, $status_sql);
    if($status_result){
      header('Location: /payment_list.php?nick='.$nick);
    } else {
      echo mysqli_error($conn);
    }
  }


 ?>
