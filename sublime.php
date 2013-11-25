<?php

// Main configuration
$inQuery = $argv[1] ?: '';
$reRowQuery = '/'.preg_quote($inQuery).'.*\.sublime-project$/i';
$results = array();
$cache = "/tmp/alfred2-sublimeprojects.tmp";
$ttl = 10;
$paths = (file_exists($cache) && time()-filemtime($cache) < $ttl) ? json_decode(file_get_contents($cache)) : array();


if (!count($paths))
{
	exec('mdfind "kMDItemFSName=*.sublime-project" | grep -v node_modules', $paths);
	file_put_contents($cache, json_encode($paths));
}

foreach ($paths AS $path)
{
	$pathInfo = pathinfo($path);
	if ($inQuery == '' || preg_match($reRowQuery, $pathInfo['basename']))
		$results[] = array(
			'uid' => $path,
			'arg' => $path,
			'title' => basename($path, '.'.$pathInfo['extension']),
			'subtitle' => 'Open (new window) or ⌘ (append) ',
			'icon' => 'icon.png',
			'valid' => true);
}

// No favorites matched
if (!count($results))
	$results[] = array(
		'uid' => 'none',
		'arg' => 'none',
		'title' => 'No Favorites Found',
		'subtitle' => 'No favorites matching your query were found',
		'icon' => 'icon.png',
		'valid' => false);


// Preparing the XML output file
$xmlObject = new SimpleXMLElement("<items></items>");
foreach($results AS $rows)
{
	$nodeObject = $xmlObject->addChild('item');
	$nodeKeys = array_keys($rows);
	foreach ($nodeKeys AS $key)
		$nodeObject->{ $key == 'uid' || $key == 'arg' ? 'addAttribute' : 'addChild' }($key, $rows[$key]);
}

// Print the XML output
echo $xmlObject->asXML();  

?>