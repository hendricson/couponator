<?php defined('IN_SITE') or die('No direct access allowed'); ?>
<div class="row mainNavRow" style="margin-top:0;width:1000px;" id="topsection">
    <div class="nine columns mainNavHeader" id="masthead">
      <div class="secondaryNav">
        <ul>
          <li><a href="<?php echo SITE_URL;?>">Home</a></li>
          <li><a href="<?php echo SITE_URL;?>/about-us.php" title="About Us">About Us</a></li>
          <li><a href="<?php echo SITE_URL;?>/contact-us.php" title="About Us">Contact Us</a></li>
          
        </ul>
 
  <form class="searchform" action="index.php" type="GET">
    <input type="hidden" name="type" value="base" />
    <input type="hidden" name="mod" value="companies" />
	<div class="searchBox">
    <label for="searchString" class="assistive">Search</label>
		<input name="search" class="searchfield" type="text"  onclick="if(this.value=='Search...') this.value='';" onkeypress="if(this.value=='Search...') this.value='';" value="Search..." tabindex="0" />

	<label for="go" class="assistive">Search</label>
		<input class="searchbutton" type="submit" value="Go" onclick="if($('.searchform .searchfield').val()=='Search...'){return false;}"/>
	</div>
</form>

         </div>
            
      <a><h2 class="MSElogo"> - Cutting Your Costs, Fighting Your Corner</h2></a>
<a>
	<span class="protest"></span>
</a>
      <ul id="topnav" class="hide-on-phones">
        <li><a class="cards" style="cursor:default;" title="Cards and Loans">Cards<br />Loans</a></li>
        <li><a class="reclaim" style="cursor:default;" title="Reclaim $1,000s">Reclaim <br />$1,000s</a></li>
          <li> <a class="shopping" style="line-height:30px;cursor:default;" title="Shopping">Shopping</a></li>
          <li> <a class="deals" style="cursor:default;" title="Deals Vouchers">Deals<br />Vouchers</a></li>
          <li> <a class="utilities" style="cursor:default;" title="Utilities and Phones">Utilities<br />Phones</a></li>
          <li> <a class="banking" style="cursor:default;" title="Banking and Saving">Banking<br />Saving</a></li>
          <li> <a class="travel" style="cursor:default;" title="Travel and Motoring">Travel<br />Motoring</a></li>
          <li> <a class="insurance" style="line-height:30px;cursor:default;">Insurance</a></li>
          <li> <a class="mortgages" style="cursor:default;">Mortgages<br />Homes</a></li>
          <li> <a class="family" style="cursor:default;">Income<br />Family</a></li>
      </ul>
    </div>
    </div>