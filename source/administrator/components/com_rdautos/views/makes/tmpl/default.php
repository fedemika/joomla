<?php

## Check if the file is included in the Joomla Framework
defined('_JEXEC') or die ('No Acces to this file!');

## Include the toolbars for saving.
JToolBarHelper::title( JText::_( 'MAKE MODEL MANAGER' ) );	
JToolBarHelper::back();

$n = count($this->makes);
$m = count($this->models);

?>

<table width="100%" border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td width="50%" align="left" valign="top">
	<fieldset class = "adminForm">
	<legend><?php echo JText::_( 'AVAIL MAKESMODELS' ); ?> (<?php echo $n; ?>)</legend>
      <table class="adminlist" width="99%">
        <thead>
          <tr>
            <th class="title" width="24"><div align="center">#</div></th>
            <th class="title" width="294"><div align="left"><?php echo JText::_( 'VEHICLE MAKE' ); ?>e</div></th>
            <th class="title" width="63"><div align="center"><?php echo JText::_( 'REMOVE' ); ?></div></th>
            <th width="75"><div align="center"><?php echo JText::_( 'PUBLISHED' ); ?></div></th>
          </tr>
        </thead>
        <?php 
           
           $k = 0;
           for ($i = 0, $n = count($this->makes); $i < $n; $i++ ){
            
            ## Give give $row the this->item[$i]
            $row        = &$this->makes[$i];
			$publish    = 'index.php?option='.$option.'&controller=makes&task=publish&p=1&cid='.$row->makeid;
			$unpublish  = 'index.php?option='.$option.'&controller=makes&task=publish&p=0&cid='.$row->makeid;
            ## Making links for redirection and deletion.
            $link       = 'index.php?option=' .$option. '&task=&controller=makes&task=makes&cid='.$row->makeid;
            $delete     = 'index.php?option=' .$option. '&controller=makes&task=delete&cid='.$row->makeid;
    
        ?>
        <tr class="<?php echo "row$k"; ?>">
          <td><div align="center"><?php echo $i+1; ?></div></td>
          <td><div align="left"><a href="<?php echo $link; ?>" ><?php echo $row->makename; ?></a></div></td>
          <td><div align="center"><a href = "javascript:if (confirm('<?php echo "". JText::_( 'DELETE' )." ".$row->makename."?";?>')){
       location.href='<?php echo $delete; ?>';}" title="<?php echo "".JText::_('DELETE MAKE')." ".$row->makename."";?>">
       <img src="../administrator/images/delete_f2.png" width="15" height="15" border="0" /></a></div></td>
          <td><div align="center"><?php 
		  if ($row->published == 1){ ?>
		  	<a href="<?php echo $unpublish; ?>" >
          <img src="../administrator/images/publish_g.png" width="15" height="15" border="0" /></a>
		   <?php }else{ ?>
		  	<a href="<?php echo $publish; ?>" >
          <img src="../administrator/images/publish_r.png" width="15" height="15" border="0" /></a>
		  <?php }
		  ?></div></td>
        </tr>
        <?php
          $k=1 - $k;
          }
          ?>
      </table>
	</fieldset>	</td>
    <td width="50%" align="left" valign="top">
    <fieldset class = "adminForm">
        <legend><?php echo JText::_( 'AVAIL MODELS' ); ?> (<?php echo $m; ?>)</legend>
		<?php if ($m <1) {
				echo JText::_( 'NO MAKE SELECTED' );
			   }else{
		?>	   	
        <table class="adminlist" width="99%">
            <thead>
              <tr>
                <th class="title" width="24"><div align="center">#</div></th>
                <th class="title" width="294"><div align="left">
				<?php echo JText::_( 'AVAIL MODELS FOR' ); ?> <?php echo $this->make->makename; ?></div></th>
                <th class="title" width="63"><div align="center"><?php echo JText::_( 'REMOVE' ); ?></div></th>
                <th width="75"><div align="center"><?php echo JText::_( 'PUBLISHED' ); ?></div></th>
              </tr>
            </thead>
            <?php 
               
               $k = 0;
               for ($i = 0, $n = count($this->models); $i < $n; $i++ ){
                
			$make          = JRequest::getVar( 'cid', 0 );
			$model         = &$this->models[$i];
			$publishing    = 'index.php?option='.$option.'&controller=makes&task=publishmodel&p=1&make='.$make.'&cid='.$model->modelid;
			$unpublishing  = 'index.php?option='.$option.'&controller=makes&task=publishmodel&p=0&make='.$make.'&cid='.$model->modelid;
			## Making links for redirection and deletion.
			$delete        = 'index.php?option=' .$option. '&controller=makes&task=remove&cid='.$model->modelid;
	
            ?>
            <tr class="<?php echo "row$k"; ?>">
              <td><div align="center"><?php echo $i+1; ?></div></td>
              <td><div align="left"><?php echo $model->model; ?></div></td>
              <td><div align="center">
              <a href = "javascript:if (confirm('<?php echo "Are You Sure? Delete Model ".$model->model."?";?>')){
       location.href='<?php echo $delete; ?>';}" title="<?php echo "Are You Sure? Delete Model ".$row->model."";?>">
       <img src="../administrator/images/delete_f2.png" width="15" height="15" border="0" /></a></div></td>
              <td><div align="center">
                <?php 
		  		if ($model->published == 1){ ?>
                <a href="<?php echo $unpublishing; ?>" > <img src="../administrator/images/publish_g.png" width="15" height="15" 
                border="0" /></a>
                <?php }else{ ?>
                <a href="<?php echo $publishing; ?>" > <img src="../administrator/images/publish_r.png" width="15" height="15" 
                border="0" /></a>
                <?php }
		  ?>
              </div></td>
            </tr>
            <?php
              $k=1 - $k;
              }
              ?>
      </table>
      <?php } ?>
    </fieldset>
    
    <fieldset class = "adminForm">
    <legend><?php echo JText::_( 'ADD MAKE' ); ?></legend>
    <form action = "index.php" method="POST" name="adminForm" id="adminForm">
    <table width="481" class="admintable">
      <tr>
        <td width="175" align="right" class="key"><?php echo JText::_( 'GIVE MAKENAME' ); ?>:</td>
        <td width="294"><input class = "text_area" type="text" name="makename"  size="20"  />
          <input type="submit" name="button"  id="button" value="<?php echo JText::_( 'ADD MAKE NOW' ); ?>" /></td>
      </tr>
    </table>
    <input name="option" type="hidden" value="com_rdautos" />
    <input name="task" type="hidden" value="savemake" />
    <input name="controller" type="hidden" value="makes"/>
    </form>
    </fieldset>
    
    <fieldset class = "adminForm">
    <legend><?php echo JText::_( 'ADD MODEL' ); ?></legend>
    <form action = "index.php" method="POST" name="adminForm" id="adminForm">
    <table width="481" class="admintable">
      <tr>
        <td width="175" align="right" class="key"><?php echo JText::_( 'CHOOSE MAKE' ); ?></td>
        <td width="294"><?php echo $this->lists[make]; ?></td>
      </tr>
      <tr>
        <td width="175" align="right" class="key"><?php echo JText::_( 'GIVE MODELNAME' ); ?>:</td>
        <td width="294"><input class = "text_area" type="text" name="model"  size="20"  />
          <input type="submit" name="button"  id="button" value="<?php echo JText::_( 'ADD MODEL NOW' ); ?>" /></td>
      </tr>      
    </table>
    <input name="option" type="hidden" value="com_rdautos" />
    <input name="task" type="hidden" value="savemodel" />
    <input name="controller" type="hidden" value="makes"/>
    </form>    
    </fieldset>    
    </td>
  </tr>
</table>

