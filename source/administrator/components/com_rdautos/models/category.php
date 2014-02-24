<?php

## Direct access is not allowed.
defined('_JEXEC') or die();

jimport('joomla.application.component.model');


class AutoModelCategory extends JModel {

   ## Empty data variabele
   var $_data  = null;
   var $_id = null;

   function __construct()
   {
      parent::__construct();

      $this->id = JRequest::getVar('cid', 0); 
	  
   }

   function getList()
   {
      if (empty($this->_data))
      {
         $db = JFactory::getDBO();

		## Making the query for showing all the cars in list function
		$sql = "SELECT * FROM #__rdautos_categories";
		 
         $db->setQuery($sql);
         $this->data = $db->loadObjectList();
      }
      return $this->data;
   }

   function getData()
   {
      if (empty($this->_data))
      {
         $db = JFactory::getDBO();

		## Making the query for showing all the cars in list function
		$sql = 'SELECT * FROM #__rdautos_categories
				WHERE catid = 1 ';
		 
         $db->setQuery($sql);
         $this->data = $db->loadObject();
      }
      return $this->data;
   }

	function remove($cid  = array()) {
		
		global $mainframe, $option;
		$db  = JFactory::getDBO();
		
		## If someone is trying to delete without $cid
		## If there is no cid provided, redirect the component.
		if(count($cid) < 1 ) {
		
			$mainframe->redirect('index.php?option='.$option, JText::_( 'NO CAT SELECTED' ));
		}
		
		JArrayHelper::toInteger($cid);
		$cids = implode( ',', $cid );

		## Make the query to delete one of the categories.
		$query = 'DELETE FROM #__rdautos_categories WHERE catid IN ( '.$cids.' )';
		$db->setQuery($query);
		
		## If the query doesn't work..
		if (!$db->query() ){
			echo "<script>alert('The query didn't run.. Please report your problem. (Code: Category-Model-75)');
			window.history.go(-1);</script>\n";		 
		}
		
		## Nothing went wrong, redirect now to the overview.
		$mainframe->redirect('index.php?option='.$option.'&controller=category', JText::_( 'CATEGORY DELETED' ));	
			
	}
 
	function publish($cid = array(), $publish = 1) {
		
		## Count the cids
		if (count( $cid )) {
		
			## Make cids safe, against SQL injections
			JArrayHelper::toInteger($cid);
			## Implode cids for more actions (when more selected)
			$cids = implode( ',', $cid );

			$query = 'UPDATE #__rdautos_categories'
				. ' SET published = '.(int) $publish
				. ' WHERE catid IN ( '.$cids.' )';
			
			## Do the query now	
			$this->_db->setQuery( $query );
			
			## When query goes wrong.. Show message with error.
			if (!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return true;
	}
 
   
	function store($data)
	{
	
		global $mainframe;
		
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
		
		## $id will be needed for imagename.
		$id = mysql_insert_id();
			
		if ($id == 0) { $id = JRequest::getVar( 'catid', 0 ); }
		
			## Requesting the files for upload.
			$file 		= JRequest::getVar( 'file', '', 'files', 'array' );

		
			## Required helper.
			require_once(JPATH_COMPONENT.DS.'helper'.DS.'helper.php');
		
			## Ready for uploading image 1
			if (isset( $_FILES['file']) and !$_FILES['file']['error'] ) {
				UPLOAD_autos::catupload($id, $file, $row->image1, '1');
			}
								
			## OK, everything is done, redirect the user now.
			$mainframe->redirect('index.php?option=com_rdautos&controller=category', JText::_( 'CATEGORY SAVED' ));	
		}			
	
	}
?>