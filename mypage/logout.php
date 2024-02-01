<?php
session_start();

unset($_SESSION['kyoka_mypage_data']);
$title="マイページ　ログアウト";
$description="";

?>
<!DOCTYPE HTML>
<html lang="ja" id="login_php">
<head>
<?php include_once  $_SERVER['DOCUMENT_ROOT'].'/template_php/gtag_head.html'; ?>
<?php include_once  $_SERVER['DOCUMENT_ROOT'].'/mypage/head_settings.php'; ?>
</head>

<body>
<?php include_once  $_SERVER['DOCUMENT_ROOT'].'/template_php/gtag_body.html'; ?>
 
 <?php 
 $option_class = 'no_menu no_login';
 include_once('header.php');
 ?>
 
 <div class="inner">
  <div class="login_input">
   
   <p>ログアウトしました。</p>
   
   <div class="regist_button_box">
    <a href="/">トップページへ</a>
   </div>
   
  </div>
  
 </div>
<?php include_once('footer.php'); ?>

</body>
</html>
