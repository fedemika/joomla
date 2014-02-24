<?php 
##########################################################################
## @package Joomla 1.5
## @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
## @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
##
## @component RD-Autos - Version 1.5.5
## @copyright Copyright (C) Robert Dam - http://www.rd-media.org
## @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
## Please do NOT remove this licence statement
###########################################################################

## Check if the file is included in the Joomla Framework
defined('_JEXEC') or die ('No Acces to this file!');

## Adding the pathway to the application.
$app =& JFactory::getApplication();
$pathway =& $app->getPathway();
$pathway->addItem(JText::_( 'CATEGORIES' ), 'index.php?option=com_rdautos&view=categories');
$pathway->addItem($this->cat->catname);


$id 		= JRequest::getInt('id', 1); 
$limitstart = JRequest::getInt('limitstart', 0);

?>
<style type="text/css">

#rda-container{
	height: 100%;
	width:	100%;
	margin:	2;
}

#rda-featured{
	width: 99%;
	float: left;
	background-color: #FFFFCC;
	border-bottom: 1px solid #DDDDDD;
	border-right: 1px solid #DDDDDD;
	border-left: 1px solid #DDDDDD;
	border-top: 1px solid #DDDDDD;
	padding-left: 4px;	
	padding-top: 4px;
	padding-bottom:2px;
	margin-bottom: 2px;
}

#rda-normal{
	width: 99%;
	float: left;
	background-color: #FFFFFF;
	border-bottom: 1px solid #DDDDDD;
	border-right: 1px solid #DDDDDD;
	border-left: 1px solid #DDDDDD;
	border-top: 1px solid #DDDDDD;
	padding-left: 4px;	
	padding-top: 4px;
	padding-bottom:2px;
	margin-bottom: 2px;
}

#rda-ordering{
	width: 99%;
	height: 19px;
	float: left;
	background-color: #FFFFFF;
	padding-left: 4px;	
	padding-top: 4px;
	padding-bottom:5px;
	margin-bottom: 2px;
	text-align: right;
}

</style>

<?php /* PLUGIN HACK ?>
<h1 class="contentheading"><?php echo JText::_( 'CATEGORYNAME' ); ?> <?php echo $this->cat->catname; ?></h1>
<?php echo JText::_( 'SUBCATINTRO' ); ?><br />
<?php END PLUGIN HACK */?>

<?php /* PLUGIN HACK ?>
    <div id = "rda-ordering">
    
    <form method="GET" name="ordering" action="index.php">
    <input name="option" type="hidden" value="com_rdautos" />
    <input name="view" type="hidden" value="category" />
    <?php echo $this->lists[ordering]; ?>
    <input name="id" type="hidden" value="<?php echo $id; ?>" />
    <input name="limitstart" type="hidden" value="<?php echo $limitstart; ?>" /> 
    <input type="submit" class="button" value="GO!" /> 
    
    </div>
<?php END PLUGIN HACK */?>

<?php
//PLUGIN HACK
$user = JFactory::getUser();
//END PLUGIN HACK

## Counting the cars that will be featured. If count == 0, don't show!
$n = count($this->featured);

if ($n != 0) {

 
$k = 0;
for ($i = 0, $n = count($this->featured); $i < $n; $i++ ){
$row    = &$this->featured[$i];
$link   = 'index.php?option=com_rdautos&view=detail&id='.$row->carid;
?>
<?php /* PLUGIN HACK ?>
<div id = "rda-featured">
    <table width="100%">
      <tr>
      <td width="100" align="center" valign="top">
      <a href="<?php echo $link; ?>">
      <img src="components/com_rdautos/images/th<?php echo $row->image1; ?>" width="<?php echo $this->config->catimage; ?>" /></a></td>
      <td width="646" align="left" valign="top"><div align="left"><a href="<?php echo $link; ?>"><strong><?php echo $row->makename; ?>
       	<?php echo $row->model; ?> <?php echo $row->modeltype; ?></strong></a>
      <br />
      <?php echo introtext($row->accesoires) ; ?> </div></td>
      <td width="226" align="center" valign="middle">
      <div align="center">
      	<?php echo condition($row->condition); ?><br>
            <?php echo $row->mileage; ?> <?php echo $this->config->mileage; ?><br>
        	<strong>
			<?php if ($row->price== 0){
					echo JText::_( 'POR' );
			  }else{				
		 			echo $this->config->currency; ?> <?php echo number_format($row->price, 2, ',', ' '); 
			   } ?></strong>          
        </div></td>
      </tr>
    </table>
  </div>
<?php REPLACE */ 
			$width  	= $this->config->thumbnailwidth;
			$height 	= $this->config->thumbnailheight;
			if (substr($row->image1,0,4) == 'http'){
				$src = $row->image1;
			}else{
				$src = "components/com_rdautos/images/th".$row->image1;
			}
?>
	<div id = "rda-featured">
    <table width="100%">
      <tr>
      <td width="100" align="center" valign="top">
      <a href="<?php echo $link; ?>">
      <img src="<?php echo $src; ?>" width="<?php echo $this->config->catimage; ?>" /></a></td>
      <td width="646" align="left" valign="top"><div align="left"><a href="<?php echo $link; ?>"><strong><?php echo $row->modeltype; ?></strong></a>
      <br />
      <?php echo introtext($row->accesoires) ; ?> </div></td>
      <td width="226" align="center" valign="middle">
      <div align="center">
				<?php echo $row->model; ?>, <?php echo $row->makename; ?> <br>
            <?php echo $row->mileage; ?> <?php echo $this->config->mileage; ?><br>
        	<strong>
			<?php if ($this->config->showprice && $row->price > 0){
		 			echo $this->config->currency; ?> <?php echo number_format($row->price, 2, ',', ' '); 
			   } ?></strong>          
<?php if ($user->usertype == 'Super Administrator'){ ?>
				<a href="administrator/index.php?option=com_rdautos&task=edit&cid[]=<?php echo $row->carid; ?>"><strong>Editar</strong></a>
<?php } ?>
        </div></td>
      </tr>
    </table>
  </div>
<?php // END PLUGIN HACK  ?>

<?php
  $k=1 - $k;
  }
?>

<?php

}

$k = 0;
for ($i = 0, $n = count($this->items); $i < $n; $i++ ){
$row    = &$this->items[$i];
$link   = 'index.php?option=com_rdautos&view=detail&id='.$row->carid;
?>

<?php /* PLUGIN HACK ?>
	<div id = "rda-normal">
    <table width="100%">
      <tr>
      <td width="100" align="center" valign="top">
      <a href="<?php echo $link; ?>">
      <img src="components/com_rdautos/images/th<?php echo $row->image1; ?>" width="<?php echo $this->config->catimage; ?>" /></a></td>
      <td width="650" align="left" valign="top"><div align="left"><a href="<?php echo $link; ?>"><strong><?php echo $row->makename; ?>
       	<?php echo $row->model; ?> <?php echo $row->modeltype; ?></strong></a>
      <br />
      <?php echo introtext($row->accesoires) ; ?> </div></td>
      <td width="222" align="center" valign="middle">
      <div align="center">
      <?php echo condition($row->condition); ?><br>
        	<strong>
			<?php if ($row->price== 0){
					echo JText::_( 'POR' );
			  }else{				
		 			echo $this->config->currency; ?> <?php echo number_format($row->price, 2, ',', ' '); 
			   } ?></strong>            
        </div>
        </td>
      </tr>

    </table>
  </div>
<?php REPLACE */ ?>
	<div id = "rda-normal">
    <table width="100%">
      <tr>
		<?php 
      		$colspan = "colspan='2'";
      		$width = "width='76%'";
      		if ($row->image1) { 
      		$width = "width='60%'";
      		$colspan = "";

					// file or url
					if (substr($row->image1,0,4) == 'http'){
						$src = split('\?',$row->image1);
						$src = $src[0];
					}else{
						$src = "components/com_rdautos/images/th".$row->image1;
					}
      			?>
	      <td width="10%" align="center" valign="top">
		      <a href="<?php echo $link; ?>">
			      <img src="<?php echo $src; ?>" width="<?php echo $this->config->thumbnailwidth; ?>" height="<?php echo $this->config->thumbnailheight; ?>" /></a>
      </td>
  <?php } ?>
      <td <?php echo $width; ?> align="left" valign="top" <?php echo $colspan; ?> >
      	<div align="left" class="sala_excerpt">
      <?php if ($row->accesoires || $row->condition || $row->fueltype || $row->gears || $row->doors || ($row->color && $row->motorsize) || $row->mileage  || $row->image1 || $row->transmission) { ?>
      	<a href="<?php echo $link; ?>">
      <?php } ?>
      		<strong><?php echo $row->modeltype; ?></strong>
      <?php if ($row->accesoires || $row->condition || $row->fueltype || $row->gears || $row->doors || ($row->color && $row->motorsize) || $row->mileage  || $row->image1 || $row->transmission) { ?>
      	</a>
      <?php } ?>
      <br />
      <?php echo introtext($row->accesoires) ; ?> 
      </div></td>
      <td width="25%" align="center" valign="middle">
      <div align="center">
			<?php if ($row->weight){
							echo $row->weight; ?><br>
			 <?php } ?>
				<?php echo $row->model?$row->model.', ':''; ?><?php echo $row->makename; ?> <br>
        	<strong>
			<?php if ($this->config->showprice && $row->price > 0){
		 			echo $this->config->currency; ?> <?php echo number_format($row->price, 2, ',', ' '); 
			   } ?></strong>
<?php if ($user->usertype == 'Super Administrator'){ ?>
				<a href="administrator/index.php?option=com_rdautos&task=edit&cid[]=<?php echo $row->carid; ?>"><strong>Editar</strong></a>
<?php } ?>
        </div>
        </td>
      </tr>
    </table>
  </div>
<?php // END PLUGIN HACK  ?>

<?php
  $k=1 - $k;
  }
?>


            <div align="center"><?php echo $this->pagination->getPagesLinks( ); ?></div>


<?php
###########################################################################
## Stripping introtext in maxview ## Maximum 150 chars                   ##
## If you want to change this, go ahead. you need to change all numbers! ##
## Settings for example wide templates could be between 185 and 200      ##
###########################################################################

function introtext($text) {

	$text = strip_tags($text, '<li><ul><ol><b><i><u>');
	if (strlen($text) > 150) {
		$pos = strpos($text, ' ', "150");
		if ((!$pos) || ($pos > 150)) {
		$pos = 150;
		}
	    $text = substr($text, 0, $pos + 1) . "....";
	    return close_dangling_tags($text);		
	}else{
		return $text;
	}

}

function close_dangling_tags($html){
  #put all opened tags into an array
  preg_match_all("#<([a-z]+)( .*)?(?!/)>#iU",$html,$result);
  $openedtags=$result[1];

  #put all closed tags into an array
  preg_match_all("#</([a-z]+)>#iU",$html,$result);
  $closedtags=$result[1];
  $len_opened = count($openedtags);
  # all tags are closed
  if(count($closedtags) == $len_opened){
    return $html;
  }

  $openedtags = array_reverse($openedtags);
  # close tags
  for($i=0;$i < $len_opened;$i++) {
    if (!in_array($openedtags[$i],$closedtags)){
      $html .= '</'.$openedtags[$i].'>';
    } else {
      unset($closedtags[array_search($openedtags[$i],$closedtags)]);
    }
  }
  return $html;
}

function condition($condition)
{
    if ($condition == 1) {
	    $condition = "".JText::_( 'VERY GOOD' )."";
	} 
	if ($condition == 2) {
	    $condition = "".JText::_( 'LIKE NEW' )."";
	}
	if ($condition == 3) {
	    $condition = "".JText::_( 'PRE LOVED' )."";
	}
	if ($condition == 4) {
	    $condition = "".JText::_( 'SPARE ENTRY' )."";
	}
	if ($condition == 5) {
	    $condition = "".JText::_( 'NEW VEHICLE' )."";
	}
	if ($condition == 6) {
	    $condition = "".JText::_( 'DEMONSTRATOR' )."";
	}			
    return $condition;    
}
?>
