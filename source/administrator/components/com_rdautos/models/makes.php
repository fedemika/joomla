<?php

## Direct access is not allowed.
defined('_JEXEC') or die();

jimport('joomla.application.component.model');


class AutoModelMakes extends JModel {

   ## Empty data variabele
   var $_data  = null;
   var $_id = null;

   function __construct()
   {
      parent::__construct();
	  
	  $this->makename =  JRequest::getVar('makename');	
	  	
      $array    = JRequest::getVar('cid', array(0), '', 'array');
      $this->id = (int)$array[0]; 
   }

   function getList()
   {
      if (empty($this->_data))
      {
         $db = JFactory::getDBO();

		## Making the query for showing all the cars in list function
		$sql = "SELECT * FROM #__rdautos_makes ORDER BY makename";
		 
         $db->setQuery($sql);
         $this->data = $db->loadObjectList();
      }
      return $this->data;
   }
   
   function getData() {
   		
      if (empty($this->_data))
      {
         $db = JFactory::getDBO();

		## Making the query for showing all the cars in list function
		$sql = 'SELECT * FROM #__rdautos_models
				WHERE makeid = '.$this->id.' ORDER BY model ';
		 
         $db->setQuery($sql);
         $this->data = $db->loadObjectList();
      }
      return $this->data;
   }   

   function getMake() {
   		
      if (empty($this->_data))
      {
         $db = JFactory::getDBO();

		## Making the query for showing all the cars in list function
		$sql = 'SELECT makeid, makename FROM #__rdautos_makes
				WHERE makeid = '.$this->id.' ';
		 
         $db->setQuery($sql);
         $this->data = $db->loadObject();
      }
      return $this->data;
   }  
   
	function remove($cid){
		
		global $mainframe, $option;
		
		$db    = JFactory::getDBO();
		
		$sql = ' SELECT * FROM #__rdautos_information where modelid = '.$cid.' ';
		$db->setQuery($sql);
		$data = $db->loadObjectList();
		$n = count($data);
		
		if ($n > 0){
		
			if ($n > 1) {
				$msg = JText::_( 'CANT DELETE MODEL' ) .' '.$n.' '. JText::_( 'USING THIS MODEL' );
			}else{
				$msg = 	JText::_( 'CANT DELETE MODEL2' ) .' '.$n.' '. JText::_( 'USING THIS MODEL' );
			}
			
			$mainframe->redirect('index.php?option='.$option.'&controller=makes&task=makes', $msg );
		}	
		
		$query = 'DELETE FROM #__rdautos_models WHERE modelid = '.$cid.' ';
		
		$db->setQuery($query);
		
		if (!$db->query() ){
			echo "<script>alert('ERROR: /models/makes.php/94');
			window.history.go(-1);</script>\n";		 
		}
		
		$mainframe->redirect('index.php?option='.$option.'&controller=makes&task=makes', JText::_( 'DELETED MODEL' ));	
			
	}

	function delete($cid){
		
		global $mainframe, $option;
		
		$db    = JFactory::getDBO();

		$sql = ' SELECT * FROM #__rdautos_information where makeid = '.$cid.' ';
		$db->setQuery($sql);
		$data = $db->loadObjectList();
		$n = count($data);
		
		if ($n > 0){
		
			if ($n > 1) {
				$msg = JText::_( 'CANT DELETE MAKE' ) .' '.$n.' '. JText::_( 'USING THIS MAKE' );
			}else{
				$msg = 	JText::_( 'CANT DELETE MAKE2' ) .' '.$n.' '. JText::_( 'USING THIS MAKE' );
			}
			
			$mainframe->redirect('index.php?option='.$option.'&controller=makes&task=makes', $msg );
		}		
		
		$query = 'DELETE FROM #__rdautos_makes WHERE makeid = '.$cid.' ';
		
		$db->setQuery($query);
		
		if (!$db->query() ){
			echo "<script>alert('An error has occured, please try again!');
			window.history.go(-1);</script>\n";		 
		}
		
		$mainframe->redirect('index.php?option='.$option.'&controller=makes&task=makes', JText::_( 'DELETED MAKE' ));	
			
	}

	function publish($cid, $publish = 1) {

		$query = 'UPDATE #__rdautos_makes'
			. ' SET published = '.(int) $publish
			. ' WHERE makeid = '.$cid.'';
		
		## Do the query now	
		$this->_db->setQuery( $query );
		
		## When query goes wrong.. Show message with error.
		if (!$this->_db->query()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
	return true;
	}

	function publishmodel($cid, $publish = 1) {

		$query = 'UPDATE #__rdautos_models'
			. ' SET published = '.(int) $publish
			. ' WHERE modelid = '.$cid.'';
		
		## Do the query now	
		$this->_db->setQuery( $query );
		
		## When query goes wrong.. Show message with error.
		if (!$this->_db->query()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
	return true;
	}	

	function addmake($data) {

		global $mainframe, $option;
		
		$row =& $this->getTable();

		## Bind the form fields to the web link table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		## Make sure the web link table is valid
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		} 

		## Store the web link table to the database
		if (!$row->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		
	return true;
	}	

	function addmodel($data) {

		global $mainframe, $option;
		
		$row =& $this->getTable('Models', 'Table');

		## Bind the form fields to the web link table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		## Make sure the web link table is valid
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		} 

		## Store the web link table to the database
		if (!$row->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		
	return true;
	}	
	
}
?>