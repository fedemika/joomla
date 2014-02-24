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

class RDAutosViewCrud extends JView {

	function display() {

		global $mainframe, $option;
		
		$db    = JFactory::getDBO();	
		
		## Model is defined in the controller
		$model	=& $this->getModel('crud');
		
		## Getting the items into a variable
		$items	=& $this->get('list');

		## Start Chained Select
		$query = "SELECT makeid, makename FROM #__rdautos_makes WHERE published = 1"; 
		$db->setQuery($query);
	
		$javascript = " onchange=\"getModelList(this)\" ";
		
		$makelist[]	    = JHTML::_('select.option',  '0', JText::_( 'Make Selection' ), 'makeid', 'makename' );
		$makelist	    = array_merge( $makelist, $db->loadObjectList() );
		$lists['make']  = JHTML::_('select.genericlist',  $makelist, 'makeid', 'class="inputbox" size="1" tabindex="1"'.$javascript, 'makeid',
		 'makename', intval($items->makeid));		
		
		## Model needs to be loaded from the DB, (when edit a car) load the right model.
		if ($items->modelid != ""){

		$query = "SELECT modelid, model FROM #__rdautos_models WHERE makeid = ".$items->makeid." "; 
		$db->setQuery($query);

		$modellist[]	= JHTML::_('select.option',  '0', JText::_( 'Make Selection' ), 'modelid', 'model' );
		$modellist	    = array_merge( $modellist, $db->loadObjectList() );
		$lists['model']  = JHTML::_('select.genericlist',  $modellist, 'modelid', 'class="inputbox" size="1" tabindex="2"', 'modelid',
		 'model', intval($items->modelid));
		
		## When adding a new car, show me a dropdown without models.
		}else{
		
		$modelid = array('0' => array('value' => '0', 'text' => 'Make Selection'));
		$modelid = array('0' => array('value' => '0', 'text' => JText::_( 'Make Selection')));
		$lists[model] = JHTML::_('select.genericList', $modelid, 'modelid', 'class="inputbox" tabindex="2"','value', 'text', $items->modelid );
		
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
		
		$lists['fuel'] = JHTML::_('select.booleanlist', 'fueltype', 'class="inputbox"', $items->fueltype);
		$lists['condition'] = JHTML::_('select.booleanlist', 'condition', 'class="inputbox"', $items->condition);
		$lists['doors'] = JHTML::_('select.booleanlist', 'doors', 'class="inputbox"', $items->doors);
		$lists['gears'] = JHTML::_('select.booleanlist', 'gears', 'class="inputbox"', $items->gears);
				
				
		## Getting the items into a variable
		$items	=& $this->get('list');
		
		$this->assignRef('lists', $lists);
		$this->assignRef('items', $items);

		$user = JFactory::getUser();

		if (count($_POST)){
			global $mainframe, $option;
			
			$db    = JFactory::getDBO();
			
			$obj = new stdClass();
			## Getting the make and model id.
			$obj->carid      = JRequest::getInt( 'id', -1, 'post' );
			$obj->makeid      = JRequest::getInt( 'makeid', 0, 'post' );
			$obj->modelid     = JRequest::getInt( 'modelid', 0, 'post' );
			## Getting the dates from the inputfields, if not selected pick the newer vehicles..
			$dateFrom    = JRequest::getInt( 'buildfrom', 0, 'post' );
			$dateTo      = JRequest::getInt( 'buildtill', 0, 'post' );
			## Getting the price indicator
			$obj->price     = JRequest::getInt( 'price', 0, 'post' );
			## Getting the transmission type
			$obj->transmission       = JRequest::getInt( 'transmission', 0, 'post' );
			$obj->fueltype        = JRequest::getInt( 'fueltype', 0, 'post' );
			## Getting the mileage
			$obj->mileage   		= JRequest::getInt( 'mileage', 0, 'post' );
			$obj->condition   	= JRequest::getInt( 'condition', 0, 'post' );
			$obj->modeltype   	= JRequest::getString( 'modeltype', '', 'post' );
			$obj->transmission	= JRequest::getString( 'transmission', '', 'post' );
			$obj->catid   			= JRequest::getInt( 'catid', 1, 'post' );
			$obj->accesoires  	= JRequest::getString( 'accesoires', '', 'post',4);
			$obj->color   			= JRequest::getString( 'color', '', 'post' );
			$obj->motorsize   	= JRequest::getString( 'motorsize', '', 'post');
			$obj->doors     		= JRequest::getInt( 'doors', 0, 'post' );
			$obj->gears     		= JRequest::getInt( 'gears', 0, 'post' );
			$obj->weight     		= JRequest::getString( 'weight', '', 'post');
			$obj->image1     		= JRequest::getString( 'image1', '', 'post');
			$obj->image2     		= JRequest::getString( 'image2', '', 'post');
			$obj->image3     		= JRequest::getString( 'image3', '', 'post');
			$obj->image4     		= JRequest::getString( 'image4', '', 'post');
			$obj->image5     		= JRequest::getString( 'image5', '', 'post');
			$obj->image6     		= JRequest::getString( 'image6', '', 'post');
			
			if ($obj->image1) $obj->image1 = $obj->image1.'?-1';
			if ($obj->image2) $obj->image2 = $obj->image2.'?-2';
			if ($obj->image3) $obj->image3 = $obj->image3.'?-3';
			if ($obj->image4) $obj->image4 = $obj->image4.'?-4';
			if ($obj->image5) $obj->image5 = $obj->image5.'?-5';
			if ($obj->image6) $obj->image6 = $obj->image6.'?-6';

			## Making the query for showing all the cars in list function
//			$basic_sql = "INSERT INTO #__rdautos_information (`catid`, `makeid`, `modelid`, `modeltype`, `price`, `mileage`, `doors`, `color`, `fueltype`, `gears`, `transmission`, `motorsize`, `enginepower`, `weight`, `featured`, `availeble`, `condition`, `constructed`, `added`, `updated`, `hits`, `published`, `accesoires`, `image1`, `image2`, `image3`, `image4`, `image5`, `image6`, `image7`, `image8`, `image9`, `image10`, `image11`, `image12`)										VALUES (1, $makeid, $modelid, '$modeltype', $price, $mileage, 0, '$color', $fueltype, 0, '$transmission', '', 0, '', 0, 0, $condition, '', NOW(), NULL, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '');";
			$obj->enginepower = 0;
			$obj->featured    = 0;
			$obj->availeble   = 0;
			$obj->hits     		= 0;

			$mail = JFactory::getMailer();

			if ($this->items->carid){ // if the carid is defined we are updating ( this ensures also that the user is the owner of the db obj, to avoid hack by the user)
				$obj->updated = date("Y-m-d H:i:s");
				$db_ok = $db->updateObject('#__rdautos_information', $obj, 'carid');
				if($db_ok){
					$msg = JText::_('Los datos han sido actualizados.');
					$mail->setSubject( 'Sala modificada' );
				}else{
					$msg = JText::_('ERROR: hubo un error al guardar los datos.');
				}
				$id = $obj->carid;
				$link = JRoute::_('index.php?option=com_rdautos&view=detail&id='.$this->items->carid, false);
			}else if($obj->carid == -1){ //else it's new, if carid > 1, somebody tried to hack the carid
				unset($obj->carid);
				$obj->published   = 0;
				$obj->modeltype = time()." ".$obj->modeltype;
				$obj->added = date("Y-m-d H:i:s");                           
				$db_ok = $db->insertObject('#__rdautos_information', $obj);
				$id = $db->insertid();
				
				if($db_ok){
					$obj_to_user = new stdClass();
					$obj_to_user->carid = $id;
					$obj_to_user->userid = $user->id;
					$db->insertObject('#__rdautos_information_to_user', $obj_to_user);
				}
				
				$msg = JText::_('Gracias por ingresar tu sala. En breve estar&aacute; publicada.');
				$link = JRoute::_('index.php?option=com_rdautos&view=crud', false);
				$mail->setSubject( 'Nueva sala' );
			}

			$mail->addRecipient( 'admin@salasdensayo.com.ar' );
			$mail->setSender( array( 'admin@salasdensayo.com.ar', 'admin@salasdensayo.com.ar' ) );//mail,name
			$mail->setBody('http://'.$_SERVER['SERVER_NAME'].'/component/rdautos/?view=detail&id='.$id);

			if($db_ok && $user->usertype != 'Super Administrator'){ // don't send mail if modifier is the Admin
				$sent = $mail->Send();
			}
//			global $mainframe;
			$mainframe->redirect($link, $msg);

		}else	{
			if ($user->id > 0){
				if ( JRequest::getVar('id', 0) > 0 && !$items->modeltype){
					$mainframe->redirect('/publicar');
				}else{						
					parent::display($tpl);
				}
			}else{
				$mainframe->redirect('/login', 'Debes estar logueado para poder publicar.');
			}
		}
	}
}
?>
