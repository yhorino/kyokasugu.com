<?php
header("Content-type: text/html;charset=utf-8");
$title="マイページTOP";
$description="";
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


	
<?php include_once('footer.php'); ?>

</body>
</html>