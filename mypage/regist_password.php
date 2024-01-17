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

function isChangeMode(){
 if(isset($_GET['mode']) && $_GET['mode'] == 'change'){ return true;}
 else { return false;}
}

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
  
    <?php if(isChangeMode()) { ?>
   <h2>パスワード変更</h2>
    <?php } else { ?>
   <h2>パスワード登録</h2>
    <?php } ?>
  
  <div class="login_input">
  <form action="./send_pass.php" method="post">
   
    <?php if(isChangeMode()) { ?>
   <p>新しいパスワードを入力してください。</p>
    <?php } else { ?>
   <p>パスワードを登録してください。</p>
    <?php } ?>
   
   <div class="input_item_box">
    
    <?php if(isChangeMode()) { ?>
     <input type="hidden" name="tmppass" value="<?php echo $_GET['id'];?>">    
    <?php } else { ?>
   <div class="input_item">
    <span class="input_label">仮パスワード</span><span class="input_password"><input type="text" name="tmppass" value="" required></span><span>（半角英数字）</span>
   </div>
    <?php } ?>

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
    
   </div>
   
   <div class="login_button_box">
    <button type="submit" id="send_button">送信</button>
   </div>
   
  </form>
   
  </div>
  
  <div id="word_info">
    <?php if(isChangeMode()) { ?>
    <?php } else { ?>
  <ul>
   <li><strong>仮パスワード</strong><br>マイページ登録時にトータルマネジマントから送信したメールに記載されています。</li>
  </ul>
 </div>
    <?php } ?>
  
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
