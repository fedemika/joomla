<?php

## No Direct Access - Kill this Script!
defined( '_JEXEC' ) or die( 'Restricted access' );

global $mainframe, $option;
## Make sure the user is authorized to view this page
$user = & JFactory::getUser();
if ($user->gid < 24) {
	$mainframe->redirect( 'index.php?option=com_rdautos', 'The configuration page is for Administrators only.' );
}

jimport( 'joomla.application.component.view');

class AutoViewConfiguration extends JView {

function display($tpl = null) {

	global $mainframe, $option;
	
	## Model is defined in the controller
	$model	=& $this->getModel();

	$config	=& $this->get('data');

	$lists = array();
	
	$lists['price']          = JHTML::_('select.booleanlist', 'showprice', 'class="inputbox"', $config->showprice);
	$lists['color']          = JHTML::_('select.booleanlist', 'showcolor', 'class="inputbox"', $config->showcolor);
	$lists['lightbox']       = JHTML::_('select.booleanlist', 'showlightbox', 'class="inputbox"', $config->showlightbox);
	$lists['showmileage']    = JHTML::_('select.booleanlist', 'showmileage', 'class="inputbox"', $config->showmileage);
	$lists['showdealer']     = JHTML::_('select.booleanlist', 'showdealer', 'class="inputbox"', $config->showdealer);
	$lists['send2friend']    = JHTML::_('select.booleanlist', 'showsend2friend', 'class="inputbox"', $config->showsend2friend);
	$lists['showdoors']      = JHTML::_('select.booleanlist', 'showdoors', 'class="inputbox"', $config->showdoors);
	$lists['showtrans']      = JHTML::_('select.booleanlist', 'showtransmission', 'class="inputbox"', $config->showtransmission);
	$lists['showgears']      = JHTML::_('select.booleanlist', 'showgears', 'class="inputbox"', $config->showgears);
	$lists['enginep']        = JHTML::_('select.booleanlist', 'showenginep', 'class="inputbox"', $config->showenginep);
	$lists['motorsize']      = JHTML::_('select.booleanlist', 'showmotorsize', 'class="inputbox"', $config->showmotorsize);
	$lists['showdate']       = JHTML::_('select.booleanlist', 'showdate', 'class="inputbox"', $config->showdate);
	$lists['showaccessoires']= JHTML::_('select.booleanlist', 'showaccessoires', 'class="inputbox"', $config->showaccessoires);
	$lists['showhits']       = JHTML::_('select.booleanlist', 'showhits', 'class="inputbox"', $config->showhits);
	$lists['mileage']        = JHTML::_('select.booleanlist', 'mileage', 'class="inputbox"', $config->mileage);
	$lists['showdate']       = JHTML::_('select.booleanlist', 'showdate', 'class="inputbox"', $config->showdate);
	$lists['showfueltype']   = JHTML::_('select.booleanlist', 'showfueltype', 'class="inputbox"', $config->showfueltype);
	$lists['showweight']     = JHTML::_('select.booleanlist', 'showweight', 'class="inputbox"', $config->showweight);
	
	$this->assignRef('config', $config);
	$this->assignRef('lists', $lists);
	parent::display($tpl);
}
    
}
?>
