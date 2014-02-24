<?php

## No Direct Access - Kill this Script!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class AutoViewMakes extends JView {

function display($tpl = null) {

	global $mainframe, $option;
	$db = JFactory::getDBO();
	
	## Model is defined in the controller
	$model	=& $this->getModel();

	$makes	=& $this->get('List');
	$models	=& $this->get('Data');
	$make	=& $this->get('Make');
	
	## Getting the data from Mysql table for first list box
	$query = "SELECT makeid, makename FROM #__rdautos_makes"; 

	$db->setQuery($query);

	$makelist[]	    = JHTML::_('select.option',  '0', JText::_( 'Make Selection' ), 'makeid', 'makename' );
	$makelist	    = array_merge( $makelist, $db->loadObjectList() );
	$lists['make']  = 
	JHTML::_('select.genericlist',  $makelist, 'makeid', 'class="inputbox" size="1" ', 
	'makeid', 'makename', intval($make->makeid));	

	$this->assignRef('makes', $makes);
	$this->assignRef('lists', $lists);
	$this->assignRef('make', $make);
	$this->assignRef('models', $models);
	
	parent::display($tpl);
}
    
}
?>
