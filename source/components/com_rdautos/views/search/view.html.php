<?php

##########################################################################
## @package Joomla 1.5
## @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
## @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
##
## @component RD-Autos - Version 1.5.3a
## @copyright Copyright (C) Robert Dam - http://www.rd-media.org
## @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
## Please do NOT remove this licence statement
###########################################################################

## no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class RDAutosViewSearch extends JView {

	function display() {

		global $mainframe, $option;
		
		$db    = JFactory::getDBO();	
		
		## Model is defined in the controller
		$model	=& $this->getModel('search');
		
		## Start Chained Select
		$query = "SELECT makeid, makename FROM #__rdautos_makes WHERE published = 1"; 
		$db->setQuery($query);
	
		$javascript = " onchange=\"getModelList(this)\" ";
		
		$makelist[]	    = JHTML::_('select.option',  '0', JText::_( 'Make Selection' ), 'makeid', 'makename' );
		$makelist	    = array_merge( $makelist, $db->loadObjectList() );
		$lists['make']  = JHTML::_('select.genericlist',  $makelist, 'makeid', 'class="inputbox" size="1" '.$javascript, 'makeid',
		 'makename', intval($items->makeid));		
		
		## Model needs to be loaded from the DB, (when edit a car) load the right model.
		if ($items->modelid != ""){

		$query = "SELECT modelid, model FROM #__rdautos_models WHERE makeid = ".$items->makeid." "; 
		$db->setQuery($query);

		$modellist[]	= JHTML::_('select.option',  '0', JText::_( 'Make Selection' ), 'modelid', 'model' );
		$modellist	    = array_merge( $modellist, $db->loadObjectList() );
/* PLUGIN HACK
		$lists['model']  = JHTML::_('select.genericlist',  $modellist, 'modelid', 'class="inputbox" size="1" ', 'modelid',
		 'model', intval($items->modelid));
REPLACE */
		$lists['model']  = JHTML::_('select.genericlist',  $modellist, 'modelid[]', 'class="inputbox" size="1" ', 'modelid',
		 'model', intval($items->modelid));
//	END PLUGIN HACK
		
		## When adding a new car, show me a dropdown without models.
		}else{
		
/* PLUGIN HACK
		$modelid = array('0' => array('value' => '0', 'text' => 'Make Selection'));
		$lists[model] = JHTML::_('select.genericList', $modelid, 'modelid', 'class="inputbox" size="1" '.'','value', 'text', $items->modelid );
REPLACE */
		$modelid = array('0' => array('value' => '0', 'text' => JText::_( 'Make Selection')));
		$lists[model] = JHTML::_('select.genericList', $modelid, 'modelid[]', 'class="inputbox" size="1"'.'','value', 'text', $items->modelid );
//	END PLUGIN HACK
		
		}
		
		## Eind Chained Select	

		## Filling the Array() for transmissions and make a select list for it.
		$transmission = array(
			'0' => array('value' => '0', 'text' => 'Make Selection'),
			'1' => array('value' => '1', 'text' => 'Manual'),
			'2' => array('value' => '2', 'text' => 'Automatic'),
			'3' => array('value' => '3', 'text' => 'Tip Tronic'),
		);	
		$lists[transmission] = JHTML::_('select.genericList', $transmission, 'transmission', ' class="inputbox" '. '', 
		'value', 'text', $items->transmission );
		
/* PLUGIN HACK: 'fueltype' como 'Servicio de bar' y 'condition' como Aire Acondicionado
		## Filling the Array() for fueltypes and make a select list for it.
		$fuel = array(
			'0' => array('value' => '0', 'text' => 'Make Selection'),
			'1' => array('value' => '1', 'text' => 'Leaded'),
			'2' => array('value' => '2', 'text' => 'Gasoline'),
			'3' => array('value' => '3', 'text' => 'LPG G3'),
			'4' => array('value' => '4', 'text' => 'LPG'),
		);		
		$lists[fuel] = JHTML::_('select.genericList', $fuel, 'fueltype', ' class="inputbox" '. '', 'value', 'text', $items->fueltype);
REPLACE */
		$lists['fuel'] = JHTML::_('select.booleanlist', 'fueltype', 'class="inputbox"', $items->fueltype, 'YES', 'INDISTINTO');
		$lists['condition'] = JHTML::_('select.booleanlist', 'condition', 'class="inputbox"', $items->condition, 'YES', 'INDISTINTO');
		$lists['doors'] = JHTML::_('select.booleanlist', 'doors', 'class="inputbox"', $items->doors, 'YES', 'INDISTINTO');
		$lists['gears'] = JHTML::_('select.booleanlist', 'gears', 'class="inputbox"', $items->gears, 'YES', 'INDISTINTO');
// END PLUGIN HACK
				
				
		## Getting the items into a variable
		$items	=& $this->get('list');
		
		$this->assignRef('lists', $lists);
		$this->assignRef('items', $items);
		parent::display($tpl);		

	
	}
}
?>
