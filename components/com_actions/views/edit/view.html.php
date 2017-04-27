<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * Actions class for the Actions Component
 */
class ActionsViewEdit extends JViewLegacy
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
		//$model->hit();		
		$this->action = $this->get('Action');
		$this->subactions = $this->get('Subactions');
		$this->team = $this->get('Team');
		$this->activities = $this->get('Activities');
		$this->teams = $this->get('Teams');
		$this->supporters = $this->get('Supporters');
		$this->services = $this->get('Services');
		// Display the view
		parent::display($tpl);
	}
}
