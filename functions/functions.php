<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

function getRequest(){
   $request = '';
   if(isset($_REQUEST['tpl'])) {
      $request = $_REQUEST['tpl'];
   } else if(isset($_REQUEST['mod'])) {
      $request = $_REQUEST['mod'];
   } else if(isset($_REQUEST['com'])) {
      $request = $_REQUEST['com'];
   } else {
      $request = 'homepage';
   }
   return $request;
}
function getFolder(){
   $folder = '';
   if(isset($_REQUEST['tpl'])) {
      $folder = '_templates';
   }else if(isset($_REQUEST['mod'])) {
         $folder = '_modules';
   }else if(isset($_REQUEST['com'])) {
         $folder = '_components';
   }
   return $folder;
}
function getPage(){
   $page = '';
   if(isset($_REQUEST['page'])) {
      $page = $_REQUEST['page'];
   } else {
      $page = '';
   }
   return $page;
}
function is_home() {
   $uri = $_SERVER['REQUEST_URI'];
   //die($uri);
   if (( $_REQUEST['tpl'] === 'homepage' OR '/synathina/' == $uri OR '/synathina/index.html' == $uri OR '/synathina/index.php' == $uri) && !isset($_REQUEST['tpl']) && !isset($_REQUEST['com']) && !isset($_REQUEST['mod']) ) {
      //print_r($uri);
      //die();
      return true;
   } else {
      return false;
   }
}

$homepage = is_home();

$servername = "localhost";
$username = "synathina";
$password = "";
$dbname = "synathina";

$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "SELECT * FROM wp_postmeta WHERE meta_key LIKE '_et_listing_lng' OR meta_key LIKE '_et_listing_lat'";
$result = $conn->query($sql);



$myArray = array(); // make a new array to hold all your data
$index = 0;
$buffer_id = 0;
while($row = $result->fetch_assoc()){ // loop to store the data in an associative array.
     $myArray[$index] = $row;
     $index++;
}
//print_r($myArray)

?>
