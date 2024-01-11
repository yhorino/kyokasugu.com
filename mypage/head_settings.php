<?php
  $currentPage = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>
 <meta name="robots" content="noindex">
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width">
 <link rel="stylesheet" href="style.css">
 <script src="https://kit.fontawesome.com/a366e23f99.js" crossorigin="anonymous"></script>
 <title><?php echo $title;?>　：　マイページ</title>

 <meta http-equiv="X-UA-Compatible" content="IE=edge" />
 <meta name="description" content="<?php echo $description;?>">
 <link rel="canonical" href="<?php echo $currentPage;?>">
 <link rel="alternate" media="handheld" href="<?php echo $currentPage;?>">
 
 <meta name="copyright" content="Copyright 2020 建設業許可すぐ取りたい All Rights Reserved.">
 <meta property="og:title" content="<?php echo $title;?>　：　マイページ">
 <meta property="og:type" content="article">
 <meta property="og:url" content="<?php echo $currentPage;?>">
 <meta property="og:image" content="">
 <meta property="og:site_name" content="建設業許可すぐ取りたい">
 <meta property="og:description" content="<?php echo $description;?>"> 
 <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png">
 <link rel="icon" href="/favicon.ico">
