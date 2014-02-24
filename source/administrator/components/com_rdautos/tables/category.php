<?php
defined ('_JEXEC') or die ('Restricted Acces - No Access');


class TableCategory extends JTable {

	var $catid = null;
	var $catname = null;
	var $alias = null;
	var $decription = null;
	var $published = null;
	
	function __construct(&$db) {
		parent::__construct( '#__rdautos_categories' , 'catid' , $db );
	}	
}
?>