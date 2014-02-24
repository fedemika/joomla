<?php

## Direct access is not allowed.
defined('_JEXEC') or die();

jimport('joomla.application.component.model');


class AutoModelApplication extends JModel {

   ## Empty data variabele
   var $_data  = null;
   var $_id = null;
   var $_ordering = null;
   var $_orderby = null;
   var $_total;
   var $_pagination;

   function __construct()
   {
      parent::__construct();
	  
	global $mainframe;

	$config = JFactory::getConfig();

	## Get the pagination request variables
	$limit        = $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
	$limitstart    = $mainframe->getUserStateFromRequest( 'products.limitstart', 'limitstart', 0, 'int' );
	

	## In case limit has been changed, adjust limitstart accordingly
	$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

	$this->setState('limit', $limit);
	$this->setState('limitstart', $limitstart);
				  

      $array    = JRequest::getVar('cid', array(0), '', 'array');
      $this->id = (int)$array[0]; 
	  
	  $this->ordering = JRequest::getVar( 'ordering', 'added' );
	  $this->orderby = JRequest::getVar( 'orderby', 'DESC' );
	  
   }
   
   function getPagination() {
   
        if (empty($this->_pagination))
        {
            jimport('joomla.html.pagination');
            $this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
        }

        return $this->_pagination;
    }
    
    function getTotal(){
	
        if (empty($this->_total))
        {
            $query = "SELECT * FROM #__rdautos_makes, #__rdautos_models, #__rdautos_information
				WHERE #__rdautos_information.makeid = #__rdautos_makes.makeid
				AND #__rdautos_information.modelid = #__rdautos_models.modelid";
            $this->_total = $this->_getListCount($query, $this->getState('limitstart'), $this->getState('limit'));
        }

        return $this->_total;
    }  

   function getList()
   {
	global $option;
      if (empty($this->_data))
      {
         $db = JFactory::getDBO();

		## Making the query for showing all the cars in list function
		$user_join = "LEFT JOIN #__rdautos_information_to_user  AS u ON c.carid = u.carid";
		$cat_join = "LEFT JOIN #__categories AS d ON c.catid = d.id";
		$sql = "SELECT a.makename, b.model, c.*, d.title, u.userid FROM #__rdautos_makes AS a, #__rdautos_models AS b, #__rdautos_information AS c $user_join $cat_join
				WHERE c.makeid = a.makeid
				AND c.modelid = b.modelid
				ORDER BY c.".$this->ordering." ".$this->orderby."";

         $db->setQuery($sql, $this->getState('limitstart'), $this->getState('limit' ));
         $this->data = $db->loadObjectList();
      }
      return $this->data;
   }
   
   function getData() {
   		
      if (empty($this->_data))
      {
         $db = JFactory::getDBO();

		## Getting the information for just one car. 
		## The ID is prvided by the URL
		$sql = 'SELECT * FROM #__rdautos_information
				WHERE carid = '. (int) $this->id.' ';
		 
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
		
			$mainframe->redirect('index.php?option='.$option, JText::_( 'NO SELECTED CAR' ));
		}
		
		JArrayHelper::toInteger($cid);
		$cids = implode( ',', $cid );

		## Make the query to delete one of the cars.
		$query = 'DELETE FROM #__rdautos_information WHERE carid IN ( '.$cids.' )';
		$db->setQuery($query);
		
		## If the query doesn't work..
		if (!$db->query() ){
			echo "<script>alert('The query didn't run.. Please report your problem. (Code: Application-Model-123)');
			window.history.go(-1);</script>\n";		 
		}
		
		## Nothing went wrong, redirect now to the overview.
		$mainframe->redirect('index.php?option='.$option, JText::_( 'SELECTED CAR DELETED' ));	
			
	}

	function publish($cid = array(), $publish = 1) {
		
		## Count the cids
		if (count( $cid )) {
		
			## Make cids safe, against SQL injections
			JArrayHelper::toInteger($cid);
			## Implode cids for more actions (when more selected)
			$cids = implode( ',', $cid );

			$query = 'UPDATE #__rdautos_information'
				. ' SET published = '.(int) $publish
				. ' WHERE carid IN ( '.$cids.' )';
			
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
			
		if ($id == 0) { $id = JRequest::getVar( 'carid', 0 ); }
		
			## Requesting the files for upload.
			$file 		= JRequest::getVar( 'ad_picture1', '', 'files', 'array' );
			$file2 		= JRequest::getVar( 'ad_picture2', '', 'files', 'array' );
			$file3 		= JRequest::getVar( 'ad_picture3', '', 'files', 'array' );
			$file4 		= JRequest::getVar( 'ad_picture4', '', 'files', 'array' );
			$file5 		= JRequest::getVar( 'ad_picture5', '', 'files', 'array' );
			$file6 		= JRequest::getVar( 'ad_picture6', '', 'files', 'array' );
			$file7 		= JRequest::getVar( 'ad_picture7', '', 'files', 'array' );
			$file8 		= JRequest::getVar( 'ad_picture8', '', 'files', 'array' );
			$file9 		= JRequest::getVar( 'ad_picture9', '', 'files', 'array' );
			$file10 	= JRequest::getVar( 'ad_picture10', '', 'files', 'array' );
			$file11		= JRequest::getVar( 'ad_picture11', '', 'files', 'array' );
			$file12 	= JRequest::getVar( 'ad_picture12', '', 'files', 'array' );
		
			## Required helper.
			require_once(JPATH_COMPONENT.DS.'helper'.DS.'helper.php');
		
			## Ready for uploading image 1
			if (isset( $_FILES['ad_picture1']) and !$_FILES['ad_picture1']['error'] ) {
				UPLOAD_autos::uploadhandler($id, $file, $row->image1, '1');
			}
			## Ready for uploading image 2
			if (isset( $_FILES['ad_picture2']) and !$_FILES['ad_picture2']['error'] ) {
				UPLOAD_autos::uploadhandler($id, $file2, $row->image2, '2');
			}	
			## Ready for uploading image 3
			if (isset( $_FILES['ad_picture3']) and !$_FILES['ad_picture3']['error'] ) {
				UPLOAD_autos::uploadhandler($id, $file3, $row->image3, '3');
			}	
			## Ready for uploading image 4
			if (isset( $_FILES['ad_picture4']) and !$_FILES['ad_picture4']['error'] ) {
				UPLOAD_autos::uploadhandler($id, $file4, $row->image4, '4');
			}	
			## Ready for uploading image 5
			if (isset( $_FILES['ad_picture5']) and !$_FILES['ad_picture5']['error'] ) {
				UPLOAD_autos::uploadhandler($id, $file5, $row->image5, '5');
			}	
			## Ready for uploading image 6
			if (isset( $_FILES['ad_picture6']) and !$_FILES['ad_picture6']['error'] ) {
				UPLOAD_autos::uploadhandler($id, $file6, $row->image6, '6');
			}	
			## Ready for uploading image 7
			if (isset( $_FILES['ad_picture7']) and !$_FILES['ad_picture7']['error'] ) {
				UPLOAD_autos::uploadhandler($id, $file7, $row->image7, '7');
			}							
			## Ready for uploading image 8
			if (isset( $_FILES['ad_picture8']) and !$_FILES['ad_picture8']['error'] ) {
				UPLOAD_autos::uploadhandler($id, $file8, $row->image8, '8');
			}
			## Ready for uploading image 9
			if (isset( $_FILES['ad_picture9']) and !$_FILES['ad_picture9']['error'] ) {
				UPLOAD_autos::uploadhandler($id, $file9, $row->image9, '9');
			}
			## Ready for uploading image 10
			if (isset( $_FILES['ad_picture10']) and !$_FILES['ad_picture10']['error'] ) {
				UPLOAD_autos::uploadhandler($id, $file10, $row->image10, '10');
			}
			## Ready for uploading image 11
			if (isset( $_FILES['ad_picture11']) and !$_FILES['ad_picture11']['error'] ) {
				UPLOAD_autos::uploadhandler($id, $file11, $row->image11, '11');
			}
			## Ready for uploading image 12
			if (isset( $_FILES['ad_picture12']) and !$_FILES['ad_picture12']['error'] ) {
				UPLOAD_autos::uploadhandler($id, $file12, $row->image12, '12');
			}										
			## OK, everything is done, redirect the user now.
			$mainframe->redirect('index.php?option=com_rdautos', JText::_( 'VEHICLE SAVED' ));	
		}			
	
	}
?>