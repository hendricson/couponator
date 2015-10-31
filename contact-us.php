<?php define('IN_SITE', 1);?>
<?php include_once 'siteadmin/includes/config/main.php';?>
<!DOCTYPE html>
<head>
<title><?php echo SITE_NAME?> - Contact Us</title>
<meta name="DESCRIPTION" content="<?php echo SITE_NAME;?> Contact Us page" />
<meta name="KEYWORDS" content="<?php echo SITE_NAME?>" />
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
<div class="six columns"><div class='innerWhite'><div id="breadcrumb"><a title="<?php echo SITE_NAME;?>" href="<?php echo SITE_URL;?>"><?php echo SITE_URL;?></a> &raquo; Contact Us</a> </div>		<style>
		div#headBlock .ToolsList ul li a span{display:none}		
		
		div#headBlock .author {float:left; width:123px}
		
		div#headBlock div.ToolsList ul li.facebook{position:absolute;right:150px;}
		div#headBlock div.ToolsList ul li.twitter{position:absolute;right:40px;}
		div#headBlock .ToolsList ul {width: 594px;}
		div#headBlock ul {
    		height: 57px;
    	}
		</style>
		<div id="headBlock1"><h1>If you need to get in touch?</h1>


</div>

<style>

#articleContent p:first-child {margin-top: 0;}

</style>

<div id="articleContent" >
<p>
    Do you have any suggestions for us?
</p>
<p>
    Want to share a <em><?php echo SITE_URL;?> </em>experience with us?
</p>
<p>
    Or do you want our advice on something? (We would be honoured to be of assistance).
</p>
<p>
    Anything, everything, don’t keep it to yourself. Let it out. Contact us.
</p>
<p>
    You can get in touch with by phone at 0161 429 1265 or email us at <?php echo ADMIN_EMAIL;?>.
</p>
<p>
    Or you can log into the <em><?php echo SITE_URL;?></em>community to interact with others just like you.
</p>
<p>
    And did you check our FAQs? Perhaps, your question has already been answered.
</p>
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