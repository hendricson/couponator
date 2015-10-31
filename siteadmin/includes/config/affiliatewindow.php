<?php
/**
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
 */

// Enables or disables the WSDL caching feature. 
// @see http://uk3.php.net/manual/en/soap.configuration.php#ini.soap.wsdl-cache-enabled
ini_set("soap.wsdl_cache_enabled", 0);

// Constants for both APIs
define('API_VERSION', 3);
define('API_USER_TYPE', 'affiliate'); // (affiliate || merchant)

// AW API constants
define('API_PASSWORD', ''); // You API password (found in your userarea)
define('API_USERNAME', ''); // You affiliate || merchant ID (e.g: 12345) - is not necessary

define('AW_WSDL', 'http://api.affiliatewindow.com/v'.API_VERSION.'/'.ucfirst(API_USER_TYPE).'Service?wsdl');
define('AW_NAMESPACE', 'http://api.affiliatewindow.com/');
define('AW_SOAP_TRACE', false);	// turn OFF when finished testing

// PS API constants
define('API_KEY', ''); // You API key - Found in your account

define('PS_WSDL', 'http://v'.API_VERSION.'.core.com.productserve.com/ProductServeService.wsdl');
define('PS_NAMESPACE', 'http://api.productserve.com/');
define('PS_SOAP_TRACE', false);	// turn OFF when finished testing

// Set more constants based on API choice
if (API=='AW') {
	define('API_WSDL', AW_WSDL);
	define('API_NAMESPACE', AW_NAMESPACE);
	define('API_SOAP_TRACE', AW_SOAP_TRACE);
}
elseif (API=='PS') {
	define('API_WSDL', PS_WSDL);
	define('API_NAMESPACE', PS_NAMESPACE);
	define('API_SOAP_TRACE', PS_SOAP_TRACE);
}
else {
	die('You HAVE to select the appropriate api (AW/PS)');
}
