<?php
session_start();
header("Content-type: text/html;charset=utf-8");

include_once('class.php');

$_id = $_POST['id'];
$_tmppass = $_POST['tmppass'];
$_pass = $_POST['pass'];
$_pass2 = $_POST['pass2'];

$_SESSION['output_buffer']['error_unmatch'] = false;
if($_pass != $_pass2){
 $_SESSION['output_buffer']['error_unmatch'] = true;
 header('Location: ./regist_password.php?id='.$_id);
 exit();
}
$_mypage_kyoka = new LoginKyokaData();
$_SESSION['output_buffer']['error_datanotfound'] = false;
if($_mypage_kyoka->getRecordDataById($_id) == false){
 $_SESSION['output_buffer']['error_datanotfound'] = true;
 header('Location: ./regist_password.php?id='.$_id);
 exit();
}

if($_tmppass != $_id){
 $_SESSION['output_buffer']['error_tmppass_unmatch'] = true;
 if($_tmppass != $_mypage_kyoka->PasswordTmp()){
  $_SESSION['output_buffer']['error_tmppass_unmatch'] = true;
  header('Location: ./regist_password.php?id='.$_id);
  exit();
 }
}

$_mypage_kyoka->setPassword($_pass);
$_mypage_kyoka->setPasswordTmp('');
$_mypage_kyoka->setStatus(STATUS_ACTIVE);
$_mypage_kyoka->updateRecordData();

header('Location: ./regist_password_done.php');
exit();

?>
