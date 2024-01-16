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
  <div class="regist_input">
  <form action="./send_tmppass.php" method="post">
   
   <p>入力いただいたメールアドレスへ「仮パスワード」を記載したメールを送信します。</p>
   
   <div class="input_item_box">
    
   <div class="input_item">
    <span class="input_label">許可番号（半角数字6桁）</span><input type="text" name="id" value="" required>
    <input type="hidden" name="mode" value="">
   </div>
   
   <div class="input_item">
    <span class="input_label">電話番号（半角数字）</span><span class="input_tel"><input type="tel" name="tel" value="" required></span>
   </div>

   <div class="input_item">
    <span class="input_label">メールアドレス</span><span class="input_mail"><input type="email" name="mail" value="" required></span>
   </div>

<?php if ( (isset($view_data['error_notfound']))&&(true === $view_data['error_notfound']) ) : ?>
    <span class="error">許可番号または電話番号に誤りがあります<br></span>
<?php endif; ?>
   
   </div>
   
   <div class="regist_button_box">
    <button type="submit" id="send_button">送信</button>
   </div>
   
  </form>
   
  </div>

  <div id="word_info">
  <ul>
   <li><strong>許可番号</strong><br>トータルマネジマントが発行した６桁の番号です。<br>許可番号がわからない場合は「<a href="tel:0120968631">0120-968-631</a>」までお問合せください。</li>
  </ul>
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
