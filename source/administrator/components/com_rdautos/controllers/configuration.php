<?php

defined('_JEXEC') or die ('No Acces to this file!');

jimport('joomla.application.component.controller');

## This Class contains all data for the car configuration
class AutoControllerConfiguration extends JController {

   function display() {
	  
	 JRequest::setVar( 'layout', 'default'  );
     JRequest::setVar( 'view'  , 'configuration');
	 JRequest::setVar( 'edit', true );
	
	## Let's go to the view part.
     parent::display();
	  	  
   }

	function save() {

		$post	= JRequest::get('post');

		$model	=& $this->getModel('configuration');

		if ($model->store($post)) {
			$msg = JText::_( 'Configuration Saved' );
		} else {
			$msg = JText::_( 'Error Saving Configuration' );
		}

		$link = 'index.php?option=com_rdautos&controller=configuration';
		$this->setRedirect($link, $msg);
	}


}	
?>
