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
		//'number of '.
		'('.
			'id of it, '.
			'(name of it | "<none>") & " <br>" & (device type of it | "<none>"), '.
			'concatenation " <br>" of values of results from (bes property "User Name") of it as string | "<none>", '.
			'('.
				'if ((first 3 of it) as string = "Win") '.
				'then ((preceding text of first " " of it) as string & " <br>" as string & (following text of first " " of it) as string) '.
				'else ((preceding text of last " " of it) as string & " <br>" as string & (following text of last " " of it) as string)'.
			') of '.
			'operating system of it | "<none>", '.
			'concatenation (" <br>") of (ip addresses of it as string) | "<none>", '.
			'('.
				'('.
					'((day_of_week of (it as date)) as three letters) & ", " & '.
					'((month of (it as date)) as three letters) & " " & ((day_of_month of (it as date)) as two digits) & ", " & ((year of (it as date)) as string) '.
				') of '.
				'( '.
					'('.
						'( '.
							'( '.
								'preceding text of (first "/" of (following text of (first "/" of it))) & '.
								'" " & '.
								'(((preceding text of (first "/" of it)) as integer) as month) as three letters & '.
								'" " & '.
								'following text of (last "/" of it) '.
							') of '.
							'(value of results from (bes property "First Report Time") of it) '.
						')'.
					') | '.
					'"31 Dec 1969" '.
				') '.
			') '.
		') '.
		'of ';
		
	if ($filter == "All Machines") {
		$relevance .= 
			'bes computers ';
	}
	else {
		$relevance .= 
			'members of '.
			'bes computer groups '.
			'whose ( name of it = "'.$filter.'") ';
	}
	
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