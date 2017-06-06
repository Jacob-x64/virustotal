<script src="js/sorttable.js"></script>

<?php
/*
File name: domains.php
Purpose: Displays full list of domain info for the given IP
*/

session_start();

ini_set('display_errors', 'On');
error_reporting(E_ALL);

@$ip = $_GET['ip'];


if (isset($_SESSION[$ip]) && isset($_SESSION[$ip]['domains'])){
	$domain_array = $_SESSION[$ip]['domains'];
	echo "<h3>Resolved domains for $ip</h3>";
	echo "<table class='sortable' border='1'><tr><th>Last Resolved Date ></th><th>Domain (click for VT link) ></th></tr>";

	foreach($domain_array as $value){
		echo "<tr><td>" . substr($value->last_resolved,0, 10) . "</td><td><a href='https://www.virustotal.com/en/domain/" . $value->hostname . "/information'>" . $value->hostname . "</a></td></tr>";
		
	}

	echo "</table>";
}
else {
	echo "<h3>Don't have domain info for that IP. The session may have timed out or there is no info to be displayed on this IP.<h3>";
}

?>
