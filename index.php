<?php
function curPageURL()
{
	$pageURL = 'http';
	if( isset($_SERVER["HTTPS"]) AND $_SERVER["HTTPS"] == "on" )
	{
		$pageURL .= "s";
	}
	$pageURL .= "://";
	if( $_SERVER["SERVER_PORT"] != "80" )
	{
		$pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
	}
	else
	{
		$pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}


include("simple_html_dom.php");
if( !empty($_REQUEST['show_id']) )
{
	$html = @file_get_html('http://eztv.ag/shows/' . $_REQUEST['show_id']);
	if( empty($html) )
	{
		echo "Show not found!";
		exit;
	}


	header("content-type:text/xml");

	echo '<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE torrent PUBLIC "-//bitTorrent//DTD torrent 0.1//EN" "http://xmlns.ezrss.it/0.1/dtd/">
<rss version="2.0">
	<channel>
		<title>ezRSS - Search Results</title>
		<description>Custom RSS feed based off search filters.</description>';

	foreach( $html->find('a[class=magnet]') as $element )
	{
		$links[$element->parent()->prev_sibling()->first_child()->title] = $element->href;
	}

	arsort($links);
	foreach( $links as $key => $link )
	{
		echo "<item>";
		echo '<title><![CDATA[' . $key . ']]></title>
		<link><![CDATA[' . $link . ']]></link>';
		echo "</item>";
	}

	echo '</channel>
	</rss>';
}
else
{
	// Show form

	include_once('html5up-hyperspace/index.php');

}
