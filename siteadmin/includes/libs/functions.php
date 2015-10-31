<?php

/**
 * Standard function for display of errors
 *
 * @param string $mess       message of error
 * @param string $addMess    additional information about error
 * @param string $fName      script name
 * @param string $lineNumber number of line in script
 *
 * @return string
 */
function sc_error($mess, $addMess = '', $fName = '', $lineNumber = '')
{
 
}

/**
 * PEAR Error handling function. Generate exception.
 *
 * @param object $errorPbj
 * @return void
 */
function pear_error_callback($errorObj)
{
    if (empty($GLOBALS['noDbErrors']))
        sc_error($errorObj->message.'<br /><br />'.$errorObj->userinfo);
} 

if (!function_exists('mb_str_replace')) {
    function mb_str_replace($search, $replace, $subject) {
        if (is_array($subject)) {
            foreach ($subject as $key => $val) {
                $subject[$key] = mb_str_replace((string)$search, $replace, $subject[$key]);
            }
            return $subject;
        }
        //$pattern = '/(?:'.implode('|', array_map(create_function('$match', 'return preg_quote($match[0], "/");'), (array)$search)).')/u';
        $pattern = '/('.preg_quote(implode('', (array)$search), '/').')/u';
        if (is_array($search)) {
            if (is_array($replace)) {
                $len = min(count($search), count($replace));
                $table = array_combine(array_slice($search, 0, $len), array_slice($replace, 0, $len));
                $f = create_function('$match', '$table = '.var_export($table, true).'; return array_key_exists($match[0], $table) ? $table[$match[0]] : $match[0];');
                $subject = preg_replace_callback($pattern, $f, $subject);
                return $subject;
            }
        }
        $subject = preg_replace($pattern, (string)$replace, $subject);
        return $subject;
    }
}

    function getIP () {

        $t = getenv('HTTP_X_FORWARDED_FOR');
	    $ip = $_SERVER['REMOTE_ADDR'] != getenv('SERVER_ADDR') ? $_SERVER['REMOTE_ADDR'] : (!empty($t) ? $t : $_SERVER['REMOTE_ADDR']);
	    if (isset ($_SERVER["HTTP_X_CLUSTER_CLIENT_IP"]) && $_SERVER["HTTP_X_CLUSTER_CLIENT_IP"] == $_SERVER['REMOTE_ADDR']) {
	       $ip = getenv('HTTP_X_FORWARDED_FOR');   
	    }

	    return $ip;  
	}

class CPRoute {
	
function _($url, $isSEF = 0, $isBackend = 0) {
	$t1 = explode('&', $url);
	$t1[0] = str_replace('index.php?', '', $t1[0]);
	$params = array();
	
	foreach ($t1 as $k => $v) {
		$p = explode('=', $v);
		if ($p[0] == 'type' || $p[0] == 'mod' || $p[0] == 'what' || $p[0] == 'cat' || $p[0] == 'page') {
			${$p[0]} = $p[1];
		} else {
			$params[] = $v;
		}
	}

	$return = $isBackend ? SITE_URL.'/siteadmin/' : SITE_URL.'/';
	$p = count($params) > 0 ? implode('&', $params) : '';
	if ($isSEF || SEF) {
		if ($type == 'base' && $mod == 'companies' && !empty($cat) && empty($what)) {
			return $return . $cat . '/';	
		} elseif ($type == 'base' && $mod == 'companies' && !empty($cat) && $what == 'page') {
			return $return . $cat . '/' . $page;
		} else {
			return $return . $type.'/'.$mod.'/?'.$p;
		}
	} else {
		$result = $return . 'index.php?type='.$type.'&mod='.$mod;
		if (!empty($what)) $result .= '&what='.$what;
		if (!empty($cat)) $result .= '&cat='.$cat;
		if (!empty($page)) $result .= '&page='.$page;
		if (!empty($p)) $result .= '&'.$p;
		return $result;
	}
}

function build($params = array(), $isSEF = 0, $isBackend = 0) {
	
	$params1 = array();
	
	foreach ($_GET as $k => $v) {
		if ($k == 'type' || $k == 'mod' || $k == 'what') {
			${$k} = $v;
		} else {
			if (!key_exists($k, $params)) $params1[] = $k.'='.$v;
		}
	}
	
	if (!empty($_REQUEST['ptype'])) $type = $_REQUEST['ptype'];
	if (!empty($_REQUEST['pmod'])) $mod = $_REQUEST['pmod'];

	foreach ($params as $k => $v) {
		$params1[] = $k.'='.$v;
	}

	return IPandaRoute::getSiteURL($isSEF, $isBackend).implode('&', $params1);
}

function getSiteURL($isSEF = 0, $isBackend = 0) {
	foreach ($_GET as $k => $v) {
		if ($k == 'type' || $k == 'mod' || $k == 'what') {
			${$k} = $v;
		} 
	}
	if (!empty($_REQUEST['ptype'])) $type = $_REQUEST['ptype'];
	if (!empty($_REQUEST['pmod'])) $mod = $_REQUEST['pmod'];
	if (!empty($_REQUEST['pwhat'])) $what = $_REQUEST['pwhat'];
	
	$return = $isBackend ? SITE_URL.'/siteadmin/' : SITE_URL.'/';
	if ($isSEF || SEF) {
		return !empty($what) ? $return . $type.'/'.$mod.'/'.$what.'?' : $return . $type.'/'.$mod.'/?';
	}
	return !empty($what) ? $return . 'index.php?type='.$type.'&mod='.$mod.'&what='.$what.'&' : $return . 'index.php?type='.$type.'&mod='.$mod.'&';
}

function formopen1($attributes = 'method="GET" name="htmlform"', $appendGetVars = 0, $isSEF = 0, $useJustIndex = 0, $limit = 50) {
	$params1 = array();
	foreach ($_GET as $k => $v) {
		if ($k == 'type' || $k == 'mod' || $k == 'what') {
			${$k} = $v;
		} else {
			$params1[$k] = $v;
		} 
	}
	
	$url = $useJustIndex ? 'index.php' : CPRoute::getSiteURL();
	
	$html = '<form action="'.$url.'" '.$attributes.'>'."\n";
	
	if (!($isSEF || SEF)) {
		$html .= '<input type="hidden" name="type" value="'.$type.'" />'."\n";
		$html .= '<input type="hidden" name="mod" value="'.$mod.'" />'."\n";
	}
	
	$html .= '<input type="hidden" name="p" value="1" />'."\n";
	$html .= '<input type="hidden" name="limit" value="'.$limit.'" />'."\n";
	
	if (count($params1) > 0 && $appendGetVars)
	foreach ($params1 as $k => $v) {
		$html .= '<input type="hidden" name="'.$k.'" value="'.$v.'" />'."\n";
	}
	
	return $html;
}

}

class CPHelper {
	public function getStaggImageHTML ($url) {	
		if (!empty($url)) {
    		$url = strpos($url, 'http:') === false ? SITE_URL.'/'.mb_str_replace('{siteaddr}', '', $url) : $url;
    		return '<img src="'.$url.'" class="theStagg" />';
    	}
    	return '';	
	}
	public function getCompanyURLs($id_company, $url, $source = '') {
		$result = ($source == 'aw') ? 'http://www.awin1.com/awclick.php?mid='.$id_company.'&id='.API_USERNAME.'&platform=cs' : $url;
    	$t = str_replace('http://', '', $url);
    	$t = str_replace('https://', '', $t);	
    	return array($result, $t);
	}
}