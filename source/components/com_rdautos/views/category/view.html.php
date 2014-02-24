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

class RDAutosViewCategory extends JView {

	function display() {

		global $mainframe, $option;
		
		$db    		= JFactory::getDBO();
		$id   		= JRequest::getVar('id', 0);	
		$order   	= JRequest::getInt('order', 1);
		
		## Model is defined in the controller
		$model	=& $this->getModel('category');
		
		## Getting the items into a variable
		$items		=& $this->get('list');
		$config		=& $this->get('data');
		$cat		=& $this->get('cat');
		$featured	=& $this->get('featured');
        $pagination = $this->get( 'Pagination' ); 
		
		## Getting the pathway
		$query 	  = "SELECT catname FROM #__rdautos_categories WHERE catid = 1 ";
		$db->setQuery($query);
		$category = $db->loadObject();

		## Filling the Array() for doors and make a select list for it.
		$ordering = array(
			'0' => array('value' => '0', 'text' => JText::_( 'ORDER PRICE' )),
			'1' => array('value' => '1', 'text' => JText::_( 'ORDER MODEL' )),
			'2' => array('value' => '2', 'text' => JText::_( 'ORDER CONSTRUCTION' )),
			'3' => array('value' => '3', 'text' => JText::_( 'ORDER MILEAGE' )),
			'4' => array('value' => '4', 'text' => JText::_( 'ORDER FUEL' )),
		);
		$lists[ordering] = JHTML::_('select.genericList', $ordering, 'ordering', ' class="inputbox" '. '', 'value', 'text', $order );
	
		$this->assignRef('category', $category);		       
		$this->assignRef('pagination' , $pagination); 		
		$this->assignRef('items', $items);
		$this->assignRef('cat', $cat);
		$this->assignRef('config', $config);
		$this->assignRef('featured', $featured);
		$this->assignRef('lists', $lists);
		parent::display($config->template ? $config->template:$tpl);		

	
	}

}
?>
