<?php
// Returns a list of Windows Patches along with its source severity.
	
	// Defines output as an XML Document
	header('Content-type: application/xml');
	
	// Fetches HTTP variables from the PHP's Domain URL into PHP variables
	$userName = $_GET['user'];   // BigFix Username
	$password = $_GET['pass'];   // BigFix Password
	$server = $_GET['serv'];     // BigFix Server Name  EX:"bigfixserver.companyname.com:52311"
	$filter = $_GET['cg'];       // Computer Group Name, case sensitive
	
	$filter = str_replace('%20', ' ', $filter);
	$filter = str_replace('%2F', '/', $filter);
	
	// Relevance Query as Concatenated String
	$relevance = 
		//'number of '.
		'( '.
			'(id of item 0 of it ), '.
			'( '.
				'if (exists first ": " of it) '.
				'then '.
				'('.
					'(preceding text of first ": " of it) as string & '.
					'": <br>" & '.
					'( '.	
						'if (exists first " - " of ((following text of first ": " of it) as string)) '.
						'then '.
						'( '.
							'(preceding text of first " - " of ((following text of first ": " of it) as string)) as string & '.
							'" <br>- " & '.
							'( '.
								'if (exists first " - " of ((following text of first " - " of ((following text of first ": " of it) as string)) as string)) '.
								'then '.
								'( '.
									'(preceding text of first " - " of ((following text of first " - " of ((following text of first ": " of it) as string)) as string)) as string & '.
									'" <br>- " & '.
									'( '.
										'if (exists first " - " of ((following text of first " - " of ((following text of first " - " of ((following text of first ": " of it) as string)) as string)) as string)) '.
										'then '.
										'('.
											'(preceding text of first " - " of ((following text of first " - " of ((following text of first " - " of ((following text of first ": " of it) as string)) as string)) as string)) as string & '.
											'" <br>- " & '.
											'( '.
												'if (exists first " - " of ((following text of first " - " of ((following text of first " - " of ((following text of first " - " of ((following text of first ": " of it) as string)) as string)) as string)) as string)) '.
												'then '.
												'( '.
													'(preceding text of first " - " of ((following text of first " - " of ((following text of first " - " of ((following text of first " - " of ((following text of first ": " of it) as string)) as string)) as string)) as string)) as string & '.
													'" <br>- " & '.
													'(following text of first " - " of ((following text of first " - " of ((following text of first " - " of ((following text of first " - " of ((following text of first ": " of it) as string)) as string)) as string)) as string)) as string '.
												') '.
												'else ((following text of first " - " of ((following text of first " - " of ((following text of first " - " of ((following text of first ": " of it) as string)) as string)) as string)) as string) '.
											') '.
										') '.
										'else ((following text of first " - " of ((following text of first " - " of ((following text of first ": " of it) as string)) as string)) as string) '.
									') '.
								') '.
								'else ((following text of first " - " of ((following text of first ": " of it) as string)) as string) '.
							') '.
						') '.
						'else '.
						'('.
							'(following text of first ": " of it) as string'.
						') '.
					')'.
				') '.
				'else '.
				'('.
					'if (exists first " - " of it) '.
					'then '.
					'('.
						'('.
							'(preceding text of first " - " of it) as string '.
						') & '.
						'" <br>- " & '.
						'( '.
							'if (exists first " - " of ((following text of first " - " of it) as string)) '.
							'then '.
							'( '.
								'(preceding text of first " - " of ((following text of first " - " of it) as string)) as string & '.
								'" <br>- " & '.
								'(following text of first " - " of ((following text of first " - " of it) as string)) as string '.
							') '.
							'else ((following text of first " - " of it) as string) '.
						') '.
					') '.
					'else '.
					'('.
						'it'.
					') '.
				') '.
			') of '.
			'name of item 0 of it | "<none>", '.
			'item 1 of it, '.
			'('.
				'((day_of_week of (it as date)) as three letters) & ", " & '.
				'((month of (it as date)) as three letters) & " " & ((day_of_month of (it as date)) as two digits) & ", " & ((year of (it as date)) as string) '.
			') of '.
			'( '.
				'( '.
					'( '.
						'(following text of first ", " of (it as string))'.
					') of '.
					'source release date of item 0 of it as string '.
				') '.
				'| "31 Dec 1969" '.
			'), '.
			'source severity of item 0 of it | "<none>" '.
		') '.
		'of '.
		'( '.
			'item 1 of it, '.
			'number of results (elements of item 0 of it, item 1 of it) whose (remediated flag of it), '.
			'number of results (elements of item 0 of it, item 1 of it) whose (relevant flag of it) '.
		') ';
	if ($filter != "All Machines") {
		$relevance .= 
			'whose '.
			'( '.
				'item 1 of it > 0 or '.
				'item 2 of it > 0 '.
			') ';
	}
	$relevance .= 
		'of '.
		'( '.
			'item 0 of it, '.
			'elements of item 1 of it '.
		') '.
		'of '.
		'( '.
			'( '.
				'set of ';
		if ($filter == "All Machines") {
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
					'exists results whose (remediated flag of it or relevant flag of it) of it '.
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
