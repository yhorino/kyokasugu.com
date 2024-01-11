<?php
session_start();
header("Content-type: text/html;charset=utf-8");

include_once('class.php');

$_id = $_POST['id'];
$_pass = $_POST['pass'];

$_mypage_kyoka = new LoginKyokaData();
$_mypage_kyoka->setKokyakuBango($_id);
$_mypage_kyoka->getRecordData();

$_SESSION['output_buffer']['error_invalid_login'] = false;
$login_check = $_mypage_kyoka->checkPassword($_pass);
if($login_check == false){
 $_SESSION['output_buffer']['error_invalid_login'] = true;
 header('Location: ./index.php');
 exit();
}


header('Location: ./top.php');
exit();

?>
