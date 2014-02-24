<?php 
## Required helper.
require_once(JPATH_COMPONENT.DS.'helper'.DS.'helper.php');
## initialize the editor
$editor =& JFactory::getEditor();
JHTML::_('behavior.tooltip', '.hasTip', $opts);

## Setting the toolbars up here..
$newCar	= ($this->items->carid < 1);
$text = $newCar ? JText::_( 'ADD NEW' ) : JText::_( 'EDIT' );
JToolBarHelper::title(''.$text.' '.JText::_( 'VEHICLE' ), 'generic.png');
JToolBarHelper::save();
if ($this->items->carid < 1)  {
	## Cancel the operation
	JToolBarHelper::cancel();
} else {
	## For existing items the button is renamed `close`
	JToolBarHelper::cancel( 'cancel', JText::_( 'CLOSE' ) );
};

## Adding the AJAX part to the dropdowns & Lightbox functions
$document =& JFactory::getDocument();
$document->addScript( JURI::root(true).'/administrator/components/com_rdautos/helper/ajax.js');
$document->addScript( '../components/com_rdautos/assets/roebox.js' );
$document->addStyleSheet( '../components/com_rdautos/assets/roebox.css' );
?>
<br />	

<style type="text/css">

#thumbnail{
	border: 1px solid;
	padding: 2px;
	border-color: #CCCCCC;
}
#delete{
	border: 1px solid;
	padding: 1px;
	border-color: #CCCCCC;
	background-color:#CCCCCC;
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
		ajax[index].requestFile = 'index.php?option=com_rdautos&task=getModels&format=raw&makeid='+Code;	
		ajax[index].onCompletion = function(){ createModels(index) };	
		ajax[index].runAJAX();		// Execute AJAX function
	}
}

function createModels(index)
{
	var obj = document.getElementById('modelid');
	eval(ajax[index].response);	// Executing the response from Ajax as Javascript code	
}


function add_sub(el){
	if (el.checked)
		el.form.elements['accesoires'].value+=el.value;
	else{
		var re=new RegExp('(.*)'+el.value+'(.*)$');
		el.form.elements['accesoires'].value=el.form.elements['accesoires'].value.replace(re,'$1$2');
	}
}

	
</script>
<style type="text/css">
select{
	width:120px;
}
</style>

<form action = "index.php" method="POST" name="adminForm" id="adminForm" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td width="43%" align="left" valign="top">
	<fieldset class = "adminForm">
	<legend><?php echo JText::_( 'VEHICLE INFO' ); ?></legend>
	<table width="412" class="admintable">
<?php
	if ($this->just_1_make_n_model > 0){
		$hide_make_n_model = " style='display:none;'";
	}
?>
      <tr <?php echo $hide_make_n_model ?> >
        <td width="175" align="right" class="key">
		<?php echo JHTML::_('tooltip', JText::_( 'DESIRED MAKE' ), null , null, JText::_( 'VEHICLE INFO' )); ?>        </td>
        <td width="225"><?php echo $this->lists[make]; ?></td>
      </tr>
      <tr <?php echo $hide_make_n_model ?> >
        <td width="175" align="right" class="key">
		<?php echo JHTML::_('tooltip', JText::_( 'DESIRED MODEL' ), null , null, JText::_( 'CAR MODEL' )); ?>		</td>
        <td><?php echo $this->lists[model]; ?></td>
      </tr>
      <tr>
        <td width="175" align="right" class="key">
		<?php echo JHTML::_('tooltip', JText::_( 'DESIRED MODELINFO' ), null , null, JText::_( 'DEFINE YOUR MODEL' )); ?>		</td>
        <td>
        <input class = "text_area" type="text" name="modeltype"  size="20" value="<?php echo $this->items->modeltype; ?>"  /></td>
      </tr>  
        <td width="175" align="right" class="key">
		<?php echo JHTML::_('tooltip', JText::_( 'DESIRED CATEGORY' ), null , null, JText::_( 'SELECT CATEGORY' )); ?>		</td>
        <td><?php echo $this->lists[catid]; ?></td>
      </tr>
		<?php if ($this->config->showprice != 0) { ?>
      <tr>
        <td align="right" class="key">
		<?php echo JHTML::_('tooltip', JText::_( 'DESIRED PRICE' ), null , null, JText::_( 'VEHICLE PRICE' )); ?>        </td>
        <td><input class = "text_area" type="text" name="price"  size="20" maxlength="7" value="<?php echo $this->items->price;?>"  /></td>
      </tr>
		<?php } ?>
      <tr>
        <td align="right" class="key">
		<?php echo JHTML::_('tooltip', JText::_( 'DESIRED YEAR' ), null , null, JText::_( 'CONSTRUCTION YEAR' )); ?>		</td>
        <td><input name="constructed" type="text" class="inputbox" value="<?php echo $this->items->constructed; ?>" size="20" maxlength="7" /></td>
      </tr>
		<?php if ($this->config->showcolor != 0) { ?>
      <tr>
        <td align="right" class="key"><font color="#000000"><?php echo JText::_( 'VEHICLE COLOR' ); ?></font></td>
        <td>
			<input class = "text_area" type="text" name="color" size="40" maxlength="40" value="<?php echo $this->items->color; ?>" /></td>
      </tr>
		<?php } ?>
      <tr>
        <td align="right" class="key"><font color="#000000"><?php echo JText::_( 'VEHICLE WEIGHT' ); ?></font></td>
        <td>
		<input class = "text_area" type="text" name="weight" size="20" maxlength="25" value="<?php echo $this->items->weight; ?>" />		</td>
      </tr>
      <tr>
        <td align="right" class="key">
        <?php echo JHTML::_('tooltip', JText::_( 'DESIRED MILEAGE' ), null , null, JText::_( 'MILEAGE' )); ?>        </td>
        <td><input class = "text_area" type="text" name="mileage" size="20" value="<?php echo $this->items->mileage; ?>" /> <?php echo $this->config->mileage ?></td>
      </tr>
		<?php if ($this->config->showgears != 0) { ?>
      <tr>
        <td align="right" class="key"><font color="#000000"><?php echo JText::_( 'GEAR COUNT' ); ?></font></td>
        <td><?php echo $this->lists[gears]; ?></td>
      </tr>
		<?php } ?>
		<?php if ($this->config->showdoors != 0) { ?>
      <tr>
        <td align="right" class="key"><font color="#000000"><?php echo JText::_( 'DOOR COUNT' ); ?></font></td>
        <td><?php echo $this->lists[doors]; ?></td>
      </tr>
		<?php } ?>
		<?php if ($this->config->showfueltype != 0) { ?>
      <tr>
        <td align="right" class="key"><font color="#000000"><?php echo JText::_( 'FUEL USED' ); ?></font></td>
        <td><?php echo $this->lists[fuel]; ?></td>
      </tr>
		<?php } ?>
      <tr>
        <td align="right" class="key"><font color="#000000"><?php echo JText::_( 'TRANS TYPE' ); ?></font></td>
<!-- PLUGIN HACK
        <td><?php echo $this->lists[transmission]; ?></td>
			REPLACE -->
				<td><input class = "text_area" type="text" name="transmission" size="50" maxlength="255" value="<?php echo $this->items->transmission; ?>" />		</td>
<!-- END PLUGIN HACK -->
      </tr>
		<?php if ($this->config->showmotorsize != 0) { ?>
      <tr>
        <td align="right" class="key">
        <?php echo JHTML::_('tooltip', JText::_( 'DESIRED MOTORSIZE' ), null , null, JText::_( 'MOTOR SIZE' )); ?>        </td>
        <td><input class="text_area" type="text" name="motorsize" size="10"  value="<?php echo $this->items->motorsize; ?>" /></td>
      </tr>
		<?php } ?>
      <tr>
        <td align="right" class="key">
		<?php echo JHTML::_('tooltip', JText::_( 'DESIRED HORSEPOWERS' ), null , null, JText::_( 'HORSE POWERS' )); ?></td>
        <td><input class="text_area" type="text" name="enginepower" size="10"  value="<?php echo $this->items->enginepower; ?>" /></td>
      </tr>
      <tr>
        <td align="right" class="key"><font color="#000000"><?php echo JText::_( 'VEHICLE CONDITION' ); ?></font></td>
        <td><?php echo $this->lists[condition]; ?></td>
      </tr>
      <tr>
        <td align="right" class="key"><font color="#000000"><?php echo JText::_( 'VEHICLE AVAILEBLE' ); ?></font></td>
        <td><?php echo $this->lists[availeble]; ?></td>
      </tr>
      <tr>
        <td align="right" class="key"><font color="#000000"><?php echo JText::_( 'FEATURED CAR' ); ?></font></td>
        <td><?php echo $this->lists[featured]; ?></td>
      </tr>
      <tr>
        <td align="right" class="key"><font color="#000000"><?php echo JText::_( 'PUBLISH CAR' ); ?></font></td>
        <td><?php echo $this->lists['published']; ?></td>
      </tr>
    </table>
	<br />
	</fieldset>
	</td>
    <td width="57%" align="left" valign="top">	

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>	<fieldset class = "adminForm">
	<legend><?php echo JText::_( 'ADDITIONAL' ); ?></legend>
	<?php
	// parameters : areaname, content, width, height, cols, rows
	echo $editor->display( 'accesoires' ,  $this->items->accesoires , '100%', '175', '75', '15' , false ) ;
	?>
	</fieldset></td>
  </tr>
  <tr>
    <td><fieldset class = "adminForm">
	<legend><?php echo JText::_( 'IMAGES' ); ?></legend>
    <table width="100%" border="0">
  <tr>
    <td width="8%"><?php echo JText::_( 'IMAGE1' ); ?></td>
    <td width="40%" align="left" valign="middle"><input type="file" name="ad_picture1" id="ad_picture1" /></td>
    <td width="9%"><?php echo JText::_( 'IMAGE7' ); ?></td>
    <td width="43%"><input type="file" name="ad_picture7" id="ad_picture7" /></td>
  </tr>
  <tr>
    <td><?php echo JText::_( 'IMAGE2' ); ?></td>
    <td><input type="file" name="ad_picture2" id="ad_picture2" /></td>
    <td><?php echo JText::_( 'IMAGE8' ); ?></td>
    <td><input type="file" name="ad_picture8" id="ad_picture8" /></td>
  </tr>
  <tr>
    <td><?php echo JText::_( 'IMAGE3' ); ?></td>
    <td><input type="file" name="ad_picture3" id="ad_picture3" /></td>
    <td><?php echo JText::_( 'IMAGE9' ); ?></td>
    <td><input type="file" name="ad_picture9" id="ad_picture9" /></td>
  </tr>
  <tr>
    <td><?php echo JText::_( 'IMAGE4' ); ?></td>
    <td><input type="file" name="ad_picture4" id="ad_picture4" /></td>
    <td><?php echo JText::_( 'IMAGE10' ); ?></td>
    <td><input type="file" name="ad_picture10" id="ad_picture10" /></td>
  </tr>
  <tr>
    <td><?php echo JText::_( 'IMAGE5' ); ?></td>
    <td><input type="file" name="ad_picture5" id="ad_picture5" /></td>
    <td><?php echo JText::_( 'IMAGE11' ); ?></td>
    <td><input type="file" name="ad_picture11" id="ad_picture11" /></td>
  </tr>
  <tr>
    <td><?php echo JText::_( 'IMAGE6' ); ?></td>
    <td><input type="file" name="ad_picture6" id="ad_picture6" /></td>
    <td><?php echo JText::_( 'IMAGE12' ); ?></td>
    <td><input type="file" name="ad_picture12" id="ad_picture12" /></td>
  </tr>
</table>

    </fieldset></td>
  </tr>
  <tr>
    <td>
    <fieldset class = "adminForm">
	<legend><?php echo JText::_( 'IMAGES AND OPTIONS' ); ?></legend>
		<table width="100%" border="0" cellspacing="5" cellpadding="0">

		<?php 
		if ($this->items->image1  != ''){ $image[]  = $this->items->image1; }	
		if ($this->items->image2  != ''){ $image[]  = $this->items->image2; }	
		if ($this->items->image3  != ''){ $image[]  = $this->items->image3; }	
		if ($this->items->image4  != ''){ $image[]  = $this->items->image4; }
		if ($this->items->image5  != ''){ $image[]  = $this->items->image5; }
		if ($this->items->image6  != ''){ $image[]  = $this->items->image6; }		
		if ($this->items->image7  != ''){ $image[]  = $this->items->image7; }		
		if ($this->items->image8  != ''){ $image[]  = $this->items->image8; }	
		if ($this->items->image9  != ''){ $image[]  = $this->items->image9; }	
		if ($this->items->image10 != ''){ $image[]  = $this->items->image10; }	
		if ($this->items->image11 != ''){ $image[]  = $this->items->image11; }
		if ($this->items->image12 != ''){ $image[]  = $this->items->image12; }
		
		$width  	= 100;
		$height 	= 80;
		$path       = JPATH_SITE.DS.'components'.DS.'com_rdautos'.DS.'images'.DS;
		$car		=  $this->items->carid;

		for ($ct=0, $i=0, $n=count( $image ); $i < $n; $i++)
		{

			if($ct==6)$ct=0;
			if($ct==0)
			{
			?>
			<tr>
			<?php
			}
			// file or url
			if (substr($image[$i],0,4) == 'http'){
				$href = $image[$i];
				$src = $image[$i];
			}else{
				$href = "../components/com_rdautos/images/".$image[$i];
				$src = "../components/com_rdautos/images/th".$image[$i];
			}
			?>
			<td align="center" valign="middle">
              <div id ="thumbnail"><a href="<?php echo $href; ?>" rel="roebox" >
              	 <img src="<?php echo $src; ?>" 
                 width="<?php echo $width; ?>" height="<?php echo $height; ?>" border="0" /></a>
                 <a href="<?php echo $href; ?>" rel="roebox" ></a><br>
				 <div id ="delete">
                 <a href="index.php?option=com_rdautos&task=delete&image=<?php echo $image[$i]; ?>&cid=<?php echo $car; ?>" >
				 <?php echo JText::_( 'DELETE IMAGE' ); ?></a>
                 </div>
               </div>
            </td>
			<?php
			if($ct==6)
			{
			?>
			</tr>
			<?php
			}		
			$ct++;
		}
		
		if($ct<3)
		{
		for($i=$ct ; $i<3 ; $i++)
		echo '<td></td>';
		echo '</tr>';
		}

		
		?> 
		</table> 

	</fieldset>
    </td>
  </tr>
</table>

	</td>
  </tr>
</table>

	
    <?php 
	if ($this->items->added == ""){
	?>	<input type="hidden" name="added" value="<?php echo date("Y-m-d H:i:i"); ?>" /> <?php
	?>	<input type="hidden" name="updated" value="<?php echo date("Y-m-d H:i:i"); ?>" /> <?php
	}else{
	?>	<input type="hidden" name="updated" value="<?php echo date("Y-m-d H:i:i"); ?>" /> <?php	
	}
	?>	
	<input type="hidden" name="carid" value="<?php echo $this->items->carid; ?>" />
	<input type="hidden" name="option" value="<?php echo $option; ?>" />
	<input type="hidden" name="task" value="" />
	</form>

