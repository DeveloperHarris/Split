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
}
?>