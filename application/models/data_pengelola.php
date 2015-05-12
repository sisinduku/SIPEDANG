<?php

/**
 * Kelas untuk objek DataPengelola. Pengelola hanya ada satu
 * @author Saptanto Sindu
 *
 */
class DataPengelola extends CI_Model{
	
	/**
	 * Fungsi untuk mendapatkan username pengelola
	 * @return $row['username']
	 */
	function get_username(){
		$query = "SELECT username FROM tbl_data_pengelola";
		$result = $this->db->query($query);
		
		$row = $result->row_array();
		return $row;
	}
	
	/**
	 * Fungsi untuk mendapatkan password pengelola
	 * @return $row['password']
	 */
	function get_hashed_password(){
		$query = "SELECT password FROM tbl_data_pengelola";
		$result = $this->db->query($query);
	
		$row = $result->row_array();
		return $row;
	}
	
	/**
	 * Fungsi untuk mendapatkan array yang berisi semua atribut dari pengelola
	 * @return array DataPengelola
	 */
	function get_data_pengelola(){
		$query = "SELECT * FROM tbl_data_pengelola";
		$result = $this->db->query($query);
		
		$row = $result->result_array();
		return $row;
	}
	
	/**
	 * @param string $oldPassWord
	 * @param string $newPassWord
	 * @return string jika gagal|NULL jika sukses
	 */
	function set_hashed_password($oldPassWord, $newPassWord){
		
		$password = $this->get_hashed_password();
		$username = $this->get_username();
		
		if ((crypt($oldPassWord, $password)) === $password) {
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