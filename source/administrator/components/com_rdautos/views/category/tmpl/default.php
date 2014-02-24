<?php

## Check if the file is included in the Joomla Framework
defined('_JEXEC') or die ('No Acces to this file!');

## initialize the editor
$editor =& JFactory::getEditor();
JHTML::_('behavior.tooltip');

## Include the toolbars for saving.
JToolBarHelper::title(JText::_( 'CAT MANAGER' ));
JToolBarHelper::publish();
JToolBarHelper::unpublish();
JToolBarHelper::addNew();
JToolBarHelper::deleteList();

?>

<form action = "index.php?option=com_rdautos&controller=category" method="POST" name="adminForm">
  <table class="adminlist" width="100%">
    <thead>
      <tr>
        <th width="15"><div align="center">
          <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?> ) ;" />
        </div></th>
        <th class="title" width="81"><div align="center"><span class="key"><?php echo JText::_( 'CAT PREVIEW' ); ?></span></div></th>
        <th class="title" width="227"><div align="left"><span class="key"><?php echo JText::_( 'CAT NAME' ); ?></span></div></th>
        <th width="526"><div align="left"><span class="key"><?php echo JText::_( 'SHORT DESC' ); ?></span></div></th>
        <th width="71"><?php echo JText::_( 'REMOVE' ); ?></th>
        <th width="71"><span class="key"><?php echo JText::_( 'PUBLISHED' ); ?></span></th>
        <th width="29">ID#</th>
      </tr>
    </thead>
    <?php 
	   
	   $k = 0;
	   for ($i = 0, $n = count($this->items); $i < $n; $i++ ){
		
		$row        = &$this->items[$i];
		
		$published 	= JHTML::_('grid.published', $row, $i );
		$checked    = JHTML::_('grid.id', $i, $row->catid );
		$link 		= JRoute::_( 'index.php?option=' .$option. '&controller=category&task=edit&cid='.$row->catid.'' );
		$delete     = 'index.php?option=' .$option. '&controller=category&task=remove&cid='.$row->catid;
	
	?>
    <tr class="<?php echo "row$k"; ?>">
      <td><div align="center"><?php echo $checked; ?></div></td>
      <td align="center" valign="top">
      <img src="../components/com_rdautos/catimages/<?php echo $row->image; ?>" width="75" /></td>
      <td><div align="left">
	  <a href="<?php echo $link; ?>"><?php echo $row->catname; ?></a> <small><em>(<?php echo $row->alias; ?>)</em></small></div>      </td>
      <td><div align="left"><?php echo $row->decription; ?></div></td>
      <td><div align="center"><a href = "javascript:if (confirm('<?php echo "". JText::_( 'DELETE' )." ". JText::_( 'CATEGORY' )." ".$row->catname."?" ;?>  ')){
       location.href='<?php echo $delete; ?>';}" title="<?php echo "Delete Ctaegory?";?>">
      <img src="../administrator/images/delete_f2.png" width="15" height="15" border="0" /></a></div></td>
      <td><div align="center"><?php echo $published; ?></div></td>
      <td><div align="center"><?php echo $i+1 ; ?></div></td>
    </tr>
    <?php
	  $k=1 - $k;
	  }
	  ?>
  </table>
  <input name = "option" type="hidden" value="<?php echo $option; ?>" />
  <input name = "task" type="hidden" value="" />
  <input name = "boxchecked" type="hidden" value="0"/>
  <input name = "controller" type="hidden" value="category"/>

</form>