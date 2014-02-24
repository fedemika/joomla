<?php

## No Direct Access - Kill this Script!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class AutoViewCategory extends JView {

	function display($tpl = null) {
	
		## If we want the add/edit form..
		if($this->getLayout() == 'form') {
			$this->_displayForm($tpl);
			return;
		}

		global $mainframe, $option;
		
		$db    = JFactory::getDBO();	
		
		## Model is defined in the controller
		$model	=& $this->getModel();
		
		## Getting the items into a variable
		$items	=& $this->get('list');

		$this->assignRef('items', $items);
		parent::display($tpl);

	}
	
	function _displayForm($tpl) {
		
		global $mainframe, $option;
		
		## Connecting the Database
		$db    = JFactory::getDBO();
		
		$id = JRequest::getVar('cid', 0);
		
		## Making the query for showing all the categories in list function
		$sql = 'SELECT * FROM #__rdautos_categories
				WHERE catid = '. (int) $id.' ';
		 
         $db->setQuery($sql);
         $data = $db->loadObject();

		## Radio Buttons for published and featured
		$lists['published'] = JHTML::_('select.booleanlist', 'published', 'class="inputbox"', $data->published);	

		$this->assignRef('data', $data);
		$this->assignRef('lists', $lists);
		parent::display($tpl);
		
	}    
}
?>
