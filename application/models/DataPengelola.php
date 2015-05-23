<?php

/**
 * Kelas untuk objek DataPengelola. Pengelola hanya ada satu
 * @author Saptanto Sindu
 *
 */
class DataPengelola extends CI_Model{
	
	private $username, $password;
	
	public function __construct(){
		// Call the CI_Model constructor
		parent::__construct();
	}
	
	/**
	 * Fungsi untuk mendapatkan username pengelola
	 * @return $row['username']
	 */
	function get_username(){
		$this->db->select('username');
		$result = $this->db->get('tbl_data_pengelola', 1);
		
		$row = $result->row_array();
		return $row;
	}
	
	/**
	 * Fungsi untuk mendapatkan password pengelola
	 * @return $row['password']
	 */
	function get_hashed_password(){
		$this->db->select('password');
		$result = $this->db->get('tbl_data_pengelola', 1);
	
		$row = $result->row_array();
		return $row;
	}
	
	/**
	 * Fungsi untuk mendapatkan array yang berisi semua atribut dari pengelola
	 * @return array DataPengelola
	 */
	function get_data_pengelola(){
		$result = $this->db->get('tbl_data_pengelola');
		
		$row = $result->result_array();
		return $row;
	}
	
	/**
	 * @param string $oldPassWord
	 * @param string $newPassWord
	 * @return string jika gagal|NULL jika sukses
	 */
	function set_hashed_password(){
		
		$oldPassWord = $this->input->post('oldPassWord');
		$newPassWord = $this->input->post('newPassWord');
		
		$this->password = $this->get_hashed_password();
		$this->username = $this->get_username();
		
		if ((crypt($oldPassWord, $this->password)) === $this->password) {
			// == Generate hash untuk password baru
			$cost = 10;
			$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
			$salt = sprintf("$2a$%02d$", $cost) . $salt;
			$passwordHash = crypt($newPassWord, $salt);
		
			$query = sprintf("UPDATE tbl_data_pengelola SET password='%s' WHERE username=%s",
					$passwordHash, $this->db->escape($username)
			);
			$qResult = $this->db->query($query);
			if ($qResult === false) return ("Query failed!");
		
		} else return "Password lama salah! Pastikan ditulis dengan benar.";
		return null;
	}	
}
?>