<head>
<script src="js/sorttable.js"></script>
<script src="js/main.js"></script>
<link rel="stylesheet" type="text/css" href="css/style.css">


<script>

window.onload = function() {  
document.getElementById('btnsubmit').onclick = function () {  
        load_data();  
    };
}
</script>
</head>

<?php

session_start();

ini_set('display_errors', 'On');
error_reporting(E_ALL);

$base_ip_url = "https://www.virustotal.com/vtapi/v2/ip-address/report";
$base_url_url = "https://www.virustotal.com/vtapi/v2/url/report";
@$current_data = $_POST['IPs'];
$api_key = "";

$data_array = preg_split('/[|;, \n\r]+/', $current_data);

$size_data_array = sizeof($data_array);

?>
<h1>IP Lookup</h1>
<form method='POST' action='index.php' name='form'>
	<textarea name='IPs' rows='6' cols='50'><?php if (isset($_POST['IPs'])){/*trim whitespace.*/echo trim($_POST['IPs']);}?></textarea></br >	
	<input type='submit' action='submit' value='Submit' name='s' id='btnsubmit'/>
 
</form>
<div id='loading'>
</div>

<?php
if (isset($_POST['s'])){

echo "<table class='sortable' border='1'>";
echo "<tr><th>IP ></th><th>Country ></th><th>AS owner ></th><th>Domain count ></th><th>Malicious files talking to IP ></th><th>Malicious URL count ></th></tr>";
}
foreach($data_array as $key => $value){	
	if($data_array[$key] != ""){
		echo "<tr>";
		$query_ip_url = $base_ip_url . "?apikey=" . $api_key . "&ip=" . $data_array[$key];
		@$resp_array = json_decode(file_get_contents($query_ip_url));
	
		/*
		format for $_SESSION:

			      urls	
			     /
		$_SESSION[IP]-->domains
 		 	     \
			      mal_files
		*/
	
		//get the array with all the domains for this IP so we can do stuff to it
		@$domains_array = $resp_array->resolutions;	
		$_SESSION[$data_array[$key]]['domains'] = $domains_array;
		$domain_count = count($domains_array);
	
		//all the malicious files talking to this IP
		@$mal_file_array = $resp_array->detected_communicating_samples;
		$_SESSION[$data_array[$key]]['mal_files'] = $mal_file_array;
		$mal_file_count = count($mal_file_array);
	
		//all the malicious URLs for this IP
		@$url_array = $resp_array->detected_urls;
		$_SESSION[$data_array[$key]]['urls'] = $url_array;
		$url_count = count($url_array);
		
		echo "<td>" . $data_array[$key] . "</td><td>" . @$resp_array->country . "</td>" . "<td>" . @$resp_array->as_owner . "</td><td><a href='domains.php?ip=" . $data_array[$key] . "' target='_blank'>" . $domain_count . "</a></td><td><a href='mal_files.php?ip=" . $data_array[$key] . "' target='_blank'>" . $mal_file_count . "</a></td><td><a href='urls.php?ip=" . $data_array[$key] . "' target='_blank'>" . $url_count . "</a></td>";	
	
		echo "</tr>";
	}

echo "</table>";

?>
