<?php
/**
*
* DigitalWindow API Client
*
* Copyright (C) 2008 Digital Window Ltd.
*
* This program is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License
* as published by the Free Software Foundation; either version 2
* of the License, or (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*
*/

/**
 * Creates and returns the appropriate SOAP client for the current version of PHP
 */
class ClientFactory
{
	/**
	 * Creates and returns the appropriate SOAP client for the current version of PHP
	 *
	 * @param void
	 * @return object
	 */
	public static function getClient()
	{
		// create user object
		$oUser = new stdClass();

		// IF api key is used, add only that to user object
		if (API == 'PS') {
		    $oUser->sApiKey = API_KEY;
		}
		else {
		    $oUser->iId = API_USERNAME;
    		$oUser->sPassword = API_PASSWORD;
    		$oUser->sType = API_USER_TYPE;
		}

		// get PHP ver
		$iPhpVer= str_replace('.', '', phpversion());

		// PHP5 (only 5.0.5 onwards has __setSoapHeaders)
		if (class_exists('SoapClient') && $iPhpVer>505) {

			// use PHP5 ext
			require_once('class.php5Client.php');

			$oClient =& Php5Client::getInstance($oUser);
		}
		// Check soap is installed. If not, dispaly error message //
		elseif ($iPhpVer>505) {
			die('You are missing the PHP SoapClient. Please re-compile PHP with Soap enabled.');
		}
		// no SOAP client could be initialized
		else {
			die('AffiliateWindow APIs will only work with PHP5 and above. Please reinstall');
		}

		return $oClient;
	}
} // end class