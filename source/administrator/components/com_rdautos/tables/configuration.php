<?php
defined ('_JEXEC') or die ('Restricted Acces - No Access');


class TableConfiguration extends JTable {

	var $id = null;
	var $currency = null;
	var $showprice = null;
	var $showcolor = null;
	var $showlightbox = null;
	var $showmileage = null;
	var $showdealer = null;
	var $showprintpage = null;
	var $showsend2friend = null;
	var $showdoors = null;
	var $showtransmission = null;
	var $showgears = null;
	var $showenginep = null;
	var $showmotorsize = null;
	var $showdate = null;
	var $showaccessoires = null;
	var $showrservation = null;
	var $showfeatured = null;
	var $showview = null;
	var $lightboxheight = null;
	var $lightboxwidth = null;
	var $thumbnailheight = null;
	var $thumbnailwidth = null;	
	var $showhits = null;
	var $mileage = null;
	var $showfueltype = null;
	var $showweight = null;	
	var $countfeatured = null;
	var $collums = null;
	var $template = null;
	
	function __construct(&$db) {
		parent::__construct( '#__rdautos_config' , 'id' , $db );
	}	
}
?>