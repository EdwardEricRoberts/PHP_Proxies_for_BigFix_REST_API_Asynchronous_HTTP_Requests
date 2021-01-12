<?php
	// Defines output as an XML Document
	header('Content-type: application/xml');
	
	// Fetches HTTP variables from the PHP's Domain URL into PHP variables
	$userName = $_GET['user'];
	$password = $_GET['pass'];
	$server = $_GET['serv'];
	$siteType = $_GET['type']; //external, custom, operator, master
	$site = $_GET['site'];
	
	$site = str_replace('%', '%252525', $site);
	$site = str_replace(' ', '%20', $site);
	$site = str_replace('!', '%21', $site);
	$site = str_replace('"', '%22', $site);
	$site = str_replace('#', '%23', $site);
	$site = str_replace('$', '%24', $site);
	$site = str_replace('&', '%26', $site);		// ' = %27
	$site = str_replace('*', '%2A', $site);
	$site = str_replace('+', '%2B', $site);
	$site = str_replace(',', '%2C', $site);
	$site = str_replace('-', '%2D', $site);
	$site = str_replace('.', '%2E', $site);
	$site = str_replace('/', '%2F', $site);
	$site = str_replace(':', '%3A', $site);
	$site = str_replace(';', '%3B', $site);
	$site = str_replace('<', '%3C', $site);
	$site = str_replace('=', '%3D', $site);
	$site = str_replace('>', '%3E', $site);
	$site = str_replace('?', '%3F', $site);
	$site = str_replace('@', '%40', $site);
	$site = str_replace('\\', '%5C', $site);
	$site = str_replace('_', '%5F', $site);
	$site = str_replace('~', '%7E', $site);
	
	// BigFix REST API URL
	if ($siteType == 'master') {
		$url = "https://".$server."/api/site/".$siteType."/permissions";
	}
	else {
		$url = "https://".$server."/api/site/".$siteType."/".$site."/permissions";
	}
	
	// Proxy call to BigFix server using PHP cURL
	$ch = curl_init();
	// Submits the API's URL
	curl_setopt($ch, CURLOPT_URL,$url);
	// Defines authorization type as Basic Authentication
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	// Submits User Name and Password to the URL
	curl_setopt($ch, CURLOPT_USERPWD, "$userName:$password");
	// Allows output to be set to a variable
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
	// Turns off SSL Verification
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	// Sets cURL output to return variable
	$returned = curl_exec($ch);
	// Closes cURL
	curl_close ($ch);
	// Outputs results to the page
	echo $returned; 
?>