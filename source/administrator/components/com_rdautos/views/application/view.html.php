<?php

## no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class AutoViewApplication extends JView {

	function display() {

		## If we want the add/edit form..
		if($this->getLayout() == 'form') {
			$this->_displayForm($tpl);
			return;
		}
	
		global $mainframe, $option;
		
		$db    = JFactory::getDBO();
		
		## Making the query for getting the currency from the config table
		$sql = ' SELECT currency, mileage FROM #__rdautos_config WHERE id = 1';
		$db->setQuery($sql);
		$data = $db->loadObject();
		
		## Model is defined in the controller
		$model	=& $this->getModel();
		
		## Getting the items into a variable
		$items		=& $this->get('list');
        ## Getting the pagination thing :-)
		$pagination = $this->get( 'Pagination' );        
        
		$this->assignRef( 'pagination' , $pagination); 				
		$this->assignRef('items', $items);
		$this->assignRef('data', $data);
		parent::display($tpl);
   
   }

	function _displayForm($tpl) {
	
		global $mainframe, $option;

		$db		=& JFactory::getDBO();
		
		$id     = JRequest::getVar('cid', 0);
	
		$model	=& $this->getModel();
		
		$items	=& $this->get('data');

		## Start Chained Select
		$query = "SELECT makeid, makename FROM #__rdautos_makes WHERE published = 1"; 
		$db->setQuery($query);
	
		$makes = $db->loadObjectList();
		if (count($makes)>1){
			$javascript = " onchange=\"getModelList(this)\" ";
			$selected = intval($items->makeid);
		}else{ // if we have only one make, we let it selected
			$selected = $makes[0]->makeid;
		}		

		$makelist[]	    = JHTML::_('select.option',  '0', JText::_( 'MAKE A SELECTION PLS' ), 'makeid', 'makename' );
		$makelist	    = array_merge( $makelist, $db->loadObjectList() );
		$lists['make']  = JHTML::_('select.genericlist',  $makelist, 'makeid', 'class="inputbox" size="1" '.$javascript, 'makeid', 'makename', $selected);		
		
		
		## Making the query for getting the currency from the config table
		$sql = ' SELECT * FROM #__rdautos_config WHERE id = 1';
		$db->setQuery($sql);
		$config = $db->loadObject();

		$query = "SELECT modelid, model FROM #__rdautos_models WHERE published = 1"; 
		$db->setQuery($query);	
		$models = $db->loadObjectList();
		
		## Model needs to be loaded from the DB, (when edit a car) load the right model.
		if ($items->modelid != ""){

		$query = "SELECT modelid, model FROM #__rdautos_models WHERE makeid = ".$items->makeid." "; 
		$db->setQuery($query);

		$modellist[]	= JHTML::_('select.option',  '0', JText::_( 'MAKE A SELECTION PLS' ), 'modelid', 'model' );
		$modellist	    = array_merge( $modellist, $db->loadObjectList() );
		$lists['model']  = JHTML::_('select.genericlist',  $modellist, 'modelid', 'class="inputbox" size="1" ', 'modelid',
		 'model', intval($items->modelid));
		
		## When adding a new car, show me a dropdown without models.
		}else{		
			if (count($models)==1){ // if we have only one make, we let it selected
				$modellist[]	= JHTML::_('select.option',  '0', JText::_( 'MAKE A SELECTION PLS' ), 'modelid', 'model' );
				$modellist	    = array_merge( $modellist, $models );
				$lists['model']  = JHTML::_('select.genericlist',  $modellist, 'modelid', 'class="inputbox" size="1" ', 'modelid',
				 'model', intval($models[0]->modelid));
			}else{
				$modelid = array('0' => array('value' => '0', 'text' => JText::_( 'MAKE A SELECTION PLS' )));
				$lists[model] = JHTML::_('select.genericList', $modelid, 'modelid', 'class="inputbox" '.'','value', 'text', $items->modelid );
			}		
		}

		$just_1_make_n_model = count($makes)==1 && count($models)==1;
		
		## Eind Chained Select	

		$query = "SELECT catid, catname FROM #__rdautos_categories WHERE published = 1 "; 
		$db->setQuery($query);

		$catlist[]	= JHTML::_('select.option',  '0', JText::_( 'MAKE A SELECTION PLS' ), 'catid', 'catname' );
		$catlist	    = array_merge( $catlist, $db->loadObjectList() );
		$lists['catid'] 			= JHTML::_('list.category',  'catid', $option, intval( $items->catid ) );
//		$lists['catid']  = JHTML::_('select.genericlist',  $catlist, 'catid', 'class="inputbox" size="1" ', 'catid',		 'catname', intval($items->catid));
		
/* PLUGIN HACK
		## Filling the Array() for doors and make a select list for it.
		$doors = array(
			'0' => array('value' => '0', 'text' => JText::_( 'MAKE A SELECTION PLS' )),
			'2' => array('value' => '2', 'text' => '2'.JText::_( 'DOORS' )),
			'3' => array('value' => '3', 'text' => '3'.JText::_( 'DOORS' )),
			'4' => array('value' => '4', 'text' => '4'.JText::_( 'DOORS' )),
			'5' => array('value' => '5', 'text' => '5'.JText::_( 'DOORS' )),
		);
		$lists[doors] = JHTML::_('select.genericList', $doors, 'doors', ' class="inputbox" '. '', 'value', 'text', $items->doors ); 
REPLACE */
		$lists['doors'] = JHTML::_('select.booleanlist', 'doors', 'class="inputbox"', $items->doors);
// END PLUGIN HACK
		
/* PLUGIN HACK: Gears como Salas vacias
		## Filling the Array() for gears and make a select list for it.
		$gears = array(
			'0' => array('value' => '0', 'text' => JText::_( 'MAKE A SELECTION PLS' )),
			'4' => array('value' => '4', 'text' => '4'.JText::_( 'GEARS' )),
			'5' => array('value' => '5', 'text' => '5'.JText::_( 'GEARS' )),
			'6' => array('value' => '6', 'text' => '6'.JText::_( 'GEARS' )),
		);
REPLACE */
		$lists['gears'] = JHTML::_('select.booleanlist', 'gears', ' class="inputbox" ', $items->gears ); 
// END PLUGIN HACK
		
/* PLUGIN HACK: 'Condition' como 'Aire Acondicionado'
		## Filling the Array() for conditions and make a select list for it.
		$condition = array(
			'0' => array('value' => '0', 'text' => JText::_( 'MAKE A SELECTION PLS' )),
			'1' => array('value' => '1', 'text' => JText::_( 'VERY GOOD' )),
			'2' => array('value' => '2', 'text' => JText::_( 'LIKE NEW' )),
			'3' => array('value' => '3', 'text' => JText::_( 'PRE LOVED' )),
			'4' => array('value' => '4', 'text' => JText::_( 'SPARE ENTRY' )),
			'5' => array('value' => '5', 'text' => JText::_( 'NEW VEHICLE' )),
			'6' => array('value' => '6', 'text' => JText::_( 'DEMONSTRATOR' )),
		);
		$lists[condition] = JHTML::_('select.genericList', $condition, 'condition', ' class="inputbox" '. '', 'value', 'text', 
		$items->condition ); 
REPLACE */
		$lists['condition'] = JHTML::_('select.booleanlist', 'condition', 'class="inputbox"', $items->condition);
// END PLUGIN HACK

		
		## Filling the Array() for availebillity and make a select list for it.
		$availeble = array(
			'0' => array('value' => '0', 'text' => JText::_( 'MAKE A SELECTION PLS' )),
			'1' => array('value' => '1', 'text' => JText::_( 'VEHICLE IS AVAILEBLE' )),
			'2' => array('value' => '2', 'text' => JText::_( 'VEHICLE NOT AVAILEBLE' )),
			'3' => array('value' => '3', 'text' => JText::_( 'VEHICLE COMING' )),
		);		
		$lists[availeble] = JHTML::_('select.genericList', $availeble, 'availeble', ' class="inputbox" '. '', 'value', 'text', 
		$items->availeble);
		
/* PLUGIN HACK: 'fueltype' como 'Servicio de bar'
		## Filling the Array() for fueltypes and make a select list for it.
		$fuel = array(
			'0' => array('value' => '0', 'text' => JText::_( 'MAKE A SELECTION PLS' )),
			'1' => array('value' => '1', 'text' => JText::_( 'LEADED' )),
			'2' => array('value' => '2', 'text' => JText::_( 'GASOLINE' )),
			'3' => array('value' => '3', 'text' => JText::_( 'LPGG3' )),
			'4' => array('value' => '4', 'text' => JText::_( 'LPG' )),
		);		
		$lists[fuel] = JHTML::_('select.genericList', $fuel, 'fueltype', ' class="inputbox" '. '', 'value', 'text', $items->fueltype);
REPLACE */
		$lists['fuel'] = JHTML::_('select.booleanlist', 'fueltype', 'class="inputbox"', $items->fueltype);
// END PLUGIN HACK
		
		## Filling the Array() for transmissions and make a select list for it.
		$transmission = array(
			'0' => array('value' => '0', 'text' => JText::_( 'MAKE A SELECTION PLS' )),
			'1' => array('value' => '1', 'text' => JText::_( 'MANUAL' )),
			'2' => array('value' => '2', 'text' => JText::_( 'AUTOMATIC' )),
			'3' => array('value' => '3', 'text' => JText::_( 'TIP TRONIC' )),
		);	
		$lists[transmission] = JHTML::_('select.genericList', $transmission, 'transmission', ' class="inputbox" '. '', 
		'value', 'text', $items->transmission );
		
		## Radio Buttons for published and featured
		$lists['published'] = JHTML::_('select.booleanlist', 'published', 'class="inputbox"', $items->published);
		$lists['featured']  = JHTML::_('select.booleanlist', 'featured', 'class="inputbox"', $items->featured);
			
		$this->assignRef('items', $items);
		$this->assignRef('lists', $lists);
		$this->assignRef('config', $config);
		$this->assignRef('just_1_make_n_model', $just_1_make_n_model);
		
		parent::display($tpl);
	
	}

}
?>
