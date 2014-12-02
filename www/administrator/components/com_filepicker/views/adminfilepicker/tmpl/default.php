<?php 
/**
 * @version 0.1.0 Beta
 * @package Joomla
 * @subpackage FilePicker
 * @author Milton Pfenninger <info@webconstruction.ch>
 * @copyright Copyright (C) 2009 Milton Pfenninger. All rights reserved.
 * @license GNU/GPL
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 3 of the License, or (at your option) any later version.
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with this program; if not, see <http://www.gnu.org/licenses/>.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die(); 
?>
<h2>Please donate some money to support the development of File Picker.</h2>
<h3>If you support us with a donation, File Picker will get following functions:</h3>
<ul>
	<li>Secure download of files.</li>
	<li>Download-counter plugin for File Picker.</li>
	<li>Save settings for each user.</li>
	<li>Multi language support</li>
	<li>Advanced file commands: renaming, deleting files/folder and folder creating</li>
	<li>Advanced settings in modal window (optional the Javascript settings)</li>
	<li>Joomla! 1.6 compatible, when it's released.</li>
</ul>
<p>So please donate to make File Picker better. Thank you!</p>
<form action="https://www.paypal.com/en/cgi-bin/webscr" method="post" target="paypal">
	<input type="hidden" name="cmd" value="_donations" />
	<input type="hidden" name="business" value="U78RYN4C42X82" />
	<input type="hidden" name="return" value="http://www.webconstruction.ch/en/thanks.html" />
	<input type="hidden" name="undefined_quantity" value="0" />
	<input type="hidden" name="item_name" value="Donation for Webconstruction.ch" />
	Amount:&nbsp;<input type="text" name="amount" size="4" maxlength="10" value="12" style="text-align:right;" />
<select name="currency_code">
<option value="EUR">EUR</option>
<option value="USD">USD</option>
<option value="GBP">GBP</option>
<option value="CHF">CHF</option>
<option value="AUD">AUD</option>
</select>
	<input type="hidden" name="charset" value="utf-8" />
	<input type="hidden" name="no_shipping" value="1" />
	<input type="hidden" name="image_url" value="http://www.webconstruction.ch/templates/webconstruction/images/default/webconstruction/logo.png" />
	<input type="hidden" name="cancel_return" value="http://www.webconstruction.ch/en/aborted.html" />
	<input type="hidden" name="no_note" value="0" /><br /><br />
		<input type="image" src="http://www.paypal.com/en_US/i/btn/x-click-butcc-donate.gif" name="submit" alt="PayPal secure payments." />
	</form>