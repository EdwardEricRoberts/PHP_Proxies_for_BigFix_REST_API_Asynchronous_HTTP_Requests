<?php
// Returns a list of accessable Windows Computers that also compares the overall numbers of Remidiated and Relevant Windows Patches returning the ratio as a compliance percentage.  Can also be filtered by Computer Group.
	
	// Defines output as an XML Document
	header('Content-type: application/xml');
	
	// Fetches HTTP variables from the PHP's Domain URL into PHP variables
	$userName = $_GET['user'];   // BigFix Username
	$password = $_GET['pass'];   // BigFix Password
	$server = $_GET['serv'];     // BigFix Server Name  EX:"bigfixserver.companyname.com:52311"
	$filter = $_GET['cg'];       // Computer Group, case sensitive
	
	$filter = str_replace('%20', ' ', $filter);
	$filter = str_replace('%2F', '/', $filter);
	
	// Relevance Query as Concatenated String
	$relevance = 
		//'number of '.
		'( '.
			'id of item 0 of it, '.
			'(name of item 0 of it | "<none>") & " <br>" & (device type of item 0 of it | "<none>"), '.
			'concatenation " <br>" of values of results from (bes property "User Name") of item 0 of it as string | "<none>", '.
			'((preceding text of first " " of operating system of item 0 of it) as string & " <br>" & (following text of first " " of operating system of item 0 of it) as string) | "<none>", '.
			'concatenation " <br>" of (ip addresses of item 0 of it as string) | "<none>", '.
			'('.
				'('.
					'((day_of_week of it) as three letters) & ", " & '.
					'((month of it) as three letters) & " " & ((day_of_month of it) as two digits) & ", " & ((year of it) as string) '.
				') of '.
				'date (local time zone) of it & '.
				'html " <br>" & '.
				'('.
					'if ((hour_of_day of it) < 12) '.
					'then '.
					'('.
						'if ((hour_of_day of it != 0 )) '.
						'then ((two digit hour of it) & ":" & (two digit minute of it) & ":" & (two digit second of it) & " AM") '.
						'else ((12 as string) & ":" & (two digit minute of it) & ":" & (two digit second of it) & " AM") '.
					') '.
					'else '.
					'('.
						'('.
							'if ((hour_of_day of it) = 12) '.
							'then (12 as string) '.
							'else '.
							'('.
								'if (((hour_of_day of it) - 12) < 10) '.
								'then ((0 as string) & (((hour_of_day of it) - 12) as string))'.
								'else (((hour_of_day of it) - 12) as string)'.
							') '.
						') & ":" & (two digit minute of it) & ":" & (two digit second of it) & " PM"'.
					')'.
				') of '.
				'time (local time zone) of it '.
			') of last report time of item 0 of it, '.
			//'last report time of item 0 of it as string | "<none>", '.
			'item 2 of it, '.                         // Count of Applicable Windows Patches
			'(item 2 of it) - (item 1 of it), '.      // Count of Remidiated Windows Patches
			'item 1 of it, '.                         // Count of Relevant Windows Patches
			'( '.
				'if (item 2 of it = 0) '.
				'then ("N/A") '.
				'else ((100 - (item 1 of it as floating point / item 2 of it as floating point * 100)) as integer as string & "%") '.
			')'.   // Compliance Percentage
		') '.
		'of '.
		'( '.
			'item 0 of it, '.
			'number of results (item 0 of it, elements of item 1 of it) whose (relevant flag of it), '.
			'number of results (item 0 of it, elements of item 1 of it) whose (remediated flag of it or relevant flag of it) '.
		') '.
		'of '.
		'( '.
			'(elements of item 0 of it), '. // whose (id of it = unique values of ids of members of bes computer group whose(name of it = ""))
			'item 1 of it '.
		') '.
		'of '.
		'( '.
			'( '.
				'set of ';
		if ($filter == "All Machines") {    // This is what I used for my "select everything" state, no Computer Group with that name existed
			$relevance .= 
				'subscribed computers of '.
				'bes sites '.
				'whose (name of it = "Enterprise Security") ';
		}
		else {
			$relevance .=
				'items 0 of '.
				'( '.
					'subscribed computers of bes sites whose (name of it = "Enterprise Security"), '.
					'it'.
				') '.
				'whose (id of item 0 of it = id of item 1 of it) '.
				'of '.
				'members of '.
				'bes computer groups '.
				'whose (name of it = "'.$filter.'") ';
		}
		$relevance .= 
			'), '.
			'( '.
				'set of fixlets '.
				'whose '.
				'( '.
					'globally visible flag of it = TRUE and '.
					'( '.
						'exists source severity '.
						'whose '.
						'( '.
							'it is not "" and '.
							'it does not contain "N/A" and '.
							'it does not contain "Unspecified" '.
						') '.
						'of it '.
					') and '.
					'(source release date of it) > date "01 Jan 2000" and '.
					'exists results whose (remediated flag of it or relevant flag of it) of it and '.
					'exists actions of it '.
				') '.
				'of '.
				'bes sites '.
				'whose (name of it = "Enterprise Security") '.
			') '.
		') ';
	
	// HTTP Encoding to make the relevance query URL Friendly
	$relevance = str_replace('%', '%252525', $relevance); // This is the reason why I could not simply use "urlencode".  In order for '%' to be used in the relevance as a string you must specially encode it like this.
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
