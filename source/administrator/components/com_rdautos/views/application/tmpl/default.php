<?php 
## Check if the file is included in the Joomla Framework
defined('_JEXEC') or die ('No Acces to this file!');

## Required helper for showing extra info (not stored in DB).
require_once(JPATH_COMPONENT.DS.'helper'.DS.'helper.php');

## Setup the toolbars.
JToolBarHelper::title( JText::_( 'VEHICLE OVERVIEW' ) );
JToolBarHelper::publish();
JToolBarHelper::unpublish();
JToolBarHelper::editListX();
JToolBarHelper::addNew();
JToolBarHelper::deleteList();
?>

<table width="100%" border="0">
  <tr>
    <td>
        <div align="right">
        <form method="POST" name="thisform" action="index.php?option=com_rdautos">
        <select size="1" name="ordering">
        <option value=""><?php echo JText::_( 'PLS SELECT' ); ?></option>
        <option value="added"><?php echo JText::_( 'ORDER BY ADDED' ); ?></option>
        <option value="updated"><?php echo JText::_( 'ORDER BY UPDATE' ); ?></option>
        <option value="makeid"><?php echo JText::_( 'ORDER BY MAKE' ); ?></option>
        <option value="catid"><?php echo JText::_( 'ORDER BY CATID' ); ?></option>
        <option value="hits"><?php echo JText::_( 'ORDER BY HITS' ); ?></option>
        <option value="fueltype"><?php echo JText::_( 'ORDER BY FUELTYPE' ); ?></option>
        <option value="published"><?php echo JText::_( 'ORDER BY PUBLISHED' ); ?></option>
        </select>
        <select size="1" name="orderby" >
        <option value=""><?php echo JText::_( 'PLS SELECT' ); ?></option>
        <option value="ASC"><?php echo JText::_( 'ASC' ); ?></option>
        <option value="DESC"><?php echo JText::_( 'DESC' ); ?></option>
        </select>  
        <input type="submit" name="button"  id="button" value="GO!" />      
        </form>
        </div>
    </td>
  </tr>
</table>

<form action = "index.php" method="POST" name="adminForm">
  <table class="adminlist" width="100%">
    <thead>
      <tr>
        <th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?> ) ;" /></th>
        <th class="title" width="183"><div align="left"><?php echo JText::_( 'MAKE MODEL' ); ?></div></th>
        <th class="title" width="71"><?php echo JText::_( 'PRICE' ); ?></th>
        <th width="76"><?php echo JText::_( 'MILEAGE' ); ?></th>
        <th width="76"><div align="center"><?php echo JText::_( 'FUELTYPE' ); ?></div></th>
        <th width="73"><?php echo JText::_( 'ADDED' ); ?></th>
        <th width="76"><?php echo JText::_( 'UPDATED' ); ?></th>
        <th width="79"><?php echo JText::_( 'IN THIS CATEGORY' ); ?></th>
        <th width="79"><?php echo JText::_( 'VEHICLE AVAILEBLE' ); ?></th>
        <th width="81"><?php echo JText::_( 'HITS' ); ?></th>
        <th width="64"><?php echo JText::_( 'FEATURED' ); ?></th>
        <th width="71"><?php echo JText::_( 'PUBLISHED' ); ?></th>
        <th width="71"><?php echo JText::_( 'USER' ); ?></th>
      </tr>
    </thead>
    <?php 
	   
	   $k = 0;
	   for ($i = 0, $n = count($this->items); $i < $n; $i++ ){
		
		## Give give $row the this->item[$i]
		$row        = &$this->items[$i];
		$published 	= JHTML::_('grid.published', $row, $i );
		$checked    = JHTML::_('grid.id', $i, $row->carid );
		## Making links for redirection and deletion.
		$link       = 'index.php?option=' .$option. '&task=edit&cid[]='.$row->carid;
		$delete     = 'index.php?option=' .$option. '&task=remove&cid='.$row->carid;

	?>
    <tr class="<?php echo "row$k"; ?>">
      <td><?php echo $checked; ?></td>
      <td><a href = "<?php echo $link; ?>"> <?php echo $row->makename; ?> <?php echo $row->model; ?> 
	  <?php echo $row->modeltype; ?> </a> <small><br>
	  <span class="title"><?php echo JText::_( 'BUILD' ); ?></span><?php echo $row->constructed; ?></small></td>
      <td><div align="center">
	  <?php if ($row->price == "0"){
	  			echo JText::_( 'POR' );
			}else {	
	     		echo $this->data->currency; ?> <?php echo number_format($row->price, 2, ',', ' '); 
			} 
	  ?></div></td>
      <td><div align="center"><?php echo $row->mileage; ?> <?php echo $this->data->mileage; ?></div></td>
      <td><div align="center"><?php echo fueltype($row->fueltype); ?></div></td>
      <td><div align="center"><?php echo date ("d-m-Y", strtotime($row->added)); ?></div></td>
      <td><div align="center"><?php echo date ("d-m-Y", strtotime($row->updated)); ?></div></td>
      <td><div align="center"><?php echo $row->title; ?></div></td>
      <td><div align="center"><?php echo availeble($row->availeble); ?></div></td>
      <td><div align="center"><?php echo $row->hits; ?></div></td>
      <td><div align="center"><?php if ($row->featured == 1) { ?>
      <img src="../administrator/images/tick.png" width="15" height="15" border="0" />
      <?php } ?>
      </div></td>
      <td><div align="center"><?php echo $published; ?></div></td>
      <td><div align="center"><a href="index.php?option=com_users&view=user&task=edit&cid[]=<?php echo $row->userid;?>"><?php echo $row->userid;?></a></div></td>
    </tr>
    <?php
	  $k=1 - $k;
	  }
	  ?>
  </table>
  
  <input name = "option" type="hidden" value="<?php echo $option; ?>" />
  <input name = "task" type="hidden" value="" />
  <input name = "boxchecked" type="hidden" value="0"/>
  <input name = "controller" type="hidden" value="application"/>
  
<table width="100%" align="center" class="adminlist">
    <tfoot>
      <tr>
        <td colspan="7"><div align="center"><?php echo $this->pagination->getListFooter(); ?></div></td>
        </tr>  
    </tfoot>   
</table>  
</form>
