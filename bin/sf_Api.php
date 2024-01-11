<?php
/**
 *  あいち労災様
*
* @copyright Copyright (c) 2017, SunBridge Inc.
* @version v1.00
*
*    v1.00: 2017/06/22
*/
header('Content-Type: text/html; charset=UTF-8');
$_sf_root = dirname(dirname(__FILE__));


require_once("$_sf_root/lib/conf.php");
require_once("$_sf_root/lib/soapclient/SforcePartnerClient.php");
require_once("$_sf_root/lib/soapclient/SforceHeaderOptions.php");
require_once("$_sf_root/lib/Print.php");
require_once("$_sf_root/lib/Proxy.php");
require_once("$_sf_root/lib/SfLogin.php");
require_once("$_sf_root/lib/Util.php");



$sf_login = false;

function sf_soql_select($select, $from, $where, $orderby){
  global $_con;
  global $sf_login;

  if($sf_login == false){
   init();
   sf_login();
   $sf_login = true;
  }
 
  $returns = array();
  $query = "SELECT $select FROM $from WHERE $where $orderby";
  try {

    $response = $_con->query($query);

    $queryResult = new QueryResult($response);

    for ($queryResult->rewind(); $queryResult->pointer < $queryResult->size; $queryResult->next()) {
      array_push($returns, $queryResult->current());
    }
  } catch (Exception $e) {
    err_die(__LINE__, __FUNCTION__ . "["  . __LINE__ . "]: ". $e->getMessage());
  }
 
 // return $returns;
 return json_decode(json_encode($returns), true);
}

function sf_soql_update($select, $from, $where, $orderby, $updateitems){
  global $_con;
  global $sf_login;

  if($sf_login == false){
   init();
   sf_login();
   $sf_login = true;
  }
 
  try {
     $sobj = sf_soql_select_s($select, $from, $where, $orderby);
     $sobj->fields = $updateitems;
     $response = $_con->update(array($sobj));
     return TRUE;
  } catch (Exception $e) {
    err_die(__LINE__, __FUNCTION__ . "["  . __LINE__ . "]: ". $e->getMessage());
  }
}

function sf_soql_insert($type, $insertitems){
  global $_con;
  global $sf_login;

  if($sf_login == false){
   init();
   sf_login();
   $sf_login = true;
  }
 
  try {
     $sobj = new SObject();
     $sobj->type = $type;
     $sobj->fields = $insertitems;
     $response = $_con->create(array($sobj));
     return TRUE;
  } catch (Exception $e) {
    err_die(__LINE__, __FUNCTION__ . "["  . __LINE__ . "]: ". $e->getMessage());
  }
}

function sf_soql_select_s($select, $from, $where, $orderby){
  global $_con;
  global $sf_login;

  if($sf_login == false){
   init();
   sf_login();
   $sf_login = true;
  }
 
  $returns = array();
  $query = "SELECT $select FROM $from WHERE $where $orderby";
  try {

    $response = $_con->query($query);

    $queryResult = new QueryResult($response);

    for ($queryResult->rewind(); $queryResult->pointer < $queryResult->size; $queryResult->next()) {
      array_push($returns, $queryResult->current());
    }
  } catch (Exception $e) {
    err_die(__LINE__, __FUNCTION__ . "["  . __LINE__ . "]: ". $e->getMessage());
  }
 
 return $returns[0];
}


?>
