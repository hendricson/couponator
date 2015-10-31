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

/**
 * A custom error object for handling SoapFaults
 * 
 */
class SoapError
{
    public $sCode = '';
    public $sString = '';
    public $sDetails = '';
    
    /**
     * Constructor
     * 
     * @access public
     * @param object $oSoapFault
     * @param string $sFunctionName
     * @return SoapError
	 */
    function SoapError($oSoapFault, $sFunctionName)
    {
        if (!empty($oSoapFault)) {
            $this->sCode    = $oSoapFault->faultcode;
            $this->sString  = $oSoapFault->faultstring;
            $this->sDetails = $sFunctionName . ': ' . (!empty($oSoapFault->detail) ? $oSoapFault->detail->ApiException->message : 'No error message available');
        }
    }
}