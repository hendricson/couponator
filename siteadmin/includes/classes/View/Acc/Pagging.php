<?php

class Pagging extends View_Base 
{
    private $mResOnPage; //Results on page
    private $mEcount;    //total number of items
    private $mPageLink;  //Link for pages
    private $mPage;      //Current page
    private $mPageMax;   //Max pagging items on page

    public function __construct(&$glObj, $location, $ResOnPage  = 10, $Ecount = 0, $page = 1, $link = '')
    {
        $this -> mResOnPage     =  $ResOnPage;
        $this -> mEcount        =  $Ecount; //total number of items
        $this -> mPageLink      =  $link;
        $this -> mPageMax       =  8; 
        
        if (!is_numeric($page) || $page == 0)
        {
            $page = 1;
        }    
        $this -> mPage          = $page;
        
        parent :: __construct($glObj, $location); 
    }#Pagging


    public function &Make()
    {       
  
        $pages = '';
        if ($this -> mEcount < $this -> mResOnPage || $this -> mResOnPage == 0)
        {
            $this -> assign('pages', array());
        	$pages = $this -> fetch('_pagging.php');
        	return $pages;	
        }

        $range    = $this -> GetRange();
               
        $range[]  = $this -> mEcount;
        $this -> assign('range', $range);
        $this -> assign('page' , $this -> mPage);

        $link = $this -> mPageLink;
        $link .=  ( strpos($link, '?') > 0 ) ? '&' : '?';
        #make list
        $k   = 0;
        $i   = 1;
        $res = array();

        $fl = 1;
        $lr = 8;  
        if (($this -> mEcount / $this -> mResOnPage) > $this -> mPageMax && $this -> mPage >= $this -> mPageMax - 1)
        {
        	if (floor(($this -> mPage + 1) / $this -> mPageMax) == (($this -> mPage + 1) / $this -> mPageMax))
        	{
        		$fl = $this -> mPage - ($this -> mPageMax / 2);
        		$lr = $this -> mPage + $this -> mPageMax - ($this -> mPageMax / 2); 
        	}
        	else 
        	{
                $fl = floor($this -> mPage / $this -> mPageMax) * $this -> mPageMax  - 1;
                if ($this -> mPage < $fl + ($this -> mPageMax / 2) - 1)
                {
                	$fl = $fl - ($this -> mPageMax / 2);
                }
                $lr = $fl + $this -> mPageMax;   		
        	}
        }

        $this -> assign( 'last_page', '' );
        $this -> assign( 'last_page_link',  '' );
        $this -> assign('lprev', '');
        $this -> assign('lnext', '');
        
        if (1 < $this -> mPage)
        {
        	$this -> assign('lprev', $link.'p='.($this -> mPage - 1));
        }
        if ($this -> mPage < (ceil($this -> mEcount / $this -> mResOnPage)))
        {
        	$this -> assign('lnext', $link.'p='.($this -> mPage + 1));
        	if ( $lr < (ceil($this -> mEcount / $this -> mResOnPage)) )
        	{
        	    $this -> assign( 'last_page', ceil($this -> mEcount / $this -> mResOnPage) );
                $this -> assign( 'last_page_link',  $link.'p='.ceil($this -> mEcount / $this -> mResOnPage) );        	    
        	}
        }
            
      
        while ($k < $this -> mEcount)
        {
            if ($i > $lr)
            {
            	break;
            }
            if ($i >= $fl && $i <= $lr)
            {
        	    $res[] =  array('page' => $i, 'link' => $link.'p='.$i);
            }    
            $k     += $this -> mResOnPage;
            $i ++;
        }

        $this -> assign('pages', $res);
        $this -> assign('limit', $this->mResOnPage);
        
        $pages = $this -> fetch('_pagging.php');
               
        return $pages;

    }#Make

    
    public function &Make2()
    {
        $pages = '';
        if ($this -> mEcount < $this -> mResOnPage || $this -> mResOnPage == 0)
        {
            return $pages;
        }
    

        $range    = $this -> GetRange();
        $range[]  = $this -> mEcount;
        $this -> assign('range', $range);
        $this -> assign('page' , $this -> mPage);

        $link = $this -> mPageLink;
        $link .=  ( strpos($link, '?') > 0 ) ? '&' : '?';
        
        #make list
        $k   = 0;
        $i   = 1;
        $res = array();

        $fl = 1;
        $lr = 8;  
        if (($this -> mEcount / $this -> mResOnPage) > $this -> mPageMax && $this -> mPage >= $this -> mPageMax - 1)
        {
        	if (floor(($this -> mPage + 1) / $this -> mPageMax) == (($this -> mPage + 1) / $this -> mPageMax))
        	{
        		$fl = $this -> mPage - ($this -> mPageMax / 2);
        		$lr = $this -> mPage + $this -> mPageMax - ($this -> mPageMax / 2); 
        	}
        	else 
        	{
                $fl = floor($this -> mPage / $this -> mPageMax) * $this -> mPageMax  - 1;
                if ($this -> mPage < $fl + ($this -> mPageMax / 2) - 1)
                {
                	$fl = $fl - ($this -> mPageMax / 2);
                }
                $lr = $fl + $this -> mPageMax;   		
        	}
        }
        
        if (1 < $this -> mPage)
        {
        	$this -> assign('lprev', ($this -> mPage - 1));
        }
        if ($this -> mPage < (ceil($this -> mEcount / $this -> mResOnPage)))
        {
        	$this -> assign('lnext', ($this -> mPage + 1));
        }
            
        while ($k < $this -> mEcount)
        {
            if ($i > $lr)
            {
            	break;
            }
            if ($i >= $fl && $i <= $lr)
            {
        	    $res[] =  array('page' => $i, 'link' => $i);
            }    
            $k     += $this -> mResOnPage;
            $i ++;
        }
        $this -> assign('pages', $res);
        $pages = $this -> fetch('_pagging.php');
        return $pages;

    }#Make2
    
    
    public function &GetRange()
    {
        $res[0] = ($this -> mPage - 1) * $this -> mResOnPage;
        $res[1] =  $this -> mPage * $this -> mResOnPage;
        if ($res[1] > $this -> mEcount)
            $res[1] = $this -> mEcount;
        return $res;

    }#GetRange
       
}#end class