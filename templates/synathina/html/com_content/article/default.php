<?php
defined('_JEXEC') or die;


function youtubeID($url){
 $res = explode("v=",$url);
 if(isset($res[1])) {
	$res1 = explode('&',$res[1]);
	if(isset($res1[1])){
		$res[1] = $res1[0];
	}
	$res1 = explode('#',$res[1]);
	if(isset($res1[1])){
		$res[1] = $res1[0];
	}
 }
 return substr($res[1],0,12);
	 return false;
}

//db connection
$db = JFactory::getDBO();

//get menu item notes
$query = "SELECT note FROM #__menu WHERE id='".@$_REQUEST['Itemid']."' ";
$db->setQuery($query);
$note = $db->loadResult();

$doc = JFactory::getDocument();
$lang_code_array=explode('-',$doc->language);
$lang_code=$lang_code_array[0];

//cases:
if(@$_REQUEST['art']==1 || $note=='press' || $note=='opencalls'){
	$new=0;
}else{
	$new=1;
}
$new=0;

date_default_timezone_set('Europe/Athens');

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

// Create shortcuts to some parameters.
$params  = $this->item->params;
$images  = json_decode($this->item->images);
$attribs  = json_decode($this->item->attribs);
$urls    = json_decode($this->item->urls);
$canEdit = $params->get('access-edit');
$user    = JFactory::getUser();
$info    = $params->get('info_block_position', 0);


$breadcumbs_modules=JModuleHelper::getModules('breadcumbs');
$stegi_modules=JModuleHelper::getModules('stegi');

$article_image='http://www.synathina.gr/images/template/synathina_big.jpg';

if($note=='stegi'){
	//get di images
	$query = "SELECT * FROM #__di_images WHERE object_id='".$this->item->id."' ORDER BY ordering ASC";
	$db->setQuery($query);
	$imgs = $db->loadObjectList();
?>
<div class="l-stegh">
	<div class="module module--synathina">
		<div class="module-skewed module-skewed--gray">
			<div class="module-wrapper">
				<h3 class="module-title"><?php echo $this->escape($this->item->title); ?></h3>
				<?php echo $this->item->introtext; ?>
			</div>
		</div>
	</div>
<?php
		foreach ($stegi_modules as $stegi_module){
			echo JModuleHelper::renderModule($stegi_module);
		}
?>
<?php
	if(count($imgs)>0){
?>
<h3 class="gallery-title">Gallery</h3>
<div class="module module--synathina more_actions">
	<div class="gallery gallery--singlerow gallery--filter" rel="js-start-gallery">
<?php
	$c=1;
	$p=1;
	foreach($imgs as $img){
		$image='images/di/'.$img->object_id.'_'.$img->object_image_id.'_'.$img->filename;
		echo '<div class="gallery-item" style="position:relative">
						<a class="fill" class="magnifying-gallery" href="'.$image.'" style="background-image:url(\''.$image.'\'); "></a>
					</div>';
		$c++;
	}
?>
	</div>
</div>
<?php
	}
?>
</div>
<?php
}else{
?>

<div class="<?=($new==1?'l-news':'')?> l-news--article">
<?php
		foreach ($breadcumbs_modules as $breadcumbs_module){
			echo JModuleHelper::renderModule($breadcumbs_module);
		}
?>
	<article class="c-article">
		<h1 <?=($new==1?'class="color-orange"'.($note==''?' style="margin-bottom:20px;"':''):'')?>><?php echo $this->escape($this->item->title); ?></h1>
<?php
	if($new==0){
		echo '<figure role="complementary">';
		if($note=='opencalls'){
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
			//team info
			$query = "SELECT id, name FROM #__teams
						WHERE user_id='".$this->item->created_by."' LIMIT 1";
			$db->setQuery($query);
			$team = $db->loadObject();

			if ($team) {
				echo '<h2 style="margin:0px; padding:0px"><a style="color:#05c0de" href="'.JRoute::_('index.php?option=com_teams&view=team&id='.$team->id.'&Itemid=140').'">'.$team->name.'</a></h2>';
			}
			echo '<time class="opencall_time">Deadline: '.(trim(@$attribs->opencall_date)!=''?' '.@JHTML::_('date', @$attribs->opencall_date, 'd/m/Y'):'').'</time>';
			$activities_array=@$attribs->opencall_activities;
			//$activities_array=explode(',',$attribs->opencall_activities);
			if(count($activities_array)>0){
				echo '<div class="opencall_activities"><ul class="inline-list inline-list--separated thematiki--list">';
			}
			for($i=0; $i<count($activities_array); $i++){
				if($activities_array[$i]!=''){
					echo '<div class="thematiki thematiki--perivallon">
									<img src="'.$activities_array_info[$activities_array[$i]][1].'" width="45" height="35" alt="'.$activities_array_info[$activities_array[$i]][0].'" title="'.$activities_array_info[$activities_array[$i]][0].'" />
								</div>';
				}
			}
			if(count($activities_array)>0){
				echo '</ul></div>';
			}
		}
		//get di images
		$query = "SELECT * FROM #__di_images WHERE object_id='".$this->item->id."' ORDER BY ordering ASC";
		$db->setQuery($query);
		$imgs = $db->loadObjectList();
		if(count($imgs)>0){
			foreach($imgs as $img){
				if($img->link!=''){
					echo '<a href="javascript:void(null)" class="figure-item video-container">
									<div class="youtube" id="'.youtubeID($img->link).'" data-params="modestbranding=1&showinfo=0&controls=1&vq=hd720"></div>
								</a>';
				}else{
					echo '<a href="'.JURI::base().'images/di/'.$img->object_id.'_'.$img->object_image_id.'_'.$img->filename.'" class="figure-item magnifying-gallery">
									<img src="'.JURI::base().'images/di/'.$img->object_id.'_'.$img->object_image_id.'_'.$img->filename.'" alt="" />
									<p>'.$img->description.'</p><br />
								</a>';
				}
			}

		}
		echo '<br /></figure>';
	}
	if ($note == 'press') {
		$new_text=$this->item->introtext;
	} else {
		if ($new == 0) {
			if ($this->item->fulltext == '') {
				$new_text = strip_tags($this->item->introtext,'<strong><a><br><br /><br/><p><img><ul><li><i><u><em>');
			}else{
				$new_text = strip_tags($this->item->fulltext,'<strong><a><br><br /><br/><p><img><ul><li><i><u><em>');
			}
		} elseif($note != '') {
			$new_text = preg_replace('#\s*\[caption[^]]*\].*?\[/caption\]\s*#is', '', $this->item->fulltext);
		} else {
			$new_text = $this->item->text;
		}
	}
?>
		<div role="main" class="c-article__content <?=($new==1?'c-article__content--wrapp':'')?>">
<?php
	if($new==1){
		//get di images
		$query = "SELECT * FROM #__di_images WHERE object_id='".$this->item->id."' ORDER BY ordering ASC LIMIT 1";
		$db->setQuery($query);
		$imgs = $db->loadObjectList();
		foreach($imgs as $img){
			echo '<img src="'.JURI::base().'images/di/'.$img->object_id.'_'.$img->object_image_id.'_'.$img->filename.'" style="max-height:320px;display:block;" alt="'.$this->escape($this->item->title).'" /><p>'.@$img->caption.'</p><br />';
		}
	}
	$imgs_tags = $imgs;
?>
<?php echo $new_text; ?>

<?php
	//attachments
	$query = "SELECT * FROM #__attachments WHERE state=1 AND parent_type='com_content' AND parent_entity='article' AND parent_id='".$this->item->id."' ORDER BY id DESC";
	$db->setQuery($query);
	$atts = $db->loadObjectList();
	if(count($atts)>0){
	echo '<div class="document-download">
					<h3 class="text-center">'.($lang_code=='en'?'Downloads':'Αρχεία').'</h3>
					<ul class="inline-list">';
	foreach($atts as $att){
		echo '	<li>
							<a href="'.$att->url.'" download="'.addslashes($att->filename).'" target="_blank">
								<i class="doc-icon doc-icon--pdf"></i>
								<div>'.$att->filename.'</div>
							</a>
						</li>';
	}
	echo '	</ul>
				</div>';
	}
	//meta tags
	if(count(@$imgs_tags)>0){
		$i=0;
		foreach($imgs_tags as $img){
			if($i==0){
				$article_image='http://www.synathina.gr/images/di/'.$img->object_id.'_'.$img->object_image_id.'_'.$img->filename;
			}
			$i++;
		}
	}
?>
		<div class="pull-right share-icons">
			<a href="http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo $this->item->title;?>&amp;p[summary]=<?php echo addslashes(strip_tags($note=='stegi'?$this->item->introtext:$new_text));?>&amp;p[url]=<?php echo JUri::current();?>&amp;p[images][0]=<?php echo $article_image; ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600'); return false;">
				<img src="<?php echo JURI::base(); ?>images/template/facebook.png" alt="facebook" />
			</a>&nbsp;
			<a href="http://twitter.com/home?status=<?php echo $this->item->title; ?> <?php echo urlencode(JUri::current());?>"  onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600');return false;">
				<img src="<?php echo JURI::base(); ?>images/template/tweet.png" alt="twitter" />
			</a>
		</div>
		<div class="clearfix"></div>
<?php
	if($new==1){
		//echo $i;
		$p=1;
		$c=1;
		$query = "SELECT * FROM #__di_images WHERE object_id='".$this->item->id."' ORDER BY ordering ASC";
		$db->setQuery($query);
		$imgs = $db->loadObjectList();
		if(count($imgs)>1){
			echo '<div class="module module--synathina">
							<h3 class="gallery-title">Gallery</h3>
							<div class="gallery gallery--multirow" rel="js-start-gallery">';
			//for($c=1; $c<=count($imgs); $c++){
			foreach($imgs as $img){
				if($c==1 || $c%7==0){
					echo '<div class="gallery-frame" data-id="'.$p.'">';
					$p++;
				}
				echo '<div class="gallery-item">
								<a class="fill" class="magnifying-gallery" href="'.JURI::base().'images/di/'.$img->object_id.'_'.$img->object_image_id.'_'.$img->filename.'" style="background-image:url(\''.JURI::base().'images/di/'.$img->object_id.'_'.$img->object_image_id.'_'.$img->filename.'\')"></a>
							</div>';
				if($c%6==0 || $c==count($imgs)){
					echo '</div>';
				}
				$c++;
			}
			echo '	</div>
						</div>';
		}
	}

?>

		</div>

	</article>
</div>
<?php
}
//meta tags
$doc->setMetaData( 'twitter:card', 'summary_large_image' );
$doc->setMetaData( 'twitter:site', '@synathina' );
$doc->setMetaData( 'twitter:title', 'συνΑθηνά' );
$doc->setMetaData( 'twitter:description', $this->escape($this->item->title) );
$doc->setMetaData( 'twitter:image', $article_image );

$doc->setMetaData( 'og:url', JUri::current() );
$doc->setMetaData( 'og:type', 'article' );
$doc->setMetaData( 'og:title', $this->escape($this->item->title) );
$doc->setMetaData( 'og:description', addslashes(strip_tags($note=='stegi'?$this->item->introtext:$new_text)) );
$doc->setMetaData( 'og:image', $article_image );
?>


