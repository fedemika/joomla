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
$pathway->addItem(JText::_( 'SEARCH' ), 'index.php?option=com_rdautos&view=search');
$pathway->addItem(JText::_( 'SEARCH RESULTS' ));

?>
<style type="text/css">

#container{
	height: 100%;
	width:	100%;
	margin:	2;
}

#featured{
	width: 100%;
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

#normal{
	width: 100%;
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

</style>

<div id ="container">

<?php

## Counting the cars that will be featured. If count == 0, don't show!
$n = count($this->items);

if ($n == 0){ 

	echo "<h1 class=\"contentheading\">".JText::_( 'NO SEARCH RESULTS' )."</h1>";
	echo "<br>";
/* PLUGIN HACK 
	echo JText::_( 'NO RESULTS' );
		END PLUGIN HACK */ 
	echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"3;  URL=index.php?option=com_rdautos&view=search\"> ";
}
?>

<?php
//print_r($this->search);
echo "<i><b>" .JText::_( 'FOUND VEHICLES' )." ".$n." </b>". JText::_( 'VEHICLES' )."<br/>";
echo "Salas de ensayo en ".$this->search->makename;
if ($this->search->model){
	$first = true;
	echo " (";
	foreach($this->search->model as $model){
		if (!$first){
			echo ", ";
		}
		echo $model;
		$first = false;
	}
	echo ")";
}

if ($this->search->mileage){
	echo " con superficies desde ".$this->search->mileage." m2";
}

if ($this->search->condition || $this->search->fueltype || $this->search->doors || $this->search->gears) {
	echo " con las siguientes facilidades: <br>";
?>
						<ul class="salas_detalles"> 
	      <?php if ($this->search->condition) { ?>
						<li>
		        	<?php echo JText::_( 'CONDITION' ); ?>
						</li>
				<?php } ?>
	      <?php if ($this->search->fueltype) { ?>
						<li>
		        	<?php echo JText::_( 'FUEL TYPE' ); ?>
						</li>
				<?php } ?>
	      <?php if ($this->search->doors) { ?>
						<li>
		        	<?php echo JText::_( 'DOORS' ); ?>
						</li>
				<?php } ?>
	      <?php if ($this->search->gears) { ?>
						<li>
		        	<?php echo JText::_( 'GEARS' ); ?>
						</li>
				<?php } ?>
					</ul>
<?php
}
echo "</i>";
//print_r($this->search);
if(count($this->items) == 0){
	echo JText::_( 'NO VEHICLE FOUND' )." <a href=\"index.php?option=com_rdautos&amp;view=search\">".JText::_( 'TRY AGAIN' )."</a>";
}
//echo "<br/>search id:".$this->search_id."<br/>";

$k = 0;
for ($i = 0, $n = count($this->items); $i < $n; $i++ ){
$row    = &$this->items[$i];
$link   = 'index.php?option=com_rdautos&view=detail&id='.$row->carid;
?>
 	<div id = "normal">
   <table width="100%">
      <tr>
		<?php 
      		$colspan = "colspan='2'";
      		$width = "width='76%'";
      		if ($row->image1) { 
      		$width = "width='60%'";
      		$colspan = "";
      			?>
	      <td width="10%" align="center" valign="top">
		      <a href="<?php echo $link; ?>">
<?php /* if no width="" the IE interprets it as a 0 */ 

			$width  	= $this->config->thumbnailwidth;
			$height 	= $this->config->thumbnailheight;
			// file or url
			if (substr($row->image1,0,4) == 'http'){
				$src = split('\?',$row->image1);
				$src = $src[0];
			}else{
				$src = "components/com_rdautos/images/th".$row->image1;
			}
?>
      <img width="<?php echo $width; ?>" height="<?php echo $height; ?>" src="<?php echo $src; ?>"<?php echo (!empty($this->config->catimage)?'width="'.$this->config->catimage.'':''); ?>" /></a>
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
      <div align="center" class="preview_sala" >
			<?php if ($row->weight){
							echo $row->weight; ?><br>
			 <?php } ?>
				<?php echo $row->model?$row->model.', ':''; ?><?php echo $row->makename; ?> <br>
        	<strong>
			<?php if ($this->config->showprice && $row->price > 0){
		 			echo $this->config->currency; ?> <?php echo number_format($row->price, 2, ',', ' '); 
			   } ?></strong>            
<?php $user = JFactory::getUser();
      if ($user->usertype == 'Super Administrator'){ ?>
				<a href="administrator/index.php?option=com_rdautos&task=edit&cid[]=<?php echo $row->carid; ?>"><strong>Editar</strong></a>
<?php } ?>
        </div>
        </td>
      </tr>
    </table>
  </div>

<?php
  $k=1 - $k;
  }
?>


</div>


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