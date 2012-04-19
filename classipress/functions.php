<?php
/**
 * Theme functions file
 *
 * DO NOT MODIFY THIS FILE. Make a child theme instead: http://codex.wordpress.org/Child_Themes
 *
 * @package ClassiPress
 * @author AppThemes
 */

// current  version
$app_theme = 'ClassiPress';
$app_abbr = 'cp';
$app_version = '3.1.7';
$app_edition = 'Ultimate Edition';

// define rss feed urls
$app_rss_feed = 'http://feeds2.feedburner.com/appthemes';
$app_twitter_rss_feed = 'http://twitter.com/statuses/user_timeline/appthemes.rss';
$app_forum_rss_feed = 'http://www.appthemes.com/forum/external.php?type=RSS2';

// define the db tables we use
$app_db_tables = array($app_abbr.'_ad_forms', $app_abbr.'_ad_meta', $app_abbr.'_ad_fields', $app_abbr.'_ad_pop_daily', $app_abbr.'_ad_pop_total' , $app_abbr.'_ad_packs', $app_abbr.'_order_info');

// define the transients we use
$app_transients = array($app_abbr.'_cat_menu');

// Framework
require( dirname(__FILE__) . '/framework/load.php' );

scb_register_table( 'app_pop_daily', $app_abbr . '_ad_pop_daily' );
scb_register_table( 'app_pop_total', $app_abbr . '_ad_pop_total' );

require( dirname(__FILE__) . '/framework/includes/stats.php' );

// Theme-specific files
require( dirname(__FILE__) . '/includes/theme-functions.php' );

