<?php defined('IN_SITE') or die('No direct access allowed'); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="<?php echo SITE_URL;?>/css/home.css">
<style>
@font-face{
font-family:'museo-slab';
src:url('<?php echo SITE_URL;?>/fonts/museo_slab_500-webfont.eot');
src:url('<?php echo SITE_URL;?>/fonts/museo_slab_500-webfont.eot?#iefix') format('embedded-opentype'),url('<?php echo SITE_URL;?>/fonts/museo_slab_500-webfont.woff') format('woff'),url('<?php echo SITE_URL;?>/fonts/museo_slab_500-webfont.ttf') format('truetype');font-weight:normal;font-style:normal}@font-face{font-family:'museo-slab';src:url('<?php echo SITE_URL;?>/fonts/museo_slab_700-webfont.eot');src:url('<?php echo SITE_URL;?>/fonts/museo_slab_700-webfont.eot?#iefix') format('embedded-opentype'),url('<?php echo SITE_URL;?>/fonts/museo_slab_700-webfont.woff') format('woff'),url('<?php echo SITE_URL;?>/fonts/museo_slab_700-webfont.ttf') format('truetype');font-weight:700;font-style:normal}@font-face{font-family:'league-gothic';src:url('<?php echo SITE_URL;?>/fonts/league_gothic-webfont.eot');src:url('<?php echo SITE_URL;?>/fonts/league_gothic-webfont.eot?#iefix') format('embedded-opentype'),url('<?php echo SITE_URL;?>/fonts/league_gothic-webfont.woff') format('woff'),url('<?php echo SITE_URL;?>/fonts/league_gothic-webfont.ttf') format('truetype');font-weight:normal;font-style:normal}@font-face {font-family: 'fontello';src: url('<?php echo SITE_URL;?>/fonts/fontello.eot');src: url('<?php echo SITE_URL;?>/fonts/fontello.eot?#iefix') format('embedded-opentype'),url('<?php echo SITE_URL;?>/fonts/fontello.woff') format('woff'),url('<?php echo SITE_URL;?>/fonts/fontello.ttf') format('truetype'),url('<?php echo SITE_URL;?>/fonts/fontello.svg#fontello') format('svg');font-weight: normal; font-style: normal;}</style>
<link rel="stylesheet" href="_<?php echo SITE_URL;?>/css/reset.css">

<link rel="stylesheet" href="<?php echo SITE_URL;?>/css/base.css">
<link rel="stylesheet" href="_<?php echo SITE_URL;?>/css/fixes.css">

<!--[if lt IE 9]>
		<link rel="stylesheet" href="<?php echo SITE_URL;?>/css/ie9.css">
<![endif]-->

<link rel="stylesheet" href="<?php echo SITE_URL;?>/css/sidebar.css">
<link rel="stylesheet" href="<?php echo SITE_URL;?>/css/merchant.css">
<link rel="stylesheet" href="<?php echo SITE_URL;?>/css/pagging.css">

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL;?>/js/jquery.stickem.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL;?>/js/couponator.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL;?>/js/merchant_original.js"></script>

<meta name="viewport" content="width=device-width" />
<style type="text/css">

body{
margin:0;
padding:0;
}

#topsection{
<?php if (!defined('INNERPAGE')) {?>position:absolute;<?php }?>
top:0;
height: 160px; /*Height of top section*/
width:840px;
display:block;
overlay:none;
<?php if (!defined('INNERPAGE')) {?>margin-bottom:160px;<?php }?>
}

#contentwrapper{
margin-top:<?php echo defined('INNERPAGE') ? '10' : '180';?>px;
float: left;
width: 100%;
}

#contentcolumn{
margin: 0px 320px 0 0px; /*Margins for content column. Should be "0 RightColumnWidth 0 LeftColumnWidth*/
}

#rightcolumn{
float: left;
width: 320px; 
margin-left: -320px; /*Set left margin to -(RightColumnWidth)*/
margin-top:<?php echo defined('INNERPAGE') ? '10' : '180';?>px;
}

.stickem-container{
position:relative;
}
.stickit {
    margin-left: 680px !important;
    position: fixed;
    top: 10px;
    margin-top: 0 !important;
}

.stickit-end {
    bottom:-15px;
    position: absolute;
    margin-left: 680px !important;
	
}

</style>
