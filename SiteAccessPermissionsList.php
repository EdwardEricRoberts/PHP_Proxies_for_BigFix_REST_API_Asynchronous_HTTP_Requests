<?php
// Returns a list of all BigFix Users that have permission to access a particular Site.  The Site Name and Site Type must be lined up correctly.
	
	// Defines output as an XML Document
	header('Content-type: application/xml');
	
	// Fetches HTTP variables from the PHP's Domain URL into PHP variables
	$userName = $_GET['user'];  // BigFix Username
	$password = $_GET['pass'];  // BigFix Password 
	$server = $_GET['serv'];    // BigFix Server Name  EX:"bigfixserver.companyname.com:52311"
	$siteType = $_GET['type'];  // Site Type can only be one of the following (external, custom, operator, or master)
	$site = $_GET['site'];      // Site Name, case sensitive
	
	$site = str_replace('%', '%252525', $site); // This is the reason why I could not simply use "urlencode".  In order for '%' to be used in the relevance as a string you must specially encode it like this.
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
