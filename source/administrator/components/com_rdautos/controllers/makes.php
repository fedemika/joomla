<?php

defined('_JEXEC') or die ('No Acces to this file!');

jimport('joomla.application.component.controller');

## This Class contains all data for the car manager
class AutoControllerMakes extends JController {

	function __construct() {
		parent::__construct();

			## Register Extra tasks
			$this->registerTask('add' , 'edit' );
			$this->registerTask('unpublish','publish');
			$this->registerTask('apply','save' );	
			
			$this->makeid = JRequest::getInt('makeid', 0);	
			$this->model = JRequest::getInt('model');	

	}

	## This function will display if there is no choice.
	function display() {
	
		JRequest::setVar( 'layout', 'default'  );
		JRequest::setVar( 'view'  , 'makes');
		parent::display();
	}

	## This function will save makes.
	function savemake() {
		
		global $mainframe, $option;
		
		$makename = JRequest::getVar(makename);
		
		## Connecting the Database
		$db    = JFactory::getDBO();
		
		## Doing the query to be sure if this make isn't allready in DB
		$sql   = 'SELECT makename FROM #__rdautos_makes WHERE makename LIKE "%'.$makename.'%" ';

		$db->setQuery($sql);
		$data = $db->loadObjectList();
		
		## Count the result 
		$n = count($data);
		
		## If result is bigger than 1, it's on the list..
		if ($n > 0) {
		
			JError::raiseWarning(100, 'This make allready exists in your list!');
			$mainframe->redirect('index.php?option='.$option.'&controller=makes&task=makes');			
		
		} else {
			
			$post['makename']  = JRequest::getVar('makename');
			$post['published'] = JRequest::getVar('published', 1);	

			$model = $this->getModel('makes');
	
			if(!$model->addmake($post)) {
				echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
			}

		}		
		
		$this->setRedirect('index.php?option='.$option.'&controller=makes', 'Added Vehicle Make Succesfull.');
	}

	## This function will save makes.
	function savemodel() {
		
		global $mainframe, $option;
		
		$model = JRequest::getVar(model);
		
		## Connecting the Database
		$db    = JFactory::getDBO();
		
		## Doing the query to be sure if this make isn't allready in DB
		$sql   = 'SELECT model FROM #__rdautos_models 
				  WHERE makeid = "'.(int) $this->makeid.'"
				  AND model = "'.$model.'" ';

		$db->setQuery($sql);
		$data = $db->loadObjectList();
		
		## Count the result 
		$n = count($data);
		
		## If result is bigger than 1, it's on the list..
		if ($n > 0) {
			
			## Raise a warnings message
			JError::raiseWarning(100, 'This model allready exists in your list!');
			$mainframe->redirect('index.php?option='.$option.'&controller=makes&task=makes');		
		
		} else {
			
			$post['makeid']  = JRequest::getVar('makeid');
			$post['model']  = JRequest::getVar('model');
			$post['published'] = "1";	

			$model = $this->getModel('makes');
	
			if(!$model->addmodel($post)) {
				echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
			}

		}	
			
		$msg ='Added Vehicle Model Succesfull.';
		$this->setRedirect('index.php?option='.$option.'&controller=makes&cid='.JRequest::getVar('makeid').'', $msg);
	}

	function remove() {
	
		global $option;
	
		$cid = JRequest::getVar('cid', 0);

		$model = $this->getModel('makes');
		
		if(!$model->remove($cid)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect('index.php?option='.$option.'&controller=makes&task=makes', 'Selected model has been deleted!');
		
	}

	function delete() {
	
		global $option;
	
		$cid = JRequest::getVar('cid', 0);

		$model = $this->getModel('makes');
		
		if(!$model->delete($cid)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect('index.php?option='.$option.'&controller=makes&task=makes', 'Selected model has been deleted!');
		
	}
	
	function publish() {
	
		global $mainframe;
		
		$p   = JRequest::getVar( 'p', 0 );
		$cid = JRequest::getVar( 'cid', 0 );
		
		## Getting the task (publish/upnpublish)
		if ($p == 1) {
			$publish = 1;
		} else {
			$publish = 0;
		}		
		
		## Make a connection with the model
		$model = $this->getModel('makes');
		
		## If the model exists, go on with publish action
		if(!$model->publish($cid, $publish)) {
			$link = 'index.php?option=com_rdautos';
			$this->setRedirect($link, 'An error occured..'.$cid.' '.$publish.'');
		}
		$link = 'index.php?option=com_rdautos&controller=makes&task=makes';
		$this->setRedirect($link);
	}

	function publishmodel() {
	
		global $mainframe;
		
		$p    = JRequest::getVar( 'p', 0 );
		$make = JRequest::getVar( 'make', 0 );
		$cid  = JRequest::getVar( 'cid', 0 );
		
		## Getting the task (publish/upnpublish)
		if ($p == 1) {
			$publish = 1;
		} else {
			$publish = 0;
		}		
		
		## Make a connection with the model
		$model = $this->getModel('makes');
		
		## If the model exists, go on with publish action
		if(!$model->publishmodel($cid, $publish)) {
			$link = 'index.php?option=com_rdautos';
			$this->setRedirect($link, 'An error occured.. Please post your bug in our forum, thank you for helping.');
		}
		$link = 'index.php?option=com_rdautos&controller=makes&task=makes&cid='.$make.'';
		$this->setRedirect($link);
	}

   
}	
?>
