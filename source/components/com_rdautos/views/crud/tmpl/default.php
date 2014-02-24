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

## Adding the AJAX part to the dropdowns & Lightbox functions
$document =& JFactory::getDocument();
$document->addScript( JURI::root(true).'/administrator/components/com_rdautos/helper/ajax.js');

?>
<style type="text/css">

#container{
	height: 100%;
	width:	100%;
	margin:	2;
}

#top{
	border: 1px solid;
	border-color:#CCCCCC;
	padding-left: 3px;
	padding-bottom: 2px;
	padding-top: 2px;
	background-color:#EEEEEE;
}

#normal{
	border: 0px solid;
	border-color:#CCCCCC;
	padding: 3px;
}	
</style>
<script type="text/javascript">
	
var ajax = new Array();

function getModelList(sel)
{
	var Code = sel.options[sel.selectedIndex].value;
	document.getElementById('modelid').options.length = 0;	
	if(Code.length>0){
		var index = ajax.length;
		ajax[index] = new sack();
		ajax[index].requestFile = 'index.php?option=com_rdautos&controller=search&task=getModels&format=raw&makeid='+Code;	
		ajax[index].onCompletion = function(){ createModels(index) };	
		ajax[index].runAJAX();		// Execute AJAX function
	}
}

function createModels(index)
{
	var obj = document.getElementById('modelid');
	eval(ajax[index].response);	// Executing the response from Ajax as Javascript code	
}

</script>

<script language="javascript">
 
function getKeyCode(eventObject)

{

if (!eventObject) keyCode = window.event.keyCode; //IE

else keyCode = eventObject.which; //Mozilla

return keyCode;

}

function onlyNumeric(eventObject)

{

keyCode = getKeyCode(eventObject);

if (((keyCode > 31) && (keyCode < 48)) || ((keyCode > 57) && (keyCode < 127)))

{

if (!eventObject) window.event.keyCode = 0; //IE

else eventObject.preventDefault(); //Mozilla

return false;

}

}

function popup(mylink, windowname)
{
if (! window.focus)return true;
var href;
if (typeof(mylink) == 'string')
   href=mylink;
else
   href=mylink.href;
window.open(href, windowname, 'width=400,height=230,scrollbars=yes');
return false;
}

</script>
<!-- Skin CSS file -->
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.7.0/build/assets/skins/sam/skin.css">
<!-- Utility Dependencies -->
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/yahoo-dom-event/yahoo-dom-event.js"></script> 
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/element/element-min.js"></script> 
<!-- Needed for Menus, Buttons and Overlays used in the Toolbar -->
<script src="http://yui.yahooapis.com/2.7.0/build/container/container_core-min.js"></script>
<!-- Source file for Rich Text Editor-->
<script src="http://yui.yahooapis.com/2.7.0/build/editor/simpleeditor-min.js"></script>

<style type="text/css">
select{
	width:140px;
}
</style>

<?php /* PLUGIN HACK ?>
<h1 class="contentheading">
<?php echo JText::_( 'SEARCH VEHICLE' ); ?> </h1>
<?php echo JText::_( 'SEARCH EXPLANATION' ); ?><br><br>
<?php END PLUGIN HACK */?>

<form action = "index.php?option=com_rdautos&view=crud" method="POST" name="adminForm" id="adminForm">
<input name="catid" type="hidden" id="catid" value="<?php echo $this->items->catid; ?>"/>
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td width="69%">
        <div id="container">
        	
         	<div id="top">			
                <?php echo JText::_( 'CRUD OPTIONS' ); ?>
            </div>   
          	<div id="normal" class="yui-skin-sam">			
                <table width="100%" border="0" cellspacing="1" cellpadding="1">
                  <tr>
                    <td><?php echo JText::_( 'SEARCH MAKE' ); ?></td>
                    <td><?php echo $this->lists[make]; ?></td>
                    <td><?php echo JText::_( 'SEARCH NAME' ); ?></td>
                    <td><input name="modeltype" value="<?php echo $this->items->modeltype; ?>" type="text" class="inputbox" id="modeltype" size="20" maxlength="90" tabindex="11"/></td>
                  </tr>
                  <tr>
                    <td><?php echo JText::_( 'SEARCH MODEL' ); ?></td>
                    <td><?php echo $this->lists[model]; ?></td>
                    <td><?php echo JText::_( 'SEARCH TRANS' ); ?></td>
                    <td><input name="transmission" value="<?php echo $this->items->transmission; ?>" type="text" class="inputbox" id="transmission" size="20" maxlength="255" tabindex="12"/></td>
                  </tr>
                  <tr>
                    <td><?php echo JText::_( 'SEARCH COLOR' ); ?></td>
						        <td><input type="text" name="color" value="<?php echo $this->items->color; ?>" size="20" maxlength="20" tabindex="3"/></td>
                    <td><?php echo JText::_( 'SEARCH PRICE' ); ?></td>
                    <td><input name="price" value="<?php echo $this->items->price; ?>" type="text" class="inputbox" id="price" size="8" maxlength="7"
                    onkeypress="onlyNumeric(arguments[0])" tabindex="13"/></td>
                  </tr>
                  <tr>
                    <td><?php echo JText::_( 'SEARCH MOTORSIZE' ); ?></td>
						        <td><input type="text" name="motorsize" value="<?php echo $this->items->motorsize; ?>" size="6"   tabindex="4"/></td>
                    <td><?php echo JText::_( 'SEARCH MILEAGE' ); ?></td>
                    <td><input name="mileage" value="<?php echo $this->items->mileage; ?>" type="text" class="inputbox" id="mileage" size="1" maxlength="3" tabindex="14"/>m2</td>
                  </tr>
                  <tr>
                    <td><?php echo JText::_( 'TELEFONO' ); ?></td>
						        <td><input type="text" name="weight" value="<?php echo $this->items->weight; ?>" size="20" maxlength="25" tabindex="5"/></td>
                  </tr>
						      <tr>
						        <td colspan="3"><h4 class="salas_titulos"><br><?php echo JText::_( 'DETALLES' ); ?>:</h4></td>
						      </tr>
                  <tr>
	                  <td colspan=4>
	<?php
/*										$editor =& JFactory::getEditor();
//										JHTML::_('behavior.tooltip', '.hasTip', $opts);
											echo $editor->display( 'accesoires' ,  '', '100%', '175', '75', '15' , false ) ;*/
?>
											<textarea style="width: 100%; height: 175px;" name="accesoires" id="accesoires">
												<?php echo $this->items->accesoires; ?>
											</textarea>
                		</td>
                	</tr>
						      <tr>
						        <td colspan="3"><h4 class="salas_titulos"><?php echo JText::_( 'FACILIDADES' ); ?>:</h4></td>
						      </tr>
                  <tr>
                    <td><?php echo JText::_( 'SEARCH FUEL' ); ?></td>
                    <td><?php echo $this->lists[fuel]; ?></td>
                  </tr>
                  <tr>
                    <td><?php echo JText::_( 'SEARCH CONDITION' ); ?></td>
                    <td><?php echo $this->lists[condition]; ?></td>
                  </tr>
                  <tr>
                    <td><?php echo JText::_( 'SEARCH DOORS' ); ?></td>
                    <td><?php echo $this->lists[doors]; ?></td>
                  </tr>
                  <tr>
                    <td><?php echo JText::_( 'SEARCH GEARS' ); ?></td>
                    <td><?php echo $this->lists[gears]; ?></td>
                  </tr>
						      <tr>
						        <td colspan="3">
						        	<h4 class="salas_titulos"><?php echo JText::_( 'IMAGES_CRUD' ); ?>: </h4>
						        </td>
						      </tr>
                  <tr>
                    <td align="right"><?php echo JText::_( 'IMAGE1_URL' ); ?>:</td>
                    <td colspan="3"><input name="image1" value="<?php echo substr($this->items->image1, 0, (strpos($this->items->image1, '?')>0?strpos($this->items->image1, '?'):strlen($this->items->image1))); ?>" type="text" class="inputbox" id="image1" size="60" maxlength="255" /></td>
                  </tr>
                  <tr>
                    <td align="right"><?php echo JText::_( 'IMAGE2_URL' ); ?>:</td>
                    <td colspan="3"><input name="image2" value="<?php echo substr($this->items->image2, 0, (strpos($this->items->image2, '?')>0?strpos($this->items->image2, '?'):strlen($this->items->image2))); ?>" type="text" class="inputbox" id="image2" size="60" maxlength="255" /></td>
                  </tr>
                  <tr>
                    <td align="right"><?php echo JText::_( 'IMAGE3_URL' ); ?>:</td>
                    <td colspan="3"><input name="image3" value="<?php echo substr($this->items->image3, 0, (strpos($this->items->image3, '?')>0?strpos($this->items->image3, '?'):strlen($this->items->image3)));  ?>" type="text" class="inputbox" id="image3" size="60" maxlength="255" /></td>
                  </tr>
                  <tr>
                    <td align="right"><?php echo JText::_( 'IMAGE4_URL' ); ?>:</td>
                    <td colspan="3"><input name="image4" value="<?php echo substr($this->items->image4, 0, (strpos($this->items->image4, '?')>0?strpos($this->items->image4, '?'):strlen($this->items->image4))); ?>" type="text" class="inputbox" id="image4" size="60" maxlength="255" /></td>
                  </tr>
                  <tr>
                    <td align="right"><?php echo JText::_( 'IMAGE5_URL' ); ?>:</td>
                    <td colspan="3"><input name="image5" value="<?php echo substr($this->items->image5, 0, (strpos($this->items->image5, '?')>0?strpos($this->items->image5, '?'):strlen($this->items->image5))); ?>" type="text" class="inputbox" id="image5" size="60" maxlength="255" /></td>
                  </tr>
                  <tr>
                    <td align="right"><?php echo JText::_( 'IMAGE6_URL' ); ?>:</td>
                    <td colspan="3"><input name="image6" value="<?php echo substr($this->items->image6, 0, (strpos($this->items->image6, '?')>0?strpos($this->items->image6, '?'):strlen($this->items->image6))); ?>" type="text" class="inputbox" id="image6" size="60" maxlength="255" /></td>
                  </tr>
                  <tr>
                    <td><div align="right">
<?php 	if ($this->items->carid){
					$button_value = JText::_( 'SAVE' );
					print("<input type='hidden' name='id' value='".$this->items->carid."'>");
				}else{
					$button_value = JText::_( 'CREATE' );
				}
?>
          <input type="submit" name="button" id="button" class="button" value="<?php echo $button_value; ?>" />
                    </div></td>
                  </tr>
                </table>
       	  </div>             
        </div>
    </td>
  </tr>  
</table>
<br /><br />
</form>
<script language="javascript">
	var myEditor = new YAHOO.widget.SimpleEditor('accesoires', {
	    height: '200px',
	    width: '550px',
	    dompath: false,
	    animate: true,
	    handleSubmit: true, 
	    toolbar: {
	        buttons: [
	            { group: 'textstyle', label: 'Font Style',
	                buttons: [
	                    { type: 'push', label: 'Bold', value: 'bold' },
	                    { type: 'push', label: 'Italic', value: 'italic' },
	                    { type: 'push', label: 'Underline', value: 'underline' },
									    { type: 'separator' },
					            { type: 'push', label: 'Create an Unordered List', value: 'insertunorderedlist' },
					            { type: 'push', label: 'Create an Ordered List', value: 'insertorderedlist' },
	                    { type: 'separator' },
	                    { type: 'select', label: 'Arial', value: 'fontname', disabled: true,
	                        menu: [
	                            { text: 'Arial', checked: true },
	                            { text: 'Arial Black' },
	                            { text: 'Comic Sans MS' },
	                            { text: 'Courier New' },
	                            { text: 'Lucida Console' },
	                            { text: 'Tahoma' },
	                            { text: 'Times New Roman' },
	                            { text: 'Trebuchet MS' },
	                            { text: 'Verdana' }
	                        ]
	                    },
//	                    { type: 'spin', label: '13', value: 'fontsize', range: [ 9, 75 ], disabled: true },
	                    { type: 'separator' },
	                    { type: 'color', label: 'Font Color', value: 'forecolor', disabled: true },
	                    { type: 'color', label: 'Background Color', value: 'backcolor', disabled: true }
	                ]
	            }
	        ]
	    }
	});
	myEditor.invalidHTML = { a: { keepContents: true }	};
	myEditor.render();
</script>

