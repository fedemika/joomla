<?php

## Direct access is not allowed.
defined('_JEXEC') or die();

jimport('joomla.application.component.model');


class AutoModelStats extends JModel {

   ## Empty data variabele
   var $_data  = null;

/*
   function __construct()
   {
      parent::__construct();
	  
	  $this->makename =  JRequest::getVar('makename');	
	  	
      $array    = JRequest::getVar('cid', array(0), '', 'array');
      $this->id = (int)$array[0]; 
   }
*/
   function getList() {
      if (empty($this->_data)) {
				$db = JFactory::getDBO();

				## Making the query for showing all the cars in list function
				$make_model_join = "LEFT JOIN #__rdautos_makes AS mk ON l.makeid = mk.makeid LEFT JOIN #__rdautos_models AS md ON l.modelid = md.modelid ";
				$sql = "SELECT l.*, makename, model FROM #__rdautos_search_log AS l $make_model_join ORDER BY search_date DESC LIMIT 0,300";
				$db->setQuery($sql);
				$list = $db->loadObjectList();
				foreach($list as &$row) {
					if (strpos($row->modelid, ',')>0){
						$row->model = $this->getModelsNames($row->modelid);
					}
				}				
				$this->data = $list;
      }
      return $this->data;
   }
   
   function getModelsNames($modelIds) {
			$db = JFactory::getDBO();

			## Making the query for showing all the cars in list function
			$sql = "SELECT model FROM #__rdautos_models WHERE modelid in (".$modelIds.")";
			
			$db->setQuery($sql);
			$result = $db->loadResultArray();

      return implode(',', $result);
   }

}
?>