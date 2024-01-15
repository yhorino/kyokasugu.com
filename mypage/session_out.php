<?php
header("Content-type: text/html;charset=utf-8");
$data_unserialize = unserialize($_SESSION['kyoka_mypage_data']);
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
 <h2 class="mypage_title">セッション有効期限切れ</h2>
</div>
 
<div class="outer_box_body">

 <div class="session_out_box">
  <p>
   長時間無操作だったため、セッションの有効期限が切れました。
  </p>

  <a href="/" class="submit_button" id="submit_button">トップページへ</a>

 </div>
</div>

<?php include_once('footer.php'); ?>

</body>
</html>
