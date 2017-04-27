<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$action=$this->action[0];

$document = JFactory::getDocument();
$document->setTitle($action->name);

function strip_single_tag($str,$tag){

    $str1=preg_replace('/<\/'.$tag.'>/i', '', $str);

    if($str1 != $str){

        $str=preg_replace('/<'.$tag.'[^>]*>/i', '', $str1);
    }

    return $str;
}


//db connection
$db = JFactory::getDBO();

$user = JFactory::getUser();
$isroot = $user->authorise('core.admin');
//activities
$query="SELECT a.*
				FROM #__team_activities AS a
				WHERE a.published=1 ";
$db->setQuery( $query );
$activities = $db->loadObjectList();
$activities_array_info=array();
foreach($activities as $activity){
	$activities_array_info[$activity->id]=array($activity->name, $activity->image);
}

$months=array(1=>'ΙΑΝ','ΦΕΒ','ΜΑΡ','ΑΠΡ','ΜΑΙ','ΙΟΥΝ','ΙΟΥΛ','ΑΥΓ','ΣΕΠ','ΟΚΤ','ΝΟΕ','ΔΕΚ');
			
$config= new JConfig();
$app = JFactory::getApplication();
$templateDir = JURI::base() . 'templates/' . $app->getTemplate();

//get lang variables
$lang = JFactory::getLanguage();
$this->language = $lang->getTag();//$doc->language;
$lang_code_array=explode('-',$this->language);
$lang_code=$lang_code_array[0];

//get menu clues
$menu_params = $app->getMenu()->getActive()->params;
$menu_link = $app->getMenu()->getActive()->link;


$subactions=$this->subactions;
//print_r($subactions);
?>

<div class="l-draseis l-draseis--article">

<?php
	if($isroot==1){
		echo '<a href="index.php?option=com_actions&view=edit&id='.$action->id.'&Itemid=144" style="font-weight:bold; font-size:20px; color:#05c1df">edit</a>';
	}
?>
   <div class="clearfix">
	 
      <aside class="l-draseis__col-left">
<?php
	if($action->image!=''){
?>
    <img src="images/actions/main_images/<?php echo $action->image; ?>" alt="<?php echo $action->name; ?>" style="width:100%; " />
<?php
	}
?>			
         <div class="module module--synathina">
            <div class="module-skewed module-skewed gray">
               <div class="list-group list-group--draseis">
                  <div class="list-group-item">
<?php
			if(@$action->best_practice==1){
				echo '	<img style="max-width:56px" src="images/template/best.png" alt="" />';
			}
?>									
                     <h3 class="list-group-item-title" style="<?=(@$action->best_practice==1?'padding-top:0px;':'')?>"><?php echo $action->name; ?></h3>
                     <ul class="inline-list inline-list--separated">
                        <li><a href="<?php echo JRoute::_('index.php?option=com_teams&view=team&id='.$action->team_id.'&Itemid=137');  ?>"><?php echo $action->team_name; ?></a></li>
                     </ul>
<?php
	$partners1=explode(',',$action->partners);
	$partners=array();
	for($p=0; $p<count($partners1); $p++){
		if($partners1[$p]!=''){
			$partners[]=$partners1[$p];
		}
	}
	for($p=0; $p<count($partners); $p++){
		if($p==0){
			echo '<br />Συνεργαζόμενες ομάδες:<br /><ul class="inline-list inline-list--separated">';
		}
		$query = "SELECT name, id FROM #__teams WHERE id='".$partners[$p]."' LIMIT 1";
		$db->setQuery( $query );
		$partners_result = $db->loadObjectList();	
		foreach($partners_result as $partner_result){
			echo '<li><a href="'.JRoute::_('index.php?option=com_teams&view=team&id='.@$partner_result->id.'&Itemid=137').'">'.@$partner_result->name.'</a></li>';
		}
		if(($p+1)==count($partners)){
			echo '</ul>';
		}
	}
	$supporters1=explode(',',$action->supporters);
	$supporters=array();
	for($p=0; $p<count($supporters1); $p++){
		if($supporters1[$p]!=''){
			$supporters[]=$supporters1[$p];
		}
	}
	for($p=0; $p<count($supporters); $p++){
		if($p==0){
			echo '<br />Υποστηρικτές:<br /><ul class="inline-list inline-list--separated">';
		}
		$query = "SELECT name, id FROM #__teams WHERE id='".$supporters[$p]."' LIMIT 1";
		//echo $query;
		$db->setQuery( $query );
		$partners_result = $db->loadObjectList();	
		foreach($partners_result as $partner_result){
			echo '<li><a href="'.JRoute::_('index.php?option=com_teams&view=team&id='.@$partner_result->id.'&Itemid=137').'">'.@$partner_result->name.'</a></li>';
		}
		if(($p+1)==count($supporters)){
			echo '</ul>';
		}
	}	
	
?>										 
<!--fix when supporters exist-->
<!--
                     <ul class="inline-list inline-list--separated">
                        <li><a href="">Atenistas</a></li>
                     </ul>
-->										 
<!--end fix-->										 
<?php
	if($action->web_link!=''){
		$web_link1=$action->web_link;
		$prefix=substr($action->web_link,0,4);
		if($prefix!='http'){
			$web_link1='http://'.$action->web_link;
		}			
?>
                     <a class="list-group-link" href="<?php echo $web_link1; ?>" target="_blank" style="text-decoration:underline">
                        Web Link / Facebook Event
                     </a>
<?php
	}
?>										 
 <!--                    <ul class="inline-list inline-list--separated thematiki--list">
<?php
	if(@$action->team_fb_link!=''){
		$team_fb_link1=$action->team_fb_link;
		$prefix=substr($action->team_fb_link,0,4);
		if($prefix!='http'){
			$team_fb_link1='http://'.$action->team_fb_link;
		}			
		echo '<li><a target="_blank" href="'.$team_fb_link1.'"><i class="fa fa-facebook"></i></a></li>';
	}
	if(@$action->team_tw_link!=''){
		$team_tw_link1=$action->team_tw_link;
		$prefix=substr($action->team_tw_link,0,4);
		if($prefix!='http'){
			$team_tw_link1='http://'.$action->team_tw_link;
		}			
		echo '<li><a target="_blank" href="'.$team_tw_link1.'"><i class="fa fa-twitter"></i></a></li>';
	}
	if(@$action->team_in_link!=''){
		$team_in_link1=$action->team_in_link;
		$prefix=substr($action->team_in_link,0,4);
		if($prefix!='http'){
			$team_in_link1='http://'.$action->team_in_link;
		}			
		echo '<li><a target="_blank" href="'.$team_in_link1.'"><i class="fa fa-instagram"></i></a></li>';
	}
	if(@$action->team_li_link!=''){
		$team_li_link1=$action->team_li_link;
		$prefix=substr($action->team_li_link,0,4);
		if($prefix!='http'){
			$team_li_link1='http://'.$action->team_li_link;
		}			
		echo '<li><a target="_blank" href="'.$team_li_link1.'"><i class="fa fa-linkedin"></i></a></li>';
	}
	if(@$action->team_yt_link!=''){
		$team_yt_link1=$action->team_yt_link;
		$prefix=substr($action->team_yt_link,0,4);
		if($prefix!='http'){
			$team_yt_link1='http://'.$action->team_yt_link;
		}			
		echo '<li><a target="_blank" href="'.$team_yt_link1.'"><i class="fa fa-youtube"></i></a></li>';
	}
	if(@$action->team_go_link!=''){
		$team_go_link1=$action->team_go_link;
		$prefix=substr($action->team_go_link,0,4);
		if($prefix!='http'){
			$team_go_link1='http://'.$action->team_go_link;
		}			
		echo '<li><a target="_blank" href="'.$team_go_link1.'"><i class="fa fa-google"></i></a></li>';
	}
	if(@$action->team_pn_link!=''){
		$team_pn_link1=$action->team_pn_link;
		$prefix=substr($action->team_pn_link,0,4);
		if($prefix!='http'){
			$team_pn_link1='http://'.$action->team_pn_link;
		}			
		echo '<li><a target="_blank" href="'.$team_pn_link1.'"><i class="fa fa-pinterest"></i></a></li>';
	}	
?>										 
                     </ul>-->
                  </div>
<?php
	foreach($subactions as $subaction){
		$action_date_start_array=explode(' ',$subaction->action_date_start);
		$action_date_start_array1=explode('-',$action_date_start_array[0]);
		$time_array_start=explode(':',$action_date_start_array[1]);
		$date_from=$action_date_start_array1[2].' '.$months[(int)$action_date_start_array1[1]].' '.$action_date_start_array1[0];
		$date_from1=$action_date_start_array1[2].' '.$months[(int)$action_date_start_array1[1]].' '.$action_date_start_array1[0].' '.$time_array_start[0].':'.$time_array_start[1];
		$time_from=$time_array_start[0].':'.$time_array_start[1];
		$action_date_end_array=explode(' ',$subaction->action_date_end);
		$action_date_end_array1=explode('-',$action_date_end_array[0]);
		$time_array_end=explode(':',$action_date_end_array[1]);
		$date_to=$action_date_end_array1[2].' '.$months[(int)$action_date_end_array1[1]].' '.$action_date_end_array1[0];
		$date_to1=$action_date_end_array1[2].' '.$months[(int)$action_date_end_array1[1]].' '.$action_date_end_array1[0].' '.$time_array_end[0].':'.$time_array_end[1];
		$time_to=$time_array_end[0].':'.$time_array_end[1];
?>
                  <div class="list-group-item">
                     <h4 class="list-group-item-title list-group-item-title--subtitle"><?php echo $subaction->subtitle; ?></h4>
                     <span><strong><?=($date_from!=$date_to?$date_from1.' – '.$date_to1:$date_from.' '.$time_from.'-'.$time_to)?></strong></span>
                     <br>
<?php
	if($subaction->stegi_use==1){
		echo '<a style="color:#5d5d5d" href="http://www.google.com/maps/place/37.980522,23.726839/@37.980522,23.726839,15z" target="_blank">Αθηνάς 55, στέγη συνΑθηνά</a>';
	}else{
		echo '<a style="color:#5d5d5d" href="http://www.google.com/maps/place/'.$subaction->lat.','.$subaction->lng.'/@'.$subaction->lat.','.$subaction->lng.',15z" target="_blank">'.$subaction->address.'</a>';
	}
?>										 
                     <br>
                     <ul class="inline-list inline-list--separated thematiki--list">
<?php
 $activities_array=explode(',',$subaction->activities);
 for($i=0; $i<count($activities_array); $i++){
	if($activities_array[$i]!=''){
		echo '<div class="thematiki thematiki--perivallon">
						<img src="'.$activities_array_info[$activities_array[$i]][1].'" width="45" height="35" alt="'.$activities_array_info[$activities_array[$i]][0].'" title="'.$activities_array_info[$activities_array[$i]][0].'" />
					</div>';
	}
	 
 }
?>										 
                     </ul>
                     <br>
                     <span><strong><?php echo $subaction->area; ?><sup>η</sup> Δημοτική Κοινότητα</strong></span>
                  </div>
<?php
	}
?>
               </div>
            </div>
         </div>
      </aside>
      <div class="l-draseis__col-right">
			<article class="c-article">
<?php
	$desc=$action->description;
	if($action->description==''){
		$desc=$action->short_description;
	}
	$desc = preg_replace('#(<[a-z ]*)(style=("|\')(.*?)("|\'))([a-z ]*>)#', '\\1\\6', $desc);
	$replace_array=array('<div>','</div>','<a ');
	$replace_array1=array('<p>','</p>','<a target="_blank" ');
	echo str_replace($replace_array,$replace_array1,strip_tags($desc,'<a><p><br><strong><h3>')); 
?>
			</article>
			<div class="pull-right share-icons">
				<a href="http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo $action->name;?>&amp;p[summary]=<?php echo addslashes(strip_tags($desc));?>&amp;p[url]=<?php echo JUri::current();?>&amp;p[images][0]=<?php echo 'http://www.synathina.gr/images/actions/main_images/'.$action->image; ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600'); return false;">
					<img src="<?php echo JURI::base(); ?>images/template/facebook.png" alt="facebook" />
				</a>&nbsp;
				<a href="http://twitter.com/home?status=<?php echo clean($action->name); ?> <?php echo urlencode(JUri::current());?>"  onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600');return false;">
					<img src="<?php echo JURI::base(); ?>images/template/tweet.png" alt="twitter" />
				</a>			
			</div>		 
      </div>

   </div>


<?php
	$i=0;
	$images=array();
	foreach (glob('images/actions/'.$action->id.'/*.*') as $filename) {
		$images[]=$filename;
		$i++;
	}

	$p=1;
	if($i>0){
		echo '<div class="module module--synathina">
						<h3 class="gallery-title">Gallery</h3>
						<div class="gallery gallery--multirow" rel="js-start-gallery">';
		for($c=1; $c<=$i; $c++){
			if($c==1 || ($c-1)%6==0){
				echo '<div class="gallery-frame" data-id="'.$p.'">';
				$p++;
			}
			echo '<div class="gallery-item">
							<a class="fill" class="magnifying-gallery" href="'.$images[$c-1].'" style="background-image:url(\''.$images[$c-1].'\'); "></a>
						</div>';
			if($c%6==0 || $c==$i){
				echo '</div>';
			}		
		}
		echo '	</div>
					</div>';
	}
	
	//get 9 similar actions
	date_default_timezone_set('Europe/Athens');
	$area_where='';
	if($action->area>0){
		$area_where=" AND aa.area='".$action->area."' ";	
	}
	$query = "SELECT a.id,a.alias,a.image,a.best_practice, a.name, aa.address, aa.action_date_start, aa.action_date_end, t.name AS tname 
						FROM #__actions AS a 
						INNER JOIN #__actions AS aa ON aa.action_id=a.id 
						INNER JOIN #__teams AS t ON t.id=a.team_id 
						WHERE a.action_id=0 AND a.id!='".$action->id."' AND a.published=1 AND aa.action_date_end>='".date('Y-m-d H:i:s')."' ".$area_where." GROUP BY a.id ORDER BY aa.action_date_end DESC LIMIT 9";
	$db->setQuery( $query );
	$other_actions = $db->loadObjectList();
	$actions_left=9-count($other_actions);
	$all_actions=$other_actions;
	if($actions_left>0){
		$query = "SELECT a.id, a.alias, a.image, a.name, aa.action_date_start,aa.action_date_end, aa.address, t.name AS tname 
							FROM #__actions AS a 
							INNER JOIN #__actions AS aa ON aa.action_id=a.id 
							INNER JOIN #__teams AS tON t.id=a.team_id 
							WHERE a.action_id=0 AND a.id!='".$action->id."'  AND a.published=1  AND aa.action_date_end>='".date('Y-m-d H:i:s')."' GROUP BY a.id ORDER BY aa.action_date_end DESC LIMIT ".$actions_left." ";		
		$other_actions1 = $db->loadObjectList();
		$all_actions1=array_merge((array) $other_actions, (array) $other_actions1);
		shuffle($all_actions1);
		$all_actions = (object)$all_actions1 ;
	}else{
		$all_actions1=(array)$all_actions;
		shuffle($all_actions1);
		$all_actions = (object)$all_actions1 ;
	}
	//($all_actions);
		
?>			
   <h3 class="gallery-title"><?php echo JText::_('COM_ACTIONS_SEE_MORE'); ?></h3>
   <div class="module module--synathina more_actions">
      <div class="gallery gallery--singlerow gallery--filter" rel="js-start-gallery">
<?php
	$a=1;
	$f=1;
	foreach($all_actions as $all_action){
		if(($a-1)%3==0){
			//echo '<div class="gallery-frame" data-id="'.$f.'">';
			$f++;
		}			
		$link=JRoute::_('index.php?option=com_actions&view=action&id='.$all_action->id.'&Itemid='.@$_REQUEST['Itemid']);
		$link=JRoute::_('index.php?option=com_actions&view=action&id='.$all_action->id.':'.$all_action->alias.'&Itemid='.@$_REQUEST['Itemid']);
		if($all_action->image!=''){
			list($width, $height) = getimagesize('images/actions/main_images/'.$all_action->image);
			//192 155
			$image_path='images/actions/main_images/'.$all_action->image;
			if($width>$height){
				//$max_width='width:192px;';
				$max_height='max-height:310px;';
				$bg_height='auto';
				$bg_width='100%';					
			}else{
				$max_height='max-height:155px;';
				$max_width='max-width:392px;';
				$bg_width='auto';
				$bg_height='100%';			
			}
		}else{
			$image_path='images/template/no-team.jpg';
		}
		echo '<div class="gallery-item-2" style="position:relative">
						'.(@$all_action->best_practice==1?'<div class="badge-icon"><a href="'.$link.'"><img style="max-width:56px" src="images/template/best.png" alt="" /></a></div>':'').'
						<a href="'.$link.'" class="fill" style="background-color:#FFF; background-size: '.@$bg_width.' '.@$bg_height.'; background-position: center center;'.@$max_width.@$max_height.';background-image:url(\''.$image_path.'\')"></a>';
		$start_date=JHTML::_('date', $all_action->action_date_start, 'd-m-Y');
		$end_date=JHTML::_('date', $all_action->action_date_end, 'd-m-Y');
    echo '  <div class="caption">
							<a href="'.$link.'"><span class="caption-title">'.stripslashes($all_action->name).'</span></a>
							<span class="caption-details">'.$all_action->address.'</span>
							<span class="caption-details">'.($start_date!=$end_date?$start_date.' – '.$end_date:$start_date).'</span>
							<em class="caption-italic">'.JText::_('COM_ACTIONS_BY').' '.stripslashes($all_action->tname).'</em>
						 </div>
					</div>';						
		if(($a%3==0) || $a==count($all_actions)){
			//echo '</div>';
		}				 
		$a++;
	}	
?>	
      </div>
   </div>
</div>

<?php

function clean($string) {
   return str_replace('"', '', $string); // Replaces all quotes with nothing.

   //return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

//meta tags
$document->setMetaData( 'title', clean($action->name) );

$document->setMetaData( 'twitter:card', 'summary_large_image' );
$document->setMetaData( 'twitter:site', '@synathina' );
$document->setMetaData( 'twitter:title', 'συνΑθηνά' );
$document->setMetaData( 'twitter:description', clean($action->name) );
$document->setMetaData( 'twitter:image', 'http://www.synathina.gr/images/actions/main_images/'.$action->image );

$document->setMetaData( 'og:url', "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" );
$document->setMetaData( 'og:type', 'article' );
$document->setMetaData( 'og:title', clean($action->name) );
$document->setMetaData( 'og:description', clean(strip_tags($desc)) );
$document->setMetaData( 'og:image', 'http://www.synathina.gr/images/actions/main_images/'.$action->image );

?>		