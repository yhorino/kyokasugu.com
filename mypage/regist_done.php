<?php
session_start();

// セッション内に「エラー情報のフラグ」が入っていたら取り出す
$view_data = array();
if (true === isset($_SESSION['output_buffer'])) {
    $view_data = $_SESSION['output_buffer'];
}

// (二重に出力しないように)セッション内の「出力用情報」を削除する
unset($_SESSION['output_buffer']);
$title="マイページ　ログイン";
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
  <div id="login_input">
   
   <p>入力いただいたメールアドレスへ「仮パスワード」を記載したメールを送信しました。</p>
   
   <div class="input_item">
    <a href="index.php">ログイン画面へ</a>
   </div>
   
  </div>
  
 </div>
<?php include_once('footer.php'); ?>

<script>
 $(function(){
  $("#acc_id").hide();
  $("#acc_link").click(function(){
   $("#acc_id").slideToggle();
   return false;
  });
 });
</script>
 
</body>
</html>
