<script src="js/sorttable.js"></script>

<?php

/*
File name: hash_search.php
Purpose: Find associated hashes for the same file from VT API
*/

ini_set('display_errors', 'On');
error_reporting(E_ALL);

//API stuff
$base_report_url = "https://www.virustotal.com/vtapi/v2/file/report";
$api_key = "";

@$hashes = $_POST['hashes'];
@$hash_array = preg_split('/[|;, \n\r]+/', $hashes);

$md5_structure = "/^[a-f0-9]{32}$/i";
$sha1_structure = "/^[0-9a-f]{40}$/i";
$sha256_structure = "/[A-Fa-f0-9]{64}/";

?>

<h3>Hash Search</h3>
<form method='POST' action='hash_search.php'>
<textarea name='hashes' rows='6' cols='50'>
<?php if (isset($_POST['hashes'])){/*trim whitespace.*/echo trim($_POST['hashes']);}?>
</textarea>
<input type='submit' action='submit' value='Submit' name='s'/>
</form>

<?php

function spit_out_array($arr){
	$output = "";
	foreach ($arr as $val){
		 $output .= $val . "<br />";	
	}
	return $output;
}

//check to see if the form was submitted
if (isset($_POST['s'])){
	echo "<table class='sortable' border='1'>";
	echo "<tr><th>Known Filenames</th><th>First seen in the wild</th><th>First seen by VirusTotal</th></th><th>SHA1</th><th>SHA256</th><th>MD5</th><th>VirusTotal Link</th></tr>";
	
	foreach($hash_array as $key => $value){
		if($value != ""){
			
		 //form the query string and execute it against the API, getting the json and decoding it into an array we can use
                        $query_report_url = $base_report_url . "?apikey=" . $api_key . "&resource=" . $value . "&allinfo=1";
                       @$resp_array = json_decode(file_get_contents($query_report_url));
			$names = $resp_array->submission_names;
			
					
			echo "<tr><td>" . @spit_out_array($names) . "</td><td>" . @$resp_array->first_seen . "</td><td>" . @$resp_array->additional_info->first_seen_itw . "</td><td>" . @$resp_array->sha1 . "</td><td>" . @$resp_array->sha256 . "</td><td>" . @$resp_array->md5 . "</td><td><a href='" . @$resp_array->permalink . "'>" . "Permalink" . "</a></td></tr>";
		
			
		}
	}	
	echo "</table>";
}

?>
