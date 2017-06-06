<script src="js/sorttable.js"></script>

<?php
/*
File name: urls.php
Purpose: Displays full list of URLs on the given IP
*/

session_start();

ini_set('display_errors', 'On');
error_reporting(E_ALL);

@$ip = $_GET['ip'];

if (isset($_SESSION[$ip]) && isset($_SESSION[$ip]['urls'])){
	$url_array = $_SESSION[$ip]['urls'];
	echo "<h3>Malicious URLs on $ip</h3>";
	echo "<table class='sortable' border='1'><tr><th>Date ></th><th>Positives ></th><th>URL (first 150 characters) ></th></tr>";

	foreach($url_array as $value){
		echo "<tr><td>" . $value->scan_date . "</td><td>" . $value->positives . "/" . $value->total . "</td><td><a href='https://www.virustotal.com/en/url/" . hash('sha256',$value->url) . "/analysis'>" . substr($value->url,0,150) . "</a></td></tr>";
		
	}

	echo "</table>";
}
else {
	echo "<h3>Don't have info for that IP. Session may have timed out or there is no info to be displayed.</h3>";
}

?>
