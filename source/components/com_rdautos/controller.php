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

class RDAutosController extends JController {

	function display()
    {
		## Set a default view if none exists
/* PLUGIN HACK : we show the cat 1 by default and force 'categories' view also to the cat 1
		if ( ! JRequest::getCmd( 'view' ) ) {
		   JRequest::setVar('view', 'categories' );
REPLACE */
		if ( ! JRequest::getCmd( 'view' ) || JRequest::getCmd( 'view' ) == 'categories' ) {
		   JRequest::setVar('view', 'category' );
		   JRequest::setVar('id', '1' );
// END PLUGIN HACK
		}
		parent::display();
    }
}
?>