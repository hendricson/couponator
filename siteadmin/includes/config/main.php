<?php
/** DB Params */
define('DB_TYPE',   'mysql');         // allow 'mysql','mssql','pgsql' etc. (compatible with PEAR)
define('DB_MYSQL_VER', 4.1);          // MySQL Version
define('DB_HOST',   'localhost');     // mysql-server name
define('DB_USER',   '');          // existing user of database
define('DB_PASS',   '');          // and its password
define('DB_NAME',   '');        // name of database
define( 'TB',       'cp_' );          // prefix for all tables for this databas

//define('OS', 'NIX');
/** Site Config */	
define('SEF'	        , 0);
define('DOMAIN'         , 'localhost');
define('SITE_URL'       , 'http://localhost/couponator');
define('PATH_ROOT'      , '/couponator/');    // Site root path
define('PATH_ROOT_ADM'  , '/couponator/siteadmin/');    // Site root path
define('BPATH'          , $_SERVER['DOCUMENT_ROOT'] . PATH_ROOT  );// Web-server root path
define('SESSION_NAME'	, 'SesssionUniqueCode3879');
define('SITE_NAME'	    , 'Couponator Demo');
define('ADMIN_EMAIL'    , 'support@couponator');

/** Date format */
define("DATE_FORMAT", "d.m.Y");
define("DATE_FORMAT_LT", "d.m.Y");
define("DATE_FORMAT_FL", "l, F j, Y");
define("DATE_FORMAT_FL2", "F j, Y");
define("DATE_FORMAT_FL3", "F j");
