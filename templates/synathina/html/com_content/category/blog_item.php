<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

//connect to db
$db = JFactory::getDBO();

$user = JFactory::getUser();
$isroot = $user->authorise('core.admin');

//get menu item notes
$note='';
$query = "SELECT note FROM #__menu WHERE id='".@$_REQUEST['Itemid']."' ";
$db->setQuery($query);
$note = $db->loadResult();

$slider_modules=JModuleHelper::getModules('slider');

// Create a shortcut for params.
$params = $this->item->params;
$images  = json_decode($this->item->images);
$attribs  = json_decode($this->item->attribs);
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
$canEdit = $this->item->params->get('access-edit');
$info    = $params->get('info_block_position', 0);
//print_r($attribs);
if ($params->get('access-view')) :
	$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language));
else :
	$menu = JFactory::getApplication()->getMenu();
	$active = $menu->getActive();
	$itemId = $active->id;
	$link = new JUri(JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false));
	$link->setVar('return', base64_encode(JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language), false)));
endif;
if($note=='synathina'){
/*---------SYNATHINA TEMPLATE--------*/
?>
<div class="module module--synathina">
	<div class="module-skewed">
		 <div class="module-wrapper">
				<h3 class="module-title"><?php echo $this->item->title; ?></h3>
<?php
	//get action by year
	$slider_1_2013=185+23;
	$slider_1_2014=317+70;
	$slider_1_2015=451+169;
	$slider_1_2016=638+459;
	for($y=2017; $y<=date('Y'); $y++){
		${'slider_1_'.$y}=count_actions_1($y);
	}
	//total
	$slider_1_all=0;
	for($y=2013; $y<=date('Y'); $y++){
		$slider_1_all+=${'slider_1_'.$y};
	}
	$slider_2_2013 = 42;
	$slider_2_2014 = 77;
	$slider_2_2015 = 75;
	$slider_2_2016 = 87;
	for($i=2017; $i<=date('Y'); $i++){
		${'slider_2_'.$i} = teams_count2($i);
	}
	//total teams
	$slider_2_all_teams=0;
	for($y=2013; $y<=date('Y'); $y++){
		$slider_2_all_teams+=${'slider_2_'.$y};
	}

	$total_donators = donators_count();

	$replace_array=array($slider_1_all,$slider_2_all_teams,$total_donators);
	$replace_array1=array('{total_actions}','{total_teams}','{total_donators}');
?>
	<?php echo str_replace($replace_array1,$replace_array,$this->item->introtext); ?>
		 </div>
<?php
	if($this->item->counter==$this->item->total){
		if (count($slider_modules)>0) :
			foreach ($slider_modules as $slider_module){
				echo JModuleHelper::renderModule($slider_module);
			}
		endif;
	}
?>
	</div>
</div>

<?php
/*-----END OF SYNATHINA TEMPLATE-----*/
}elseif($note=='teams'){
/*---------TEAMS TEMPLATE--------*/
	echo '<div class="module-wrapper">
					<h3 class="module-title">'.$this->item->title.'</h3>
					'.$this->item->introtext.'
        </div>	';
/*-----END OF TEAMS TEMPLATE-----*/
/*-----START OF EU TEMPLATE-----*/
}elseif($note=='eu'){
?>
	<div class="module module--synathina">
			<div class="module-skewed">
				 <div class="module-wrapper">
						<h3 class="module-title"><?php echo $this->item->title; ?></h3>
						<?php echo str_replace('<img ','<img class="img-responsive" ',$this->item->introtext); ?>
				 </div>
			</div>
	 </div>
<?php
/*-----END OF EU TEMPLATE-----*/
/*-----START OF OPEN CALLS TEMPLATE-----*/
}elseif($note=='opencalls1'){
		$attribs1  = json_decode($this->item->attribs);
?>
	<div class="thumbnail-list__item">
		 <article class="thumbnail">
<?php
	if(@$attribs1->article_video!=''){
		echo '<div class="module-embed">
						<iframe width="560" height="315" src="https://www.youtube.com/embed/'.youtubeID($attribs1->article_video).'" frameborder="0" allowfullscreen></iframe>
					</div>';
	}else{
		//get di images
		$query = "SELECT * FROM #__di_images WHERE object_id='".$this->item->id."' ORDER BY ordering ASC";
		$db->setQuery($query);
		$imgs = $db->loadObjectList();
		$i=0;
		foreach($imgs as $img){
			if($i==0){
				list($width, $height) = @getimagesize('images/di/'.$img->object_id.'_'.$img->object_image_id.'_'.$img->filename);
				//style="height:'.($height<310?$height.'px; margin-bottom:'.ceil(310-$height).'px':'310px').'"
				echo '<a href="'.$link.'"><img src="images/di/'.$img->object_id.'_'.$img->object_image_id.'_'.$img->filename.'" class="img-responsive" style="max-height:310px;"  /></a>';
			}
			if(count($imgs)==0){
				echo '<a href="'.$link.'"><img src="http://placehold.it/511x310" class="img-responsive" style="height:310px" /></a>';
			}
			$i++;
		}
	}
?>
				<div class="caption">
					 <h3><a style="color:#5d5d5d" href="<?php echo $link; ?>"><?php echo $this->item->title; ?></a><?=($isroot==1&&$this->item->state==0?' <span style="color:red;">ανενεργό</span>':'')?></h3>
					 <time>Deadline: <?php echo @JHTML::_('date', $attribs1->opencall_date, 'd/m/Y');?></time>
					 <p>
						<p style="max-height:208px; overflow:hidden;"><?php echo str_replace('<a ','<a target="_blank" ',strip_tags(($this->item->introtext==''?$this->item->fulltext:$this->item->introtext),'<br/><br><strong><a><br />')); ?></p>
						<a class="caption-more" href="<?php echo $link; ?>"><?php echo JText::_('COM_CONTENT_FEED_READMORE'); ?></a>
					 </p>
				</div>
		 </article>
	</div>
<?php
/*-----END OF OPEN CALLS TEMPLATE-----*/
} else {
	//get di images
	$query = "SELECT * FROM #__di_images WHERE object_id='".$this->item->id."' ORDER BY ordering ASC LIMIT 1";
	$db->setQuery($query);
	$imgs = $db->loadObjectList();
?>
	<div class="media">
		<div class="media-left badge-item" >
<?php foreach ($imgs as $img) { ?>
			<div class="badge-image">
				<a href="<?php echo $link; ?>">
					<img class="results-img-width" src="<?php echo JURI::base().'images/di/'.$img->object_id.'_'.$img->object_image_id.'_'.$img->filename; ?>" alt="<?php echo $this->item->title; ?>" />
				</a>
			</div>
<?php } ?>
		</div>
		 <div class="media-body">
				<h3 class="media-title"><a href="<?php echo $link; ?>"><?php echo $this->item->title; ?></a></h3>
				<time><?php echo JHTML::_('date', $this->item->created, 'd M Y');?></time>
<?php
	if($this->item->introtext==''){
		$newtext=strip_tags($this->item->fulltext,'<strong><a>');
		if ($note == 'opencalls') {

		}
	}else{
		$newtext=strip_tags($this->item->introtext,'<strong><a>');
	}
?>
				 <p>
					<?php echo str_replace('<a ','<a target="_blank" ',$newtext); ?>
					<a href="<?php echo $link; ?>"><?php echo JText::_('COM_CONTENT_FEED_READMORE'); ?></a>
				 </p>
		 </div>
	</div>
<?php
	if ($this->item->counter % 2 == 0) {
		echo '<div class="articles_by_two">&nbsp;</div>';
	}
	$this->item->counter++;
}
?>
<?php //echo $this->item->event->afterDisplayContent; ?>
