<!DOCTYPE html>
<head>
<title>Not just another voucher codes, discounts and cash back site.</title>
<meta name="DESCRIPTION" content="At <?php echo SITE_NAME;?> we aim to provide a detailed review and information that assist the consumer in saving money with discounts, coupons and vouchers." />
<meta name="KEYWORDS" content="discounts, vouchers, coupons, cash backs" />
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
	<div class="six columns" id="contentcolumn">
	
<div class="innerRow">
<p>
    At <?php echo SITE_NAME;?> we aim to provide detailed review and information that assist the consumer in not just <strong>saving money</strong> with discounts, coupons
    and vouchers; but the <strong>right decision</strong> when buying a service or product.
</p>
<p>
    Each listed service provider or product comes with an extensive and informative article written after conducting thorough research.
</p>
<p>
    We promise to continue the research and provide you with up to date news, reviews and ratings for each product or brand that we display on this site.
</p>
</div>	
<div class="innerRow">
 
    <ul class="block-grid three-up mobile">
<?php foreach ($this->cl as $cat) {?>
<?php if (count($this->pl[$cat['id']]) > 0) {
	$name = ($cat['number_ads'] > 0) ? $cat['name'].' <span style="color:#777;">('.$cat['number_ads'].')</span>' : $cat['name'];
	//echo "cat=<pre>";print_r($cat);echo "</pre><hr>"; 
	?>
<li><div class="section <?php echo !empty($cat['color']) ? 'color_'.$cat['color'] : '';?>">
<h4><a href="<?php echo CPRoute::_('index.php?type=base&mod=companies&cat='.$cat['alias']);?>" title="<?php echo $cat['name'];?> section"><?php echo $name;?></a></h4>
<ul>	
	<?php foreach ($this->pl[$cat['id']] as $subcat) {
		 $name = ($subcat['number_ads'] > 0) ? $subcat['name'].' ('.$subcat['number_ads'].')' : $subcat['name'];
		?>
	<li><a href="<?php echo CPRoute::_('index.php?type=base&mod=companies&cat='.$cat['alias'].'/'.$subcat['alias']);?>" title="<?php echo $subcat['name'];?>"><?php echo $name;?></a></li>
	<?php } ?>
</ul>
</div></li> 
<?php } ?>
<?php } ?>  

</ul>

   
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