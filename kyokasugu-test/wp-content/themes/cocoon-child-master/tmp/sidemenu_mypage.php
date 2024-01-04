<link rel="stylesheet" href="/kyokasugu-test/wp-content/themes/cocoon-child-master/tmp/sidemenu.css" type="text/css">

<nav id="common_sidemenu">
 
 <div class="sm_outer jimu">
  
  <div class="sm_header">
   
   <div class="sm_logo">
    <a href="/">
     <div class="sm_logo_button_sp"><img src="/kyokasugu-test/wp-content/uploads/2023/12/logo_kyoka.png" alt="建設業許可すぐ取りたい"></div>
    </a>
   </div>
   
   <div class="sm_spacer">
   </div>
   
   <div class="sm_menuclose">
    <a onclick="menu_slideout();">
     <div class="sm_menuclose_button_pc"><i class="fas fa-times menuclose_icon"></i> <span class="menuclose_text">閉じる</span></div>
     <div class="sm_menuclose_button_sp sp_button"><i class="fas fa-times menuclose_icon sp_icon"></i><span class="menuclose_text sp_text">閉じる</span></div>
    </a>
   </div>
   
  </div>
  
  <div class="sm_body">
   <ul class="sm_list">
	   <li><a href="/mypage/top.php">マイページTOP</a></li>
	   <li><a href="/mypage/kaisya.php">会社情報</a></li>
	   <li><a href="/mypage/kanyusya.php">特別加入者情報</a></li>
	   <li><a href="/mypage/kanyusya.php">会員カード</a></li>
	   <li><a href="/mypage/kanyusya.php">加入証明書</a></li>
	   <li><a href="/mypage/download.php">各種ダウンロード・印刷</a></li>
   </ul>
  </div>
  
  <div class="sm_footer">
   <!--
   <div class="sm_footer_syokaibox">
    <div class="sm_footer_syokai_title">友達紹介はこちら</div>
    <div class="sm_footer_syokai_body">
     <a class="sm_footer_syokai_syokaibutton" href="http://line.me/R/msg/text/?友達紹介【一人親方労災保険RJC】%0d%0aこちらからお申込みください%0d%0ahttps://www.xn--4gqprf2ac7ft97aryo6r5b3ov.tokyo/mailform_new/single_new/mitsumori_input.php%3futm_source=mypage%26utm_medium=line%26syoukai_no=<?php echo $_SESSION['row']['CellsNo__c']; ?>"><img src="image/ic_line.png" class="button_icon"> LINEで紹介</a>
     <a class="sm_footer_syokai_syokaibutton" href="mailto:?subject=友達紹介【一人親方労災保険RJC】&amp;body=こちらからお申込みください%0d%0ahttps://www.xn--4gqprf2ac7ft97aryo6r5b3ov.tokyo/mailform_new/single_new/mitsumori_input.php%3futm_source=mypage%26utm_medium=mail%26syoukai_no=<?php echo $_SESSION['row']['CellsNo__c']; ?>"><img src="image/ic_mail.png" class="button_icon"> メールで紹介</a>
    </div>
   </div>
  -->
 </div>
 
</nav>

<script>
 jQuery(function($){
  $('#common_sidemenu').addClass('hide');
 });
 function menu_slidein(){
  jQuery('#common_sidemenu').removeClass('hide');
  jQuery('#common_sidemenu').addClass('show');
 }
 function menu_slideout(){
  jQuery('#common_sidemenu').removeClass('show');
  jQuery('#common_sidemenu').addClass('hide');
 }
</script>

