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
  <form action="./send_pass.php" method="post">
   
   <p>パスワードを登録してください。</p>
   
   <div class="input_item">
    <span class="input_label">仮パスワード</span><span class="input_password"><input type="text" name="tmppass" value="" required></span><span>（半角英数字）</span>
   </div>

   <div class="input_item">
    <span class="input_label">パスワード</span><span class="input_password"><input type="password" name="pass" value="" required><i class="fa-solid fa-eye pw_input_eyeicon"></i></span><span>（半角英数字）</span>
   </div>

   <div class="input_item">
    <span class="input_label">パスワード（再入力）</span><span class="input_password"><input type="password" name="pass2" value="" required><i class="fa-solid fa-eye pw_input_eyeicon"></i></span><span>（半角英数字）</span>
   </div>
   
   <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
   
<?php if ( (isset($view_data['error_tmppass_unmatch']))&&(true === $view_data['error_tmppass_unmatch']) ) : ?>
    <span class="error">仮パスワードが一致しません<br></span>
<?php endif; ?>

<?php if ( (isset($view_data['error_unmatch']))&&(true === $view_data['error_unmatch']) ) : ?>
    <span class="error">入力されたパスワードが一致しません<br></span>
<?php endif; ?>

<?php if ( (isset($view_data['error_datanotfound']))&&(true === $view_data['error_datanotfound']) ) : ?>
    <span class="error">マイページ登録情報が見つかりませんでした。<br></span>
<?php endif; ?>
   
   <div class="input_item">
    <button type="submit" id="send_button">送信</button>
   </div>
   
  </form>
   
  </div>
  
  <div id="word_info">
  <ul>
   <li><strong>仮パスワード</strong><br>マイページ登録時にトータルマネジマントから送信したメールに記載されています。</li>
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
