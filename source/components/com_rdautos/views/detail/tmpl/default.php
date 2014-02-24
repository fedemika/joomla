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
<?php /* PLUGIN HACK ?>
        <?php echo JText::_( 'DETAILS FOR' ); ?> 
		<?php echo $this->items->makename; ?> <?php echo $this->items->model; ?> <?php echo $this->items->modeltype; ?></h2>
<?php REPLACE */ ?>
				<?php echo $this->items->modeltype; 
					if ($this->items->image1  != ''){	
				?> 
					(<font size=2><a href="<?php echo $_SERVER['REQUEST_URI']?>#fotos"><?php echo JText::_( 'FOTOS' ); ?></a></font>)
				<?php }
				?> 
<?php $user = JFactory::getUser();
      if ($user->usertype == 'Super Administrator' || ($user->id && $user->id == $this->items->userid)){ ?>
				(<a href="publicar/?id=<?php echo $this->items->carid; ?>"><strong>Editar</strong></a>)
<?php } ?>
				</h2>
<?php // END PLUGIN HACK  ?>
    </td>
  </tr>
  <tr>
    <td align="left" valign="top">
      <div class="pre_gmap">
    	<table width="100%" border="0" cellspacing="1" cellpadding="1">
      <tr>
        <td width="6%"  valign="top"><?php echo JText::_( 'MAKE AND MODEL' ); ?></td>
        <td width="1%"  valign="top"><div align="center">:</div></td>
        <td width="62%" valign="top"><?php echo $this->items->makename; ?>
        	<?php 
        		echo $this->items->model?', ':'';
						$model = split('/', $this->items->model);
						if (count($model)>1){
							$model = $model[count($model)-1];
						}else{
							$model = $model[0];
						}
						echo $model;
        	?>
        </td>
      </tr>
      <?php if ($this->items->color && $this->config->showcolor != 0) { ?>
      <tr>
        <td valign="top"><?php echo JText::_( 'VEHICLE COLOR' ); ?></td>
        <td valign="top"><div align="center">:</div></td>
        <td valign="top"><?php echo $this->items->color . " " .$this->items->motorsize; ?></td>
      </tr>
      <?php } ?>
			<?php if ($this->items->weight){ ?>
      <tr>
        <td valign="top"><?php echo JText::_( 'TELEFONO' ); ?></td>
        <td valign="top"><div align="center">:</div></td>
        <td valign="top"><?php echo $this->items->weight;; ?></td>
      </tr>
			 <?php } ?>
      <?php if ($this->items->price > 0 && $this->config->showprice != 0) { ?>
      <tr>
        <td valign="top" width="6%"><?php echo JText::_( 'VEHICLE PRICE' ); ?></td>
        <td valign="top" width="1%"><div align="center">:</div></td>
        <td valign="top" width="62%"><?php 
				echo $this->config->currency; ?>
            <?php echo number_format($this->items->price, 2, ',', ' '); ?> </td>
      </tr>
      <?php } ?>
      <?php if ($this->items->mileage > 0) { ?>
      <tr>
        <td valign="top"><?php echo JText::_( 'MILEAGE' ); ?></td>
        <td valign="top"><div align="center">:</div></td>
        <td valign="top"><?php echo $this->items->mileage; ?> <?php echo $this->config->mileage; ?></td>
      </tr>
      <?php } ?>
      <?php if ($this->items->transmission) { 
      				if (strpos($this->items->transmission, 'http') === 0 ){
								$url = $this->items->transmission;
							}else{
								$url = 'http://'.$this->items->transmission;
							}
			?>
      <tr>
        <td valign="top"><?php echo JText::_( 'URL' ); ?></td>
        <td valign="top"><div align="center">:</div></td>
        <td valign="top"><a target="_blank" href="<?php echo $url; ?>"><strong>
        <a target="_blank" href="<?php echo $url; ?>"><strong>
      	<?php  // don't show the http://
      			echo (strpos($this->items->transmission, '://')>0? substr($this->items->transmission, strpos($this->items->transmission, '://')+3):$this->items->transmission); ?>
      	</strong></a>
      </tr>
      <?php } ?>
      <tr>
        <td colspan="3">
      <?php if ($this->items->condition || $this->items->fueltype || $this->items->gears || $this->items->doors) { ?>
						<h4 class="salas_titulos"><?php echo JText::_( 'FACILIDADES' ); ?>:</h4>
						<ul class="salas_detalles"> 
	      <?php if ($this->items->condition) { ?>
						<li>
		        	<?php echo JText::_( 'CONDITION' ); ?>
						</li>
				<?php } ?>
	      <?php if ($this->items->fueltype) { ?>
						<li>
		        	<?php echo JText::_( 'FUEL TYPE' ); ?>
						</li>
				<?php } ?>
	      <?php if ($this->items->doors) { ?>
						<li>
		        	<?php echo JText::_( 'DOORS' ); ?>
						</li>
				<?php } ?>
	      <?php if ($this->items->gears) { ?>
						<li>
		        	<?php echo JText::_( 'GEARS' ); ?>
						</li>
				<?php } ?>
					</ul>
			<?php } ?>
	    </td>
	   </tr>
	  </table>
    </div>
      <?php if ($this->items->color && $this->config->showcolor != 0 && $this->items->motorsize ) { 
							if ($this->items->makename == "Capital Federal"){
								$address = $this->items->color . " " . $this->items->motorsize . " " . $this->items->makename . ' argentina';      	
							}else{
								$model = split('/', $this->items->model);
								if (count($model)>1){
									$model = '';
								}else{
									$model = $this->items->model;
								}
//								$model = $model[count($model)-1];
								$address = $this->items->color . " " . $this->items->motorsize . " " . $model . ", " . $this->items->makename . ', argentina';      	
							}
							$address = str_replace("(GBA)", "", $address);
			?>
					    <div id="gmap" class="gmap" style="width:250px;height:250px; overflow:hidden;">
				  	  	<input type="hidden" id="gmap_address" value="<?php echo $address; ?>">
 					   </div>
      <?php 
						if ($user->usertype != 'Super Administrator'){ // don't include google adsense if super admin
							$filepath = substr(__FILE__, 0, strpos(__FILE__, 'templates'));
								if (file_exists($filepath.'google_adsense_detail_small.php')){
									include($filepath.'google_adsense_detail_small.php');
								}
							}

      			}else{ 
							if ($user->usertype != 'Super Administrator'){ // don't include google adsense if super admin
							$filepath = substr(__FILE__, 0, strpos(__FILE__, 'templates'));
								if (file_exists($filepath.'google_adsense_detail_square.php')){
									include($filepath.'google_adsense_detail_square.php');
								}
							}
						}							
?>
   	<div id="div_detalles">
    	<table width="100%" border="0" cellspacing="1" cellpadding="1">
      <?php if ($this->config->showaccessoires != 0 && strlen($this->items->accesoires) > 6) { ?>
      <tr>
        <td colspan="3"><h4 class="salas_titulos"><?php echo JText::_( 'DETALLES' ); ?>:</h4></td>
      </tr>
      <tr>
        <td colspan="3">
        	<div class="accesoires">
        		<?php echo $this->items->accesoires; ?>
        	</div>
        </td>
      </tr>
      <?php } ?>
	    </table>
   	</div>
    </td>
  <tr>
	</tr>
    <td align="left" valign="top">
<?php if ($this->items->image1  != ''){	
?>
        <a name="fotos" style="text-decoration:none;"><h4 class="salas_titulos"><?php echo JText::_( 'FOTOS' ); ?>:</h4></a>
<?php } ?>
<?php //	END PLUGIN HACK ?>
    <div id="photos">
		<table width="100%" border="0" cellspacing="5" cellpadding="0">
		
		<?php 
		if ($this->items->image1  != ''){ $image[]  = $this->items->image1; }	
		if ($this->items->image2  != ''){ $image[]  = $this->items->image2; }	
		if ($this->items->image3  != ''){ $image[]  = $this->items->image3; }	
		if ($this->items->image4  != ''){ $image[]  = $this->items->image4; }
		if ($this->items->image5  != ''){ $image[]  = $this->items->image5; }
		if ($this->items->image6  != ''){ $image[]  = $this->items->image6; }		
		if ($this->items->image7  != ''){ $image[]  = $this->items->image7; }		
		if ($this->items->image8  != ''){ $image[]  = $this->items->image8; }	
		if ($this->items->image9  != ''){ $image[]  = $this->items->image9; }	
		if ($this->items->image10 != ''){ $image[]  = $this->items->image10; }	
		if ($this->items->image11 != ''){ $image[]  = $this->items->image11; }
		if ($this->items->image12 != ''){ $image[]  = $this->items->image12; }
		
		$width  	= $this->config->thumbnailwidth;
		$height 	= $this->config->thumbnailheight;
		$count		= $this->config->collums;

		for ($ct=0, $i=0, $n=count( $image ); $i < $n; $i++)
		{

			if($ct==$count)$ct=0;
			if($ct==0)
			{
			?>
			<tr>
			<?php
			}
			// file or url
			if (substr($image[$i],0,4) == 'http'){
				$src = split('\?',$image[$i]);
				$src = $src[0];
				$href = $src;
			}else{
				$href = "components/com_rdautos/images/".$image[$i];
				$src = "components/com_rdautos/images/th".$image[$i];
			}
			?>
			<td align="center" valign="middle" width="1%">
              <div id ="rd_thumbnail">
                 <a href="<?php echo $href; ?>" rel="roebox[setnamehere]" title="
				 SALA:<?php echo $this->items->modeltype; ?>. <?php echo $this->items->model; ?>, <?php echo $this->items->makename; ?>">
				 <img src="<?php echo $src; ?>" 
                 width="<?php echo $width; ?>" height="<?php echo $height; ?>" border="0" />
			     </a></div></td>
			<?php
			if($ct==2)
			{
			?>
			</tr>
			<?php
			}		
			$ct++;
		}
		
		if($ct<3)
		{
		for($i=$ct ; $i<3 ; $i++)
		echo '<td></td>';
		echo '</tr>';
		}

		
		?> 
		</table> 

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
