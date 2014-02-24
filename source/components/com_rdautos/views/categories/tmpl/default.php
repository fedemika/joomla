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

$app =& JFactory::getApplication();
$pathway =& $app->getPathway();
$pathway->addItem(JText::_( 'CATEGORIES' ), 'index.php?option=com_rdautos&view=categories');

## Counting Cars for Stocklevels
$total = count($this->count);

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
<h1 class="contentheading"><?php echo JText::_( 'CAT AVAIL' ); ?></h1>
<?php echo JText::_( 'CAT INTROTEXT' ); ?>

<?php 
$k = 0;
for ($i = 0, $n = count($this->items); $i < $n; $i++ ){
$row    = &$this->items[$i];
$link   = 'index.php?option=com_rdautos&view=category&id='.$row->catid;
?>

	<div id = "normal">
    <table width="100%">
      <tr>
      <td width="100" align="center" valign="top">
      <a href="<?php echo $link; ?>">
      <img src="components/com_rdautos/catimages/<?php echo $row->image; ?>" width="<?php echo $this->config->catimage; ?>" /></a></td>
      <td width="650" align="left" valign="top">
      <div align="left"><a href="<?php echo $link; ?>"><strong><?php echo $row->catname; ?></strong></a> <br />
          <?php echo $row->decription; ?>
      <br />
      </div></td>
      <td width="222" align="center" valign="middle">
      <div align="center"></div>
        </td>
      </tr>
    </table>
  </div>

<?php
  $k=1 - $k;
  }
?>
<?php echo $total; ?> <?php echo JText::_( 'VEHICLES IN STOCK' ); ?>