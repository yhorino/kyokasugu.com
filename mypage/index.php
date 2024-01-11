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
 <?php include_once('pw_toggle.inc'); ?>
 
 <div class="inner">
  <div id="login_input">
  <form action="./login.php" method="post">
   
   <p>顧客番号とパスワードを入力してください。</p>
   
   <div class="input_item">
    <span class="input_label">顧客番号</span><input type="text" name="id" value="" required><span>（半角英数字8桁）</span>
    <input type="hidden" name="mode" value="">
   </div>
   
   <div class="input_item">
    <span class="input_label">パスワード</span><span class="input_password"><input type="password" name="pass" value="" required><i class="fa-solid fa-eye pw_input_eyeicon"></i></span><span>（半角英数字）</span>
   </div>

<?php if ( (isset($view_data['error_invalid_login']))&&(true === $view_data['error_invalid_login']) ) : ?>
    <span class="error">顧客番号またはパスワードに誤りがあります<br></span>
<?php endif; ?>
   
   <div class="input_item">
    <button type="submit" id="login_button">ログイン</button>
   </div>
   
  </form>
   
  <div id="regist">
   <p>初めてご利用する方はこちら</p>
   <a href="regist.php" id="regist_btn" >新規登録</a>
  </div>
   
  </div>

  <div id="word_info">
  <ul>
   <li><strong>顧客番号</strong><br>マイページ登録時にトータルマネジマントが発行したマイページログイン用の番号です。<br>顧客番号がわからない場合は「<a href="tel:0120968631">0120-968-631</a>」までお問合せください。</li>
   <li><strong>パスワード</strong><br>マイページにて登録いただいたパスワードです。<br>未登録の方、パスワードを忘れた方は「<a href="regist.php" class="normal_link">パスワード登録</a>」から登録をしてください。</li>
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
