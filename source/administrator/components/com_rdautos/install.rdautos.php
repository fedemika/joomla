<?php 

defined('_JEXEC') or die ('No Access to this File');

function com_install() {
	
?>

<h3>Congratulations! RD-Autos for Joomla! 1.5 is ready to go!</h3>
Thank you for downloading RD-Autos, but also installing it! Undoubtly you are about to embark on many joyous hours of authoring
and organizing all the best cars for your city. <br><b>Get started:</b> 
Navigate to Components > RD-Autos > Configuration. Here you will need to set some settings for your component.<br>
After you're done at the Configuration Screens go to the menu again and add some vehicle makes and models to get it work properly.<br> 
When having some Makes and models in your Database stored, go to the Car Manager and click on the NEW button!<br>
<br>
<h3>Help us to get the project running!</h3><br>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="image" src="https://www.paypal.com/nl_NL/NL/i/btn/x-click-butcc-donate.gif" border="0" name="submit" alt="PayPal, de veilige en complete manier van online betalen.">
<img alt="" border="0" src="https://www.paypal.com/nl_NL/i/scr/pixel.gif" width="1" height="1">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
</form>
<br>
<h3>Thank you notes!</h3>
Special thank you goes out to: <b>Ramiz (Germany), Ersun (Turkey), Stefan (Sweden), Victor (Canada)</b><br>
Offcourse would like to say thank you to all donators and translators for making this component an international one!<br>

<?php
}
?>