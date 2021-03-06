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

## Require the base controller
require_once( JPATH_COMPONENT.DS.'controller.php' );
##require_once( JPATH_COMPONENT.DS.'helpers'.DS.'phocagallery.php' );

## Require specific controller if requested
if($controller = JRequest::getWord('controller')) {
    $path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
    if (file_exists($path)) {
        require_once $path;
    } else {
        $controller = '';
    }
}

## Create the controller
$classname    = 'RDAutosController'.ucfirst($controller);
$controller   = new $classname( );

## Perform the Request task
$controller->execute( JRequest::getVar( 'task' ) );

## Redirect if set by the controller
$controller->redirect();
?>
