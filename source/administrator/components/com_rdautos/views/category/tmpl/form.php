<?php

## Check if the file is included in the Joomla Framework
defined('_JEXEC') or die ('No Acces to this file!');

## Setting the toolbars up here..
$newCat	= ($this->data->catid < 1);
$text = $newCat ? JText::_( 'Add New' ) : JText::_( 'Edit Your' );
JToolBarHelper::title(''.$text.' Category', 'generic.png');
JToolBarHelper::save();
if ($this->data->catid < 1)  {
	## Cancel the operation
	JToolBarHelper::cancel();
} else {
	## For existing items the button is renamed `close`
	JToolBarHelper::cancel( 'cancel', 'Close' );
};

## initialize the editor
$editor =& JFactory::getEditor();
JHTML::_('behavior.tooltip', '.hasTip', $opts);
?>
<form action = "index.php" method="POST" name="adminForm" id="adminForm" enctype="multipart/form-data">

<div class="col width-60">
<fieldset class="adminform">
<legend><span class="key"><?php echo JText::_( 'CAT DETAILS' ); ?></span></legend>

<table class="admintable">
    <tr>
        <td class="key">
        <label for="catname" width="100"><font color="#000000"><?php echo JText::_( 'CAT TITLE' ); ?></font></label></td>
        <td colspan="2"><input class="text_area" type="text" name="catname" id="catname" size="50" maxlength="50" 
        value="<?php echo $this->data->catname; ?>" />
        </td>
    </tr>
    <tr>
        <td class="key"><label for="alias">
		<font color="#000000"><?php echo JText::_( 'ALIAS' ); ?></font></label>
        </td>
        <td colspan="2"><input class="text_area" type="text" name="alias" id="alias" size="50" maxlength="50"
        value="<?php echo $this->data->alias; ?>" /></td>
    </tr>
    <tr>
        <td width="120" class="key"><font color="#000000"><?php echo JText::_( 'Published' ); ?></font></td>
        <td><span class="adminForm"><?php echo $this->lists['published']; ?></span></td>
    </tr>
    <tr>
        <td class="key">
		<?php echo JHTML::_('tooltip', JText::_( 'DESIRED CATIMAGE' ), null , null, JText::_( 'CAT IMAGE' )); ?>
        </td>
        <td><input type="file" name="file" size="35" id="file" /></td>
    </tr>
</table>

</fieldset>

<fieldset class="adminform">
    <legend><span class="key"><?php echo JText::_( 'CAT INFO' ); ?></span>.</legend>
        <strong>
        - <?php echo JText::_( 'CAT INFO1' ); ?><br />
        - <?php echo JText::_( 'CAT INFO2' ); ?><br />
        - <?php echo JText::_( 'CAT INFO3' ); ?>
        </strong>
</fieldset>
    
<fieldset class="adminform"><legend><?php echo JText::_( 'DESCRIPTION' ); ?></legend>

<table class="admintable">
    <tr>
        <td valign="top" colspan="3">
        <?php
        ## parameters : areaname, content, width, height, cols, rows
        echo $editor->display( 'decription',  $this->data->decription , '100%', '200', '100', '15' ) ; ?></td>
    </tr>
</table>
</fieldset>
</div>
<div class="clr"></div>
<input type = "hidden" name="catid" value="<?php echo $this->data->catid; ?>" />
<input type = "hidden" name="option" value="com_rdautos" />
<input type = "hidden" name="task" value="" />
<input type = "hidden" name="controller" value="category" />
</form>
		
