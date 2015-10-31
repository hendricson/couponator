<?php

class View_Base_Companies extends View_Base 
{
    public function __construct(&$glObj, $location )
    {
    	parent :: __construct($glObj, $location); 
    }
    
    public function readmorize($text) {
	if (strpos($text, '<hr id="system-readmore" />') !== false) {	
		$t = explode('<hr id="system-readmore" />', $text);
	return '<div class="readmore-on">'.
	trim($t[0])
	.'<span class="readmore-link">... <a href="#" class="readmore-merchantintro">Read More &raquo;</a></span>
    <div style="display: none;" class="readmore-off">'.
	trim($t[1])
	.'<a href="#" class="readless-merchantintro">Read Less &laquo;</a>
    </div>
    </div>';
	} 
	return $text;

    }
    
    public function AddExtraHTMLToSidebar(&$company) {
    	define('API', 'PS');
    	require_once 'siteadmin/includes/config/affiliatewindow.php';
    	$result = CPHelper::getStaggImageHTML($company['staggurl']);
    	$result .= '<div id="sidebar-merchantDescription-main"><h3>'. (empty($company['sidebar_title']) ? 'Quick Glance' : $company['sidebar_title']) .'</h3>';
    	$result .= mb_str_replace('{logo}', '<img src="'.$company['logourl'].'" style="float:left; margin:5px;"/>', $company['sidebar']);
    	if (!empty($company['displayurl'])) {
    		list($cloakedURL, $realURL) = CPHelper::getCompanyURLs($company['id'], $company['displayurl'], $company['source']);
    		$result .= '<ul><li class="official-website"><h4>Official Website</h4><a href="'.$cloakedURL.'" target="_blank">'.$realURL.'</a></li></ul>';
    	}
    	$result .= '</div>';
    	$company['sidebar'] = $result;
    }

}

?>