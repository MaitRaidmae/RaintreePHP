#!/usr/bin/php -q
<?php
$servername = "localhost";
$username = "raintree";
$password = "rainPass";
$total_letters = 0;
$letters_array = array();

try {
    $conn = new PDO("mysql:host=$servername;dbname=raintree", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "select p.pn, p.first, p.last, i.iname, i.from_date, i.to_date from patient p left join insurance i on p._id=i.patient_id order by i.to_date desc;";
    $data = $conn->query($query);
    
    echo "Query results:\n\n";
    foreach ($data as $row) {
		// Print query results to console
		echo $row["pn"] . ", " . $row["first"] . ", " . $row["last"];
		// If insurance data exists append insurance data.
		if ($row["iname"] != "") {
			// Convert Date fields 
			$date_from = date('m-d-y',strtotime($row["from_date"]));
			$date_to = date('m-d-y',strtotime($row["to_date"]));
			echo ", " .  $row["iname"] . ", " . $date_from  . ", " . $date_to . "\n";
		}
		else {
			echo "\n";
		}
		// Get Letter stats;
		$lastLength = strlen($row["last"]);
		for($i = 0; $i <= $lastLength; $i++ ){
			$uLetter = strtoupper(substr($row["last"],$i,1));
			if (preg_replace('/\P{L}/', '', $uLetter)) {
				$total_letters = $total_letters + 1;
				if (array_key_exists($uLetter,$letters_array)){
					$letters_array[$uLetter] = $letters_array[$uLetter] + 1;
				}
				else if ($uLetter != " ") {
					$letters_array[$uLetter] = 1;
				}
			}
		} 
	}
	echo "\n\nLetter Statististics:\n\n";
	foreach ($letters_array as $letter => $num_letters) {
		$percent = round($num_letters/$total_letters*100,2) . " %";
		echo $letter . "\t" . $num_letters . "\t" . $percent. "\n";
	}
	
	
}
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?> 
