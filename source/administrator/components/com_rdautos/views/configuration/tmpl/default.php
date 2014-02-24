<?php

## Check if the file is included in the Joomla Framework
defined('_JEXEC') or die ('No Acces to this file!');

## Include the toolbars for saving.
JToolBarHelper::title( JText::_( 'COMP CONFIG' ), 'config.png');	
JToolBarHelper::save();
JToolBarHelper::back();

?>
<form action = "index.php" method="POST" name="adminForm" id="adminForm" enctype="multipart/form-data">

<table width="100%" border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td width="50%" align="left" valign="top">
	<fieldset class = "adminForm">
	<legend><?php echo JText::_( 'COMPONENT CONFIG' ); ?></legend>
	<table width="482" class="admintable">
      <tr>
        <td width="183" align="right" class="key"><?php echo JText::_( 'SHOW PRICE' ); ?></td>
        <td width="287"><?php echo $this->lists['price']; ?></td>
      </tr>    
      <tr>
        <td width="183" align="right" class="key"><?php echo JText::_( 'SHOW COLOR' ); ?></td>
        <td><?php echo $this->lists['color']; ?></td>
      </tr>
      <tr>
        <td width="183" align="right" class="key"><?php echo JText::_( 'SHOW MILEAGE' ); ?></td>
        <td><?php echo $this->lists['showmileage']; ?></td>
      </tr>
      <tr>
        <td align="right" class="key"><?php echo JText::_( 'SHOW DOORCOUNT' ); ?></td>
        <td><?php echo $this->lists['showdoors']; ?></td>
      </tr>
      <tr>
        <td align="right" class="key"><?php echo JText::_( 'SHOW TRANS' ); ?></td>
        <td><?php echo $this->lists['showtrans']; ?></td>
      </tr>
      <tr>
        <td align="right" class="key"><?php echo JText::_( 'SHOW ENGPOWER' ); ?></td>
        <td><?php echo $this->lists['enginep']; ?></td>
      </tr>
      <tr>
        <td align="right" class="key"><?php echo JText::_( 'SHOW MOTORSIZE' ); ?></td>
        <td><?php echo $this->lists['motorsize']; ?></td>
      </tr>
      <tr>
        <td align="right" class="key"><?php echo JText::_( 'SHOW ACC' ); ?></td>
        <td><?php echo $this->lists['showaccessoires']; ?></td>
      </tr>
      <tr>
        <td align="right" class="key"><?php echo JText::_( 'SHOW HITS' ); ?></td>
        <td><?php echo $this->lists['showhits']; ?></td>
      </tr>
      <tr>
        <td align="right" class="key"><?php echo JText::_( 'SHOW DEALER' ); ?></td>
        <td><?php echo $this->lists['showdealer']; ?></td>
      </tr>
      <tr>
        <td align="right" class="key"><?php echo JText::_( 'SHOW SEND TO FRIEND' ); ?></td>
        <td><?php echo $this->lists['send2friend']; ?></td>
      </tr>
      <tr>
        <td align="right" class="key"><?php echo JText::_( 'SHOW DATE ADDED' ); ?></td>
        <td><?php echo $this->lists['showdate']; ?></td>
      </tr>
      <tr>
        <td align="right" class="key"><?php echo JText::_( 'ACTIVATE LIGHTBOX' ); ?></td>
        <td><?php echo $this->lists['lightbox']; ?></td>
      </tr>
      <tr>
        <td align="right" class="key"><?php echo JText::_( 'SHOW FUELTYPE' ); ?></td>
        <td><?php echo $this->lists['showfueltype']; ?></td>
      </tr>
      <tr>
        <td align="right" class="key"><?php echo JText::_( 'SHOW WEIGHT' ); ?></td>
        <td><?php echo $this->lists['showweight']; ?></td>
      </tr>
      <tr>
        <td align="right" class="key">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
	</fieldset>	</td>
    <td width="50%" align="left" valign="top">
    <fieldset class = "adminForm">
        <legend><span class="key"><?php echo JText::_( 'SHOW ADDITIONAL' ); ?></span></legend>
    
        <table width="482" class="admintable">
          <tr>
            <td width="208" align="right" class="key"><?php echo JText::_( 'LIGHTBOX WIDTH' ); ?></td>
            <td width="260"><input name="lightboxwidth" type="text" class= "text_area" value="<?php echo $this->config->lightboxwidth; ?>"  size="5" maxlength="3" /> 
              px</td>
          </tr>
          <tr>
            <td align="right" class="key"><?php echo JText::_( 'LIGHTBOX HEIGHT' ); ?></td>
            <td><input name="lightboxheight" type="text" class= "text_area" value="<?php echo $this->config->lightboxheight; ?>"  size="5" maxlength="3" /> 
              px</td>
          </tr>
          <tr>
            <td align="right" class="key"><?php echo JText::_( 'THUMB WIDTH' ); ?></td>
            <td><input name="thumbnailwidth" type="text" class= "text_area" value="<?php echo $this->config->thumbnailwidth; ?>"  size="5" maxlength="3" /> 
              px</td>
          </tr>
          <tr>
            <td align="right" class="key"><?php echo JText::_( 'THUMB HEIGHT' ); ?></td>
            <td><input name="thumbnailheight" type="text" class= "text_area" value="<?php echo $this->config->thumbnailheight; ?>"  size="5" maxlength="3" /> 
              px</td>
          </tr>
          <tr>
            <td align="right" class="key"><?php echo JText::_( 'SET CURRENCY' ); ?></td>
            <td><input class= "text_area" type="text" name="currency"  size="5" value="<?php echo $this->config->currency; ?>" /></td>
          </tr>
          <tr>
            <td align="right" class="key"><?php echo JText::_( 'SET MILEAGE' ); ?></td>
            <td><input class= "text_area" type="text" name="mileage"  size="5" value="<?php echo $this->config->mileage; ?>" /></td>
          </tr>
          <tr>
            <td align="right" class="key"><?php echo JText::_( 'COUNT COLLUMS' ); ?></td>
            <td><input name="collums" type="text" class= "text_area" value="<?php echo $this->config->collums; ?>"  size="5" maxlength="1" /></td>
          </tr>
          <tr>
            <td align="right" class="key"><?php echo JText::_( 'TEMPLATE' ); ?></td>
            <td><input name="template" type="text" class= "text_area" value="<?php echo $this->config->template; ?>"  size="20"/></td>
          </tr>
        </table>
    </fieldset></td>
  </tr>
</table>


<input name="option" type="hidden" value="com_rdautos" />
<input name="id" type="hidden" value="<?php echo $this->config->id; ?>" />
<input name="task" type="hidden" value="" />
<input name="boxchecked" type="hidden" value="0"/>
<input name="controller" type="hidden" value="configuration"/>
</form>
<table width="100%" border="0">
  <tr>
    <td>
    <div align="right"><strong>
    <a href="http://www.rd-media.org/index.php?option=com_content&amp;view=category&amp;layout=blog&amp;id=25&amp;Itemid=60" 
    target="_blank">RD-Autos Version 1.5.5</a></strong>&nbsp;&nbsp;
    </div></td>
  </tr>
</table>
