<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * Actions class for the Actions Component
 */
class ActionsViewForm extends JViewLegacy
{
	// Overwriting JView display method
	function display($tpl = null) 
	{
		// Assign data to the view
		$this->item = $this->get('Item');
 
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		$model = $this->getModel();
		$model->hit();		
		$this->team = $this->get('Team');
		$this->activities = $this->get('Activities');
		$this->teams = $this->get('Teams');
		$this->teams_users = $this->get('Teams_users');
		$this->services = $this->get('Services');
		// Display the view
		parent::display($tpl);
	}
}
