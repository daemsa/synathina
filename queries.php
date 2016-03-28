<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>cziogas</title>
</head>
<body style="background-color:#000; color:#FFF; margin:0px; padding:0px;">
<?php
    function cutat($num, $tt){
        if (mb_strlen($tt)>$num){
            $tt=mb_substr($tt,0,$num-2).'...';
        }
        return $tt;
    }
   $db_name='synathina';
   $db_user='synathina';
   $db_pass='';
   $db_host='localhost';
   
   $conn=mysql_connect($db_host, $db_user, $db_pass);
   if (!$conn) {
    die('Could not connect: ' . mysql_error());
   }
   mysql_select_db ($db_name,$conn);
  mysql_query("set character_set_client=utf8");
  mysql_query("set character_set_connection=utf8"); 
  mysql_query("set collation_connection=utf8"); 
  mysql_query("set character_set_results=utf8");
   mysql_query("SET NAMES 'utf-8' ;"); 

      echo '{<br />
                "type" : "FeatureCollection",<br />
                "features" : [<br />';
                
   $query = "SELECT p.post_id,wp.post_title,wp.post_date,wp.post_content FROM wp_postmeta AS p LEFT JOIN wp_posts AS wp ON wp.ID=p.post_id  WHERE (p.meta_key='_et_listing_lng' OR p.meta_key='_et_listing_lat') GROUP BY p.post_id ORDER BY p.meta_id ASC ";
   $result=mysql_query($query);
    $i=0;
   while($row=mysql_fetch_array($result, MYSQL_ASSOC)){
      //echo $row['post_date'].'<br />';
      $query = "SELECT p.meta_value FROM wp_postmeta AS p  WHERE p.post_id=".$row['post_id']." AND p.meta_key='_et_listing_lng' LIMIT 1 ";
      $result1=mysql_query($query);
      $lng=mysql_result($result1, 0, 'meta_value');
      $query = "SELECT p.meta_value FROM wp_postmeta AS p  WHERE p.post_id=".$row['post_id']." AND p.meta_key='_et_listing_lat' LIMIT 1 ";
      $result2=mysql_query($query);
      $lat=mysql_result($result2, 0, 'meta_value');   
      if($lat == '' OR $lng == '') { $lat = 0; $lng = 0; }
      //echo $query;
      //$result=mysql_query($query);

               
      
      //while($row=mysql_fetch_array($result, MYSQL_ASSOC)){
         echo ' {<br />
          "type": "Point",<br />
          "object_constructor" : "Activity",<br />
          "coordinates": ['.$lat.', '.$lng.'],<br />
          "id" : '.$i.',<br />
          "is_featured" : false,<br />
          "slug" : "",<br />
          "team_id" : "",<br />
          "team_name" : "",<br />
          "team_members" : "",<br />
          "sponsor_title" : "",<br />
          "date" : "'.$row['post_date'].'",<br />
          "title" : "'.addcslashes($row['post_title'], '"').'",<br />
          "content" : "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima necessitatibus atque temporibus, rerum quod labore dolore minus consequuntur odit et sed ullam mollitia nemo. Porro magnam, neque! Distinctio, temporibus, ullam.",<br />
          "content_img" : "",<br />
          "logo" : "",<br />
          "logo_sponsor" : "",<br />
          "logo_team" : ""<br />
       },';
       //"content" : "'.cutat(200, addcslashes(strip_tags($row['post_content'], '"'))).'",<br />
         //echo $row['post_title'].' - '.$row['meta_id'].' - '.$row['post_id'].' - '.$row['meta_key'].' - '.$row['meta_value'].'<br />';
         
      //}
      $i++; 
   }
echo ' ]<br /> 
            }';      
            


?>

</body>
</html>