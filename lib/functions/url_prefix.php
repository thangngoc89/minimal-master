<?php
/*
 * Prepend all included hosts
 */
add_filter('the_content', 'kn_prefix_post_urls');

function kn_prefix_post_urls($content) {
	if ( ! is_singular('post') ) {
		return $content;
	}
	$prefix = genesis_get_option('url_prefix');
  $urls = find_all_urls_in_text($content);
	$included_host = get_included_hosts_array();

  foreach($urls as $url) {
		$host = parse_url($url)['host'];

		if (in_array($host, $included_host)) {
			$content = str_replace($url, $prefix.$url, $content);
		}
	}

	return $content;
}

function find_all_urls_in_text($text) {
  $regex = '/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i';
  preg_match_all($regex, $text, $matches);

  return $matches[0];
}

function get_included_hosts_array() {
	$raw_hosts = genesis_get_option('url_prefix_include_hosts');
	$raw_hosts_array = explode(',' , $raw_hosts);

	foreach ($raw_hosts_array as $i => $host) {
		$raw_hosts_array[$i] = str_replace(' ', '', $host);
	}
	return $raw_hosts_array;
}
