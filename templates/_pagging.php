<?php
//echo "this->lprev=<pre>";print_r($this->lprev);echo "</pre><hr>"; 
//echo "this->lnext=<pre>";print_r($this->lnext);echo "</pre><hr>"; 
//echo "this->pages=<pre>";print_r($this->pages);echo "</pre><hr>";
?>
<?php if (count($this->pages) > 1) {?>
<div style="clear:both;padding-top:30px;width:100%;">
<center>
<div class="blog-post-preview1 blog-post1 post-story1" style="border-top: 0px;background:#edeee7;">
  <div id="SlideShowPaginate" style="width:<?php echo 201+count($this->pages)*42;?>px;">
  	<?php if (!empty($this->lprev)) {?>
  	<div <?php if (empty($this->lnext)) {?> class="last-page"<?php } ?>>
  	<a href="<?php echo $this->lprev;?>"><span id="LeftArrow" class="ov"></span></a>
  	<?php } else {?>
  	<div class="first-page">
  	<span id="LeftArrow" class="ov"></span>
  	<?php } ?>
  		<div id="slideshow-pager-ul-wrapper">
  			<ul style="margin-left: 0px">
  				<?php for($i = 0; $i < count($this->pages); $i++) {?>
  				<?php if ($this->page == $this->pages[$i]['page']) {?>
  				<?php //echo "this->pages[$i]=<pre>";print_r($this->pages[$i]);echo "</pre><hr>"; ?>
		        <span ><a href="javascript:document.fms.p.value=<?php echo $this->pages[$i]['page'];?>;document.fms.submit();"><li class="bt-active s-enable"><?php echo $this->pages[$i]['page'];?></li></a></span>
		        <?php } else {?>
		        <a href="javascript:document.fms.p.value=<?php echo $this->pages[$i]['page'];?>;document.fms.submit();"><li><?php echo $this->pages[$i]['page'];?></li></a>
		        <?php } ?>
		        <?php } ?>
  			</ul>
  		</div>
  		<?php if (!empty($this->lnext)) {?>
  		<a href="<?php echo $this->lnext;?>"><span id="RightArrow" class="ov"></span></a>
  		<?php } else {?>
  		<span id="RightArrow" class="ov"></span>
  		<?php } ?>
  	</div>
  </div>
</div>
</center>
<div class="adsperpage_tab" <?php if (count($this->pages) > 1) {?>style="margin-top:-50px;"<?php } ?>><span style="font-weight:bold;">Listings per page:</span>&nbsp;&nbsp;<a href="javascript:document.fms.limit.value=10;document.fms.submit();" <?php if ($this->limit == 10) {?>class="selected"<?php } ?>>10</a>&nbsp;|&nbsp;<a href="javascript:document.fms.limit.value=25;document.fms.submit();" <?php if ($this->limit == 25) {?>class="selected"<?php } ?>>25</a>&nbsp;|&nbsp;<a href="javascript:document.fms.limit.value=50;document.fms.submit();" <?php if ($this->limit == 50) {?>class="selected"<?php } ?>>50</a>&nbsp;|&nbsp;<a href="javascript:document.fms.limit.value=100;document.fms.submit();" <?php if ($this->limit == 100) {?>class="selected"<?php } ?>>100</a>&nbsp;|&nbsp;<a href="javascript:document.fms.limit.value=150;document.fms.submit();" <?php if ($this->limit == 150) {?>class="selected"<?php } ?>>150</a></div>
<?php } ?>



