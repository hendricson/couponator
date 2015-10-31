<?php

class Ctrl_Base_Companies extends Ctrl_Base 
{
    private $mCompanies;
    private $location; 

    public function __construct(&$glObj, $location )
    {
    	parent :: __construct($glObj); 
        include_once 'Model/Base/Companies.class.php';
        $this->mCompanies = new Model_Base_Companies($this->mDb); 
		$this->location = $location;	
    }
    
    /*     * ***************************
      Client Part
     * *************************** */

    public function Index()
    {
    	define('API', 'PS');
    	require_once 'siteadmin/includes/config/affiliatewindow.php';
    	   	
    	include_once 'View/Base/Companies.class.php';
        $view = new View_Base_Companies($this->mlObj, $this->location); 
        
        $type = $_REQUEST['ptype'];
        $mod = $_REQUEST['pmod'];
        $cid = isset($_REQUEST['cid']) ? (int)$_REQUEST['cid'] : 0;
        $search = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
        $sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : '';
        $cat = isset($_REQUEST['cat']) ? $_REQUEST['cat'] : '';
        $search = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
        
        $catname = '';
        $catsidebar = '';
        $breadcrumbs = '';
        $id_cat = 0;
        $id_company = 0;
        $cl = '';
        
        if (!empty($cat)) {
	        list($id_cat, $id_company, $breadcrumbs, $catname, $catsidebar) = $this->mCompanies->getIDs();
    
	        // get cats and subcats
	        include_once 'Model/Base/Cats.class.php';
	        $mDict = new Model_Base_Cats($this->mDb);
	    	$cl = $mDict ->GetCatsList($id_cat, 1, 'sortid, name ASC');
        } 
         
        $view->assign('breadcrumbs', $breadcrumbs);
        $view->assign('catname', $catname);
        $view->assign('meta_title', SITE_NAME.': '.$catname);
        $view->assign('meta_keywords', SITE_NAME.','.$catname);
        $view->assign('meta_description', SITE_NAME.': '.$catname);
        $view->assign('sidebar', $catsidebar);       

    	    // pagging
    	    $limit = intval($_SESSION[$type.'.'.$mod.'.limit']);
            include_once 'View/Acc/Pagging.php';
            if ($limit == 0) $limit = 10;
            if (!empty($type) && !empty($mod)) $limit = intval($_SESSION[$type.'.'.$mod.'.limit']);

            $view->assign('limit', $limit);
            $view->assign('view', (!empty($type) && !empty($mod)) ? $_SESSION[$type.'.'.$mod.'.view'] : '');

            $pcnt = $limit;

            $rcnt = $this->mCompanies->GetPagesCount($id_cat, array('search' => $search, 'active' => 1));
            
            $page = (int)!empty($_REQUEST['p']) ? $_REQUEST['p'] : 1;            
            if ($page > 1 && $rcnt <= $limit*($page-1)) $page--;
            if ($page < 1) $page = 1;
            $view->assign('page', $page);
                        
            $pg = new Pagging($this->mlObj, '', $limit, $rcnt, $page, CPRoute::_('index.php?type=base&mod=ads&cat='.$cat));
            $view->assign('rcnt', $rcnt);
            $range = & $pg->GetRange();
			$numberOfListingsOnPage = $range[1] - $range[0];
			$results_description = $numberOfListingsOnPage > 0 ? "Showing ".($range[0]+1)." - ".$range[1]." results out of total ".$rcnt." listings" : "No results found"; 
            $view->assign('plist_c', $range[1] - $range[0]);
            $view->assign('results_description', $results_description);

            $list = $this->mCompanies->GetList($id_cat, array('sort' => $sort, 'first' => count($range > 1) ? $range[0] : 0, 'cnt' => $limit, 'search' => $search, 'active' => 1));
            
          	$view->assign('cl', $cl);
    		$view->assign('list', $list);
    		$view->assign('paginator', $pg->Make());
    		if(!empty($search)) {
    			$view->assign('title', 'Search results for "'.$search.'"');
        		$view->display('searchresults.php');
	        } else {	      
	        	if (isset($catname)) $view->assign('title', '');  	
    			$view->display('list.php');
	        }
    } 
       
    
    public function Page () {	
    	include_once 'View/Base/Companies.class.php';
        $view = new View_Base_Companies($this->mlObj, $this->location); 
    	
		list($id_cat, $id_company, $breadcrumbs) = $this->mCompanies->getIDs();
		
		$view->assign('breadcrumbs', $breadcrumbs);
		$title = 'Page not found';
		$company = array('content' => '<a href="javascript:window.history.back();">Go Back &gt;&gt;</a>', 
						'sidebar' => '', 
						'meta_title' => $title, 
						'meta_description' => SITE_NAME,
						'meta_keywords' => SITE_NAME);
		
		if ($id_company > 0) {
			$company = $this->mCompanies->get($id_company);
			$title = trim($company['title']);
			$logo = "<img src='".$company['logourl']."' alt='".trim($company['title'])." :: ".trim($company['strapline'])." :: ".trim(mb_substr($company['meta_description'], 0, 100)).".. :: ".$company['displayurl'].	"' width='88' height='31' border='0' />";
			$logoleft = "<img src='".$company['logourl']."' style='float:left; margin:5px;' alt='".trim($company['title'])." :: ".trim($company['strapline'])." :: ".trim(mb_substr($company['meta_description'], 0, 100)).".. :: ".$company['displayurl'].	"' width='88' height='31' border='0' />";
			$company['content'] = mb_str_replace('{siteaddr}', SITE_URL.'/', $company['content']);
			$company['content'] = mb_str_replace('{logo}', $logo, $company['content']);
			$company['content'] = mb_str_replace('{logoleft}', $logoleft, $company['content']);
			$company['sidebar'] = $view->readmorize($company['sidebar']);
			$company['sidebar'] = mb_str_replace('{siteaddr}', SITE_URL.'/', $company['sidebar']);
			$company['sidebar'] = mb_str_replace('{logo}', $logo, $company['sidebar']);
			$company['sidebar'] = mb_str_replace('{logoleft}', $logoleft, $company['sidebar']);
			$view->AddExtraHTMLToSidebar($company);
			
			$vouchers = $this->mCompanies->getVouchers($id_company);
			$view->assign('vouchers', $vouchers);
		}
		
    	foreach ($company as $k => $v) {
			$view->assign($k, $v);
		}

		$view->assign('title', $title);
    	$view->display('page.php');
    }
    
    public function voucherAjax() {
    	$id = (int)$_REQUEST['id'];
    	$s = $_REQUEST['s'];

    	if ($s == md5(serialize($_SESSION['ip']))) {
    		$voucher = $this->mCompanies->getVoucher($id);
    		
    		if (!empty($voucher)) {
    			$result = array();
    			$result['the_code'] = '<p class="instruction">Your code</p>
		<strong>'.$voucher['code'].'</strong>';
    			$result['what_happened'] = '	<div class="clearfix">
		<b class="left-col" style="width:90px;">What just happened?</b>
		<div class="double-col" style="width:212px;"><p>'.$voucher['company_name'].' web site has been opened in a new window ready for you to shop. To get the discount, enter the code <strong>'.$voucher['code'].'</strong> when you reach the checkout.</p></div>
	</div>
	<div class="clearfix">
		<b class="left-col" style="width:90px;">Link to offer:</b> 
		<div class="double-col" style="width:212px;">
			<p>If the website did not open <a target="_blank" href="'.SITE_URL.'/index.php?type=base&mod=companies&what=voucherRedirect&id='.$voucher['id'].'&s='.$s.'">please click here.</a></p>
		</div>
	</div>';
    			$result['url'] = $voucher['url'];
    			echo json_encode($result);
    		} else {
    			echo "failure";
    		}
			
    	} else {
    		echo "failure";
    	}
    	exit;
    }
    
    public function voucherRedirect() {
    	$id = (int)$_REQUEST['id'];
    	$s = $_REQUEST['s'];

    	if ($s == md5(serialize($_SESSION['ip']))) {
    		$voucher = $this->mCompanies->getVoucher($id);
    		if (!empty($voucher)) {
    			header('Location: '.$voucher['url']);
    		} else {
    			header('Location: '.SITE_URL);
    		}
    	}
    }

}

?>