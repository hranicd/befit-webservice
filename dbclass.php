<?php
class dbclass {
	var $dbhost = null;
	var $dbuser = null;
	var $dbpass = null;
	var $conn = null;
	var $dbname = null;
	var $result = null;

	function __construct() {
		$podaciDB = parse_ini_file('db.ini');
		$this->dbhost = $podaciDB['server'];
		$this->dbuser = $podaciDB['korisnik'];
		$this->dbpass = $podaciDB['lozinka'];
		$this->dbname = $podaciDB['baza'];
	}

	public function openConnection() {
		$this->conn = new mysqli($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);
		if (mysqli_connect_errno()){
			echo new Exception("Došlo je do greške prilikom spajanja na bazu podataka " + mysqli_connect_errno());
		}
	}

	public function getConnection() {
		return $this->conn;
	}

	public function closeConnection() {
		if ($this->conn != null){
			$this->conn->close();
		}
	}
	function selectData($sqlQuery){
		if($this->conn == null){ 
			$this->openConnection();
		}
		$rezultat = null;
		if($this->conn){
			$rezultat = mysqli_query($this->conn, $sqlQuery);
		}else{
			$rezultat = null;

		}
		$this->closeConnection();
		return $rezultat;
	}
	function updateData($sqlQuery){
		if($this->conn == null){ 
			$this->openConnection();
		}
		$rezultat = null;
		if($this->conn){
			$rezultat = mysqli_query($this->conn, $sqlQuery);
		}else{
			$rezultat = null;
		}
		$this->closeConnection();
		return $rezultat;
	}
}
?>