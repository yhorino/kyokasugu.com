<?php
session_start();
header("Content-type: text/html;charset=utf-8");

include_once('class.php');

$_id = $_POST['id'];
$_mail = $_POST['mail'];

$_account_kyoka = new AccountKyokaData();
$_account_kyoka->setKokyakuBango($_id);
$_account_kyoka->getRecordDataByKokyakuBango();

$_SESSION['output_buffer']['error_notfound'] = false;
$id = $_account_kyoka->Id();
if($id == ''){
 $_SESSION['output_buffer']['error_notfound'] = true;
 header('Location: ./regist.php');
 exit();
}
$_mypage_kyoka = new LoginKyokaData();
$_mypage_kyoka->constructTmpData($_account_kyoka->KyokaBango());
$_mypage_kyoka->setEmail($_mail);
$_mypage_kyoka->setTmpPasswordMailSent('false');
$_mypage_kyoka->upsertRecordData();

header('Location: ./regist_done.php');
exit();

?>
