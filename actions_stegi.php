<?php
header('Content-type: application/json; charset=UTF-8');
/**
 * @package    Core.Site
 *
 * @copyright  Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * Define the application's minimum supported PHP version as a constant so it can be referenced within the application.
 */
define('JOOMLA_MINIMUM_PHP', '5.3.10');

if (version_compare(PHP_VERSION, JOOMLA_MINIMUM_PHP, '<'))
{
	die('Your host needs to use PHP ' . JOOMLA_MINIMUM_PHP . ' or higher to run this version of Core');
}

// Saves the start time and memory usage.
$startTime = microtime(1);
$startMem  = memory_get_usage();

/**
 * Constant that is checked in included files to prevent direct access.
 * define() is used in the installation folder rather than "const" to not error for PHP 5.2 and lower
 */
define('_JEXEC', 1);

if (file_exists(__DIR__ . '/defines.php'))
{
	include_once __DIR__ . '/defines.php';
}

if (!defined('_JDEFINES'))
{
	define('JPATH_BASE', __DIR__);
	require_once JPATH_BASE . '/includes/defines.php';
}

require_once JPATH_BASE . '/includes/framework.php';

// Set profiler start time and memory usage and mark afterLoad in the profiler.
JDEBUG ? $_PROFILER->setStart($startTime, $startMem)->mark('afterLoad') : null;
date_default_timezone_set('Europe/Athens');
//get lang variables
$lang=@$_REQUEST['lang'];
if($lang=='en'){
}else{
	$lang='el';
}

// Instantiate the application.
$app = JFactory::getApplication('site');

$db = JFactory::getDbo();

$date_now=date('Y-m-d').' 00:00:00';

$query = "SELECT t.name AS tname,t.alias AS talias, a.*,  aa.address AS aaddress, aa.lat AS alat,aa.lng AS alng, aa.action_date_start AS aaction_date_start,aa.action_date_end AS aaction_date_end
					FROM #__actions AS a 
					INNER JOIN #__actions AS aa ON aa.action_id=a.id 
					INNER JOIN #__teams AS t ON t.id=a.team_id 
					WHERE aa.action_date_end>='".$date_now."' AND a.published='1' AND aa.stegi_use=1 AND a.action_id=0 ORDER BY aa.action_date_end ASC";
$db->setQuery($query);
$actions = $db->loadObjectList();
$i=0;
$data= '{
      "type": "FeatureCollection",
      "features": [';
foreach($actions as $action){
	if($action->alat==''){
		$action->alat=0;
	}
	if($action->alng==''){
		$action->alng=0;
	}	
	if($i%2==0){
		$cat=1;
	}else{
		$cat=2;
	}
	$i++;
	$date_array_start=explode(' ',$action->aaction_date_start);
	$date_array_start1=explode('-',$date_array_start[0]);
	$time_array_start=explode(':',$date_array_start[1]);
	$new_start_date=$date_array_start1[2].'-'.$date_array_start1[1].'-'.$date_array_start1[0].', '.$time_array_start[0].':'.$time_array_start[1];
	$date_array_end=explode(' ',$action->aaction_date_end);
	$date_array_end1=explode('-',$date_array_end[0]);
	$time_array_end=explode(':',$date_array_end[1]);
	$new_end_date=$date_array_end1[2].'-'.$date_array_end1[1].'-'.$date_array_end1[0].', '.$time_array_end[0].':'.$time_array_end[1];	
	$link=JRoute::_('index.php?option=com_actions&view=action&id='.$action->id.':'.$action->alias.'&Itemid=138');
	$link_team=JRoute::_('index.php?option=com_teams&view=team&id='.$action->team_id.':'.$action->talias.'&Itemid=140');
	
	if($date_array_end1[2].'-'.$date_array_end1[1].'-'.$date_array_end1[0] == $date_array_start1[2].'-'.$date_array_start1[1].'-'.$date_array_start1[0]){
		$dates=$date_array_end1[2].'-'.$date_array_end1[1].'-'.$date_array_end1[0].', '.$time_array_start[0].':'.$time_array_start[1].' - '.$time_array_end[0].':'.$time_array_end[1];
	}else{
		$dates=$new_start_date.' - '.$new_end_date;
	}	
	$data.= '{
            "url":"'.htmlspecialchars($link).'","team_url":"'.htmlspecialchars($link_team).'","dates": "'.$dates.'","address": "'.trim(htmlspecialchars($action->aaddress)).'","team_id": "'.$action->team_id.'","team_name": "'.htmlspecialchars($action->tname).'","title": "'.trim(str_replace(array("\r\n","\r"),"",htmlspecialchars($action->name))).'","coordinates": ['.$action->alat.', '.$action->alng.'],"action_id": '.$action->id.'
      }'.(count($actions)==$i?'':',');
}
$data.= ']}';
			
echo $data;
//echo str_replace(array("\r\n","\r"),"",$data);
