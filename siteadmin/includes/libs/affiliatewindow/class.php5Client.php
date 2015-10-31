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

require_once('class.SoapError.php');

/**
 * PHP5: Extends SoapClient and automatically configures settings specific to the AWin API
 *
 */
class Php5Client extends SoapClient
{
    /**
     * Instance of the PHP5 soap client (itself)
     *
     * @var object
     */
	private static $oInstance = false;
	
	/**
	 * Holds any errors produced during a SOAP request
	 *
	 * @var object
	 */
	public $oSoapError = false;

	/**
	 * The Constructor
	 *
	 * @copyright DigitalWindow
 	 * @access    public
 	 *
	 * @param object - $oUser - the user object with login details
	 */
	public function __construct($oUser)
	{
		// create client
		parent::__construct(API_WSDL, array('trace'=>API_SOAP_TRACE, 'compression'=> SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE) );
		
		// create headers
		$oHeader  = new SoapHeader(API_NAMESPACE, 'UserAuthentication', $oUser, true, API_NAMESPACE);
		$aHeaders = array($oHeader);
		
		// getQuota only used on APIs which do not use a single API Key
		if (empty($oUser->sApiKey)) {
		    $aHeaders[] = new SoapHeader(API_NAMESPACE, 'getQuota', true, true, API_NAMESPACE);
		}
		
		// set headers
		$this->__setSoapHeaders($aHeaders);
		
		// set WSDL caching
		ini_set("soap.wsdl_cache_enabled", 1);
		ini_set('soap.wsdl_cache_ttl', 86400);
		
		// set server response timeout
		ini_set('default_socket_timeout', 240);
	}
	
	/**
	 * Singleton function
	 *
	 * @copyright DigitalWindow
 	 * @access    public
 	 *
	 * @param 	object - $oUser - the user object with login details
	 * 
	 * @return object - an instance of the class
	 */
	public static function &getInstance($oUser)
	{
        $sClassName =  __CLASS__;
	
		// only create new instance if necessary
		if (!self::$oInstance) {
			self::$oInstance = new $sClassName($oUser);
		}

		return self::$oInstance;
	}

	/**
	 * Executes the speficied function from the WSDL
	 *
	 * @copyright	DigitalWindow
	 * @access 	public
	 *
	 * @param 	string 	$sFunctionName the name of the function to be executed
	 * @param 	mixed 	$mParams [optional] the parameters to be passed to the function, can be array or single value
	 *
	 * @return 	mixed 	the results or a SoapError object
	 */
	public function call($sFunctionName, $mParams='')
	{
		// catch any exceptions
		try {
			return $this->$sFunctionName($mParams);
		}
		catch(SoapFault $e) {
			$this->oSoapError = new SoapError($e, $sFunctionName);

			$error = $this->oSoapError;
		}
		
		return $error;
	}

	/**
	 * Gives the remaining operations quota
	 *
	 * @copyright DigitalWindow
	 * @access 	  public
	 *
	 * @return 	int - the remaining operations quota
	 */
	public function getQuota()
	{
	    $aMatches  = array();
		$sResponse = $this->__getLastResponse();

		// use R.Exp. rather than XML parsers, as they might not be installed
		preg_match('/getQuotaResponse>(.*)<\/.*:getQuotaResponse>/', $sResponse, $aMatches);

		$iQuota= $aMatches[1];

		return $iQuota;
	}

} // end class