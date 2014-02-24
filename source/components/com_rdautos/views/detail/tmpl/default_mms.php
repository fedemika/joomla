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

## Check if the file is included in the Joomla Framework
defined('_JEXEC') or die ('No Acces to this file!');

$app =& JFactory::getApplication();
$pathway =& $app->getPathway();
$pathway->addItem(JText::_( 'CATEGORIES' ), 'index.php?option=com_rdautos&view=categories');
$pathway->addItem(''.$this->items->catname.'', 'index.php?option=com_rdautos&view=category&id='.$this->items->catid);
$pathway->addItem($this->items->makename.' '.$this->items->model.' '.$this->items->modeltype);
// PLUGIN HACK: nombre de la sala en el title, keywords y description del html
$document	=& JFactory::getDocument();
$document->setTitle($this->items->modeltype . " - " . $mainframe->getCfg('sitename'));
$document->setMetaData('keywords',  $this->items->modeltype . ", " . $mainframe->getCfg('MetaKeys'));
$document->setMetaData('description',  $mainframe->getCfg('MetaDesc') . " " . $this->items->modeltype);
// END PLUGIN HACK 
?>
<style type="text/css">


#photos{
	float: left;
	width: 50%;
}

#rd_thumbnail{
	border: 1px solid;
	padding: 2px;
	border-color: #CCCCCC;
}

</style>

<script type="text/javascript" language="javascript" src="media/system/js/mootools.js"></script>
<script type="text/javascript" language="javascript" src="components/com_rdautos/assets/roebox.js"></script>
<?php // PLUGIN HACK: google maps
$filepath = substr(__FILE__, 0, strpos(__FILE__, 'components'));
	if (file_exists($filepath.'googlemaps.php')){
		include($filepath.'googlemaps.php');
	}
// END PLUGIN HACK ?>
<link rel="stylesheet" href="components/com_rdautos/assets/roebox.css" type="text/css" media="screen" />


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2">
        <h2 class="contentheading">
				<?php echo $this->items->modeltype; 

			$user = JFactory::getUser();
      if ($user->usertype == 'Super Administrator' || ($user->id && $user->id == $this->items->userid)){ ?>
				(<a href="publicar/?id=<?php echo $this->items->carid; ?>"><strong>Editar</strong></a>)
<?php } ?>
				</h2>
<?php // END PLUGIN HACK  ?>
    </td>
  </tr>
  <tr>
    <td align="left" valign="top">
      <div class="container_info">
			<?php if ($this->items->weight && $this->config->showweight != 0){ ?>
      <div class="info_name">
        <?php echo JText::_( 'VEHICLE WEIGHT' ); ?>
      </div>
      <div class="info_value">
        <?php echo $this->items->weight; ?>
      </div>
			 <?php } ?>
			<?php if ($this->items->enginepower && $this->config->showenginep != 0){ ?>
      <div class="info_name">
        <?php echo JText::_( 'HORSE POWERS' ); ?>
      </div>
      <div class="info_value">
        <?php echo $this->items->enginepower; ?> MCB
      </div>
			 <?php } ?>
      <?php if ($this->items->color && $this->config->showcolor != 0) { ?>
      <div class="info_name">
        <?php echo JText::_( 'VEHICLE COLOR' ); ?>
      </div>
      <div class="info_value">
        <?php echo $this->items->color . " " .$this->items->motorsize; ?>
      </div>
      <?php } ?>
      <?php if ($this->items->mileage > 0) { ?>
      <div class="info_name">
        <?php echo JText::_( 'MILEAGE' ); ?>
      </div>
      <div class="info_value">
        <?php echo $this->items->mileage; ?> <?php echo $this->config->mileage; ?>
      </div>
      <?php } ?>
      <?php if ($this->items->transmission) { 
		?>
      <div class="info_name">
        <?php echo JText::_( 'TRANSMISSION' ); ?>
      </div>
      <div class="info_value">
        <?php echo $this->items->transmission; ?>
      </div>
      <?php } ?>
    </div>
		<div class="container_separator">&nbsp;</div>
		<div class="container_image">
			 <img src="components/com_rdautos/images/<?php echo $this->items->image1; ?>">
 		</div>

   </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
    <div align="right">
		  <?php if ($this->config->showdate != 0) { ?>
		  <?php echo JText::_( 'LAST UPDATE' ); ?> <?php echo date ("d-m-Y", strtotime($this->items->updated)); ?><br>
          <?php } ?>
           <?php if ($this->config->showsend2friend != 0) { ?>
        	<a href="index.php?option=com_rdautos&view=sendafriend&id=<?php echo $this->items->carid; ?>">
    		Send Vehicle to friend</a>
            <?php } ?> <br />       
    </div>
    </td>
  </tr>
</table>


<?php
###########################################################################
## Stripping introtext in maxview ## Maximum 150 chars                   ##
## If you want to change this, go ahead. you need to change all numbers! ##
## Settings for example wide templates could be between 185 and 200      ##
###########################################################################

function introtext($text) {

	if (strlen($text) > 150) {
		$pos = strpos($text, ' ', "150");
		if ((!$pos) || ($pos > 150)) {
		$pos = 150;
		}
	    $text = substr($text, 0, $pos + 1) . "....";
	    return $text;
		
	}else{
		return $text;
	}

}
function transmission($transmission)
{
    if ($transmission == 1) {
	    $transmission = "".JText::_( 'MANUAL' )."";
	} 
	if ($transmission == 2) {
	    $transmission = "".JText::_( 'AUTOMATIC' )."";
	}
	if ($transmission == 3) {
	    $transmission = "".JText::_( 'TIP TRONIC' )."";
	}
    return $transmission;    
}
 
function fueltype($fuel)
{
    if ($fuel == 1) {
	    $fuel = "".JText::_( 'LEADED' )."";
	} 
	if ($fuel == 2) {
	    $fuel = "".JText::_( 'GASOLINE' )."";
	}
	if ($fuel == 3) {
	    $fuel = "".JText::_( 'LPGG3' )."";
	}
	if ($fuel == 4) {
	    $fuel = "".JText::_( 'LPG' )."";
	}	
    return $fuel;    
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

function availeble($availeble)
{
    if ($availeble == 1) {
	    $availeble = "".JText::_( 'VEHICLE AVAILEBLE' )."";
	} 
	if ($availeble == 2) {
	    $availeble = "".JText::_( 'VEHICLE NOT AVAILEBLE' )."";
	}
	if ($availeble == 3) {
	    $availeble = "".JText::_( 'VEHICLE COMING' )."";
	}
    return $availeble;    
} 

?>
