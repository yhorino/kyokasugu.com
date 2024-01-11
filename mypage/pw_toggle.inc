<?php /* 20220808 パスワード欄に表示非表示切り替え機能追加 */ ?>

<style>
.pw_input_box{
 position: relative;
}
.input_password{
 position: relative;
}
.pw_input_eyeicon{
 position: absolute;
 right: 0.2em;
 top: 0.2em;
}
</style>

<script>
$(function(){
 $('.pw_input_eyeicon').click(function(){
  $txtPass = $(this).parent('.input_password').find('input');
  if ($txtPass.get(0).type === "text") {
    $txtPass.get(0).type = "password";
    $(this).removeClass("fa-eye-slash");
    $(this).addClass("fa-eye");
  } else {
    $txtPass.get(0).type = "text";
    $(this).removeClass("fa-eye");
    $(this).addClass("fa-eye-slash");
  }
 });
});
</script>

<?php /* 20220808 パスワード欄に表示非表示切り替え機能追加 */ ?>

