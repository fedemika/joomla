<?php
defined ('_JEXEC') or die ('Restricted Acces - No Access');

class TableApplication extends JTable {

	var $carid = null;
	var $catid = null;
	var $makeid = null;
	var $modelid = null;
	var $modeltype = null;
	var $constructed = null;
	var $price = null;
	var $mileage = null;
	var $doors = null;
	var $color = null;
	var $fueltype = null;
	var $gears = null;
	var $transmission = null;
	var $motorsize = null;
	var $enginepower = null;
	var $weight = null;
	var $featured = null;
	var $availeble = null;
	var $condition = null;
	var $added = null;
	var $updated = null;
	var $hits = null;
	var $published = null;
	var $accesoires = null;
	var $optional1 = null;
	var $optional1a = null;
	var $optiona21 = null;
	var $optional2a = null;
	var $optional3 = null;
	var $optional3a = null;
	var $image1 = null;
	var $image2 = null;
	var $image3 = null;
	var $image4 = null;
	var $image5 = null;
	var $image6 = null;
	var $image7 = null;
	var $image8 = null;
	var $image9 = null;
	var $image10 = null;
	var $image11 = null;
	var $image12 = null;
	
	function __construct(&$db) {
		parent::__construct( '#__rdautos_information' , 'carid' , $db );
	}	
}


?>