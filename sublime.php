<?php


// Main configuration
$inQuery = $argv[1] ?: '';
$root = exec('printf $HOME').'/Library/Application Support/Sublime Text 2/Settings/Session.sublime_session';
$reProjects = '/"workspaces":[^\[]+([^]]+\])/m';
$reRowQuery = '/'.preg_quote($inQuery).'/i';
$projects = array();
$results = array();


if (file_exists($root) && preg_match($reProjects, file_get_contents($root), $out))
{
	$projects = json_decode($out[1]);

	foreach ($projects AS $path)
	{
		if (preg_match($reRowQuery, $path))
		{
			$pathInfo = pathinfo($path);
			
			$results[] = array(
				'uid' => $path,
				'arg' => $path,
				'title' => basename($path, '.'.$pathInfo['extension']),
				'subtitle' => $path,
				'icon' => 'icon.png',
				'valid' => true);
		}
	}
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