<?php

## Direct access is not allowed.
defined('_JEXEC') or die();

jimport('joomla.application.component.model');


class RDAutosModelDetail extends JModel {


   function __construct(){
   
      parent::__construct();

      $this->id = JRequest::getVar('id', 0); 
	  
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
			$user = JFactory::getUser();
			if ($user){
					$user_join = "LEFT JOIN #__rdautos_information_to_user  AS u ON a.carid = u.carid";
		      if ($user->usertype == 'Super Administrator'){
						$published_condition	=	"";
					}else{
						$published_condition	=	"AND a.published = 1 ";
					}
		}
		
		## Making the query for showing all the cars in list function
		$sql = "SELECT * FROM #__rdautos_information AS a  $user_join, #__rdautos_models AS b, #__rdautos_makes AS c
					WHERE a.carid = ".$this->id."
					AND a.makeid =  c.makeid
					AND a.modelid = b.modelid 
					$published_condition";
		 
		 	$db->setQuery($sql);
		 	$this->data = $db->loadObject();
		 	if (!$this->data->carid){
		 		$this->data->carid = $this->id; // the left join may override to NULL the carid
		 	}
		}
		return $this->data;
	}
	
}
?>