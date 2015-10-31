<?php

class Model_Maintenance_AffiliateWindow
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
    
    
    
    public function importCategory ($cat) {
    	
    	$q = "INSERT INTO ".$this -> mTbCat." SET id = '".$cat['id']."',
    									   			parent = '".$cat['parent']."',
    									   			name = '".$cat['name']."',
    									   			alias = '".$cat['alias']."',
    									   			adult = '".$cat['adult']."'";
    	 $sth = $this -> mDb -> query($q);
    	 if (DB::isError($sth)) {
            return $sth;
        }
    }
    
	public function importMerchants ($id_cat) {
    	define('API', 'PS');
    	require_once 'siteadmin/includes/config/affiliatewindow.php';
		require_once 'siteadmin/includes/libs/affiliatewindow/class.ClientFactory.php';
		$oClient = ClientFactory::getClient(API_USERNAME, API_PASSWORD, API_USER_TYPE);
		
		$updated = 0;
		$added = 0;
		
		$listmerchants = array('iCategoryId'=> $id_cat, 'iMaxResult' => 10000, 
		'sColumnToReturn' => array('sStrapline','sDescription','sLogoUrl','sDisplayUrl','sClickThroughUrl','oDiscountCode','oCommissionRange')
		); 
		$oResponse= $oClient->call('getMerchantList', $listmerchants);
		
	
		if (isset($oResponse->oMerchant) && is_array($oResponse->oMerchant)) 
			foreach($oResponse->oMerchant as $details){ 	
			
			$alias = str_replace(' ', '', strtolower($details->sName));
			$alias = str_replace('\'', '', $alias);
			$alias = str_replace('&amp;', '-and-', $alias);
			$alias .= '.html';
			$alias = addslashes($alias);
			$content = "<p>{logoleft} ".$details->sDescription."</p>";
			$q = "SELECT id FROM ".$this->mTbAds." WHERE source = 'aw' AND id_source = '".$details->iId."' LIMIT 1";
			$t = $this -> mDb -> getRow($q);	
			$id_real = $t['id'];
			$url = !empty($details->sClickThroughUrl) ? $details->sClickThroughUrl : $details->sDisplayUrl;	
	    	if ($id_real > 0) {
	    		$q = "UPDATE ".$this->mTbAds." SET title = '".addslashes($details->sName)."',
	    									   title_breadcrumb = '".addslashes($details->sName)."',
	    									   alias = '".$alias."',
	    									   id_cat = '".$id_cat."',
	    									   meta_title = '".addslashes($details->sName.' - '.$details->sStrapline)."',
	    									   meta_keywords = '".addslashes($details->sName)."',
	    									   meta_description = '".addslashes($details->sDescription)."',
	    									   strapline = '".addslashes($details->sStrapline)."',
	    									   displayurl = '".addslashes($details->sDisplayUrl)."',
	    									   clickthroughurl = '".addslashes($details->sClickThroughUrl)."',
	    									   logourl = '".addslashes($details->sLogoUrl)."'   									    
	    									   WHERE source = 'aw' AND id_source = '".$details->iId."'";
		    	$sth = $this -> mDb -> query($q);
		    	if (DB::isError($sth)) {
		            return $sth;
		        }  else {
		        	$updated++;
		        }  		
	    	} else {
	    		$q = "INSERT INTO ".$this->mTbAds." SET 
	    									   title = '".addslashes($details->sName)."',
	    									   title_breadcrumb = '".addslashes($details->sName)."',
	    									   alias = '".$alias."',
	    									   content = '".addslashes($content)."',
	    									   id_cat = '".$id_cat."',
	    									   meta_title = '".addslashes($details->sName.' - '.$details->sStrapline)."',
	    									   meta_keywords = '".addslashes($details->sName)."',
	    									   meta_description = '".addslashes($details->sDescription)."',
	    									   strapline = '".addslashes($details->sStrapline)."',
	    									   displayurl = '".addslashes($details->sDisplayUrl)."',
	    									   clickthroughurl = '".addslashes($details->sClickThroughUrl)."',
	    									   logourl = '".addslashes($details->sLogoUrl)."',
	    									   source = 'aw',
	    									   id_source = '".$details->iId."'";
		    	$sth = $this -> mDb -> query($q);
		    	if (DB::isError($sth)) {
		       //     return $sth;
		        } else {
		        	$added++;
		        }  
		        $q = "SELECT id, displayurl, clickthroughurl FROM ".$this->mTbAds." WHERE source = 'aw' AND id_source = '".$details->iId."'";
	    		$t = $this->mDb->getRow($q);
	    		$id_real = $t['id'];
	    		$url = !empty($t['clickthroughurl']) ? $t['clickthroughurl'] : $t['displayurl'];  		
	    	}
	    
	    	if (isset($details->oDiscountCode) && is_object($details->oDiscountCode)) $details->oDiscountCode = array($details->oDiscountCode);
	    	if (isset($details->oDiscountCode) && is_array($details->oDiscountCode)) {
	    		$q = "DELETE FROM ".$this->mTbVch." WHERE source = 'aw' AND id_company = '".$id_real."'";
	    		$sth = $this -> mDb -> query($q);
	    		foreach ($details->oDiscountCode as $i => $oDiscountCode) {
	    			if (is_object($oDiscountCode)) {
	    				$code = str_replace('n/a', '', $oDiscountCode->sCode);
	    				//$url = '';
	    				if (isset($oDiscountCode->sUrl)) {
		    				$t = explode('&p=', $oDiscountCode->sUrl);
		    				if (count($t) == 2) $url = $t[1];
	    				}
	    				
	    				$discount = '';
	    				if (preg_match("/[0-9]+%/", $oDiscountCode->sDescription, $matches)) {
							$discount = str_replace('%', '', $matches[0]);
						}
				   				
	    				$q = "INSERT INTO ".$this->mTbVch." SET title = '".addslashes($oDiscountCode->sDescription)."',
	    									   code = '".$code."',
	    									   id_company = '".$id_real."',
	    									   url = '".$url."',
	    									   discount = '".$discount."',
	    									   start_date = '".$oDiscountCode->sStartDate."',
	    									   end_date = '".$oDiscountCode->sEndDate."',
	    									   source = 'aw'";    
	    	$sth = $this -> mDb -> query($q);
	    	if (DB::isError($sth)) {
	        //    return $sth;
	        } 								
	    			}
	    		}
	    	}
		} else {
			$q = "UPDATE ".$this->mTbCat." SET active = '0' WHERE id_cat = '".$id_cat."'";
		    $sth = $this -> mDb -> query($q);			
		}
		echo "Updated listings: ".$updated."<br /> Added listings:".$added."<hr />";
    }
        
	public function showMerchant ($id) {
    	define('API', 'PS');
    	require_once 'siteadmin/includes/config/affiliatewindow.php';
		require_once 'siteadmin/includes/libs/affiliatewindow/class.ClientFactory.php';
		$oClient = ClientFactory::getClient(API_USERNAME, API_PASSWORD, API_USER_TYPE);
				
		$listmerchants = array('iMerchantId'=> $id, 
		'sColumnToReturn' => array('sStrapline','sDescription','sLogoUrl','sDisplayUrl','sClickThroughUrl','oDiscountCode','oCommissionRange')
		); 
			
		$oResponse= $oClient->call('getMerchant', $listmerchants);
   	 
	
    }    

    public function getCategories() {
    	$sql = 'SELECT * FROM '.$this->mTbCat.' WHERE active = 1 AND source = \'aw\'';
        $db = $this -> mDb -> query($sql);
      
		$result = array();
        while ($row = $db -> FetchRow())
        {
            $result[] = $row;
        }
        return $result;  
    }



}

?>