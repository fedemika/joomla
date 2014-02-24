<?php

## Direct access is not allowed.
defined('_JEXEC') or die();

jimport('joomla.application.component.model');


class RDAutosModelSendafriend extends JModel {


   function __construct(){
   
      parent::__construct();

      $this->id = JRequest::getVar('id', 0); 
	  
   }

   function getList() {
   
		if (empty($this->_data)) {
		
		 	$db = JFactory::getDBO();
		
		# Making the query for showing all the cars in list function
		$sql = "SELECT * FROM #__rdautos_information AS a, #__rdautos_models AS b, #__rdautos_makes AS c, #__rdautos_categories AS d
					WHERE a.carid = ".$this->id."
					AND a.makeid =  c.makeid
					AND a.catid = d.catid
					AND a.modelid = b.modelid";
		 
		 	$db->setQuery($sql);
		 	$this->data = $db->loadObject();
		}
		return $this->data;
	}
	
}
?>