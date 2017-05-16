<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * Teams class for the Teams Component
 */
class TeamsViewTeam extends JViewLegacy
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
		//$this->subteams = $this->get('Subteams');
		// Display the view
		parent::display($tpl);
	}
}
