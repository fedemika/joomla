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

class RDAutosControllerSendafriend extends JController {


	function sendafriend() {
	
		global $option, $mainframe;

		## Initialize some variables
		$db			= & JFactory::getDBO();
		$SiteName	= $mainframe->getCfg('sitename');

		$id			= JRequest::getInt( 'id', 0, 'post' );
		$name		= JRequest::getVar( 'name', '', 'post' );
		$email		= JRequest::getVar( 'email', '', 'post' );
		$friendmail	= JRequest::getVar( 'friendemail', '', 'post' );
		$friendname	= JRequest::getVar( 'friendname', '', 'post' );
		$comments	= JRequest::getVar( 'comments',	 '', 'post' );
		$vehicle	= JRequest::getVar( 'vehicle',	 '', 'post' );
	
		if (! preg_match('~^[a-z0-9][a-z0-9_.\-]*@([a-z0-9]+\.)*[a-z0-9][a-z0-9\-]+\.([a-z]{2,6})$~i', $email) ) {
			$msg = JText::_( 'EMAIL NOT CORRECT');	
			$link = JRoute::_('index.php?option=com_rdautos&view=sendafriend&id='.$id);
			$this->setRedirect($link, $msg);
		}
		if (! preg_match('~^[a-z0-9][a-z0-9_.\-]*@([a-z0-9]+\.)*[a-z0-9][a-z0-9\-]+\.([a-z]{2,6})$~i', $friendmail) ) {
			$msg = JText::_( 'FMAIL NOT CORRECT');	
			$link = JRoute::_('index.php?option=com_rdautos&view=sendafriend&id='.$id);
			$this->setRedirect($link, $msg);
		}	
		
		if ( $name == '' && $friendname == '' ) {
			$msg = JText::_( 'One of the required fields is not filled.');	
			$link = JRoute::_('index.php?option=com_rdautos&view=sendafriend&id='.$id);
			$this->setRedirect($link, $msg);
		}
		
		## OK, all fields has been checked now! Let's send it now!
		
			## Opening the email template!
			$fp = fopen('components/com_rdautos/assets/sendafriend.txt','r');
			$message = fread($fp,filesize('components/com_rdautos/assets/sendafriend.txt'));
			fclose($fp);
			
			$link 		= JURI::base()."index.php?option=com_rdautos&view=detail&id=".$id." ";
			$MailFrom 	= $mainframe->getCfg('mailfrom');
			$FromName 	= $mainframe->getCfg('fromname');
			$site 		= JURI::base();

			$message = str_replace('%%NAME%%',$name, $message);
			$message = str_replace('%%FRIENDNAME%%',$friendname, $message);
			$message = str_replace('%%VEHICLE%%',$vehicle, $message);
			$message = str_replace('%%LINK%%',$link, $message);
			$message = str_replace('%%SITE_TITLE%%',$FromName ,$message);
			$message = str_replace('%%SITE_URL%%',$site ,$message);
			$message = str_replace('%%COMMENT%%',$comments ,$message);
		
			$subject	= JText::_( 'SUBJECT');

			$mail = JFactory::getMailer();

			$mail->addRecipient( $email );
			$mail->addRecipient( $friendmail );
			$mail->setSender( array( $email, $name ) );
			$mail->setSubject( $FromName.': '.$subject );
			$mail->setBody( $message );

			$sent = $mail->Send();	
			
			## Mail has been sent!
			$msg = JText::_( 'MAIL SENT');	
			$link = JRoute::_('index.php?option=com_rdautos&view=detail&id='.$id);
			$this->setRedirect($link, $msg);						
	}
}

?>