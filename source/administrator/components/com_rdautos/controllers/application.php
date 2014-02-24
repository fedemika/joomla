<?php

defined('_JEXEC') or die ('No Access to this file!');

jimport('joomla.application.component.controller');

## This Class contains all data for the car manager
class AutoControllerApplication extends JController {

	function __construct() {
		parent::__construct();

			## Register Extra tasks
			$this->registerTask( 'add' , 'edit' );
			$this->registerTask('unpublish','publish');
			$this->registerTask('apply','save' );		

	}

	## This function will display if there is no choice.
	function display() {
	
		JRequest::setVar( 'layout', 'default'  );
		JRequest::setVar( 'view'  , 'application');
		parent::display();
	}
   
	function edit() {
	
		JRequest::setVar( 'view', 'application' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar( 'hidemainmenu', 1 );
		parent::display();

	}

	###############################################################
	## This function will remove cars                            ##
	###############################################################

	function remove() {
	
		global $option;
	
		$cid = JRequest::getVar('cid', 0);

		$model = $this->getModel('application');
		if(!$model->remove($cid)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect('index.php?option='.$option, JText::_( 'SELECTED CAR DELETED' ));
		
	}

	###############################################################
	## This function will publish or unpublish cars              ##
	###############################################################

	function publish()
	{
		global $mainframe;

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);
		
		## Getting the task (publish/upnpublish)
		if ($this->getTask() == 'publish') {
			$publish = 1;
		} else {
			$publish = 0;
		}		

		if (count( $cid ) < 1) {
			$link = 'index.php?option=com_rdautos';
			$this->setRedirect($link, JText::_( 'SELECT TO PUBLISH' ));
		}

		$model = $this->getModel('application');
		if(!$model->publish($cid, $publish)) {
			$link = 'index.php?option=com_rdautos';
			$this->setRedirect($link, JText::_( 'MODEL DOESNT EXISTS' ));
		}
		$link = 'index.php?option=com_rdautos';
		$this->setRedirect($link);
	}
	
	################################################################
	## This function will load the models when a make is choosen. ##
	################################################################
	
	function getModels(){
	
		global $mainframe;
		
		$db     = JFactory::getDBO();
	
		$makeid = JRequest::getVar('makeid', 0);
		
		$sql    = 'SELECT * FROM #__rdautos_models WHERE makeid = '.$makeid.'  ORDER BY model';
		$db->setQuery($sql);
		$rows = $db->loadObjectList();

		for ($i=0, $n=count( $rows ); $i < $n; $i++){
		   $row =& $rows[$i];
		   echo "obj.options[obj.options.length] = new Option('".$row->model."','".$row->modelid."');\n";
		}	
	}

	################################################################
	## This function will save your cars                          ##
	################################################################
	
	function save() {
		
		## Generate the link when the model or the make is not filled.
		$link = 'index.php?option=com_rdautos';
		
		## Getting the post variables
		$post	            = JRequest::get('post');
		$post['accesoires'] = JRequest::getVar('accesoires', '', 'POST', 'string', JREQUEST_ALLOWRAW);
// PLUGIN HACK: trim nombre y telefono
		$post['modeltype'] = trim($post['modeltype']);
		$post['weight'] = trim($post['weight']);
// END PLUGIN HACK: trim nombre y telefono

		## Check if they have choosen a make, if not raise an error
		if ($post['makeid'] == 0 && $post['makeid'] == 0){
			global $mainframe;
			JError::raiseWarning(100, JText::_( 'CHOOSE A MODEL AND MAKE' ));
			$mainframe->redirect($link);		
		}
		
		## Check if they have choosen a model, if not raise an error
		if ($post['modelid'] == 0) {
			global $mainframe;
			JError::raiseWarning(100, JText::_( 'CHOOSE A MODEL' ));
			$mainframe->redirect($link);
		}
		
		## Check if they have choosen a make, if not raise an error
		if ($post['makeid'] == 0){
			global $mainframe;
			JError::raiseWarning(100, JText::_( 'CHOOSE A MAKE' ));
			$mainframe->redirect($link);		
		}
		
		## Check if they have choosen a make, if not raise an error
		if ($post['catid'] == 0){
			global $mainframe;
			JError::raiseWarning(100, JText::_( 'CHOOSE A CATEGORY' ));
			$mainframe->redirect($link);		
		}		
		
		## OK, it went fine! Add the vehicle now...
		$model	=& $this->getModel('application');

		if ($model->store($post)) {
			$msg = JText::_( 'VEHICLE SAVED' );
		} else {
			$msg = JText::_( 'VEHICLE NOT SAVED' );
		}

	}
	
	################################################################
	## This function will delete the images                       ##
	################################################################
	function delete(){
	
		global $mainframe, $option;
		
		## Getting the image number & the vehicle id
		$image = JRequest::getVar( 'image', 0 );
		$cid   = JRequest::getVar( 'cid', 0 );
		
		## First we want to know which imagenumber we want to update.
		$img     = str_replace('.jpg', '', $image);
		
		$id = split('-', $img);
		$id = $id[count($id)-1];
/*
		if (strlen($img) > 4) {
		
			$id      = substr($img, -2);		
		
		}else{
		
			$id      = substr($img, -1);
		
		}							
*/
		 
		$imagenr = "image".$id;
		$empty   = "";
				
		## The path to the imagefile
		$path  = JPATH_SITE.DS.'components'.DS.'com_rdautos'.DS.'images'.DS;
		
		## Making an array of files..
		$files = array( $path.$image, $path.'th'.$image); 
	
		## Impporting the file system, to check if we need FTP or not?
		jimport( 'joomla.filesystem.file' );
	
		if ((substr($image,0,4) == 'http') || JFile::delete( $files )) {
			
			$db 	=& JFactory::getDBO();
			$query 	= "UPDATE #__rdautos_information SET $imagenr = '$empty' WHERE carid = '$cid' ";
			$db->setQuery($query);
			
			if (!$db->query() ){
				echo "<script>alert('Error in controllers/application.php -162- Please report this error to the webmaster.');
				window.history.go(-1);</script>\n";		 
			}			
			
			$msg = 'Images has been deleted.';
			$link = 'index.php?option=com_rdautos&task=edit&cid='.$cid;
			$mainframe->redirect($link, $msg);
		
		} else {

			$db 	=& JFactory::getDBO();
			$query 	= "UPDATE #__rdautos_information SET $imagenr = '$empty' WHERE carid = '$cid' ";
			$db->setQuery($query);
			
			if (!$db->query() ){
				echo "<script>alert('Error in controllers/application.php -177- Please report this error to the webmaster.');
				window.history.go(-1);</script>\n";		 
			}
			
			$link = 'index.php?option=com_rdautos&task=edit&cid='.$cid;
			$msg =  'Image has been deleted from the database, but could not delete image. Call your webmaster please!';
			$mainframe->redirect($link, $msg);	
		
		}
			
	}

}	
?>
