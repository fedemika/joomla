<?php

## No Direct Access - Kill this Script!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class AutoViewStats extends JView {

function display($tpl = null) {

	global $mainframe, $option;
	$db = JFactory::getDBO();
	
	## Model is defined in the controller
	$model	=& $this->getModel();

	$stats	=& $this->get('List');
	
	$this->assignRef('stats', $stats);
	
	parent::display($tpl);
}
    
}
?>
