<?php
session_start();
header("Content-type: text/html;charset=utf-8");
$title="マイページTOP";
$description="";

include_once('class.php');

$data_unserialize_mypage = unserialize($_SESSION['kyoka_mypage_data']);
$data_unserialize_account = unserialize($_SESSION['kyoka_account_data']);
include('./session_check.php');
?>

<!doctype html>
<html id="top_php">
<head>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/template_php/gtag_head.html'; ?>
<?php include_once  $_SERVER['DOCUMENT_ROOT'].'/mypage/head_settings.php'; ?>
</head>

<body>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/template_php/gtag_body.html'; ?>
	
 
<?php include_once('header.php'); ?>

<div class="inner">
 <h2 class="mypage_title">マイページTOP</h2>
 <span class="mypage_name"><?php echo $data_unserialize_account->Name();?> 様</span>
 
 <div class="mypage_buttonbox">
  <h3 class="mypage_buttonbox_title">ダウンロードする</h3>
  <div class="mypage_buttonitems">
   <div class="mypage_buttonitem">
    <a href="<?php echo $data_unserialize_mypage->KyokasyoPDF();?>" class="mypage_button">
     <img src="img/ic_kyoka.png" class="mypage_button_icon" alt="">
     <span class="mypage_button_title">許可証</span>
    </a>
   </div>
  </div>
 </div>

 <div class="mypage_buttonbox">
  <h3 class="mypage_buttonbox_title">依頼する</h3>
  <div class="mypage_buttonitems">
   <div class="mypage_buttonitem">
    <a href="https://www.ccus-center.com/" class="mypage_button">
     <img src="img/ic_ccus.png" class="mypage_button_icon" alt="">
     <span class="mypage_button_title">建設キャリア<br>アップシステム</span>
    </a>
   </div>
   <div class="mypage_buttonitem">
    <a href="https://www.xn--y5q0r2lqcz91qdrc.com/" class="mypage_button">
     <img src="img/ic_rjc_jimu.png" class="mypage_button_icon" alt="">
     <span class="mypage_button_title">中小事業主の<br>特別労災</span>
    </a>
   </div>
   <div class="mypage_buttonitem">
    <a href="https://www.xn--4gqprf2ac7ft97aryo6r5b3ov.tokyo/" class="mypage_button">
     <img src="img/ic_rjc_hitori.png" class="mypage_button_icon" alt="">
     <span class="mypage_button_title">一人親方<br>労災保険</span>
    </a>
   </div>
  </div>
 </div>
 
</div>

<?php include_once('footer.php'); ?>

</body>
</html>