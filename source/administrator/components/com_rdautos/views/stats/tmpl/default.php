<?php

## Check if the file is included in the Joomla Framework
defined('_JEXEC') or die ('No Acces to this file!');

## Include the toolbars for saving.
JToolBarHelper::back();

?>

<table width="100%" border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td width="50%" align="left" valign="top">
	<fieldset class = "adminForm">
	<legend><?php echo JText::_( 'Serch Logs' ); ?></legend>
      <table class="adminlist" width="99%">
        <thead>
          <tr>
            <th width="20" class="title"><div align="center">#</div></th>
            <th width="255" class="title"><div align="left">Fecha</div></th>
            <th width="30" class="title"><div align="center">Resultados</div></th>
            <th width="130"><div align="center"><?php echo JText::_('SEARCH MAKE'); ?></div></th>
            <th width="130"><div align="center"><?php echo JText::_('SEARCH MODEL'); ?></div></th>
            <th width="130"><div align="center"><?php echo JText::_('SEARCH NAME'); ?></div></th>
            <th width="30"><div align="center"><?php echo JText::_('MILEAGE'); ?></div></th>
            <th width="30"><div align="center"><?php echo JText::_('DOORS'); ?></div></th>
            <th width="30"><div align="center"><?php echo JText::_('FUELTYPE'); ?></div></th>
            <th width="30"><div align="center"><?php echo JText::_('CONDITION'); ?></div></th>
            <th width="30"><div align="center"><?php echo JText::_('GEARS'); ?></div></th>
            <th><div align="center"><?php echo JText::_('SEARCH DETAILS'); ?></div></th>
          </tr>
        </thead>
        <?php 
           foreach ($this->stats as $stat){
        ?>
        <tr class="<?php echo "row$k"; ?>">
          <td><div align="center"><?php echo $stat->log_id ; ?></div></td>
          <td><div align="left"><?php echo $stat->search_date; ?></div></td>
          <td><div align="center"><?php echo $stat->results ; ?></div></td>
          <td><div align="left"><?php echo $stat->makename; ?></div></td>
          <td><div align="left"><?php echo $stat->model; ?></div></td>
          <td><div align="left"><?php echo $stat->modeltype; ?></div></td>
          <td><div align="center"><?php echo $stat->mileage ; ?></div></td>
          <td><div align="left"><?php echo $stat->doors; ?></div></td>
          <td><div align="center"><?php echo $stat->fueltype ; ?></div></td>
          <td><div align="left"><?php echo $stat->gears; ?></div></td>
          <td><div align="center"><?php echo $stat->condition ; ?></div></td>
          <td><div align="left"><?php echo $stat->accesoires; ?></div></td>
        </tr>
        <?php 
          }
        ?>
      </table>
	</fieldset>	
	</td>
  </tr>
</table>

