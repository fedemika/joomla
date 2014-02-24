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

defined('_JEXEC') or die();

jimport('joomla.application.component.model');


class RDAutosModelCategories extends JModel {


   function __construct(){
   
      parent::__construct();

      $this->id = JRequest::getVar('cid', 0); 
	  
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


   function getList() {
   
		if (empty($this->_data)) {
		
		 	$db = JFactory::getDBO();
		
			## Making the query for showing all the cars in list function
			$sql = "SELECT * FROM #__rdautos_categories WHERE published = 1";
		 
		 	$db->setQuery($sql);
		 	$this->data = $db->loadObjectList();
		}
		return $this->data;
	}

   function getCount() {
   
		if (empty($this->_data)) {
		
		 	$db = JFactory::getDBO();
		
			## Making the query for showing all the cars in list function
			$sql = "SELECT carid FROM #__rdautos_information WHERE published = 1";
		 
		 	$db->setQuery($sql);
		 	$this->data = $db->loadObjectList();
		}
		return $this->data;
	}
	
}
?>