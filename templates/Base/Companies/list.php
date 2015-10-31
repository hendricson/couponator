<?php define('INNERPAGE', 1);?>
<!DOCTYPE html>
<head>
<title><?php echo $this->meta_title;?></title>
<meta name="DESCRIPTION" content="<?php echo $this->meta_description;?>" />
<meta name="KEYWORDS" content="<?php echo $this->meta_keywords;?>" />
<?php include('templates/_head.php');?>

</head>
<body class="home">

<div id="theWrapper">

<div id="container" class="container">
<style>
	div.header {
    position: relative;
}

</style>

<?php include('templates/_topsection.php');?>

<div class="stickem-container">
<div class="row1" style="float:left;">
<div id="contentwrapper">
<div class="six columns"><div class='innerWhite'><div id="breadcrumb"><a title="<?php echo SITE_NAME;?>" href="<?php echo SITE_URL;?>"><?php echo SITE_URL;?></a> <?php echo $this->breadcrumbs;?></div>
		<style>
		div#headBlock .ToolsList ul li a span{display:none}		
		
		div#headBlock .author {float:left; width:123px}
		
		div#headBlock div.ToolsList ul li.facebook{position:absolute;right:150px;}
		div#headBlock div.ToolsList ul li.twitter{position:absolute;right:40px;}
		div#headBlock .ToolsList ul {width: 594px;}
		div#headBlock ul {
    		height: 57px;
    	}
		</style>
		<div id="headBlock1"><h1><?php echo $this->title;?></h1>
</div>

<ul class="categorylist" id="double">
<?php foreach ($this->cl as $cat) {
//echo "cat=<pre>";print_r($cat);echo "</pre><hr>"; 
$name = ($cat['number_ads'] > 0) ? $cat['name'].' <span style="color:#777;">('.$cat['number_ads'].')</span>' : $cat['name'];	
?>
<li style="margin-bottom:10px;"><a style="font-size:1.2em;font-weight:bold;" href="<?php echo CPRoute::_('index.php?type=base&mod=companies&cat='.$cat['path']);?>" title="<?php echo $cat['name'];?>"><?php echo $name;?></a></li>	
<?php } ?>
</ul>

<style>

#articleContent p:first-child {margin-top: 0;}

</style>
<?php echo CPRoute::formopen1('method="GET" id="fms" name="fms"', 0, 0, 0, $this -> limit);?>
<input type="hidden" name="cat" value="<?php echo isset($_GET['cat']) ? $_GET['cat'] : '';?>" />
</form>
<div id="articleContent" >
<h3 style="margin-bottom:0px;"><?php echo $this->catname;?></h3>
<div style="color:#666;"><em><?php echo $this->results_description;?></em></div>
<div style="clear:both;margin-bottom:20px;"></div>
<?php 
foreach ($this->list as $i => $item) {

	//echo "item=<pre>";print_r($item);echo "</pre><hr>";
	
	list($cloakedURL, $realURL) = CPHelper::getCompanyURLs($item['id'], $item['displayurl'], $item['source']);

	/*echo "cloakedURL=<pre>";print_r($cloakedURL);echo "</pre><hr>";
	echo "realURL=<pre>";print_r($realURL);echo "</pre><hr>";
	exit;*/
	//echo "this->plist_c=<pre>";print_r($this->plist_c);echo "</pre><hr>";
	
	$logo =  !empty($item['logourl']) ? '<img src="'.$item['logourl'].'" style="float:left; margin:5px;" />' : '';
	$description = mb_str_replace('{logoleft}', '', strip_tags($item['content']));
	$description = mb_strlen($description) > 250 ? mb_substr($description, 0, 250).'..' : $description;
	$pageURL = CPRoute::_('index.php?type=base&mod=companies&what=page&cat='.$item['path'].'&page='.$item['alias']);
	
	?>
	<table cellpadding="0" cellspacing="0" border="0">
	<tr>
	<td style="width:100px;" valign="top"><a href="<?php echo $pageURL;?>"><?php echo $logo;?></a></td>
	<td style="padding-left:10px;"><h4 style="margin:0"><a href="<?php echo $pageURL;?>"><?php echo $item['title'];?></a></h4>	
	<div style="font-size:0.8em;"><a href="<?php echo $cloakedURL;?>"><?php echo $realURL;?></a></div>
	<p><?php echo $description;?></p>
	</td>
	</tr>
	</table>

	<div style="clear:both;"></div>
	<?php
	
}
 echo $this->paginator;
?></div>

</div>
</div>

</div>
</div>

<?php include('templates/_sidebar_pages.php');?>

<div class="row">&nbsp;</div>

</div>
</div>

<?php include('templates/_footer.php');?>

</div>


</body>