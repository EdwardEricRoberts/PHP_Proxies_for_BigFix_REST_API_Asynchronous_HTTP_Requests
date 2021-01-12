<?php
	// Defines output as an XML Document
	header('Content-type: application/xml');
	
	// Fetches HTTP variables from the PHP's Domain URL into PHP variables
	$userName = $_GET['user'];
	$password = $_GET['pass'];
	$server = $_GET['serv'];
	$computerGroups = json_decode($_GET['cg']);
	
	if (sizeof($computerGroups) == 0)
		$computerGroups = array(0);
	
	date_default_timezone_set('America/New_York');
	
	$currentDate = date("D, d M Y H:i:s O");
	$secondTuesdayThisMonth = date("D, d M Y H:i:s O", strtotime("second tue of ".date("F Y")));
	$thursdayAfterSecondTuesdayThisMonth = date("D, d M Y H:i:s O", strtotime("second tue of ".date("F Y")." +2 days"));
	$thursdayAfterSecondTuesdayLastMonth = date("D, d M Y H:i:s O", strtotime("second tue of ".date("F Y", strtotime("last month"))." +2 days"));
	$comparisonDate = "";
	if ((new DateTime($secondTuesdayThisMonth)) > (new DateTime($currentDate))) {
		$comparisonDate = $thursdayAfterSecondTuesdayLastMonth;
	}
	else {
		$comparisonDate = $thursdayAfterSecondTuesdayThisMonth;
	}
	//echo '<script language="javascript">';
	//echo 'alert("'.$comparisonDate.'")';
	//echo '</script>';
	
	// Relevance Query as Concatenated String
	$relevance = 
		'( '.
			'0, '.
			'"All Selected Groups", '.
			'item 0 of it, '.
			'item 1 of it, '.
			'(item 2 of it) + (item 3 of it), '.
			'item 2 of it, '.
			'item 3 of it, '.
			'( '.
				'if ((item 1 of it) = 0 and (item 0 of it) != 0) '.
				'then ("Unknown") '.
				'else '.
				'( '.
					'if (((item 2 of it) + (item 3 of it)) = 0) '.
					'then ("N/A") '.
					'else (((((item 2 of it) as floating point)/(((item 2 of it) as floating point) + ((item 3 of it) as floating point)))* 100) as integer as string & "%")'.
				') '.
			') '.
		') of '.
		'( '.
			'size of item 0 of it, '.
			'size of item 1 of it, '.
			'sum of '.
			'( '.
				'number of '.
				'( '.
					'results (elements of item 1 of it, elements of item 2 of it) '.
					'whose (remediated flag of it) '.
				') '.
			'), '.
			'sum of '.
			'( '.
				'number of '.
				'( '.
					'results (elements of item 1 of it, elements of item 2 of it) '.
					'whose (relevant flag of it) '.
				') '.
			') '.	
		') of '.
		'( '.
			'set of '.
			'items 0 of '.
			'( '.
				'( '.
					'subscribed computers of '.
					'bes sites '.
					'whose (name of it = "Enterprise Security"), '.
					'members of it '.
				') '.
				'whose (id of item 0 of it = id of item 1 of it)'.
				'of '.
				'bes computer groups '.
				'whose '.
				'( ';
	for ($i = 0; $i < sizeof($computerGroups); $i++) {
		if ($i != 0) {
			$relevance .=	
					'or ';
		}
		$relevance .=	
					'id of it = '.$computerGroups[$i] . ' ';
	}
	$relevance .=	
				')'.
			'), '.
			
			'set of '.
			'items 0 of '.
			'( '.
				'( '.
					'subscribed computers '.
					'whose '.
					'('.
						'last report time of it > ("'.$comparisonDate.'" as time)'.
					') '.
					'of '.
					'bes sites '.
					'whose (name of it = "Enterprise Security"), '.
					'members of it '.
				') '.
				'whose (id of item 0 of it = id of item 1 of it) '.
				'of '.
				'bes computer groups '.
				'whose '.
				'( ';
	for ($i = 0; $i < sizeof($computerGroups); $i++) {
		if ($i != 0) {
			$relevance .=	
					'or ';
		}
		$relevance .=	
					'id of it = '.$computerGroups[$i] . ' ';
	}
	$relevance .=	
				')'.
			'), '.
			
			'set of '.
			'fixlets '.
			'whose '.
			'( '.
				'globally visible flag of it = TRUE and '.
				'( '.
					'exists source severity '.
					'whose '.
					'( '.
						'it is  not "" and '.
						'it does not contain "N/A" and '.
						'it does not contain "Unspecified" '.
					') '.
					'of it  '.
				') and '.
				'(source release date of it) > date "01 Jan 2000" and '.
				'exists results whose (remediated flag of it or relevant flag of it) of it and '.
				'exists actions of it '.
			') '.
			'of '.
			'bes sites '.
			'whose (name of it = "Enterprise Security") '.
		'); '.
		'( '.
			'id of item 0 of it, '.
			'name of item 0 of it, '.
			'item 1 of it, '.
			'item 2 of it, '.
			'(item 3 of it) + (item 4 of it), '.
			'item 3 of it, '.
			'item 4 of it, '.
			'( '.
				'if ((item 2 of it) = 0 and (item 1 of it) != 0) '.
				'then ("Unknown") '.
				'else '.
				'( '.
					'if (((item 3 of it) + (item 4 of it)) = 0) '.
					'then ("N/A") '.
					'else (((((item 3 of it) as floating point)/(((item 3 of it) as floating point) + ((item 4 of it) as floating point)))* 100) as integer as string & "%")'.
				') '.
			') '.
		') of '.
		'( '.
			'item 0 of it, '.
			'size of item 1 of it, '.
			'size of item 2 of it, '.
			'sum of '.
			'( '.
				'number of '.
				'( '.
					'results (elements of item 2 of it, elements of item 3 of it) '.
					'whose (remediated flag of it) '.
				') '.
			'), '.
			'sum of '.
			'( '.
				'number of '.
				'( '.
					'results (elements of item 2 of it, elements of item 3 of it) '.
					'whose (relevant flag of it) '.
				') '.
			') '.	
		') of '.
		'( '.
			'item 0 of it, '.
			'set of '.
			'items 0 of '.
			'( '.
				'subscribed computers of bes sites whose (name of it = "Enterprise Security"), '.
				'members of item 0 of it '.
			') '.
			'whose (id of item 0 of it = id of item 1 of it), '.
			'set of '.
			'items 0 of '.
			'( '.
				'subscribed computers '.
				'whose '.
				'('.
					'last report time of it > ("'.$comparisonDate.'" as time)'.
				') '.
				'of '.
				'bes sites '.
				'whose (name of it = "Enterprise Security"), '.
				'members of item 0 of it '.
			') '.
			'whose (id of item 0 of it = id of item 1 of it), '.
			'item 1 of it '.
		') of '.
		'( '.
			'bes computer groups '.
			'whose '.
			'( ';
	for ($i = 0; $i < sizeof($computerGroups); $i++) {
		if ($i != 0) {
			$relevance .=	
				'or ';
		}
		$relevance .=	
				'id of it = '.$computerGroups[$i] . ' ';
	}
	$relevance .=	
			'), '.
			'set of '.
			'fixlets '.
			'whose '.
			'( '.
				'globally visible flag of it = TRUE and '.
				'( '.
					'exists source severity '.
					'whose '.
					'( '.
						'it is  not "" and '.
						'it does not contain "N/A" and '.
						'it does not contain "Unspecified" '.
					') '.
					'of it  '.
				') and '.
				'(source release date of it) > date "01 Jan 2000" and '.
				'exists results whose (remediated flag of it or relevant flag of it) of it and '.
				'exists actions of it '.
			') '.
			'of '.
			'bes sites '.
			'whose (name of it = "Enterprise Security") '.
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