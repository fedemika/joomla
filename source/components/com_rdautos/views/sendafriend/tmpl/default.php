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

$vehicle = $this->items->makename.' '.$this->items->model.' '.$this->items->modeltype;

$app =& JFactory::getApplication();
$pathway =& $app->getPathway();
$pathway->addItem(JText::_( 'CATEGORIES' ), 'index.php?option=com_rdautos&view=categories');
$pathway->addItem($this->items->catname, 'index.php?option=com_rdautos&view=category&id='.$this->items->catid);
$pathway->addItem($vehicle, 'index.php?option=com_rdautos&view=detail&id='.$this->items->carid);
$pathway->addItem(JText::_( 'SEND TO FRIEND' ));

?>

<h2 class="contentheading">
<?php echo JText::_( 'SEND TO FRIEND' ); ?> </h2>
<?php echo JText::_( 'INTROTEXTSAF' ); ?> <?php echo $this->items->makename; ?> <?php echo $this->items->model; ?> <?php echo $this->items->modeltype; ?> <?php echo JText::_( 'TO A FRIEND' ); ?><br><br>
<?php echo JText::_( 'EXPLANATION' ); ?><br /><br />

<form action = "index.php?option=com_rdautos&controller=sendafriend" method="POST" name="adminForm" id="adminForm">
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td width="23%"><?php echo JText::_( 'YOUR NAME' ); ?></td>
    <td width="2%">:</td>
    <td width="75%"><input name="name" type="text" id="name" size="30" class="inputbox" /> 
      *</td>
  </tr>
  <tr>
    <td><?php echo JText::_( 'YOUR EMAIL' ); ?></td>
    <td>:</td>
    <td><input name="email" type="text" id="email" size="30" class="inputbox" /> 
      *</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?php echo JText::_( 'FRIEND NAME' ); ?></td>
    <td>:</td>
    <td><input name="friendname" type="text" id="friendname" size="30" class="inputbox" /> 
      *</td>
  </tr>
  <tr>
    <td><?php echo JText::_( 'FRIEND EMAIL' ); ?></td>
    <td>:</td>
    <td><input name="friendemail" type="text" id="friendemail" size="30" class="inputbox" /> 
      *</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top"><?php echo JText::_( 'COMMENTS' ); ?></td>
    <td align="left" valign="top">:</td>
    <td align="left" valign="top"><textarea name="comments" id="comments" cols="45" rows="4"  class="inputbox"></textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="hidden" name="task" value="sendafriend" />
    	<input type="hidden" name="controller" value="sendafriend" />
        <input type="hidden" name="id" value="<?php echo $this->items->carid; ?>" />
        <input type="hidden" name="vehicle" value="<?php echo $vehicle; ?>" />
     All fields with a * are required!</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="submit" name="button" id="button" value="<?php echo JText::_( 'SEND' ); ?>" class="button" /></td>
  </tr>
</table>
</form>
