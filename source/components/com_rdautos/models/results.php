<?php

## Direct access is not allowed.
defined('_JEXEC') or die();

jimport('joomla.application.component.model');


class RDAutosModelResults extends JModel {


   function __construct(){
   
      parent::__construct();
	  
   }

   function getData()
   {
      if (empty($this->_data))
      {
         $db = JFactory::getDBO();

		## Making the query for showing all the cars in list function
		$sql = 'SELECT * FROM #__rdautos_config WHERE id = 1 ';
		 
         $db->setQuery($sql);
         $this->data = $db->loadObject();
      }
      return $this->data;
   }
	
}
?>