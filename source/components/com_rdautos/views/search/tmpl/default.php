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

<?php // PLUGIN HACK ?>
	function setFirstMake(){
		var sel = document.getElementById('makeid');
		sel.selectedIndex = 1;
		getModelList(sel);
	}

	function multiple_single(){
		var select = document.getElementById('modelid');
		var a = document.getElementById('multiple_link');
		if (select.multiple){
			select.multiple=false;
			select.size=1;
			a.innerHTML = "Selecci&oacute;n m&uacute;ltiple";
			a.title = "Usando esta opcion pod&eacute;s seleccionar mas de una localidad presionando CTRL";
		  var dummyOption = document.createElement('option');
		  dummyOption.text='Indistinto';
		  try{
				select.add(dummyOption,0); // IE only
		  }catch(ex){
				select.add(dummyOption,select.options[0]); // standards compliant
		  }
		}else{
			select.multiple=true;
			select.size=5;
			a.innerHTML = "Selecci&oacute;n simple";
			a.title = "";
			select.remove(0);
		}
	}
<?php // END PLUGIN HACK ?>
</script>

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

<form action = "index.php?option=com_rdautos&view=results" method="POST" name="adminForm" id="adminForm">
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td width="69%">
        <div id="container">
        	
         	<div id="top">			
                <strong><?php echo JText::_( 'SEARCH OPTIONS' ); ?></strong> <small >(todos los campos son opcionales)</small>
            </div>   
          	<div id="normal">			
                <table width="100%" border="0" cellspacing="1" cellpadding="1">
                   <input name="catid" type="hidden" id="catid" value="34"/>
                  <tr>
                    <td width="36%"><strong><?php echo JText::_( 'SEARCH MAKE' ); ?></strong></td>
                    <td width="35%"><strong><?php echo JText::_( 'SEARCH MODEL' ); ?></strong><a id="multiple_link" href="javascript:void(0);" onclick="multiple_single();" style="margin-left:5px;font-size:9px;" title="Usando esta opci&oacute;n pod&eacute;s seleccionar m&aacute;s de una localidad presionando CTRL">Selecci&oacute;n m&uacute;ltiple</a></td>
                  </tr>
                  <tr>
                    <td valign="top"><?php echo $this->lists[make]; ?></td>
                    <td valign="top"><?php echo $this->lists[model]; ?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><strong><?php echo JText::_( 'SEARCH NAME' ); ?></strong> <small>(o parte del nombre)</small></td>
                    <td ><strong><?php echo JText::_( 'SEARCH DETAILS' ); ?> : </strong></td>
                  </tr>
                  <tr>
                    <td valign="top">
                    	<input name="modeltype" type="text" class="inputbox" id="modeltype" size="20" maxlength="90" /></td>
                    <td >
                    	<input name="accesoires" type="text" class="inputbox" id="accesoires" size="19" maxlength="90" /></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><strong><?php echo JText::_( 'SEARCH MILEAGE' ); ?></strong></td>
                    <td><input name="mileageFrom" type="text" class="inputbox" id="mileageFrom" size="1" maxlength="3" />m2</td>
                  </tr>
                  <tr>
                    <td><strong><?php echo JText::_( 'SEARCH DOORS' ); ?></strong></td>
                    <td ><?php echo $this->lists[doors]; ?></td>
                  </tr>
                  <tr>
                    <td><strong><?php echo JText::_( 'SEARCH FUEL' ); ?></strong></td>
                    <td ><?php echo $this->lists[fuel]; ?></td>
                  </tr>
                  <tr>
                    <td><strong><?php echo JText::_( 'SEARCH CONDITION' ); ?></strong></td>
                    <td ><?php echo $this->lists[condition]; ?></td>
                  </tr>
                  <tr>
                    <td><strong><?php echo JText::_( 'SEARCH GEARS' ); ?></strong></td>
                    <td ><?php echo $this->lists[gears]; ?></td>
                  </tr>
                  <tr>
                    <td colspan=3><div style="text-align:right;">
                      <input type="submit" name="button" id="button" class="button" value="<?php echo JText::_( 'SEARCH NOW' ); ?>" />
                    </div></td>
                  </tr>
                </table>
       	  </div>             
        </div>
    </td>
  </tr>  
</table>
<br /><br />
<?php // PLUGIN HACK ?>
<script type="text/javascript">//setFirstMake()</script>
<?php // END PLUGIN HACK ?>
</form>
