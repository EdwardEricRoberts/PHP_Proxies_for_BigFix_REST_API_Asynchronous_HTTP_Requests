<?php
	// Defines output as an XML Document
	header('Content-type: application/xml');
	
	// Fetches HTTP variables from the PHP's Domain URL into PHP variables
	$userName = $_GET['user'];
	$password = $_GET['pass'];
	$server = $_GET['serv'];
	$filter = $_GET['cg'];
	
	$filter = str_replace('%20', ' ', $filter);
	$filter = str_replace('%2F', '/', $filter);
	
	// Relevance Query as Concatenated String
	$relevance = 
		'( '.
			'it, '.
			'( '.
				'if (exists first " | " of it) '.
				'then (preceding text of first " | " of it as string) '.
				'else (it) '.
			'), '.
			'( '.
				'if (exists first " | " of it) '.
				'then (following text of first " | " of it as string) '.
				'else ("<none>") '.
			'), '.
			'multiplicity of it '.
		') '.
		'of '.
		'unique values '.
		//
		'of '.
		'( '.
			'if (it contains "%1F") '.
			'then (concatenation of substrings separated by "%1F" of it) '.
			'else (it) '.
		') '.
		'of '.
		'( '.
			'if (it contains "%1E") '.
			'then (concatenation of substrings separated by "%1E" of it) '.
			'else (it) '.
		') '.
		'of '.
		'( '.
			'if (it contains "%1D") '.
			'then (concatenation of substrings separated by "%1D" of it) '.
			'else (it) '.
		') '.
		'of '.
		'( '.
			'if (it contains "%1C") '.
			'then (concatenation of substrings separated by "%1C" of it) '.
			'else (it) '.
		') '.
		'of '.
		'( '.
			'if (it contains "%1B") '.
			'then (concatenation of substrings separated by "%1B" of it) '.
			'else (it) '.
		') '.
		'of '.
		'( '.
			'if (it contains "%1A") '.
			'then (concatenation of substrings separated by "%1A" of it) '.
			'else (it) '.
		') '.
		'of '.
		'( '.
			'if (it contains "%19") '.
			'then (concatenation of substrings separated by "%19" of it) '.
			'else (it) '.
		') '.
		'of '.
		'( '.
			'if (it contains "%18") '.
			'then (concatenation of substrings separated by "%18" of it) '.
			'else (it) '.
		') '.
		'of '.
		'( '.
			'if (it contains "%17") '.
			'then (concatenation of substrings separated by "%17" of it) '.
			'else (it) '.
		') '.
		'of '.
		'( '.
			'if (it contains "%16") '.
			'then (concatenation of substrings separated by "%16" of it) '.
			'else (it) '.
		') '.
		'of '.
		'( '.
			'if (it contains "%15") '.
			'then (concatenation of substrings separated by "%15" of it) '.
			'else (it) '.
		') '.
		'of '.
		'( '.
			'if (it contains "%14") '.
			'then (concatenation of substrings separated by "%14" of it) '.
			'else (it) '.
		') '.
		'of '.
		'( '.
			'if (it contains "%13") '.
			'then (concatenation of substrings separated by "%13" of it) '.
			'else (it) '.
		') '.
		'of '.
		'( '.
			'if (it contains "%12") '.
			'then (concatenation of substrings separated by "%12" of it) '.
			'else (it) '.
		') '.
		'of '.
		'( '.
			'if (it contains "%11") '.
			'then (concatenation of substrings separated by "%11" of it) '.
			'else (it) '.
		') '.
		'of '.
		'( '.
			'if (it contains "%10") '.
			'then (concatenation of substrings separated by "%10" of it) '.
			'else (it) '.
		') '.
		'of '.
		'( '.
			'if (it contains "%0F") '.
			'then (concatenation of substrings separated by "%0F" of it) '.
			'else (it) '.
		') '.
		'of '.
		'( '.
			'if (it contains "%0E") '.
			'then (concatenation of substrings separated by "%0E" of it) '.
			'else (it) '.
		') '.
		'of '.
		'( '.
			'if (it contains "%0C") '.
			'then (concatenation of substrings separated by "%0C" of it) '.
			'else (it) '.
		') '.
		'of '.
		'( '.
			'if (it contains "%0B") '.
			'then (concatenation of substrings separated by "%0B" of it) '.
			'else (it) '.
		') '.
		'of '.
		'( '.
			'if (it contains "%08") '.
			'then (concatenation of substrings separated by "%08" of it) '.
			'else (it) '.
		') '.
		'of '.
		'( '.
			'if (it contains "%07") '.
			'then (concatenation of substrings separated by "%00" of it) '.
			'else (it) '.
		') '.
		'of '.
		'( '.
			'if (it contains "%06") '.
			'then (concatenation of substrings separated by "%06" of it) '.
			'else (it) '.
		') '.
		'of '.
		'( '.
			'if (it contains "%05") '.
			'then (concatenation of substrings separated by "%05" of it) '.
			'else (it) '.
		') '.
		'of '.
		'( '.
			'if (it contains "%04") '.
			'then (concatenation of substrings separated by "%04" of it) '.
			'else (it) '.
		') '.
		'of '.
		'( '.
			'if (it contains "%03") '.
			'then (concatenation of substrings separated by "%03" of it) '.
			'else (it) '.
		') '.
		'of '.
		'( '.
			'if (it contains "%02") '.
			'then (concatenation of substrings separated by "%02" of it) '.
			'else (it) '.
		') '.
		'of '.
		'( '.
			'if (it contains "%01") '.
			'then (concatenation of substrings separated by "%01" of it) '.
			'else (it) '.
		') '.
		'of '.
		'( '.
			'if (it contains "%00") '.
			'then (concatenation of substrings separated by "%00" of it) '.
			'else (it) '.
		') '.
		//
		'of '.
		'values of '.
		'results from '.
		'( '.
			'bes properties '. 
			'whose '.
			'('.
				'name of it contains "Installed Applications - Windows" and '.
				'name of source analysis of it = "Application Information (Windows)"'.
			') '.
		') '.
		'of ';
	if ($filter == "All Machines") {
		$relevance .= 
			'bes computers';
	}
	else {
		$relevance .= 
		'members of bes computer groups whose (name of it = "'.$filter.'") ';
	}
		
		
	// HTTP Encoding to make the relevance query URL Friendly
	//$relevance = str_replace('%', '%252525', $relevance);
	$relevance = str_replace(' ', '%20', $relevance);
	$relevance = str_replace('!', '%21', $relevance);
	$relevance = str_replace('"', '%22', $relevance);
	$relevance = str_replace('#', '%23', $relevance);
	$relevance = str_replace('$', '%24', $relevance);
	$relevance = str_replace('&', '%26', $relevance);		// ' = %27
	$relevance = str_replace('*', '%2A', $relevance);
	$relevance = str_replace('+', '%2B', $relevance);
	$relevance = str_replace(',', '%2C', $relevance);
	$relevance = str_replace('-', '%2D', $relevance);
	$relevance = str_replace('.', '%2E', $relevance);
	$relevance = str_replace('/', '%2F', $relevance);
	$relevance = str_replace(':', '%3A', $relevance);
	$relevance = str_replace(';', '%3B', $relevance);
	$relevance = str_replace('<', '%3C', $relevance);
	$relevance = str_replace('=', '%3D', $relevance);
	$relevance = str_replace('>', '%3E', $relevance);
	$relevance = str_replace('?', '%3F', $relevance);
	$relevance = str_replace('@', '%40', $relevance);
	$relevance = str_replace('\\', '%5C', $relevance);
	$relevance = str_replace('_', '%5F', $relevance);
	$relevance = str_replace('~', '%7E', $relevance);
	
	// BigFix REST API URL
	$url = "https://".$server."/api/query?relevance=".$relevance;
	
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