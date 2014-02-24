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

jimport('joomla.application.component.controller');

class RDAutosControllerSearch extends JController {


	################################################################
	## This function will load the models when a make is choosen. ##
	################################################################
	
	function getModels(){
	
		global $mainframe;
		
		$db     = JFactory::getDBO();
	
		$makeid = JRequest::getVar('makeid', 0);
		
/* PLUGIN HACK
		$sql    = 'SELECT * FROM #__rdautos_models WHERE makeid = '.$makeid.'  ORDER BY model';
REPLACE */
		$sql    = 'SELECT * FROM #__rdautos_models WHERE makeid = '.$makeid.' and model <> \'\' ORDER BY model';
//	END PLUGIN HACK
		$db->setQuery($sql);
		$rows = $db->loadObjectList();
		
/* PLUGIN HACK
		echo "obj.options[obj.options.length] = new Option('Please Select','0');\n";
REPLACE */
		if (count( $rows ) > 0 || $makeid == 0){
			echo "obj.options[obj.options.length] = new Option('Indistinto','0');\n";
		}else{
			echo "obj.options[obj.options.length] = new Option('Proximamente...','0');\n";
		}
// END PLUGIN HACK

		
		for ($i=0, $n=count( $rows ); $i < $n; $i++){
		   $row =& $rows[$i];
		   echo "obj.options[obj.options.length] = new Option('".$row->model."','".$row->modelid."');\n";
		}	
	}

}

?>