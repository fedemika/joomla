<?php

##########################################################################
## @package Joomla 1.5
## @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
## @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
##
## @component RD-Autos - Version 1.5.3a
## @copyright Copyright (C) Robert Dam - http://www.rd-media.org
## @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
## Please do NOT remove this licence statement
###########################################################################

## no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class RDAutosViewDetail extends JView {

	function display() {

		global $mainframe, $option;
		
		## Model is defined in the controller
		$model	=& $this->getModel('detail');
		
		## Getting the items into a variable
		$items	=& $this->get('list');
		$config	=& $this->get('data');
		
		if ($items->modeltype){			
			## Update the hitcounter, increase the number with 1..
			$id   	= JRequest::getVar('id', 0);
			$db 	=& JFactory::getDBO();
			$query 	= "UPDATE #__rdautos_information SET hits = hits+1 WHERE carid = '$id' ";
			$db->setQuery($query);
			
			if (!$db->query() ){
				echo "<script>alert('Error in view/detail/view.html.php -39- Please report this error to the webmaster.');
				window.history.go(-1);</script>\n";		 
			}
	
			## Getting the pathway
			$db 	  =& JFactory::getDBO();
			$query 	  = "SELECT catname FROM #__rdautos_categories WHERE catid = ' ".$this->items->catid." ' ";
			$category = $db->setQuery($query);
		
			$this->assignRef('category', $category);
			$this->assignRef('items', $items);
			$this->assignRef('config', $config);
			parent::display($config->template ? $config->template:$tpl );			
		}else{
				$mainframe->redirect('/');
		}
	}

}
?>
