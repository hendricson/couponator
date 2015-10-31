<?php

class Model_Maintenance_Website
{
    private $mDb;
    private $mTbAds;
    private $mTbCat;


    public function __construct(&$gDb )
    {
        $this -> mDb       = $gDb;

        $this -> mTbAds      = TB . 'companies';
        $this -> mTbCat      = TB . 'cats'; 
        $this -> mTbVch      = TB . 'vouchers'; 

    }
    
    public function getCompanies() {
    	$companies = array();
    	    $q = "SELECT c.id, c.id_cat, c.alias, c.title FROM ".$this->mTbAds." AS c
LEFT JOIN ".$this->mTbCat." AS cat ON cat.id = c.id_cat
ORDER BY cat.name DESC";
    		$res = $this->mDb->query($q);
    		 while($row = $res->fetchRow())
            {
                $companies[$row['id_cat']][] = $row;
            }
       
            return $companies;
    }
    
    public function addLinkToXML($path, $priority = 0.5) {
    	$result = "<url>\r\n";
		$result .= '<loc>'.$path."</loc>\r\n";
		$result .= '<lastmod>'.date("Y-m-d")."</lastmod>\r\n";
		$result .= "<changefreq>weekly</changefreq>\r\n";
		$result .= "<priority>$priority</priority>\r\n";
		$result .= "</url>\r\n";
		return $result;	
    }
    
    public function buildPath($id_cat) {
    	$pa = array();
    	if ($id_cat > 0) {
    		$q = "SELECT alias, parent, name FROM ".$this->mTbCat." WHERE id = '".$id_cat."' LIMIT 1";
			$cat = $this -> mDb -> getRow($q);
			$pa[] = $cat['alias'];
			if ($cat['parent'] > 0)	$pa = array_merge($pa, $this->buildPath($cat['parent']));
    	}
    	return $pa; 
    }
    
    public function loadTree() {
    	$pa = array();
    	$parents = array();
    	$result = array();
    	
    	$q = "SELECT id, alias, parent, name FROM ".$this->mTbCat."";
    	$db = $this -> mDb -> query($q);
    		
    	while ($row = $db -> FetchRow())
	    {
	    	$t = array('alias' => $row['alias'], 'name' => $row['name'], 'id' => $row['id'], 'id_parent' => $row['parent'], 'path' => $row['alias'], 'level' => 0);
	        if ($row['parent'] == 0) {
	        	$parents[] = $t;	
	        } else {
	        	$pa[$row['parent']][] = $t;	
	        }
	    }
	        
	    return $this->buildTree($pa, $parents, '', 0); 
    }
    
    public function buildTree($list, $parent, $path, $level) {
    	$tree = array();
    	foreach ($parent as $k => $l) {
    		$l['path'] = !empty($path) ? $path.'/'.$l['path'] : $l['path'];	
    		$l['level'] = $level + 1;
    		if (isset($list[$l['id']])) {  			
    			$l['children'] = $this->buildTree($list, $list[$l['id']], $l['path'].$list[$l['id']]['path'], $l['level']);    			
    		}
    		$tree[] = $l;
    	}
    	return $tree; 
    } 
    
    public function deleteOutdatedCoupons() {
    	$q = "DELETE FROM ".$this->mTbVch." WHERE end_date < NOW()";
    	$sth = $this -> mDb -> query($q);
    	if (DB::isError($sth)) {
            return $sth;
        } 			
    }   

}

?>