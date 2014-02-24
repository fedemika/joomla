<?php

defined('_JEXEC') or die ('No Acces to this file!');

class UPLOAD_autos{

	function catupload($id, $file, $image, $imgnr) {

		global $mainframe, $option;
		
		$db    = JFactory::getDBO();
		
		## Making the query for the thumbs, we want to know height & width
		## Sizes will be used when using the GD Libs and making thumbs from the original
		$sql = ' SELECT * FROM #__rdautos_config WHERE id = 1';
		$db->setQuery($sql);
		$data = $db->loadObject();

		jimport('joomla.filesystem.file');

		## Make the filename safe and check if image ext is allowed
		$file['name']	= JFile::makeSafe($file['name']);
		$allowed        = array('image/pjpeg','image/gif','image/png','image/jpeg','image/JPG','image/jpg');	
		$imagepath      = JPATH_SITE.DS.'components'.DS.'com_rdautos'.DS.'catimages'.DS;
		$link           = 'index.php?option=' .$option. '&&controller=category&task=edit&cid[]='.$id;
		$maxsize        = 1000000;
		$imagetobig     = 0;
			
		## Check image size, if image is to big? Notice client.
		if ( $file['size'] > $maxsize) {
			JError::raiseWarning(100, ''.$file['name'].' '.JText::_( 'MAX UPLOAD 1 MB PP' ).'');
			$mainframe->redirect($link);
		}
		## Check if the image is in the of the supported extentions
		if (!in_array($file['type'], $allowed)){
			JError::raiseWarning(100, ''.$file['name'].' '.JText::_( 'ONLY JPG GIF PNG' ).'');
			$mainframe->redirect($link);
		}	

		## Ok, now we are ready to upload the file, first check if this one exists?	
		## If the file exists, delete the current image.
		$image_exists  = $imagepath.$image;	
		if (file_exists($image_exists)) {
			unlink($image_exists);
		}
		
		$image_exists  = $imagepath.'cat-'.$image;	
		if (file_exists($image_exists)) {
			unlink($image_exists);
		}
						
		$af_size = GetImageSize ($file['tmp_name'], $af_info);
		
        switch ($af_size[2]) {
                case 1 : {
                    $thispicext = 'gif';
                    break;
                }
                case 2 : {
                    $thispicext = 'jpg';
                    break;
                }
                case 3 : {
                    $thispicext = 'png';
                    break;
                }
        }
		
		## Define the new imagename.
		$newimagename  = $id.".".$thispicext;
		$imagename  = "catid-".$id.".".$thispicext;		

		## Insert this imagename into the database
		$db =& JFactory::getDBO();
		$query = "UPDATE #__rdautos_categories SET image = '$imagename' WHERE catid = '$id' ";
		$db->setQuery($query);
		
		if (!$db->query() ){
			echo "<script>alert('".$row->getError()."');
			window.history.go(-1);</script>\n";		 
		}
		
		chmod ( $file['tmp_name'], 0644);
		## Moving the file now to the destination folder (images), offcourse with the new name.
		if (!JFile::upload($file['tmp_name'], $imagepath.$imagename)) {
			JError::raiseWarning(100, ''.$file['name'].' '.JText::_( 'CHECK PHP SETTINGS').'');
			$mainframe->redirect($link);
		} 


	    ##create thumbnail 
		switch ($af_size[2]) {
	    	case 1 : $src = ImageCreateFromGif( $imagepath.$newimagename); break;
			case 2 : $src = ImageCreateFromJpeg( $imagepath.$newimagename); break;
			case 3 : $src = ImageCreateFromPng( $imagepath.$newimagename); break;				
		}

		$width_before  = ImageSx( $src);
		$height_before = ImageSy( $src);

		if ( $width_before  >= $height_before) {
			$width_new = min($data->catimage, $width_before);
			$scale = $width_before / $height_before;
			$height_new = round( $width_new / $scale);
		}
		else {
			$height_new = min($data->catimage, $height_before);
			$scale = $height_before / $width_before;
			$width_new = round( $height_new / $scale);
		}

		$dst = ImageCreateTrueColor( $width_new, $height_new);

		## GD Lib 2
		ImageCopyResampled( $dst, $src, 0, 0, 0, 0, $width_new, $height_new, $width_before, $height_before);

		switch ($af_size[2]) {
			case 1 : ImageGIF( $dst, $imagepath."catid-".$newimagename); break;
			case 2 : ImageJPEG( $dst, $imagepath."catid-".$newimagename); break;
			case 3 : ImagePNG( $dst, $imagepath."catid-".$newimagename); break;				
		}
		
		## Destroy temporary Files right now
		$image_exists  = $imagepath.$newimagename;	
		if (file_exists($image_exists)) {
			unlink($image_exists);
		}
		
		imagedestroy( $dst);
		imagedestroy( $src);	
	}


	function uploadhandler($id, $file, $image, $imgnr) {

		global $mainframe, $option;
		
		$db    = JFactory::getDBO();
		
		## Making the query for the thumbs, we want to know height & width
		## Sizes will be used when using the GD Libs and making thumbs from the original
		$sql = ' SELECT * FROM #__rdautos_config WHERE id = 1';
		$db->setQuery($sql);
		$data = $db->loadObject();

		jimport('joomla.filesystem.file');

		## Make the filename safe and check if image ext is allowed
		$file['name']	= JFile::makeSafe($file['name']);
		$allowed        = array('image/pjpeg','image/gif','image/png','image/jpeg','image/JPG','image/jpg');	
		$imagepath      = JPATH_SITE.DS.'components'.DS.'com_rdautos'.DS.'images'.DS;
		$link           = 'index.php?option=' .$option. '&task=edit&cid[]='.$id;
		$maxsize        = 1000000;
		$imagetobig     = 0;
		
		## Check image size, if image is to big? Notice client.
		if ( $file['size'] > $maxsize) {
			JError::raiseWarning(100, ''.$file['name'].' '.JText::_( 'MAX UPLOAD 1 MB PP' ).'');
			$mainframe->redirect($link);
		}
		## Check if the image is in the of the supported extentions
		if (!in_array($file['type'], $allowed)){
			JError::raiseWarning(100, ''.$file['name'].' '.JText::_( 'ONLY JPG GIF PNG' ).'');
			$mainframe->redirect($link);
		}	

					
		$af_size = GetImageSize ($file['tmp_name'], $af_info);
		
        switch ($af_size[2]) {
                case 1 : {
                    $thispicext = 'gif';
                    break;
                }
                case 2 : {
                    $thispicext = 'jpg';
                    break;
                }
                case 3 : {
                    $thispicext = 'png';
                    break;
                }
        }
		
		## Define the new imagename.
		$newimagename  = $id."-".$imgnr.".".$thispicext;
		$imagetoinsert = 'image'.$imgnr;		

		## Insert this imagename into the database
		$db =& JFactory::getDBO();
		$query = "UPDATE #__rdautos_information SET $imagetoinsert = '$newimagename' WHERE carid = '$id' ";
		$db->setQuery($query);
		
		if (!$db->query() ){
			echo "<script>alert('".$row->getError()."');
			window.history.go(-1);</script>\n";		 
		}
		
		chmod ( $file['tmp_name'], 0644);
		## Moving the file now to the destination folder (images), offcourse with the new name.
		if (!JFile::upload($file['tmp_name'], $imagepath.$newimagename)) {
			JError::raiseWarning(100, ''.$file['name'].' '.JText::_( 'CHECK PHP SETTINGS' ).'');
			$mainframe->redirect($link);
		} 


	   ## create thumbnail
		switch ($af_size[2]) {
			case 1 : $src = ImageCreateFromGif( $imagepath.$newimagename); break;
			case 2 : $src = ImageCreateFromJpeg( $imagepath.$newimagename); break;
			case 3 : $src = ImageCreateFromPng( $imagepath.$newimagename); break;				
		}

		$width_before  = ImageSx( $src);
		$height_before = ImageSy( $src);

		if ( $width_before  >= $height_before) {
			$width_new = min($data->thumbnailwidth, $width_before);
			$scale = $width_before / $height_before;
			$height_new = round( $width_new / $scale);
		}
		else {
			$height_new = min($data->thumbnailheight, $height_before);
			$scale = $height_before / $width_before;
			$width_new = round( $height_new / $scale);
		}

		$dst = ImageCreateTrueColor( $width_new, $height_new);

		## GD Lib 2
		ImageCopyResampled( $dst, $src, 0, 0, 0, 0, $width_new, $height_new, $width_before, $height_before);

		switch ($af_size[2]) {
			case 1 : ImageGIF( $dst, $imagepath."th".$newimagename); break;
			case 2 : ImageJPEG( $dst, $imagepath."th".$newimagename); break;
			case 3 : ImagePNG( $dst, $imagepath."th".$newimagename); break;				
		}
		
		## Destroy temporary Files right now
		imagedestroy( $dst);
		imagedestroy( $src);	
	}

}
function condition($condition){
	if ($condition == 0) {
	    $condition = JText::_( 'NOT SELECTED');
	}	
    if ($condition == 1) {
	    $condition = JText::_( 'VERY GOOD');
	} 
	if ($condition == 2) {
	    $condition = JText::_( 'AS NEW');
	}
	if ($condition == 3) {
	    $condition = JText::_( 'PRE LOVED');
	}
	if ($condition == 4) {
	    $condition = JText::_( 'DEMONSTRATOR');
	}
	if ($condition == 5) {
	    $condition = JText::_( 'SPARE ENTRY');
	}			
	if ($condition == 6) {
	    $condition = JText::_( 'NEW CAR');
	}			
    return $condition;    
} 

function fueltype($fueltype){

    if ($fueltype == 1) {
	    $fueltype = JText::_( 'LEADED');
	} 
	if ($fueltype == 2) {
	    $fueltype = JText::_( 'GASOLINE');
	}
	if ($fueltype == 3) {
	    $fueltype = JText::_( 'LPGG3');
	}
	if ($fueltype == 4) {
	    $fueltype = JText::_( 'LPG');
	}		
    return $fueltype;    
} 

function transmission($transmission) {

    if ($transmission == 1) {
	    $transmission = JText::_( 'MANUAL');
	} 
	if ($transmission == 2) {
	    $transmission = JText::_( 'AUTOMATIC');
	}
	if ($transmission == 3) {
	    $transmission = JText::_( 'SEMI MANUAL');
	}
	if ($transmission == 4) {
	    $transmission = JText::_( 'AUTOMATIC');
	}	
    return $transmission;    
} 


function availeble($availeble){

    if ($availeble == 0) {
	    $availeble = JText::_( 'NOT SELECTED');
	} 
    if ($availeble == 1) {
	    $availeble = JText::_( 'VEHICLE IS AVAILEBLE');
	} 
	if ($availeble == 2) {
	    $availeble = JText::_( 'VEHICLE NOT AVAILEBLE');
	}
	if ($availeble == 3) {
	    $availeble = JText::_( 'VEHICLE COMING');
	}
	if ($availeble == 4) {
	    $availeble = JText::_( 'OPTION TAKEN');
	}	
    return $availeble;    
} 

?>