<?php defined('IN_SITE') or die('No direct access allowed'); ?>

<!--<div class="stickem-container">-->
<div class="three1 columns1 stickem" id="rightcolumn" >
<div class="">

	<div class="sidebar fourcol last">
	<aside class="block merchantintro">
	<div class="inner">
	<?php echo $this->sidebar;?>
    </div>
	</aside>
	
	<aside class="block merchantintro code-tested">
	<?php 
	if (isset($this->vouchers) && count($this->vouchers) > 0) {
		foreach ($this->vouchers as $i =>$voucher) {
			$voucher['discount'] = mb_str_replace('Extra ', '', $voucher['discount']);
			$voucher['discount'] = mb_str_replace('SAVE -', '', $voucher['discount']);
			$voucher['discount'] = trim($voucher['discount']);
			
			$img = SITE_URL.'/images/voucher_'.$voucher['discount'].'peroff.png';
			$img_retina = SITE_URL.'/images/offer-images-164px/voucher_'.$voucher['discount'].'peroff.png';
			if (empty($voucher['discount'])) {
				$img = SITE_URL.'/images/deal_bigsavings.png';
				$img_retina = SITE_URL.'/images/offer-images-164px/deal_bigsavings.png';
			}
			if (strpos(strtoupper($voucher['title']), 'FREE') !== false && empty($voucher['discount'])) {
				$img = SITE_URL.'/images/deal_free.png';
				$img_retina = SITE_URL.'/images/offer-images-164px/deal_free.png';
			}
			if (strpos(strtoupper($voucher['title']), 'GREAT DEAL') !== false && empty($voucher['discount'])) {
				$img = SITE_URL.'/images/deal_greatdeal.png';
				$img_retina = SITE_URL.'/images/offer-images-164px/deal_greatdeal.png';
			}
		?>		
				
	
	<article class="offer-module list-module <?php echo !empty($voucher['code']) ? 'code' : 'deal';?>" id="voucher-<?php echo $voucher['id'];?>" data-merchant="<?php echo $voucher['company_name'];?>">
	<div class="left-col">
		<a class="merchant-logo click-reveal" href="javascript:;"><img src="<?php echo $img;?>" data-lazy-src="<?php echo $img;?>" alt="<?php echo $voucher['title'];?>" data-lazy-retina-src="<?php echo $img_retina;?>" class="fadeIn"></a>
		<b><?php echo !empty($voucher['code']) ? 'code' : 'deal';?></b>
	</div>
	<div class="offer-details double-col">
		<h3><a href="javascript:;" class="click-reveal"><?php echo $voucher['title'];?></a></h3>
		<p class="merchant-name"> Added <?php echo date("jS F Y", strtotime($voucher['start_date']));?>
		<?php if (!empty($voucher['code'])){?>, <br />Expires <?php echo date("jS F Y", strtotime($voucher['end_date']));?><?php }?>
		</p>
		<?php if (!empty($voucher['code'])) {?>
		<ul class="key-terms"></ul>
		<a href="javascript:;" class="click-reveal button getcode">Get Code</a>
		<a class="reveal-strip click-reveal" style="" href="javascript:;"></a>
		<div class="the-code">
		</div>
		<?php } else {?>
		<a href="<?php echo SITE_URL.'/index.php?type=base&mod=companies&what=voucherRedirect&id='.$voucher['id'].'&s='.md5(serialize($_SESSION['ip']));?>" class="click-reveal button getcode" style="width:200px;">
Click Here to Get Deal</a>		
		<?php } ?>
		<p class="additional-info"></p>
	</div>
	<div class="what-happened"></div>
	<q id="terms-placeholder"></q>
	</article>
	<?php } ?>
<?php } ?>	
<?php /*<hr class="list-module-seperator">*/?>	
	
	</aside>
	
	</div>


</div>
</div>
<div style="clear:both;"></div>
</div>
	<script>
		$(document).ready(function() {
			$('.container').stickem();
		});
		
		$('.click-reveal').click(function() {
			var id = $(this).closest('article').attr('id'); 
			id = id.replace(/voucher-/, "");
			if (id > 0) {
				jQuery.post('<?php echo SITE_URL;?>/index.php', 
				{
					type: 'base',
					mod: 'companies',
					what: 'voucherAjax',
					id: id,
					s: '<?php echo md5(serialize($_SESSION['ip']));?>'
				}, function(response){
					if (response != 'failure') {
						jQuery('.offer-module').each(function() {
							jQuery(this).attr('class', 'offer-module list-module code');
							var current_id = jQuery(this).attr('id');
							jQuery('#'+current_id+' > .what-happened').html('');
						});
						jQuery('#voucher-'+id).attr("class", "offer-module list-module code revealed last-clicked");
						
						var voucher = JSON.parse(response);
						window.open(voucher.url);
						jQuery('#voucher-'+id+' .the-code').html(voucher.the_code);
						jQuery('#voucher-'+id+' .what-happened').html(voucher.what_happened);
						} else {
							alert("Sorry, could not retrieve the code");
						}
				});
			}
		});
		
	</script>



	