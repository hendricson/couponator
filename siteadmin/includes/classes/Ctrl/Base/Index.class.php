<?php

class Ctrl_Base_Index extends Ctrl_Base 
{
    public function __construct(&$glObj )
    {
    	parent :: __construct($glObj); 
    }
    
    public function Index () {	
    	
    	// get cats and subcats
        include_once 'Model/Base/Cats.class.php';
        $mDict = new Model_Base_Cats($this->mDb);
    	$cl = $mDict ->GetCatsList(0, 1, 'sortid, name ASC');
    	
    	foreach ($cl as $cat)
        {              
           $pl[$cat['id']] = $mDict->GetCatsList($cat['id'], 1, 'name');

           if(empty($pl[$cat['id']]))
           {
               $pl[$cat['id']] = $mDict->GetCatsList($cat['id']);
           }
 
        }
        
    	include_once 'View/Base/Index.class.php';
        $view = new View_Base_Index($this->mlObj, 'Base/Index'); 
        $view->assign('cl', $cl);
        $view->assign('pl', $pl);
    	$view->display('homepage.php');
    }
}

?>