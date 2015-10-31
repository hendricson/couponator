jQuery(document).ready(function() {
jQuery(".readmore-merchantintro").click(function(){
	jQuery(".readmore-link").hide();
	jQuery(".readmore-off").css({display:"inline"});
	return false
});

jQuery(".readless-merchantintro").click(function(){
	jQuery(".readmore-link").show();
	jQuery(".readmore-off").hide();
	return false});
});