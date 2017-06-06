<script src="js/sorttable.js"></script>
<script src="js/main.js"></script>

<div id='loading'></div>
<?php
/*
File name: mal_files.php
Purpose: Displays full list of malicious files communicating with the given IP
*/

session_start();

ini_set('display_errors', 'On');
error_reporting(E_ALL);

//API stuff
$base_report_url = "https://www.virustotal.com/vtapi/v2/file/report";
$api_key = "";

@$ip = $_GET['ip'];


if (isset($_SESSION[$ip]) && isset($_SESSION[$ip]['mal_files'])){
	$mal_file_array = $_SESSION[$ip]['mal_files'];
	echo "<h3>Malicious files talking to $ip</h3>";
	echo "<table class='sortable' border='1'><tr><th>Date ></th><th>Positives ></th><th>SHA256 ></th><th>Symantec Detection ></th><th>All Other Detection ></th></tr>";
	
	foreach($mal_file_array as $value){
		$results_array_tally = array();
		//process SHA256 reports from AV vendors
		$query_report_url = $base_report_url . "?apikey=" . $api_key . "&resource=" . $value->sha256;
		
		@$resp_array = json_decode(file_get_contents($query_report_url));
		
		echo "<tr><td>" . @$value->date . "</td><td>" . @$value->positives . "/" . @$value->total . "</td><td><a target='_blank' href='https://www.virustotal.com/en/file/" . @$value->sha256 . "/analysis'>" . @$value->sha256 . "</a></td><td>" . @$resp_array->scans->Symantec->result . "</td><td>" . "<a target='_blank' href='https://www.virustotal.com/en/file/" . @$value->sha256 . "/analysis'>"  . "VirusTotal Link</a></td></tr>";
		
	}
	
	echo "</table>";

	}
else {
	echo "<h3>Don't have info for that IP. Session may have timed out or there is no info to be displayed.</h3>";
}

?>
