<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
 
/**
 * Actions Model
 */
class ActionsModelAction extends JModelItem
{
	/**
	 * @var object item
	 */
	protected $item;
 
	/**
	 * Method to auto-populate the model state.
	 *
	 * This method should only be called once per instantiation and is designed
	 * to be called on the first call to the getState() method unless the model
	 * configuration flag to ignore the request is set.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @return	void
	 * @since	1.6
	 */
	protected function populateState() 
	{
		$app = JFactory::getApplication();
		// Get the message catid
		$catid = JRequest::getInt('catid');
		$this->setState('message.catid', $catid);
		// Get the pagination
		$page = JRequest::getInt('page');
		$this->setState('message.page', $page);				
 
		// Load the parameters.
		$params = $app->getParams();
		$this->setState('params', $params);
		parent::populateState();
	}
 
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Actions', $prefix = 'Actions', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}

    /**
     * Load an JSON string into the registry into the given namespace [or default if a namespace is not given]
     *
     * @param    string    JSON formatted string to load into the registry
     * @return    boolean True on success
     * @since    1.5
     * @deprecated 1.6 - Oct 25, 2010
     */
    public function loadJSON($data)
    {
        return $this->loadString($data, 'JSON');
    }
 
	/**
	 * Get the message
	 * @return object The message to be displayed to the user
	 */
	public function getItem() 
	{
		//db connection
		$db = JFactory::getDBO();
		$query = "SELECT * FROM #__content WHERE id='".@$_REQUEST['id']."' LIMIT 1 ";
		$db->setQuery($query);
		$action = $db->loadObjectList();
		return $action;
	}
	
	public function hit($pk = 0)
	{
		$input = JFactory::getApplication()->input;
		$hitcount = $input->getInt('hitcount', 1);
		if ($hitcount)
		{
			$db = JFactory::getDBO();
			//get all subcategories
			$query = 'SELECT hits FROM #__content WHERE id=\''.$_REQUEST['id'].'\'';
			$db->setQuery( $query );
			$hits = $db->loadResult();
			$pk = (!empty($pk)) ? $pk : $hits+$hitcount;
			$query = 'UPDATE #__content SET hits=\''.$pk.'\' WHERE id=\''.$_REQUEST['id'].'\'';
			$db->setQuery($query);
			$db->execute();
		}

		return true;
	}
	
	public function getAction()
	{
			//db connection
			$db = JFactory::getDBO();
			$config= new JConfig();
			$app = JFactory::getApplication();	
			$user = JFactory::getUser();
			$isroot = $user->authorise('core.admin');			
			//t.web_link AS team_web_link, t.in_link AS team_in_link, t.fb_link AS team_fb_link, t.tw_link AS team_tw_link, t.pn_link AS team_pn_link, t.go_link AS team_go_link, t.li_link AS team_li_link, t.yt_link AS team_yt_link 			
			$query="SELECT a.*, 
							t.name AS team_name, t.id AS team_id
							FROM #__actions AS a
							INNER JOIN #__teams AS t ON t.id=a.team_id
							WHERE a.id='".@$_REQUEST['id']."' ".($isroot==1?'':'AND a.published=1')." ";
			$db->setQuery( $query );
			$actions = $db->loadObjectList();
		
			//$obj = new stdClass();
			//$actions1 = $obj->various = array('Kalle', 'Ross', 'Felipe');
			//$actions_all = (object) array_merge((array) $actions[0], (array) $subactions[0]);	
			if($actions){
				return $actions;
			}else{
				header('Location:'.JURI::root());
				exit();
			}
	}
	public function getSubactions()
	{
			//db connection
			$db = JFactory::getDBO();
			$config= new JConfig();
			$app = JFactory::getApplication();			
			$query="SELECT a.*
							FROM #__actions AS a
							WHERE a.action_id='".@$_REQUEST['id']."' AND a.published=1 ";
			$db->setQuery( $query );
			$subactions = $db->loadObjectList();		
			return $subactions;
	}	
}
