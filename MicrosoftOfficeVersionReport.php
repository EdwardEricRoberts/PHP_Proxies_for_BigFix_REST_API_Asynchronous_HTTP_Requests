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
	/*
		//'number of '.
		'( '.
			'id of item 1 of it, '.
			'(name of item 1 of it | "<none>") & "<br>" & (device type of item 1 of it | "<none>"), '.
			''.
			'item 0 of it | "<none>", '.
			'( '.
				'if (exists first "|" of item 0 of it) '.
				'then (preceding text of first "|" of item 0 of it) '.
				'else (item 0 of it) '.
			'), '.
			'( '.
				'if (exists first "|" of item 0 of it) '.
				'then (following text of first "|" of item 0 of it) '.
				'else ("-") '.
			') '.
		') of '.
		'( '.
			'values whose (it as lowercase contains "microsoft office") of it, ';
			
	if ($filter == "All Machines") {
		$relevance .= 
			'computers of it ';
	}
	else {
		$relevance .= 
			'computers '.
			'whose '.
			'( '.
				'id of it = id of members of bes computer groups whose (name of it = "'.$filter.'") '.
			')'.
			'of it ';
	}
	$relevance .= 
		') of '.
		'results of '.
		'bes properties whose (name of it contains "Installed Applications - Windows" and name of source analysis of it = "Application Information (Windows)")';
	*/
	/*
	//'number of '.
		'( '.
			'id of item 1 of it, '.
			'(name of item 1 of it | "<none>") & " <br>" & (device type of item 1 of it | "<none>"), '.
			'concatenation " <br>" of values of results from (bes property "User Name") of (item 1 of it) as string | "<none>", '.
			'item 0 of it | "<none>", '.
			'( '.
				'if (exists first "|" of item 0 of it) '.
				'then (preceding text of first "|" of item 0 of it) '.
				'else (item 0 of it) '.
			'), '.
			'( '.
				'if (exists first "|" of item 0 of it) '.
				'then (following text of first "|" of item 0 of it) '.
				'else ("-") '.
			') '.
		') '.
		'of '.
		'( '.
			'values whose ((it as lowercase contains "microsoft office") and (start of (substring "microsoft office" of (it as lowercase)) = 0)) of it, '.
			'computers of it '.
		') '.
		'of '.
		'results '.
		'( '.
			'bes property "Installed Applications - Windows" '.
			'whose (name of source analysis of it = "Application Information (Windows)") '.
			', ';
	if ($filter == "All Machines") {
		$relevance .= 
			'bes computers';
	}
	else {
		$relevance .= 
			'members of '.
			'bes computer groups '.
			'whose (name of it = "'.$filter.'")';
	}
	$relevance .= 
		')';
	*/
	
	$relevance = 
		//'number of '.
		'( '.
			'ids of item 1 of it, '.
			'names of item 1 of it, '.
			'concatenation " <br>" of values of results (item 1 of it, elements of item 2 of it) as string | "<none>", '.
			'item 0 of it | "<none>", '.
			'( '.
				'if (exists first "|" of item 0 of it) '.
				'then (preceding text of first " |" of item 0 of it) '.
				'else (item 0 of it) '.
			'), '.
			'( '.
				'if (exists first "|" of item 0 of it) '.
				'then (following text of first "| " of item 0 of it) '.
				'else ("-") '.
			') '.
		') '.
		'of '.
		'( '.
			'values whose ((it as lowercase contains "microsoft office") and (start of (substring "microsoft office" of (it as lowercase)) = 0)) of results (item 0 of it, elements of item 1 of it), '.
			'item 0 of it, '.
			'item 2 of it '.
		') '.
		'of '.
		'( '.
			'elements of item 1 of it, '.
			'item 0 of it, '.
			'item 2 of it '.
		') '.
		'of '.
		'( '.
			'set of bes properties whose (id of it = (2299708709, 2930, 1)), '. //"Installed Applications - Window"
			'set of ';
	if ($filter == "All Machines") {
		$relevance .= 
			'bes computers, ';
	}
	else {
		$relevance .= 
			'( '.
				'members of '.
				'bes computer groups '.
				'whose (name of it = "'.$filter.'") '.
			'), ';
	}
	$relevance .= 
			'set of bes properties whose (id of it = (2299708709, 29, 1)) '. //"User Name"
		') ';
	
	// HTTP Encoding to make the relevance query URL Friendly
	$relevance = str_replace('%', '%252525', $relevance);
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