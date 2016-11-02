<?php

// Get Data
$str = file_get_contents('https://eztv.ag/js/search_shows1.js');

$str = substr($str,0,strpos($str, '$(document).ready'));
echo $str;