<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

?>

<div class="l-homepage__featured" rel="js-drawer">
	<div class="is-relative">
		<div class="c-featured" rel="js-mobile-gallery">

<?php

$i = 0;
$num_array = ['super', 'first', 'second', 'third', 'fourth'];

foreach ($this->items as $i => $item) :

	$attribs = json_decode($item->attribs);
	$images = json_decode($item->images);
	$urls = json_decode($item->urls);

?>
	        <div class="featured-item c-featured__<?php echo $num_array[$i]; ?> featured-item--with-filter" style="background-image: url(<?php echo $images->image_intro; ?>)">
	            <div>
	                <h3 class="featured-item-title">
	                    <?php echo $item->title; ?>
	                </h3>
	                <p class="featured-item-description">
	                    <?php echo strip_tags($item->introtext); ?>
	                </p>
	                <a class="featured-item-cta" href="<?php echo $urls->urla; ?>"><?php echo JText::_('COM_CONTENT_READ_MORE_CAPS'); ?></a>
	            </div>
	        </div>

<?php $i++; endforeach; ?>

		</div>
	</div>
</div>