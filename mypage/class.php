<?php
// DEBUG
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
// DEBUG


 include_once('../bin/sf_Api.php');
 define('SELECT_ACCOUNTKYOKA','Id,Name,Phone,kensetugyoukyokabangou__c,kyoka_kokyakubango__c');
 define('UPDATE_ACCOUNTKYOKA','Id,Name');
 define('SELECT_MYPAGEKYOKA','Id,Name,KokyakuBango__c,Password__c,Password_tmp__c,Status__c,Email__c,TmpPasswordMailSent__c,Account__c,KyokasyoPDF__c');
 define('UPDATE_MYPAGEKYOKA','Id,Name,Password__c,Password_tmp__c,Status__c,Email__c,TmpPasswordMailSent__c');

 define('SF_OBJECT_ACCOUNT', 'Account');
 define('SF_OBJECT_KYOKAMYPAGE', 'KyokaMypage__c');

 define('STATUS_REGIST', '登録作業中');
 define('STATUS_ACTIVE', '有効');
 define('STATUS_INACTIVE', '無効');
 define('STATUS_STOP', '一時停止');

/**********************************************************************/
/* 建設業許可　取引先データ */
/**********************************************************************/
 class AccountKyokaData{
  private $_Id;
  private $_Name;
  private $_kensetugyoukyokabangou__c;
  private $_kyoka_kokyakubango__c;
  private $_Phone;
  
  public function __construct(){
  }
  
  /* 参照関数 */
  public function Id(){return $this->_Id;}
  public function Name(){return $this->_Name;}
  public function Phone(){return $this->_Phone;}
  public function KyokaBango(){return $this->_kensetugyoukyokabangou__c;}
  public function KokyakuBango(){return $this->_kyoka_kokyakubango__c;}
  
  /* 設定関数 */
  public function setId($val){$this->_Id = $val;}
  public function setName($val){$this->_Name = $val;}
  public function setPhone($val){$this->_Phone = $val;}
  public function setKyokaBango($val){$this->_kensetugyoukyokabangou__c = $val;}
  public function setKokyakuBango($val){$this->_kyoka_kokyakubango__c = $val;}
  
  /* 判定関数 */
  public function checkTel($input_tel){
   $_input_tel_nohyp = str_replace('-','',$input_tel);
   $_this_phone_nohyp = str_replace('-','',$this->Phone());
   if($_input_tel_nohyp == $_this_phone_nohyp) return true;
   else return false;
  }
  
  /* SFからレコード取得 */  
  public function getRecordData(){
   if($this->KyokaBango() == '') return false;
   
   $_select = SELECT_ACCOUNTKYOKA;
   $_from = SF_OBJECT_ACCOUNT;
   $_kyokabango = $this->KyokaBango();
   $_where = "kensetugyoukyokabangou__c = '$_kyokabango'";
   $_orderby = "";
   
   $_result = (array)sf_soql_select($_select, $_from, $_where, $_orderby);
   if(count($_result) <= 0) return false;
   
   $_row = (array)$_result[0]['fields'];
   $this->_Id = $_result[0]['Id'];
   $this->_Name = $_row['Name'];
   $this->_Phone = $_row['Phone'];
   $this->_kensetugyoukyokabangou__c = $_row['kensetugyoukyokabangou__c'];
   
   return true;
  }
  
  public function getRecordDataByKokyakuBango(){
   if($this->KokyakuBango() == '') return false;
   
   $_select = SELECT_ACCOUNTKYOKA;
   $_from = SF_OBJECT_ACCOUNT;
   $_kokyakubango = $this->KokyakuBango();
   $_where = "kyoka_kokyakubango__c = '$_kokyakubango'";
   $_orderby = "";
   
   $_result = (array)sf_soql_select($_select, $_from, $_where, $_orderby);
   if(count($_result) <= 0) return false;
   
   $_row = (array)$_result[0]['fields'];
   $this->_Id = $_result[0]['Id'];
   $this->_Name = $_row['Name'];
   $this->_Phone = $_row['Phone'];
   $this->_kensetugyoukyokabangou__c = $_row['kensetugyoukyokabangou__c'];
   
   return true;
  }
  
  public function getRecordDataById(){
   if($this->Id() == '') return false;
   
   $_select = SELECT_ACCOUNTKYOKA;
   $_from = SF_OBJECT_ACCOUNT;
   $_id = $this->Id();
   $_where = "Id = '$_id'";
   $_orderby = "";
   
   $_result = (array)sf_soql_select($_select, $_from, $_where, $_orderby);
   if(count($_result) <= 0) return false;
   
   $_row = (array)$_result[0]['fields'];
   $this->_Id = $_result[0]['Id'];
   $this->_Name = $_row['Name'];
   $this->_Phone = $_row['Phone'];
   $this->_kensetugyoukyokabangou__c = $_row['kensetugyoukyokabangou__c'];
   
   return true;
  }
  
  public function updateRecordData(){
   /*
   $_select = UPDATE_ACCOUNTKYOKA;
   $_from = SF_OBJECT_ACCOUNT;
   $_where = "Id = '$this->_Id'";
   $_orderby = "";
   
   $updateitems=array(
     'shinchokujokyo__c'=>STATE_DATTAI,
     'moshikomiuketsuke__c'=>MOUSHIKOMI_FROM,
     'dattairiyu__c'=>$this->_DattaiRiyu,
     'dattaiuketsuke__c'=>true
    );
   
   sf_soql_update($_select, $_from, $_where, $_orderby, $updateitems);
   */
   return true;
  }
  
 };


/**********************************************************************/
/* 建設業許可　マイページ認証データ */
/**********************************************************************/
 class LoginKyokaData{
  private $_Id;
  private $_Name;
  private $_KokyakuBango__c;
  private $_Password__c;
  private $_Password_tmp__c;
  private $_Status__c;
  private $_Account__c;
  private $_Email__c;
  private $_TmpPasswordMailSent__c;
  private $_KyokasyoPDF__c;
  
  public function __construct(){
  }
  
  /* 参照関数 */
  public function Id(){return $this->_Id;}
  public function Name(){return $this->_Name;}
  public function KokyakuBango(){return $this->_KokyakuBango__c;}
  public function Password(){return $this->_Password__c;}
  public function PasswordTmp(){return $this->_Password_tmp__c;}
  public function Status(){return $this->_Status;}
  public function Account(){return $this->_Account__c;}
  public function Email(){return $this->_Email__c;}
  public function TmpPasswordMailSent(){return $this->_TmpPasswordMailSent__c;}
  public function KyokasyoPDF(){return $this->_KyokasyoPDF__c;}
  
  /* 設定関数 */
  public function setId($val){$this->_Id = $val;}
  public function setName($val){$this->_Name = $val;}
  public function setKokyakuBango($val){$this->_KokyakuBango__c = $val;}
  public function setPasswordTmp($val){$this->_Password_tmp__c = $val;}
  public function setStatus($val){$this->_Status = $val;}
  public function setAccount($val){$this->_Account__c = $val;}
  public function setEmail($val){$this->_Email__c = $val;}
  public function setTmpPasswordMailSent($val){$this->_TmpPasswordMailSent__c = $val;}
  public function setPassword($val){
   $this->_Password__c = password_hash($val, PASSWORD_BCRYPT);
  }
  
  public function constructTmpData($kyoka_bango){
   $this->setPasswordTmp($this->createTmpPassword());
   $_account_kyoka = new AccountKyokaData();
   $_account_kyoka->setKyokaBango($kyoka_bango);
   $_account_kyoka->getRecordData();
   $this->setAccount($_account_kyoka->Id());
   $this->setStatus(STATUS_REGIST);
  }
  
  public function createKokyakuBango($kyoka_bango){
   return $this->_createKokyakuBango($kyoka_bango, 0);
  }
  public function createTmpPassword(){
   $_random_text = uniqid(rand(), true);
   $_random_text_4 = substr($_random_text, -4);
   return $_random_text_4;
  }
  
  /* 判定関数 */
  public function checkPassword($input_pass){
   if(password_verify($input_pass, $this->Password())) return true;
   else return false;
  }
  
  /* SFからレコード取得 */
  public function getRecordDataById($id){
   $_select = SELECT_MYPAGEKYOKA;
   $_from = SF_OBJECT_KYOKAMYPAGE;
   $_where = "Id = '$id'";
   $_orderby = "";
   
   $_result = (array)sf_soql_select($_select, $_from, $_where, $_orderby);
   if(count($_result) <= 0) return false;
   
   $_row = (array)$_result[0]['fields'];
   $this->_Id = $_result[0]['Id'];
   $this->_Name = $_row['Name'];
   $this->_KokyakuBango__c = $_row['KokyakuBango__c'];
   $this->_Password__c = $_row['Password__c'];
   $this->_Password_tmp__c = $_row['Password_tmp__c'];
   $this->_Status = $_row['Status__c'];
   $this->_Account__c = $_row['Account__c'];
   $this->_TmpPasswordMailSent__c = $_row['TmpPasswordMailSent__c'];
   $this->_KyokasyoPDF__c = $_row['KyokasyoPDF__c'];
   
   return true;
  }
  
  public function getRecordDataByAccountId($id){
   $_select = SELECT_MYPAGEKYOKA;
   $_from = SF_OBJECT_KYOKAMYPAGE;
   $_where = "Account__c = '$id'";
   $_orderby = "";
   
   $_result = (array)sf_soql_select($_select, $_from, $_where, $_orderby);
   if(count($_result) <= 0) return false;
   
   $_row = (array)$_result[0]['fields'];
   $this->_Id = $_result[0]['Id'];
   $this->_Name = $_row['Name'];
   $this->_KokyakuBango__c = $_row['KokyakuBango__c'];
   $this->_Password__c = $_row['Password__c'];
   $this->_Password_tmp__c = $_row['Password_tmp__c'];
   $this->_Status = $_row['Status__c'];
   $this->_Account__c = $_row['Account__c'];
   $this->_TmpPasswordMailSent__c = $_row['TmpPasswordMailSent__c'];
   $this->_KyokasyoPDF__c = $_row['KyokasyoPDF__c'];
   
   return true;
  }
  
  public function getRecordData(){
   if($this->KokyakuBango() == '') return false;
   
   $_select = SELECT_MYPAGEKYOKA;
   $_from = SF_OBJECT_KYOKAMYPAGE;
   $_kokyakubango = $this->KokyakuBango();
   $_where = "KokyakuBango__c = '$_kokyakubango'";
   $_orderby = "";
   
   $_result = (array)sf_soql_select($_select, $_from, $_where, $_orderby);
   if(count($_result) <= 0) return false;
   
   $_row = (array)$_result[0]['fields'];
   $this->_Id = $_result[0]['Id'];
   $this->_Name = $_row['Name'];
   $this->_KokyakuBango__c = $_row['KokyakuBango__c'];
   $this->_Password__c = $_row['Password__c'];
   $this->_Password_tmp__c = $_row['Password_tmp__c'];
   $this->_Status = $_row['Status__c'];
   $this->_Account__c = $_row['Account__c'];
   $this->_TmpPasswordMailSent__c = $_row['TmpPasswordMailSent__c'];
   $this->_KyokasyoPDF__c = $_row['KyokasyoPDF__c'];
   
   return true;
  }
  
  public function updateRecordData(){
   if($this->_Id == '') return false;
   
   $_select = UPDATE_MYPAGEKYOKA;
   $_from = SF_OBJECT_KYOKAMYPAGE;
   $_id = $this->Id();
   $_where = "Id = '$_id'";
   $_orderby = "";
   
   $updateitems=array(
     'TmpPasswordMailSent__c'=>$this->TmpPasswordMailSent(),
     'Password__c'=>$this->Password(),
     'Password_tmp__c'=>$this->PasswordTmp(),
     'Status__c'=>$this->Status()
    );
   
   sf_soql_update($_select, $_from, $_where, $_orderby, $updateitems);
   
   return true;
  }
  
  public function updateRecordData_TmpPass(){
   if($this->_Id == '') return false;
   
   $_select = UPDATE_MYPAGEKYOKA;
   $_from = SF_OBJECT_KYOKAMYPAGE;
   $_id = $this->Id();
   $_where = "Id = '$_id'";
   $_orderby = "";
   
   $updateitems=array(
     'TmpPasswordMailSent__c'=>$this->TmpPasswordMailSent(),
     'Password_tmp__c'=>$this->PasswordTmp(),
     'Email__c'=>$this->Email(),
     'Status__c'=>$this->Status()
    );
   
   sf_soql_update($_select, $_from, $_where, $_orderby, $updateitems);
   
   return true;
  }
  
  public function insertRecordData(){
   $_type = SF_OBJECT_KYOKAMYPAGE;
   
   $insertitems=array(
     'TmpPasswordMailSent__c'=>$this->TmpPasswordMailSent(),
     'Account__c'=>$this->Account(),
     'Name'=>$this->Name(),
     'KokyakuBango__c'=>$this->KokyakuBango(),
     'Password__c'=>$this->Password(),
     'Password_tmp__c'=>$this->PasswordTmp(),
     'Email__c'=>$this->Email(),
     'Status__c'=>$this->Status()
    );
   
   sf_soql_insert($_type, $insertitems);
   
   return true;
  }
  
  public function upsertRecordData(){
   if($this->Account() == '') return false;
   
   $_mypage_kyoka = new LoginKyokaData();
   $_mypage_kyoka->getRecordDataByAccountId($this->Account());
   if($_mypage_kyoka->Id() == ''){
    $this->insertRecordData();
   } else {
    $this->setId($_mypage_kyoka->Id());
    $this->updateRecordData_TmpPass();
   }
   
   return true;
  }
  
 };
?>
