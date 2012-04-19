<?php

/**
 * Module for gathering post view statistics.
 * TODO: cleanup
 */

// get the local time based off WordPress setting
$nowisnow = date('Y-m-d', current_time('timestamp'));

// get the total page views and daily page views for a post
function appthemes_stats_counter($post_id) {
	global $wpdb, $nowisnow;

	// get all the post view info to display
	$sql = $wpdb->prepare("
		SELECT t.postcount AS total, count(d.postcount) AS today
		FROM $wpdb->app_pop_total AS t
		INNER JOIN $wpdb->app_pop_daily AS d ON t.postnum = d.postnum
		WHERE t.postnum = %d AND d.time = %s GROUP BY total
	", $post_id, $nowisnow);

	$results = $wpdb->get_row($sql);

	if($results)
		echo number_format($results->total) . '&nbsp;' .__('total views', 'appthemes') . ', ' . number_format($results->today) . '&nbsp;' .__('today', 'appthemes');
	else
		echo __('No views yet', 'appthemes');
}

// record the page view
function appthemes_stats_update($post_id) {
	global $wpdb, $app_abbr, $nowisnow;

	$thepost = get_post($post_id);

	if ($thepost->post_author==get_current_user_id()) return;

	// first try and update the existing total post counter
	$results = $wpdb->query( $wpdb->prepare("UPDATE $wpdb->app_pop_total SET postcount = postcount+1 WHERE postnum = %s LIMIT 1", $post_id) );

	// if it doesn't exist, then insert two new records
	// one in the total views, another in today's views
	if ($results == 0) {
		$wpdb->insert($wpdb->app_pop_total, array(
			"postnum" => $post_id,
			"postcount" => 1
		));
		$wpdb->insert($wpdb->app_pop_daily, array(
			"time" => $nowisnow,
			"postnum" => $post_id,
			"postcount" => 1
		));
	// post exists so let's just update the counter
	} else {
		$results2 = $wpdb->query( $wpdb->prepare("UPDATE $wpdb->app_pop_daily SET postcount = postcount+1 WHERE time = %s AND postnum = %s LIMIT 1", $nowisnow, $post_id) );

		// insert a new record since one hasn't been created for current day
		if ($results2 == 0){
			$wpdb->insert($wpdb->app_pop_daily, array(
				"time" => $nowisnow,
				"postnum" => $post_id,
				"postcount" => 1
			));
		}
	}

	// get all the post view info so we can update meta fields
	$sql = $wpdb->prepare("
		SELECT t.postcount AS total, d.postcount AS today
		FROM $wpdb->app_pop_total AS t
		INNER JOIN $wpdb->app_pop_daily AS d ON t.postnum = d.postnum
		WHERE t.postnum = %s AND d.time = %s
	", $post_id, $nowisnow);

	$row = $wpdb->get_row($sql);

	// add the counters to temp values on the post so it's easy to call from the loop
	update_post_meta($post_id, $app_abbr.'_daily_count', $row->today);
	update_post_meta($post_id, $app_abbr.'_total_count', $row->total);
}

