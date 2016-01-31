<?php
interface PatientRecord {
	public function get_id();
	public function get_pn();
}

class Patient implements PatientRecord {
	private $_id;
	private $pn;
	private $first;
	private $last;
	private $dob;
	private $insurances = array();
	
	public function __construct($pn){
		$servername = "localhost";
		$username = "raintree";
		$password = "rainPass";
		try{
			$conn = new PDO("mysql:host=$servername;dbname=raintree", $username, $password);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$query = "select * from patient where pn = '" .$pn . "';";
			foreach ($conn->query($query) as $row) {
				$this->_id = $row["_id"];
				$this->pn = $row["pn"];
				$this->first = $row["first"];
				$this->last = $row["last"];
				$this->dob = $row["dob"];
			}
			$insurance_query = "select _id from insurance where patient_id = " . $this->_id .  ";";
			foreach ($conn->query($insurance_query) as $row) {
				$insurance = new Insurance($row["_id"]);
				array_push($this->insurances, $insurance);
			}
			$conn = null;
		} catch(PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
		}
	}
	
	public function get_id() {
		return $this->_id;
	}
	
	public function get_pn() {
		return $this->pn;
	}
	
	public function get_name(){
		return $this->first . " " . $this->last;
	}
	
	public function get_insurances(){
		return $this->insurances;
	}
	
	public function print_insurance_data($date){
		foreach($this->insurances as &$insurance) {
			if ($insurance->is_valid_insurance($date)){
				$is_valid = "Yes";
			} else {
				$is_valid = "No";
			}
			echo $this->pn . ", " . $this->get_name() . ", " . $insurance->get_iname() . ", " . $is_valid ."\n";
		}	
	}
}

class Insurance implements PatientRecord {
	private $_id;
	private $pn;
	private $patient_id;
	private $iname;
	private $from_date;
	private $to_date;
	
	public function __construct($_id){
		$servername = "localhost";
		$username = "raintree";
		$password = "rainPass";
		try{
			$conn = new PDO("mysql:host=$servername;dbname=raintree", $username, $password);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$query = "select i._id, p.pn, i.patient_id, i.iname, i.from_date, i.to_date from insurance i join patient p on i.patient_id = p._id where i._id = " . $_id . ";";
			foreach ($conn->query($query) as $row) {
				$this->_id = $row["_id"];
				$this->pn = $row["pn"];
				$this->patient_id = $row["patient_id"];
				$this->iname = $row["iname"];
				$this->from_date = $row["from_date"];
				$this->to_date = $row["to_date"];
			}
			$conn = null;
		} catch(PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
		}
	}
	
	public function get_id() {
		return $this->_id;
	}
	
	public function get_pn() {
		return $this->pn;
	}
	
	public function get_iname() {
		return $this->iname;
	}
	
	public function is_valid_insurance($date){
		$new_date = DateTime::createFromFormat("m-d-y", $date);
		$from_date = DateTime::createFromFormat("Y-m-d", $this->from_date);
		$to_date = DateTime::createFromFormat("Y-m-d", $this->to_date);
		if ($new_date >= $from_date && $new_date <= $to_date){
			return true;
		} else {
			return false;
		}
	}
}
d
?>
