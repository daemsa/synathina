<?php

defined('_JEXEC') or die;

/**
 * Search Component Search Model
 *
 * @since  1.5
 */
class ActionsModelMyactions extends JModelLegacy
{
	/**
	 * Search data array
	 *
	 * @var array
	 */
	protected $_data = null;

	/**
	 * Search total
	 *
	 * @var integer
	 */
	protected $_total = null;

	/**
	 * Search areas
	 *
	 * @var integer
	 */
	protected  $_areas = null;

	/**
	 * Pagination object
	 *
	 * @var object
	 */
	protected $_pagination = null;

	/**
	 * Constructor
	 *
	 * @since 1.5
	 */


	public function __construct()
	{
	parent::__construct();
	// Set the pagination request variables
	$this->setState('limit', JRequest::getVar('limit', 5, '', 'int'));
	$this->setState('limitstart', JRequest::getVar('limitstart', 0, '', 'int'));
	//$this->setState('dennis', 1);
	//echo JRequest::getVar('limitstart');
	}



	public function getMsg(){

		$app = JFactory::getApplication();
		$config = JFactory::getConfig();

		//remote db - use with $db_remote
		require_once JPATH_BASE . '/remote_db.php';

		$user = JFactory::getUser();
		$query = "SELECT id FROM #__teams WHERE user_id='".$user->id."' LIMIT 1 ";
		$db_remote->setQuery( $query );
		$team_id = $db_remote->loadResult();

		//requests
		if(@$_REQUEST['action_limit']>0){
			$action_limit=$_REQUEST['action_limit'];
		}else{
			$action_limit=6;
		}

		$query="SELECT a.* FROM #__actions AS a WHERE a.id>0 AND a.team_id='".$team_id."' AND a.action_id=0 AND (a.published=1 OR a.published=0) ORDER BY a.id DESC ";
		$db_remote->setQuery( $query );
		$actions = $db_remote->loadObjectList();
		$this->_total = count($actions);
		$this->items = array_splice($actions, $this->getState('limitstart'), $action_limit);

		return $this->items;
	}

	public function getActivities(){
		//db connection
		$db = JFactory::getDBO();
		$query="SELECT * FROM #__team_activities WHERE published=1 ORDER BY name ASC";
		$db->setQuery( $query );
		$activities = $db->loadObjectList();
		return $activities;
	}

	public function getPagination()
			 {
				if(@$_REQUEST['action_limit']>0){
					$action_limit=$_REQUEST['action_limit'];
				}else{
					$action_limit=6;
				}
			$app    = JFactory::getApplication();
			$router = $app->getRouter();
		if(@$_REQUEST['from']!=''){
			$router->setVar( 'from', @$_REQUEST['from'] );
		}
		if(@$_REQUEST['to']!=''){
			$router->setVar( 'to', @$_REQUEST['from'] );
		}
		if(@$_REQUEST['search_name']!=''){
			$router->setVar( 'search_name', @$_REQUEST['search_name'] );
		}
		if(@$_REQUEST['best']=='on'){
			$router->setVar( 'best', @$_REQUEST['best'] );
		}
		for($i=1; $i<8; $i++){
			if(@$_REQUEST['area'.$i]=='on'){
				$router->setVar( 'area'.$i, @$_REQUEST['area'.$i] );
			}
		}
		for($i=1; $i<20; $i++){
			if(@$_REQUEST['activity'.$i]=='on'){
				$router->setVar( 'activity'.$i, @$_REQUEST['activity'.$i] );
			}
		}
			 jimport('joomla.html.pagination');
			 $this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $action_limit );
			 return $this->_pagination;
	}
	/**
	 * Method to set the search parameters
	 *
	 * @param   string  $keyword   string search string
	 * @param   string  $match     matching option, exact|any|all
	 * @param   string  $ordering  option, newest|oldest|popular|alpha|category
	 *
	 * @return  void
	 *
	 * @access	public
	 */
	public function setSearch($keyword, $match = 'all', $ordering = 'newest')
	{
		if (isset($keyword))
		{
			$this->setState('origkeyword', $keyword);

			if ($match !== 'exact')
			{
				$keyword = preg_replace('#\xE3\x80\x80#s', ' ', $keyword);
			}

			$this->setState('keyword', $keyword);
		}

		if (isset($match))
		{
			$this->setState('match', $match);
		}

		if (isset($ordering))
		{
			$this->setState('ordering', $ordering);
		}
	}

	/**
	 * Method to get weblink item data for the category
	 *
	 * @access public
	 * @return array
	 */
	public function getData()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
			$areas = $this->getAreas();

			JPluginHelper::importPlugin('search');
			$dispatcher = JEventDispatcher::getInstance();
			$results = $dispatcher->trigger('onContentSearch', array(
				$this->getState('keyword'),
				$this->getState('match'),
				$this->getState('ordering'),
				$areas['active'])
			);

			$rows = array();

			foreach ($results as $result)
			{
				$rows = array_merge((array) $rows, (array) $result);
			}

			$this->_total	= count($rows);

			if ($this->getState('limit') > 0)
			{
				$this->_data = array_splice($rows, $this->getState('limitstart'), $this->getState('limit'));
			}
			else
			{
				$this->_data = $rows;
			}
		}

		return $this->_data;
	}

	/**
	 * Method to get the total number of weblink items for the category
	 *
	 * @access public
	 * @return  integer
	 */
	public function getTotal()
	{
		return $this->_total;
	}

	/**
	 * Method to set the search areas
	 *
	 * @param   array  $active  areas
	 * @param   array  $search  areas
	 *
	 * @return  void
	 *
	 * @access	public
	 */
	public function setAreas($active = array(), $search = array())
	{
		$this->_areas['active'] = $active;
		$this->_areas['search'] = $search;
	}

	/**
	 * Method to get a pagination object of the weblink items for the category
	 *
	 * @access public
	 * @return  integer
	 */


	/**
	 * Method to get the search areas
	 *
	 * @return int
	 *
	 * @since 1.5
	 */
	public function getAreas()
	{
		// Load the Category data
		if (empty($this->_areas['search']))
		{
			$areas = array();

			JPluginHelper::importPlugin('search');
			$dispatcher = JEventDispatcher::getInstance();
			$searchareas = $dispatcher->trigger('onContentSearchAreas');

			foreach ($searchareas as $area)
			{
				if (is_array($area))
				{
					$areas = array_merge($areas, $area);
				}
			}

			$this->_areas['search'] = $areas;
		}

		return $this->_areas;
	}
}
