# couponator
A prototype CMS for building a coupon site with automatically generated listings. I created this prototype back in 2011 and have not found any use for it, thought it would make a nice start for my GitHub portfolio.

## SETTING UP YOUR WEBSITE

1. Make a local copy of the Couponator

2. Configure settings at
*/siteadmin/includes/config/main.php*

3. Run the following URL to generate a .htaccess file
*http://yourwebsite/index.php?type=maintenance&mod=website&what=generateHTACCESS*

You can now access your website at *http://yourwebsite/*.  You can either use the directory structure that comes with the current distribution, or import the latest structure from AffiliateWindow. 
To do that, please copy the contents of the file available at [AffiliateWindow Wiki](http://wiki.affiliatewindow.com/index.php?title=ShopWindow_Appendix_2_Category_IDs&action=edit) to
*/docs/import/categories.list* and do the import by visiting 

*http://yoursite/index.php?type=maintenance&mod=affiliatewindow&what=ImportCategories*

## POPULATING YOUR WEBSITE WITH LISTINGS AND COUPONS
However, the website is useless without coupons. To populate the directory with the companies and coupons from AffiliateWindow.com, please do the following:

1. Add your AffiliateWindow merchant ID and API password to: 
*/siteadmin/includes/config/affiliatewindow.php*

2. Generate a shell script by running this URL

*http://yourwebsite/index.php?type=maintenance&mod=affiliatewindow&what=GenerateCronFile*

This should generate a file called awupdate.sh in the root folder of your website. Run this file regularly from a command line to populate your directory with latest AffiliateWindow listings.

3. Run the following URL to generate a shell script for a CRON

*http://yourwebsite/index.php?type=maintenance&mod=website&what=generateCron*

## GETTING SEO WORK DONE
Run the following URL to generate a sitemap

*http://yourwebsite/index.php?type=maintenance&mod=website&what=generateSitemap*

This will generate a sitemap page accessible at *http://yoursite/sitemap.php* along with its XML version at *http://yoursite/sitemap.xml*

