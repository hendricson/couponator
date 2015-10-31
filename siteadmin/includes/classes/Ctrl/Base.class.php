<?php

abstract class Ctrl_Base
{
    /**
     * full obj list
     */
    protected $mlObj;

    /**
     * Db Pointer
     * */
    protected $mDb;
    
    /** Admin area status */
    protected $mItAdmin; 


    public function __construct( &$glObj )
    {
        $this -> mlObj    =& $glObj;
        $this -> mDb      =& $this -> mlObj['gDb'];
        $this -> mItAdmin = !empty($glObj['itAdmin']) ? 1 : 0;
       
    }


}
?>