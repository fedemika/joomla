<?php
/**
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />

<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/general.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/salasdensayo/css/template.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/salasdensayo/css/<?php echo $this->params->get('colorVariation'); ?>.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/salasdensayo/css/<?php echo $this->params->get('backgroundVariation'); ?>_bg.css" type="text/css" />
<!--[if lte IE 6]>
<link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/ieonly.css" rel="stylesheet" type="text/css" />
<![endif]-->
<?php if($this->direction == 'rtl') : ?>
	<link href="<?php echo $this->baseurl ?>/templates/salasdensayo/css/template_rtl.css" rel="stylesheet" type="text/css" />
<?php endif; ?>

</head>
<body id="page_bg" class="color_<?php echo $this->params->get('colorVariation'); ?> bg_<?php echo $this->params->get('backgroundVariation'); ?> width_<?php echo $this->params->get('widthStyle'); ?>">
<a name="up" id="up"></a>
<div class="centered">
<div class="center" align="center">
	<div id="colizq">
<?php		
$user = JFactory::getUser();
if ($user->usertype != 'Super Administrator'){ // don't include google adsense if super admin
$filepath = substr(__FILE__, 0, strpos(__FILE__, 'templates'));
	if (file_exists($filepath.'google_adsense_izq.php')){
		include($filepath.'google_adsense_izq.php');
	}
}
?>
	</div>
	<div id="colder">
			<div>
				<jdoc:include type="modules" name="right" style="xhtml"/>
			</div>
<?php		
$user = JFactory::getUser();
if ($user->usertype != 'Super Administrator'){ // don't include google adsense if super admin
$filepath = substr(__FILE__, 0, strpos(__FILE__, 'templates'));
	if (file_exists($filepath.'google_adsense_der.php')){
		include($filepath.'google_adsense_der.php');
	}
}
?>
	</div>
	<div id="wrapper">
		<div id="wrapper_r">
			<div id="header">
				<div id="header_l">
					<div id="header_r">
						<div id="logo">
							<h1><a href="/"><?php echo "Encontr&aacute; tu sala de ensayo"; ?> </a></h1>
						</div>
						<jdoc:include type="modules" name="top" />
					</div>
				</div>
			</div>

			<div id="tabarea">
				<div id="tabarea_l">
					<div id="tabarea_r">
						<div id="tabmenu">
						<table cellpadding="0" cellspacing="0" class="pill">
							<tr>
								<td class="pill_l">&nbsp;</td>
								<td class="pill_m">
								<div id="pillmenu">
									<jdoc:include type="modules" name="user3" />
								</div>
								</td>
								<td class="pill_r">&nbsp;</td>
							</tr>
							</table>
						</div>
					</div>
				</div>
			</div>

			<div id="search">
				<jdoc:include type="modules" name="user4" />
			</div>

			<div id="pathway">
				<jdoc:include type="modules" name="breadcrumb" />
			</div>

			<div class="clr"></div>
<?php		
/*
?>
			<div id="left_ads">
				<script type="text/javascript"><!--
				google_ad_client = "pub-1162692257004668";
				// 200x200 salas izq, creado 11/12/08
				google_ad_slot = "6702675802";
				google_ad_width = 200;
				google_ad_height = 200;
				//-->
				</script>
				<script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>
			</div>
<?php		
*/
?>
			<div id="whitebox">
				<div id="whitebox_t">
					<div id="whitebox_tl">
						<div id="whitebox_tr"></div>
					</div>
				</div>

				<div id="whitebox_m">
<?php		
if (JRequest::getVar( 'view') != 'detail'){ // we show top ads if not in detail view
	if ($user->usertype != 'Super Administrator'){ // don't include google adsense if super admin
	$filepath = substr(__FILE__, 0, strpos(__FILE__, 'templates'));
		if (file_exists($filepath.'google_adsense_top.php')){
			include($filepath.'google_adsense_top.php');
		}
	}
}
?>
					<div id="area">
									<jdoc:include type="message" />

						<div id="leftcolumn">
						<?php if($this->countModules('left')) : ?>
							<jdoc:include type="modules" name="left" style="rounded" />
						<?php endif; ?>
						</div>

						<?php if($this->countModules('left')) : ?>
						<div id="maincolumn">
						<?php else: ?>
						<div id="maincolumn_full">
						<?php endif; ?>
							<?php if($this->countModules('user1 or user2')) : ?>
								<table class="nopad user1user2">
									<tr valign="top">
										<?php if($this->countModules('user1')) : ?>
											<td>
												<jdoc:include type="modules" name="user1" style="xhtml" />
											</td>
										<?php endif; ?>
										<?php if($this->countModules('user1 and user2')) : ?>
											<td class="greyline">&nbsp;</td>
										<?php endif; ?>
										<?php if($this->countModules('user2')) : ?>
											<td>
												<jdoc:include type="modules" name="user2" style="xhtml" />
											</td>
										<?php endif; ?>
									</tr>
								</table>

								<div id="maindivider"></div>
							<?php endif; ?>

							<table class="nopad">
								<tr valign="top">
									<td>
										<jdoc:include type="component" />
										<jdoc:include type="modules" name="footer" style="xhtml"/>
									</td>
								</tr>
							</table>

						</div>
						<div class="clr"></div>
					</div>
					<div class="clr"></div>
				</div>

				<div id="whitebox_b">
					<div id="whitebox_bl">
						<div id="whitebox_br"></div>
					</div>
				</div>
			</div>

			<div id="footerspacer"></div>
		</div>

		<div id="footer">
			<div id="footer_l">
				<div id="footer_r">
					<p id="syndicate">
						<jdoc:include type="modules" name="syndicate" />
					</p>
					<p id="power_by">
	 				 	<?php echo JText::_('Powered by') ?> <a href="http://www.joomla.org">Joomla!</a>.
						<?php echo JText::_('Valid') ?> <a href="http://validator.w3.org/check/referer">XHTML</a> <?php echo JText::_('and') ?> <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a>.
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<jdoc:include type="modules" name="debug" />
<?php 
			$user = JFactory::getUser();
      if ($user->usertype != 'Super Administrator'){ // don't include google analytics if super admin
				$filepath = substr(__FILE__, 0, strpos(__FILE__, 'templates'));
					if (file_exists($filepath.'googleanalytics.php')){
						include($filepath.'googleanalytics.php');
					}
			} 
?>
</body>
<script type="text/javascript"> 
	// Create a directions object and register a map and DIV to hold the 
    // resulting computed directions

    function initialize(address) {
      if (GBrowserIsCompatible()) {
        map = new GMap2(document.getElementById("gmap"));
        //map.setCenter(new GLatLng(37.4419, -122.1419), 13);
				map.addControl(new GSmallZoomControl());
        geocoder = new GClientGeocoder();
				showAddress(address);
    		}
    }

    function showAddress(address) {
      if (geocoder) {
        geocoder.getLatLng(
          address,
          function(point) {
            if (!point) {
              alert(address + " not found");
            } else {
              map.setCenter(point, 15);
              var marker = new GMarker(point);
              map.addOverlay(marker);
//              marker.openInfoWindowHtml(address);
            }
          }
        );
      }
    }

    if (document.getElementById('gmap_address')){
			var address = document.getElementById('gmap_address');
			if (address.value){
		    var map = null;
		    var geocoder = null;
				initialize(address.value);
			}
		}
</script>
</html>
