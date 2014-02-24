<?php

##########################################################################
## @package Joomla 1.5
## @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
## @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
##
## @component RD-Autos - Version 1.5.5
## @copyright Copyright (C) Robert Dam - http://www.rd-media.org
## @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
## Please do NOT remove this licence statement
###########################################################################

## no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class RDAutosViewcategories extends JView {

	function display() {

		global $mainframe, $option;
		
		$db    = JFactory::getDBO();	
		
		## Model is defined in the controller
		$model	=& $this->getModel('categories');
		
		## Getting the items into a variable
		$items	=& $this->get('list');
		$count	=& $this->get('count');
		$config	=& $this->get('data');

		$this->assignRef('items', $items);
		$this->assignRef('count', $count);
		$this->assignRef('config', $config);
		parent::display($tpl);		

	
	}

}
?>
