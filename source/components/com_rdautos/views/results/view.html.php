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

class RDAutosViewResults extends JView {

	function display() {

		global $mainframe, $option;
		
		$db    = JFactory::getDBO();
		
		## Getting the make and model id.
		$makeid      = JRequest::getInt( 'makeid', 0, 'post' );
/* PLUGIN HACK: multiple modelid
		$modelid     = JRequest::getInt( 'modelid', 0, 'post' );
REPLACE */ 
		$modelid     = JRequest::getVar( 'modelid', '', 'post', 'ARRAY' );
// END PLUGIN HACK 
		## Getting the dates from the inputfields, if not selected pick the newer vehicles..
		$dateFrom    = JRequest::getInt( 'buildfrom', 0, 'post' );
		$dateTo      = JRequest::getInt( 'buildtill', 0, 'post' );
		## Getting the price indicator
		$priceFrom   = JRequest::getInt( 'pricefrom', 0, 'post' );
		$priceTo     = JRequest::getInt( 'pricetill', 0, 'post' );
		## Getting the transmission type
		$trans       = JRequest::getInt( 'transmission', 0, 'post' );
		$fuel        = JRequest::getInt( 'fueltype', 0, 'post' );
		## Getting the mileage
		$mileageFrom = JRequest::getInt( 'mileageFrom', 0, 'post' );
		$mileageTo   = JRequest::getInt( 'mileageTo', 0, 'post' );
// PLUGIN HACK: search by Aire Acondicionado, Name
		$condition    = JRequest::getInt( 'condition', 0, 'post' );
		$modeltype    = trim(JRequest::getString( 'modeltype', '', 'post' ));
		$doors        = JRequest::getInt( 'doors', 0, 'post' );
		$gears        = JRequest::getInt( 'gears', 0, 'post' );
		$accesoires   = trim(JRequest::getString( 'accesoires', '', 'post' ));

		$models = implode(",", $modelid);
// END PLUGIN HACK 

		## Making the query for showing all the cars in list function
		$basic_sql = 'SELECT * FROM #__rdautos_information AS a, #__rdautos_models AS b, 
					  #__rdautos_makes AS c
						WHERE a.makeid =  c.makeid
						AND a.modelid = b.modelid ';
// PLUGIN HACK: don't show unpublished items
		$basic_sql = $basic_sql . 'AND a.published = 1 ';
// END PLUGIN HACK 
		
		if ($makeid != 0) {
			$sql = $basic_sql . 'AND a.makeid = '. (int) $makeid.' ';
			$basic_sql = $sql;					 				 
		}

/* PLUGIN HACK
		if ($modelid != 0) {
			$sql = $basic_sql . 'AND a.modelid =  '. (int) $modelid.' ';
			$basic_sql = $sql;					 				 
		}
REPLACE */
		if (isset($modelid[0]) && $modelid[0] > 0) {
			$sql = $basic_sql . 'AND a.modelid in  ('.$models.') ';
			$basic_sql = $sql;					 				 
		}
//END PLUGIN HACK 

		if ($dateFrom != 0 && $dateTo != 0) {
			$sql = $basic_sql . 'AND a.constructed BETWEEN  '. (int) $dateFrom.' 
								 AND '. (int) $dateTo.' ';
			$basic_sql = $sql;					 				 
		}
		elseif ($dateFrom == 0 && $dateTo != 0) {
			$sql = $basic_sql . 'AND a.constructed <=  '. (int) $dateTo.' ';
			$basic_sql = $sql;
		}	
		elseif ($dateFrom != 0 && $dateTo == 0) {
			$sql = $basic_sql . 'AND a.constructed >=  '. (int) $dateFrom.' ';
			$basic_sql = $sql;
		}	
		
		if ($priceFrom != 0 && $priceTo != 0) {
			$sql = $basic_sql . 'AND a.price BETWEEN  '. (int) $priceFrom.' 
								 AND '. (int) $priceTo.'  ';
			$basic_sql = $sql;					 
		}						 
		elseif ($priceFrom == 0 && $priceTo != 0) {
			$sql = $basic_sql . 'AND a.price <=  '. (int) $priceTo.' ';
			$basic_sql = $sql;
		}	
		elseif ($priceFrom != 0 && $priceTo == 0) {
			$sql = $basic_sql . 'AND a.price >= '. (int) $priceFrom.' ';
			$basic_sql = $sql;
		}
		
		if ($trans > 0) {
			$sql = $basic_sql . 'AND a.transmission = '. (int) $trans.' ';
			$basic_sql = $sql;
		}					

		if ($fuel > 0) {
			$sql = $basic_sql . 'AND a.fueltype = '. (int) $fuel.' ';
			$basic_sql = $sql;
		}				

		if ($mileageFrom != 0 && $mileageTo != 0) {
			$sql = $basic_sql . 'AND a.mileage BETWEEN  '. (int) $mileageFrom.' 
								 AND '. (int) $mileageTo.'  ';
			$basic_sql = $sql;					 
		}						 
		elseif ($mileageFrom == 0 && $mileageTo != 0) {
			$sql = $basic_sql . 'AND a.mileage <=  '. (int) $mileageTo.' ';
			$basic_sql = $sql;
		}	
		elseif ($mileageFrom != 0 && $mileageTo == 0) {
			$sql = $basic_sql . 'AND a.mileage >= '. (int) $mileageFrom.' ';
			$basic_sql = $sql;
		}
		
// PLUGIN HACK: search by Aire Acondicionado, Name
		if ($condition > 0) {
			$sql = $basic_sql . 'AND a.condition = '. (int) $condition.' ';
			$basic_sql = $sql;
		}				
		if (!empty($modeltype)) {
			$sql = $basic_sql . 'AND a.modeltype LIKE \'%'. $modeltype.'%\' ';
			$basic_sql = $sql;
		}				
		if ($doors > 0) {
			$sql = $basic_sql . 'AND a.doors = '. (int) $doors.' ';
			$basic_sql = $sql;
		}				
		if ($gears > 0) {
			$sql = $basic_sql . 'AND a.gears = '. (int) $gears.' ';
			$basic_sql = $sql;
		}				
		if (!empty($accesoires)) {
			$sql = $basic_sql . 'AND a.accesoires LIKE \'%'. $accesoires.'%\' ';
			$basic_sql = $sql;
		}				
		$basic_sql = $basic_sql . ' ORDER BY a.image1 DESC ';
//		print($basic_sql);


// END PLUGIN HACK
// PLUGIN HACK: order by model if multiple models selectes
		if (count($modelid) > 1) {
			$sql = $basic_sql . ' , b.model ';
			$basic_sql = $sql;
		}
// END PLUGIN HACK
		
		$sql = $basic_sql;
			
		$db->setQuery($sql);
		$items = $db->loadObjectList();
		$config	=& $this->get('data');

// logueamos la busquedas
		$user = JFactory::getUser();
     if ($user->usertype != 'Super Administrator'){ 
			$fp = fopen("log.txt","a");
			$toWrite = date("d-m-y H:i:s")."-->;".$makeid.";".$models.";".$fuel.";".$mileageFrom.";".$condition.";".$modeltype.";".$doors.";".$gears.";".$accesoires."\n";
			fwrite($fp,$toWrite);
			fclose($fp);

			$db    = JFactory::getDBO();
			
			$obj = new stdClass();
			## Getting the make and model id.
			$obj->search_date = date("Y-m-d H:i:s");
			$obj->makeid      = JRequest::getInt( 'makeid', 0, 'post' );
			$obj->modelid = JRequest::getVar( 'modelid', '', 'post', 'ARRAY' );
			$obj->modelid = implode(",", $obj->modelid);
			$obj->fueltype        = JRequest::getInt( 'fueltype', 0, 'post' );
			$obj->mileage   		= JRequest::getInt( 'mileageFrom', 0, 'post' );
			$obj->condition   	= JRequest::getInt( 'condition', 0, 'post' );
			$obj->modeltype   	= JRequest::getString( 'modeltype', '', 'post' );
			$obj->catid   			= JRequest::getInt( 'catid', 1, 'post' );
			$obj->accesoires  	= JRequest::getString( 'accesoires', '', 'post',4);
			$obj->doors     		= JRequest::getInt( 'doors', 0, 'post' );
			$obj->gears     		= JRequest::getInt( 'gears', 0, 'post' );
			$obj->results				= count($items);

			//TODO: no se xq al hacer cualquier búsqueda, siempre loguea una búsqueda con todos los campos del form vacios, como no se como solucionarlo, evito loguear búsquedas vacias. Tiene q ver con php/server xq en mi localhost tb pasa y en el host gratuito 260mb no pasaba...
			if ($obj->makeid || $obj->modelid || $obj->fueltype || $obj->mileage || $obj->condition || $obj->modeltype || $obj->accesoires || $obj->doors || $obj->gears){
				$db_ok = $db->insertObject('#__rdautos_search_log', $obj);
				$search_id = $db->insertid();

				if (true){
					$sql = "SELECT b.*, c.* FROM #__rdautos_models AS c, #__rdautos_makes AS b
								WHERE b.makeid =  ".$obj->makeid;
					if ($obj->modelid > 0){
							$sql .= " AND c.modelid IN (".$obj->modelid.")";
					}
					 
				 	$db->setQuery($sql);
				 	$res = $db->loadObjectList();
				 	$obj->makename = $res[0]->makename;
					if ($obj->modelid > 0){
					 	foreach($res as $r){
						 	$obj->model[] = $r->model;
					 	}
					}
				}				
			}
		}
//print_r($obj);

		$this->assignRef('search', $obj);
		$this->assignRef('search_id', $search_id);
		$this->assignRef('items', $items);
		$this->assignRef('config', $config);
		parent::display($tpl);		

	
	}
	
}
?>
