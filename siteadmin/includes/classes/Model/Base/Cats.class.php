<?php

class Model_Base_Cats
{ 

	/**
     * PEAR::DB object
     * @var DB_common
     */
    private $mDb;
    
    /**
     * categories table
     */
    private $mTbCats;
	
    /**
     * Constructor
     *
     * @param array  $dbObj        global objects array
     * @return void
     */
    public function __construct(&$gDb)
    {
        $this -> mDb         =& $gDb;
        $this -> mTbCats  = TB . 'cats'; 
        $this -> mTbCompanies  = TB . 'companies'; 
    }  	 
    
     /**
    * Get Categories List by parent field
    *
    * @param int $parent - value of parent field
    * @param int $active - if 1 - show only active elements, if 0 - show all
    * @param string $sort - sort output by this field (default: "sortid, name")
    * @return array - hash with values
    */
    function GetCatsList($parent = 0, $active = 1, $sort = '' )
    {
        if (trim($sort) == '')
            $sort = 'sortid, name';
        
        $sql  = 'SELECT c.* FROM '.$this -> mTbCats.' AS c WHERE parent = "'.$parent.'"';
     
        if ($active == 1)
            $sql .= ' AND active = 1';
        
        $sql .= ' ORDER BY '.$sort;
      
        $db   =& $this -> mDb -> query($sql);
        $res  = array();
        while ($row = $db -> fetchRow())
        {
            $row['name'] = stripslashes($row['name']);
            $row['number_ads'] = $this->getNumberAds($row['id']);
            $res[]       = $row;
        }
        
        foreach ($res as &$cat) {	
    		$cat['path'] = $this->buildCatPath($cat['id']);
    	}

        return $res;

    }#GetCatList
    
    private function getNumberAds($cat_id) {
    	$result = 0;
    	$q = 'SELECT COUNT(*) FROM '.$this->mTbCompanies.' WHERE id_cat = \''.$cat_id.'\'';
    	$result += $this -> mDb ->getOne($q);
    	
    	$q  = 'SELECT id FROM '.$this -> mTbCats.' WHERE parent = "'.$cat_id.'" AND active = 1';        
    	$db   =& $this -> mDb -> query($q);
        $res  = array();
        while ($row = $db -> fetchRow())
        {
            $result += $this->getNumberAds($row['id']);
        }
        return $result;
    	
    }
    
    public function buildCatPath($cid) {
    	$result = '';
    	include_once 'Model/Maintenance/Website.class.php';
        $mAW = new Model_Maintenance_Website($this->mDb); 
    	return implode('/', array_reverse($mAW->buildPath($cid)));
    }
	
}