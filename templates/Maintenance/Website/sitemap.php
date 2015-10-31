<?php define('IN_SITE', 1);?>
<!DOCTYPE html>
<head>
<title><?php echo SITE_NAME;?> - Sitemap</title>
<meta name="DESCRIPTION" content="<?php echo SITE_NAME;?> Sitemap" />
<meta name="KEYWORDS" content="<?php echo SITE_NAME;?>, sitemap" />
<?php include('templates/_head.php');?>

</head>
<body class="home">

<div id="theWrapper">

<div id="container" >
<style>
	div.header {
    position: relative;
}

</style>

<div class="row1" style="float:left;">
<div id="contentwrapper">
<div class="six columns"><div class='innerWhite'><div id="breadcrumb"><a title="<?php echo SITE_NAME;?>" href="<?php echo SITE_URL;?>"><?php echo SITE_URL;?></a> &raquo; Sitemap</a></div>		<style>
		div#headBlock .ToolsList ul li a span{display:none}		
		
		div#headBlock .author {float:left; width:123px}
		
		div#headBlock div.ToolsList ul li.facebook{position:absolute;right:150px;}
		div#headBlock div.ToolsList ul li.twitter{position:absolute;right:40px;}
		div#headBlock .ToolsList ul {width: 594px;}
		div#headBlock ul {
    		height: 57px;
    	}
		</style>
		<div id="headBlock1"><h1>Sitemap.</h1>


</div>

<style>

#articleContent p:first-child {margin-top: 0;}

</style>

<div id="articleContent" >
[SITEMAP]
</div>

</div>
</div>

</div>
</div>

<?php include('templates/_topsection.php');?>

<?php include('templates/_sidebar.php');?>

<div class="row">&nbsp;</div>

</div>

<?php include('templates/_footer.php');?>

</div>


</body>