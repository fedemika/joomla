<?php
defined ('_JEXEC') or die ('Restricted Acces - No Access');


class TableModels extends JTable {

	var $modelid = null;
	var $makeid = null;
	var $model = null;

	
	function __construct(&$db) {
		parent::__construct( '#__rdautos_models' , 'modelid' , $db );
	}	
}
?>