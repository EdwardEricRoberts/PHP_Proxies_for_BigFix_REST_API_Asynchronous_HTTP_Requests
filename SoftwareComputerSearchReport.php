<?php
	// Defines output as an XML Document
	header('Content-type: application/xml');
	
	// Fetches HTTP variables from the PHP's Domain URL into PHP variables
	$userName = $_GET['user'];
	$password = $_GET['pass'];
	$server = $_GET['serv'];
	$application = $_GET['app'];
	$filter = $_GET['cg'];
	
	$filter = str_replace('%20', ' ', $filter);
	$filter = str_replace('%2F', '/', $filter);
	
	$application = str_replace('%20', ' ', $application);
	$application = str_replace('%2F', '/', $application);
	$application = str_replace('%2E', '.', $application);
	
	$application = str_replace('%', '%252525', $application);
	
	$applicationWords = explode(" ", $application);
	
	// Relevance Query as Concatenated String
	$relevance = 
		'( '.
			'unique values of id of item 0 of it, '.
			'(name of item 0 of it | "<none>") & " <br>" & (device type of item 0 of it | "<none>"), '.
			'(concatenation " <br>" of values of results from (bes property "User Name") of item 0 of it as string) | "<none>", '.
			'('.
				'if ((first 3 of it) as string = "Win") '.
				'then ((preceding text of first " " of it) as string & html " <br>" as string & (following text of first " " of it) as string) '.
				'else ((preceding text of last " " of it) as string & html " <br>" as string & (following text of last " " of it) as string)'.
			') of '.
			'operating system of  item 0 of it | "<none>", '.
			'concatenation (" <br>") of (ip addresses of item 0 of it as string) | "<none>", '.
			'('.
				'(preceding text of end of first "Hz" of it) as string & '.
				'html " <br>" as string & '.
				'(following text of end of first "Hz " of it) as string '.
			') of '.
			'cpu of item 0 of it | "<none>", '.
			'('.
				'('.
					'((day_of_week of it) as three letters) & ", " & '.
					'((month of it) as three letters) & " " & ((day_of_month of it) as two digits) & ", " & ((year of it) as string) '.
				') of '.
				'date (local time zone) of it & '.
				'html " <br>" & '.
				'('.
					'if ((hour_of_day of it) <= 12) '.
					'then '.
					'('.
						'if ((hour_of_day of it != 0 )) '.
						'then ((two digit hour of it) & ":" & (two digit minute of it) & ":" & (two digit second of it) & " AM") '.
						'else ((12 as string) & ":" & (two digit minute of it) & ":" & (two digit second of it) & " AM") '.
					') '.
					'else '.
					'('.
						'('.
							'if (((hour_of_day of it) - 12) < 10) '.
							'then ((0 as string) & (((hour_of_day of it) - 12) as string)) '.
							'else (((hour_of_day of it) - 12) as string) '.
						') & ":" & (two digit minute of it) & ":" & (two digit second of it) & " PM"'.
					')'.
				') of '.
				'time (local time zone) of it '.
			') of last report time of item 0 of it, '.
			'item 1 of it, '.
			'( '.
				'if (exists first " | " of item 1 of it) '.
				'then (preceding text of first " | " of item 1 of it as string) '.
				'else (item 1 of it) '.
			'), '.
			'( '.
				'if (exists first " | " of item 1 of it) '.
				'then (following text of first " | " of item 1 of it as string) '.
				'else ("<none>") '.
			')'.
		')'.
		'of '.
		'('.
			'item 0 of it, '.
			'( '.
				'if (item 1 of it contains "%1F") '.
				'then (concatenation of substrings separated by "%1F" of item 1 of it) '.
				'else (item 1 of it) '.
			') '.
		') '.
		'of '.
		'('.
			'item 0 of it, '.
			'( '.
				'if (item 1 of it contains "%1E") '.
				'then (concatenation of substrings separated by "%1E" of item 1 of it) '.
				'else (item 1 of it) '.
			') '.
		') '.
		'of '.
		'('.
			'item 0 of it, '.
			'( '.
				'if (item 1 of it contains "%1D") '.
				'then (concatenation of substrings separated by "%1D" of item 1 of it) '.
				'else (item 1 of it) '.
			') '.
		') '.
		'of '.
		'('.
			'item 0 of it, '.
			'( '.
				'if (item 1 of it contains "%1C") '.
				'then (concatenation of substrings separated by "%1C" of item 1 of it) '.
				'else (item 1 of it) '.
			') '.
		') '.
		'of '.
		'('.
			'item 0 of it, '.
			'( '.
				'if (item 1 of it contains "%1B") '.
				'then (concatenation of substrings separated by "%1B" of item 1 of it) '.
				'else (item 1 of it) '.
			') '.
		') '.
		'of '.
		'('.
			'item 0 of it, '.
			'( '.
				'if (item 1 of it contains "%1A") '.
				'then (concatenation of substrings separated by "%1A" of item 1 of it) '.
				'else (item 1 of it) '.
			') '.
		') '.
		'of '.
		'('.
			'item 0 of it, '.
			'( '.
				'if (item 1 of it contains "%19") '.
				'then (concatenation of substrings separated by "%19" of item 1 of it) '.
				'else (item 1 of it) '.
			') '.
		') '.
		'of '.
		'('.
			'item 0 of it, '.
			'( '.
				'if (item 1 of it contains "%18") '.
				'then (concatenation of substrings separated by "%18" of item 1 of it) '.
				'else (item 1 of it) '.
			') '.
		') '.
		'of '.
		'('.
			'item 0 of it, '.
			'( '.
				'if (item 1 of it contains "%17") '.
				'then (concatenation of substrings separated by "%17" of item 1 of it) '.
				'else (item 1 of it) '.
			') '.
		') '.
		'of '.
		'('.
			'item 0 of it, '.
			'( '.
				'if (item 1 of it contains "%16") '.
				'then (concatenation of substrings separated by "%16" of item 1 of it) '.
				'else (item 1 of it) '.
			') '.
		') '.
		'of '.
		'('.
			'item 0 of it, '.
			'( '.
				'if (item 1 of it contains "%15") '.
				'then (concatenation of substrings separated by "%15" of item 1 of it) '.
				'else (item 1 of it) '.
			') '.
		') '.
		'of '.
		'('.
			'item 0 of it, '.
			'( '.
				'if (item 1 of it contains "%14") '.
				'then (concatenation of substrings separated by "%14" of item 1 of it) '.
				'else (item 1 of it) '.
			') '.
		') '.
		'of '.
		'('.
			'item 0 of it, '.
			'( '.
				'if (item 1 of it contains "%13") '.
				'then (concatenation of substrings separated by "%13" of item 1 of it) '.
				'else (item 1 of it) '.
			') '.
		') '.
		'of '.
		'('.
			'item 0 of it, '.
			'( '.
				'if (item 1 of it contains "%12") '.
				'then (concatenation of substrings separated by "%12" of item 1 of it) '.
				'else (item 1 of it) '.
			') '.
		') '.
		'of '.
		'('.
			'item 0 of it, '.
			'( '.
				'if (item 1 of it contains "%11") '.
				'then (concatenation of substrings separated by "%11" of item 1 of it) '.
				'else (item 1 of it) '.
			') '.
		') '.
		'of '.
		'('.
			'item 0 of it, '.
			'( '.
				'if (item 1 of it contains "%10") '.
				'then (concatenation of substrings separated by "%10" of item 1 of it) '.
				'else (item 1 of it) '.
			') '.
		') '.
		'of '.
		'('.
			'item 0 of it, '.
			'( '.
				'if (item 1 of it contains "%0F") '.
				'then (concatenation of substrings separated by "%0F" of item 1 of it) '.
				'else (item 1 of it) '.
			') '.
		') '.
		'of '.
		'('.
			'item 0 of it, '.
			'( '.
				'if (item 1 of it contains "%0E") '.
				'then (concatenation of substrings separated by "%0E" of item 1 of it) '.
				'else (item 1 of it) '.
			') '.
		') '.
		'of '.
		'('.
			'item 0 of it, '.
			'( '.
				'if (item 1 of it contains "%0C") '.
				'then (concatenation of substrings separated by "%0C" of item 1 of it) '.
				'else (item 1 of it) '.
			') '.
		') '.
		'of '.
		'('.
			'item 0 of it, '.
			'( '.
				'if (item 1 of it contains "%0B") '.
				'then (concatenation of substrings separated by "%0B" of item 1 of it) '.
				'else (item 1 of it) '.
			') '.
		') '.
		'of '.
		'( '.
			'item 0 of it, '.
			'( '.
				'if (item 1 of it contains "%08") '.
				'then (concatenation of substrings separated by "%08" of item 1 of it) '.
				'else (item 1 of it) '.
			') '.
		') '.
		'of '.
		'('.
			'item 0 of it, '.
			'( '.
				'if (item 1 of it contains "%07") '.
				'then (concatenation of substrings separated by "%07" of item 1 of it) '.
				'else (item 1 of it) '.
			') '.
		') '.
		'of '.
		'('.
			'item 0 of it, '.
			'( '.
				'if (item 1 of it contains "%06") '.
				'then (concatenation of substrings separated by "%06" of item 1 of it) '.
				'else (item 1 of it) '.
			') '.
		') '.
		'of '.
		'('.
			'item 0 of it, '.
			'( '.
				'if (item 1 of it contains "%05") '.
				'then (concatenation of substrings separated by "%05" of item 1 of it) '.
				'else (item 1 of it) '.
			') '.
		') '.
		'of '.
		'('.
			'item 0 of it, '.
			'( '.
				'if (item 1 of it contains "%04") '.
				'then (concatenation of substrings separated by "%04" of item 1 of it) '.
				'else (item 1 of it) '.
			') '.
		') '.
		'of '.
		'('.
			'item 0 of it, '.
			'( '.
				'if (item 1 of it contains "%03") '.
				'then (concatenation of substrings separated by "%03" of item 1 of it) '.
				'else (item 1 of it) '.
			') '.
		') '.
		'of '.
		'('.
			'item 0 of it, '.
			'( '.
				'if (item 1 of it contains "%02") '.
				'then (concatenation of substrings separated by "%02" of item 1 of it) '.
				'else (item 1 of it) '.
			') '.
		') '.
		'of '.
		'('.
			'item 0 of it, '.
			'( '.
				'if (item 1 of it contains "%01") '.
				'then (concatenation of substrings separated by "%01" of item 1 of it) '.
				'else (item 1 of it) '.
			') '.
		') '.
		'of '.
		'('.
			'item 0 of it, '.
			'( '.
				'if (item 1 of it contains "%00") '.
				'then (concatenation of substrings separated by "%00" of item 1 of it) '.
				'else (item 1 of it) '.
			') '.
		') '.
		'of '.
		'( '.
			'computers of it, '.
			'values '.
			'whose '.
			'(';
	foreach($applicationWords as $key => $value) {
		if ($key != 0) {
			$relevance .= 'and ';
		}
		$relevance .= 
				'(it as lowercase contains "'.$value.'") ';
	}

	$relevance .= 
			') of it '.
		') '.
		'of '.
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
			'bes computers ';
	}
	else {
		$relevance .= 
			'members of bes computer groups whose (name of it = "'.$filter.'") ';
	}

	// HTTP Encoding to make the relevance query URL Friendly
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