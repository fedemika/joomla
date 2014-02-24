<?php

defined('_JEXEC') or die ('No Access to this file!');

jimport('joomla.application.component.controller');

## This Class contains all data for the car manager
class AutoControllerCategory extends JController {

	function __construct() {
		parent::__construct();
		
			## Register Extra tasks
			$this->registerTask( 'add' , 'edit' );
			$this->registerTask('unpublish','publish');
			$this->registerTask('apply','save' );	
	}

	## This function will display if there is no choice.
	function display() {
	
		JRequest::setVar( 'layout', 'default');
		JRequest::setVar( 'view', 'category');
		parent::display();
	}
   
	function edit() {
	
		JRequest::setVar( 'layout', 'form');
		JRequest::setVar( 'view', 'category');		
		JRequest::setVar( 'hidemainmenu', 1 );
		parent::display();

	}

	################################################################
	## This function will save your categories                    ##
	################################################################
	
	function save() {

		$post	            = JRequest::get('post');
		$post['decription'] = JRequest::getVar('decription', '', 'POST', 'string', JREQUEST_ALLOWRAW);

		$model	=& $this->getModel('category');

		if ($model->store($post)) {
			$msg = JText::_( 'Category Saved' );
		} else {
			$msg = JText::_( 'Error Saving...' );
		}

	}

	###############################################################
	## This function will publish or unpublish cats              ##
	###############################################################

	function publish()
	{
		global $mainframe;

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);
		
		## Getting the task (publish/upnpublish)
		if ($this->getTask() == 'publish') {
			$publish = 1;
		} else {
			$publish = 0;
		}		

		if (count( $cid ) < 1) {
			$link = 'index.php?option=com_rdautos&controller=category';
			$this->setRedirect($link, 'Select a vehicle to publish');
		}

		$model = $this->getModel('category');
		if(!$model->publish($cid, $publish)) {
			$link = 'index.php?option=com_rdautos&controller=category';
			$this->setRedirect($link, 'The Model Doesn\'t Exists');
		}
		$link = 'index.php?option=com_rdautos&controller=category';
		$this->setRedirect($link);
	}

###############################################################
## This function will remove cats                            ##
###############################################################

	function remove() {
	
		global $option;
	
		$cid = JRequest::getVar('cid', 0);

		$model = $this->getModel('category');
		if(!$model->remove($cid)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect('index.php?option='.$option, 'Selected car'.$s.' '.$t.' deleted succesfully from the system!');
		
	}

   
}	
?>
