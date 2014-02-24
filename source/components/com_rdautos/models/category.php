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


class RDAutosModelCategory extends JModel {

	   var $_total = null;
	   var $_pagination = null;
	   var $_data = null;
	   var $_ordering = null;

   function __construct(){
   
      parent::__construct();
		
		$this->id 		= JRequest::getVar('id', 0); 
		$this->ordering = JRequest::getInt('ordering', 0);
		
		global $mainframe;
		
		$config = JFactory::getConfig();
		
		// Get the pagination request variables
		$limit        = $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		//$limitstart    = $mainframe->getUserStateFromRequest( 'limitstart', 'limitstart', 0, 'int' );
		$limitstart    = JRequest::getVar('limitstart', 0);
		
		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
		
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);

	  
   }

	function getPagination() {
		
		if (empty($this->_pagination)) {
		
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}
	
		return $this->_pagination;
	}
    
    function getTotal() {
	
        if (empty($this->_total)) {
		
            $query = "SELECT * FROM #__rdautos_information AS a, #__rdautos_makes AS c, #__rdautos_models AS d
					  WHERE a.makeid = c.makeid
					  AND a.modelid = d.modelid
					  AND a.catid = ".$this->id."
					  AND a.published = 1";
            $this->_total = $this->_getListCount($query, $this->getState('limitstart'), $this->getState('limit'));
        }

        return $this->_total;
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
		
/* PLUGIN HACK: encapsulate the ordering
		## Making the ordering switch statements
		switch ($this->ordering) {
		   case 0:
			  $this->order = "price";
			  break;
		   case 1:
			  $this->order = "modelid";
			  break;
		   case 2:
			  $this->order = "constructed";
			  break;
		   case 3:
			  $this->order = "mileage";
			  break;
		   case 4:
			  $this->order = "fueltype";
			  break;
		   default:
			  $this->order = "price";			  			  
		} 		
	REPLACE */
			$this->order = $this->getOrdering();
// END PLUGIN HACK 
		 	$db = JFactory::getDBO();
		
			## Making the query for showing all the cars in list function
/* PLUGIN HACK 
			$sql="SELECT * FROM #__rdautos_information AS a, #__rdautos_makes AS c, #__rdautos_models AS d
					WHERE a.makeid = c.makeid
					AND a.modelid = d.modelid
					AND a.catid = ".$this->id."
					AND a.published = 1 
					ORDER BY a.".$this->order." ";
REPLACE */
			$sql="SELECT * FROM #__rdautos_information AS a, #__rdautos_makes AS c, #__rdautos_models AS d
					WHERE a.makeid = c.makeid
					AND a.modelid = d.modelid
					AND a.catid = ".$this->id."
					AND a.published = 1 
					ORDER BY a.image1 DESC, a.".$this->order." ";
// print_r($sql);
// END PLUGIN HACK 
		 
		 	$db->setQuery($sql, $this->getState('limitstart'), $this->getState('limit' ));
		 	$this->data = $db->loadObjectList();
		}
		return $this->data;
	}

   function getFeatured() {
   
		if (empty($this->_data)) {
		
		 	$db = JFactory::getDBO();
		
			## Making the query for showing all the cars in list function
			$sql = "SELECT * FROM #__rdautos_information AS a, #__rdautos_makes AS c, #__rdautos_models AS d
					WHERE a.makeid = c.makeid
					AND a.modelid = d.modelid
					AND a.catid = ".$this->id."
					AND a.published = 1
					AND a.featured = 1
					ORDER BY RAND() LIMIT 2 ";
		 
		 	$db->setQuery($sql);
		 	$this->data = $db->loadObjectList();
		}
		return $this->data;
	}	
	

   function getCat() {
   
		if (empty($this->_data)) {
		
		 	$db = JFactory::getDBO();
		
			$sql = "SELECT catname FROM #__rdautos_categories 
					WHERE catid = ".$this->id." ";
		 
		 	$db->setQuery($sql);
		 	$this->data = $db->loadObject();
		}
		return $this->data;
	}


// PLUGIN HACK 
	function getWith_image() {
   
		if (empty($this->_data)) {
		
			$order = $this->getOrdering();
		 	$db = JFactory::getDBO();
		
			## Making the query for showing all the cars in list function
			$sql = "SELECT * FROM #__rdautos_information AS a, #__rdautos_makes AS c, #__rdautos_models AS d
					WHERE a.makeid = c.makeid
					AND a.modelid = d.modelid
					AND a.catid = ".$this->id."
					AND a.published = 1
					AND a.image1 <> '' 
					ORDER BY a.".$order;
		 
		 	$db->setQuery($sql);
		 	$this->data = $db->loadObjectList();
		}
		return $this->data;
	}
	
	function getOrdering() {
		## Making the ordering switch statements
		switch ($this->ordering) {
		   case 0:
			  $result = "modeltype";
			  break;
		   case 1:
			  $result = "modelid";
			  break;
		   case 2:
			  $result = "constructed";
			  break;
		   case 3:
			  $result = "mileage";
			  break;
		   case 4:
			  $result = "fueltype";
			  break;
		   default:
			  $result = "price";			  			  
		}
		return $result;	
	}
		
// END PLUGIN HACK 
}
?>