<?php
######################################################################################
## 																					##
## @Package    	: RD Autos v1.5														##
## @Subpackage 	: Components														##
## @Link 		: http://rd-media.org												##	
## @License		: GNU/GPL v2														##	
## @Author		: Robert Dam														##
## 																					##
## Please leave all copyrights in the scripts. Removal is not prohibit.				##	
## If you like this piece of software, concider a donation to keep it running.		##
##																					##
######################################################################################

## no direct access
defined('_JEXEC') or die('Restricted access');

## Require the base controller
require_once (JPATH_COMPONENT.DS.'controller.php');

## Require specific controller if requested.
if($controller = JRequest::getWord('controller', 'application')) {
	$path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
	if (file_exists($path)) {
		require_once $path;
	} else {
		$controller = '';
	}
}

## Create the controller
$classname	= 'AutoController'.ucfirst($controller);
$controller	= new $classname( );

## Perform the Request task, display will be loaded automatically.
$controller->execute( JRequest::getCmd( 'task' ) );
$controller->redirect();

?>