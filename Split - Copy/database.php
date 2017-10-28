<?php 
require("config.php");

class Database
{
	private $db;
	private $db_config = array(
		"host" => "localhost",
		"username" => "root",
		"password" => "",
		"db" => "split_database");

	public function __construct()
	{
		$this->db = mysqli_connect($this->db_config["host"], $this->db_config["username"], $this->db_config["password"], $this->db_config["db"]);
	}
	public function query($sql)
	{
		return $this->db->query($sql);
	}
	public function check_email($email)
	{
		$emailList = array();
		$result = $this->db->query("SELECT email FROM users;");
		while($row = $result->fetch_assoc())
		{
			$emailList[] = $row['email'];
		}
		return !in_array($email, $emailList);
	}
	public function getError()
	{
		return $this->db->error;
	}
	public function checkUser($email, $pass)
	{
		$sql = "SELECT password_hash FROM users WHERE email='" . $email . "';";
		$result = $this->query($sql);
		if ($result->num_rows == 1)
		{
			$row = $result->fetch_object();
			return password_verify($pass, $row->password_hash);
		}
	}
	public function createUser($email, $pass, $first_name, $last_name)
	{
		$sql = "INSERT INTO users (email, password_hash, first_name, last_name) VALUES ('";
		$sql .= $email . "', '" . password_hash($pass, PASSWORD_DEFAULT) . "', '" . $first_name . "', '" . $last_name . "');";
		$this->db->query($sql);
	}
}
?>