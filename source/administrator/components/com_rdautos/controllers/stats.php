<?php

defined('_JEXEC') or die ('No Acces to this file!');

jimport('joomla.application.component.controller');

## This Class contains all data for the car manager
class AutoControllerStats extends JController {

	function __construct() {
		parent::__construct();

			## Register Extra tasks
/*			$this->registerTask('add' , 'edit' );
			$this->registerTask('unpublish','publish');
			$this->registerTask('apply','save' );	
	*/		
	}

	## This function will display if there is no choice.
	function display() {
	
		JRequest::setVar( 'layout', 'default'  );
		JRequest::setVar( 'view'  , 'stats');
		parent::display();
	}
   
}	
?>
