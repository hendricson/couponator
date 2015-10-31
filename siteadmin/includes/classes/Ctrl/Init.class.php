<?php

class Ctrl_Init extends Ctrl_Base
{	
    public function __construct( $glObj, $what = 0 )
    {
        parent :: __construct( $glObj );
        
        switch ($what)
        {
            case 'admin':
                $this -> InitAdmin( $glObj );
                break;

            case 'index':
                $this -> InitIndex( $glObj );
                break;
        }
    }

    public function InitAdmin( &$glObj )
    {
 
    }


    public function InitIndex( &$glObj )
    {
                
        include_once 'Ctrl/Security/Dispatch.class.php';
        $moDispatch = new Ctrl_Security_Dispatch();

        /** Start Current Controller */
        $moDispatch -> Start( $glObj );
       
        echo $glObj['html'];

    }/** InitBase */

}
?>