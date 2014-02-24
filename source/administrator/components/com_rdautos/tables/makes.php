<?php
defined ('_JEXEC') or die ('Restricted Acces - No Access');


class TableMakes extends JTable {

	var $makeid = null;
	var $makename = null;
	var $published = null;
	
	function __construct(&$db) {
		parent::__construct( '#__rdautos_makes' , 'makeid' , $db );
	}	
}
?>