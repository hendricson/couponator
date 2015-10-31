<?php

class Ctrl_Maintenance_AffiliateWindow extends Ctrl_Base 
{
    private $mCompanies;
    private $location; 

    public function __construct(&$glObj, $location )
    {
    	parent :: __construct($glObj); 
        $this->mAW = new Model_Maintenance_AffiliateWindow($this->mDb); 
    }
    
    public function ImportCategories () {	
    	$categories = file_get_contents (BPATH.'docs/import/categories.list');
    	$rows = explode('|- style="background:#F5FFFA;' , $categories);
    	$cats = array();
    	foreach ($rows as $i => $row) {
    		if ($i > 0) {
    			$t = array();
    			$data = explode('|align="center"|', $row);
    			if ($data[1] > 0) {
    				$t['id'] = $data[1];
    				$t['name'] = trim($data[2]);
    				$t['alias'] = str_replace(' ', '-', $t['name']);
    				$t['alias'] = str_replace('\'', '', $t['alias']);
    				$t['alias'] = str_replace('&', 'and', $t['alias']);
    				$t['alias'] = str_replace(',', '', $t['alias']);
    				$t['parent'] = $data[4];
    				$t['adult'] = $data[5];
    				$cats[] = $t; 
    			}
    			
    			$t = array();
    			$data = explode('|align="center" style="background:#CEF2E0;"|', $row);
    			if ($data[1] > 0) {
    				$t['id'] = $data[1];
    				$t['name'] = trim($data[2]);
    				$t['alias'] = str_replace(' ', '-', $t['name']);
    				$t['alias'] = str_replace('\'', '', $t['alias']);
    				$t['alias'] = str_replace('&', 'and', $t['alias']);
    				$t['alias'] = str_replace(',', '', $t['alias']);    				
    				$t['parent'] = $data[4];
    				$t['adult'] = $data[5]; 
    				$cats[] = $t; 
    			}
    		}
    	}
    	
    	foreach ($cats as $i => $cat) {
    		$this->mAW->importCategory($cat);
    	}
    	
    }
    
    public function ImportMerchants() {
    	$ids = $_REQUEST['ids'];
 
    	if (is_array($ids) && count($ids) > 0) {
    		foreach ($ids as $i => $id) {
    			if ($id > 0) {
    				$this->mAW->importMerchants($id);
    			}
    		}
    	}
    }
    
    public function ShowMerchant() {
    	$id = $_REQUEST['id'];
 
    	if ($id > 0) {
    		$this->mAW->showMerchant($id);
    	}
    }    
    
    public function GenerateCronFile() {
    	$ids = $_REQUEST['ids'];
    	
    	$categories = $this->mAW->getCategories();
    	
    	$result = "#!/bin/sh\r\n";
    	
    	$result .= "echo \"Doing some general cron tasks...\"\r\n";
    	$result .= "wget -O - -q -t 1 \"".SITE_URL."/index.php?type=maintenance&mod=website&what=generalCron\"\r\n";
 
    	if (is_array($categories) && count($categories) > 0)
    	foreach ($categories as $category) {
    		$result .= "echo \"Opening category #".$category['id']."\"\r\n";
    		$result .= "wget -O - -q -t 1 \"".SITE_URL."/index.php?type=maintenance&mod=affiliatewindow&what=ImportMerchants&ids[]=".$category['id']."\"\r\n";	
    		$result .= "sleep 1\r\n";
    	}
    	
    	$fp = fopen('awupdate.sh', 'w');
	    fwrite($fp, $result);
	    fclose($fp);
	    
	    echo "OK";
    }    
}
