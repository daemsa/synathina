<?

	$resp=mysql_connect("localhost",'synathina-sql','Pol2013@@!!');
	mysql_select_db('synathinasql');
	mysql_query("SET NAMES UTF8");


if ($_REQUEST['d']=='1')
{
    
	$query="SELECT term_id,(SELECT name FROM wp_terms WHERE wp_term_taxonomy.term_id=wp_terms.term_id) as name 
	        FROM `wp_term_taxonomy` WHERE taxonomy='listing_type' ORDER BY name ASC";
	$res=mysql_query($query);  
	$num=mysql_numrows($res);
	$numcount=0; 
	if ($_REQUEST['p1']=='0')
	{
		echo '{ "data" : ['; 
	}
	else
	{
		echo '{ "data" : [{"id":"none","name":"Όλα"}';      
	}
	while ($row=mysql_fetch_assoc($res))
   {           
       $numcount++;
       if (($_REQUEST['p1']=='0')&&($numcount==1))
       {
       }
       else
       {
       		echo ',';
       }
       echo '{"id":"'.$row['term_id'].'","name":"'.$row['name'].'"}';
       //if ($num>$numcount) 
   	    	
   }       
   echo ']}'; 
}

if ($_REQUEST['d']=='2')
{
    
	$query="SELECT term_id,(SELECT slug FROM wp_terms WHERE wp_term_taxonomy.term_id=wp_terms.term_id) as slug,(SELECT name FROM wp_terms WHERE wp_term_taxonomy.term_id=wp_terms.term_id) as name 
	        FROM `wp_term_taxonomy` WHERE taxonomy='listing_location' ORDER BY name ASC";
	$res=mysql_query($query);  
	$num=mysql_numrows($res);
	$numcount=0; 
	if ($_REQUEST['p1']=='0')
	{
		echo '{ "data" : ['; 
	}
	else
	{
		echo '{ "data" : [{"id":"none","name":"Όλα","slug":"Ola"}'; 
	}
	     
	while ($row=mysql_fetch_assoc($res))
   {           
       $numcount++;
       if (($_REQUEST['p1']=='0')&&($numcount==1))
       {
       }
       else
       {
       		echo ',';
       }
       echo '{"id":"'.$row['term_id'].'","name":"'.$row['name'].'","slug":"'.urldecode($row['slug']).'"}';
       //if ($num>$numcount) 
   	    	
   }       
   echo ']}'; 
}

if ($_REQUEST['d']=='3')
{
    
	$query="SELECT AVG(rating_rating) as avg
FROM `wp_ratings`
WHERE `rating_postid` = '".$_REQUEST['p1']."'";

	$res=mysql_query($query);  
	$num=mysql_numrows($res);
	$numcount=0; 
	echo '{ ';      
	while ($row=mysql_fetch_assoc($res))
   {           
       $numcount++;
       echo '"rating":'.$row['avg'];
       
   	    	
   }       
   echo '}'; 
}

if ($_REQUEST['d']=='4')
{
    $query="SELECT post_title
FROM `wp_posts`
WHERE `ID` = '".$_REQUEST['p1']."'";
	$res=mysql_query($query);  
	$num=mysql_numrows($res);
	$numcount=0; 
	      
	$row=mysql_fetch_assoc($res);
	
	$rating_posttitle=$row['post_title'];
	$query="    INSERT INTO `wp_ratings` (`rating_postid`, `rating_posttitle`, `rating_rating`, `rating_timestamp`, `rating_ip`, `rating_host`, `rating_username`, `rating_userid`)
VALUES ('".$_REQUEST['p1']."', '".$rating_posttitle."', '".$_REQUEST['p2']."', UNIX_TIMESTAMP(), '0.0.0.0', '0.0.0.0', 'iphoneapp', '0');";
	$res=mysql_query($query);  
	$num=mysql_numrows($res);
	$numcount=0; 
	echo '{ "result" : "OK"}'; 
}




?>