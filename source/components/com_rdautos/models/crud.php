<?php

## Direct access is not allowed.
defined('_JEXEC') or die();

jimport('joomla.application.component.model');


class RDAutosModelCrud extends JModel {


   function __construct(){
   
      parent::__construct();

      $this->id = JRequest::getVar('id', 0); 
	  
   }

   function getList() {
   
		if (empty($this->_data)) {
		
		 	$db = JFactory::getDBO();
			$user = JFactory::getUser();
	
			if ($user){
		      if ($user->usertype == 'Super Administrator'){
						$user_condition	=	"";
						$user_join = "";
					}else{
						$user_join = "LEFT JOIN #__rdautos_information_to_user  AS u ON a.carid = u.carid";
						$user_condition	=	"AND u.userid = ".$user->id;
					}
			}
		## Making the query for showing all the cars in list function
		$sql = "SELECT * FROM #__rdautos_information AS a $user_join, #__rdautos_models AS b, #__rdautos_makes AS c 
					WHERE a.carid = ".$this->id." $user_condition 
					AND a.makeid =  c.makeid
					AND a.modelid = b.modelid";
		 
		 	$db->setQuery($sql);

		 	$this->data = $db->loadObject();
		}
		return $this->data;
	}
	
}
?>