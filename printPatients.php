<?php
require_once("PatientRecord.php");
		$servername = "localhost";
		$username = "raintree";
		$password = "rainPass";
try{
	$conn = new PDO("mysql:host=$servername;dbname=raintree", $username, $password);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$query = "select pn from patient;";
	foreach ($conn->query($query) as $row) {
		$patient = new Patient($row["pn"]);
		$patient->print_insurance_data(date("m-d-y"));
	}
	$conn = null;
} catch(PDOException $e) {
	echo "Connection failed: " . $e->getMessage();
}

$test = new Patient("A2");

?>
