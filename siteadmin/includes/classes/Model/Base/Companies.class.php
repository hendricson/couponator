<?php

class Model_Base_Companies
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
        
    public function getIDs () {
    	global $glObj;
    	$cat = '';
    	$page = '';
    	$catname = '';
    	$sidebar = '';
    	$breadcrumbs = '';
    	$breadcrumbs_link = 'index.php?type=base&mod=companies&cat=';

    	if (preg_match('/^[0-9a-z:()\/-]+$/i', strtolower($_REQUEST['cat']))) $cat = $_REQUEST['cat'];   	
    	if (isset($_REQUEST['page']) && preg_match('/^[0-9a-z\.\-_\(\)]+$/i', $_REQUEST['page'])) $page = $_REQUEST['page'];
    	if (!empty($cat)) {
    		$cats = explode('/', $cat);
    		
    		$id_cat = 0;
    		$id_company = 0;
    		foreach ($cats as $k => $name) {
    			$q = "SELECT id, name, sidebar FROM ".$this->mTbCat." WHERE alias = '".$name."' AND parent = '".$id_cat."'";
    			$row = $this->mDb->getRow($q);
        		$id_cat = $row['id']; 
        		$breadcrumbs_link .= $name;
        		$t = $breadcrumbs_link;
 
        		if ($k < count($cats) - 1) {
        			$breadcrumbs_link .= '/';	
        		}

        		$breadcrumbs .= ' &raquo; ';
        		if ($k == count($cats) - 1) {
        			$catname = $row['name'];
        			$sidebar = $row['sidebar'];
        		}
        		$breadcrumbs .= empty($page) && $k == count($cats) - 1 ? $row['name'] : '<a href="'.CPRoute::_($t).'" rel="nofollow">'.$row['name'].'</a>';
        		
    		}
    		if (!empty($page)) {
	    		$q = "SELECT id, title_breadcrumb FROM ".$this->mTbAds." WHERE alias = '".$page."' AND id_cat = '".$id_cat."'";
	    		$row = $this->mDb->getRow($q);
	        	$id_company = $row['id'];         	
	        	$breadcrumbs .= ' &raquo; '.$row['title_breadcrumb'];	        	
    		}

    		return array($id_cat, $id_company, $breadcrumbs, $catname, $sidebar);
	    	
    	}
    	
    	return array(null, null, null, null);
    	
    }
    
    public function GetPagesCount($cat, $params = array())
    {
        $sql = 'SELECT COUNT(id) as cnt FROM '.$this->mTbAds.' WHERE id = id';

        if ((int)$cat)
        {
            $sql .= ' AND id_cat = '.(int)$cat;
        }

        if (!empty($params['search']))
        {
            $search = mb_strtolower(mysql_escape_string(strip_tags($params['search'])), 'utf8');
            $sql .= ' AND LOWER(title) LIKE "%'.$search.'%"';
        }

        if(!empty($params['active']) && $params['active'] != -1)
        {
            $sql .= ' AND active = '.$params['active'];
        }

        if(!empty($params['where']))
        {
            $sql .= $params['where'];
        }

        return $this -> mDb -> getOne($sql);
    } 
    
   /**
     * Get list of Ads with pictures
     * @param int $cat - category ID
     * @param int $country - country ID
     * @param int $subcat - subcat ID
     * @param string $sort - sort param, default sorted by pubdate
     * @param int $first - for pagging, from which item
     * @param int $cnt - for pagging, count of returned items
     * @param int $region - region ID
     * @param int $city - city ID
     * @return array
     */
    public function  GetList($cat, $params = array())
    {
        $sql = 'SELECT * FROM '.$this->mTbAds.' WHERE id = id';

        if ((int)$cat)
        {
            $sql .= ' AND id_cat = '.(int)$cat;
        }


        if (!empty($params['search']))
        {
            $search = mb_strtolower(mysql_escape_string(strip_tags($params['search'])), 'utf8');
            $sql .= ' AND LOWER(title) LIKE "%'.$search.'%"';
        }

        if(!empty($params['where']))
        {
            $sql .= $where;
        }

        if(!empty($params['where']) && $params['active'] != -1)
        {
            $sql .= ' AND active = '.$params['active'];
        }


        $sql .= !empty($params['sort']) ? ' ORDER BY '.$params['sort'] : ' ORDER BY title ASC';
        
        $r = array();
        if (isset($params['cnt']) && isset($params['first']))
        {
            $db = $this -> mDb -> limitQuery($sql, $params['first'], $params['cnt']);
        }
        else
        {
            $db = $this -> mDb -> query($sql);
        }
        
        include_once 'Model/Base/Cats.class.php';
        $mDict = new Model_Base_Cats($this->mDb);

        while ($row = $db -> FetchRow())
        {
            $row['path'] = $mDict -> buildCatPath($row['id_cat']);
            $r[] = $row;
        }

        return $r;
    }       


    public function Get($id)
    {
        $sql = 'SELECT * FROM '.$this->mTbAds.' WHERE id = ?';
        $row = $this->mDb->GetRow($sql, array($id));

        return $row;
    }
    
    public function getVouchers($id)
    {
        $sql = 'SELECT v.*, c.title_breadcrumb AS company_name FROM '.$this->mTbVch.' AS v
        LEFT JOIN '.$this->mTbAds.' AS c ON c.id = v.id_company 
        WHERE v.id_company = ? AND v.start_date < NOW() AND v.end_date > NOW() ORDER BY v.end_date ASC';
        $db = $this -> mDb -> query($sql, array($id));
      
		$result = array();
        while ($row = $db -> FetchRow())
        {
            $result[] = $row;
        } 
        
        return $result;
    }
    
    public function getVoucher($id)
    {
        $sql = 'SELECT v.*, c.title_breadcrumb AS company_name FROM '.$this->mTbVch.' AS v
        LEFT JOIN '.$this->mTbAds.' AS c ON c.id = v.id_company 
        WHERE v.id = ? AND v.start_date < NOW() AND v.end_date > NOW() LIMIT 1';

        $db = $this -> mDb -> query($sql, array($id));
      
		$result = array();
        while ($row = $db -> FetchRow())
        {
            $result[] = $row;
        } 
        
        if (count($result) >= 1) return $result[0];
        
        return null;
    }

}

?>