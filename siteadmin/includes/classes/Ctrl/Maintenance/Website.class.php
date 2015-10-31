<?php

class Ctrl_Maintenance_Website extends Ctrl_Base 
{
    private $mCompanies;
    private $location; 

    public function __construct(&$glObj, $location )
    {
    	parent :: __construct($glObj); 
        include_once 'Model/Maintenance/Website.class.php';
        $this->mAW = new Model_Maintenance_Website($this->mDb); 
    }
    
    public function generalCron() {
    		
    	$this->mAW->deleteOutdatedCoupons();
    }
    
    public function generateSitemap () {	
    	$staticPages = array(
	    	array('title' => 'Home page', 'url' => SITE_URL, 'priority' => '1.00'),
	    	array('title' => 'About us', 'url' => SITE_URL.'about-us.php', 'priority' => '0.80'),
	    	array('title' => 'Contact us', 'url' => SITE_URL.'contact-us.php', 'priority' => '0.80'),
	    	array('title' => 'Terms and Conditions', 'url' => SITE_URL.'terms-and-condition.php', 'priority' => '0.80'),
	    	array('title' => 'Privacy Policy', 'url' => SITE_URL.'privacy-policy.php', 'priority' => '0.80'),
	    	array('title' => 'Sitemap', 'url' => SITE_URL.'sitemap.php', 'priority' => '0.80'), 	
    	);
    	$result = '<?xml version="1.0" encoding="UTF-8"?>'."\r\n";
		$result .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\r\n";
		
		$companies = $this->mAW->getCompanies();//list of companies grouped by cat ID

		$html = '<ul class="sitemaplist">';
		foreach ($staticPages as $i => $page) {
			$html .= '<li><a href="'.$page['url'].'">'.$page['title'].'</a></li>';
			$result .= $this->mAW->addLinkToXML($page['url'], $page['priority']);
		}
		
		$pa = $this->mAW->loadTree();

   		foreach (new RecursiveIteratorIterator(new RecursiveArrayIterator($pa), RecursiveIteratorIterator::SELF_FIRST) as $k => $v) {
   			if (is_array($v) && isset($v['id'])) {
   				if ($v['level'] > $last_level) {
   					for ($i = $last_level; $i < $v['level']; $i++) {
   						$html .= "<li><ul>";
   					}
   					$last_level = $v['level'];	
   				} elseif ($v['level'] < $last_level) {
   					//$html .= "</li></ul>";	
   					for ($i = $v['level']; $i < $last_level; $i++) {
   						$html .= "</li></ul>";
   					}
   					$last_level = $v['level'];
   				}	
   				$html .= '<li><a href="'.SITE_URL.'/'.$v['path'].'/">'.$v['name'].'</a></li>';	
   				$result .= $this->mAW->addLinkToXML(SITE_URL.$v['path'].'/');
   				if (count($companies[$v['id']]) > 0) {	
		   			foreach ($companies[$v['id']] as $i => $company) {
		   				$html .= '<li><a href="'.SITE_URL.'/'.$v['path'].'/'.$company['alias'].'" style="color:#505050;">'.$company['title'].'</a></li>';
		   				$result .= $this->mAW->addLinkToXML(SITE_URL.'/'.$v['path'].'/'.$company['alias']);
		   			}
   				}
	   			
   			}
   		}
   		$html .= '</ul>';
   		
   		$sitemap = file_get_contents(BPATH.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'Maintenance'.DIRECTORY_SEPARATOR.'Website'.DIRECTORY_SEPARATOR.'sitemap.php');
   		$sitemap = str_replace('[SITEMAP]', $html, $sitemap);
   		
   		$fp = fopen(BPATH.DIRECTORY_SEPARATOR.'sitemap.php', 'w');
	    fwrite($fp, $sitemap);
	    fclose($fp);
	    
    	$result .= "</urlset>\r\n";
    	header('Content-type: text/xml');
    	echo $result;
    	$fp = fopen(BPATH.DIRECTORY_SEPARATOR.'sitemap.xml', 'w');
	    fwrite($fp, $result);
	    fclose($fp);
   		
    	return $result;
    }

    public function generateHTACCESS () {	
   		
   		$file = file_get_contents(BPATH.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'Maintenance'.DIRECTORY_SEPARATOR.'Website'.DIRECTORY_SEPARATOR.'.htaccess');
   		$file = str_replace('[SITE_URL]', SITE_URL, $file);
   		$file = str_replace('[PATH_ROOT]', PATH_ROOT, $file);
   		
   		$fp = fopen(BPATH.DIRECTORY_SEPARATOR.'.htaccess', 'w');
	    fwrite($fp, $file);
	    fclose($fp);
	    
	    echo "OK";
	    
    }    
   

}
