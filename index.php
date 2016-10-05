<?php

include("simple_html_dom.php");

$html = file_get_html('http://eztv.ag/shows/'.$_REQUEST['show']);

header("content-type:text/xml");

echo '<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE torrent PUBLIC "-//bitTorrent//DTD torrent 0.1//EN" "http://xmlns.ezrss.it/0.1/dtd/">
<rss version="2.0">
	<channel>
		<title>ezRSS - Search Results</title>
		<description>Custom RSS feed based off search filters.</description>';

foreach($html->find('a[class=magnet]') as $element) {
	$links[$element->parent()->prev_sibling()->first_child()->title] = $element->href;
}

arsort($links);
foreach($links as $key => $link) {
	echo "<item>";
	echo '<title><![CDATA['.$key.']]></title>
		<link><![CDATA['.$link.']]></link>';
	echo "</item>";
}

echo '</channel>
</rss>';