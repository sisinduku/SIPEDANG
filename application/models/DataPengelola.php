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
		
		$row = $result->row();
		return $row;
	}
	
	/**
	 * Fungsi untuk mendapatkan password pengelola
	 * @return $row['password']
	 */
	function get_hashed_password($userName){
		$this->db->select('password');
		$this->db->where('username', $userName);
		$result = $this->db->get('tbl_data_pengelola', 1);
	
		$row = $result->row();
		return ($row!=null?$row->password:null);
	}
	
	/**
	 * Fungsi untuk mendapatkan array yang berisi semua atribut dari pengelola
	 * @return array DataPengelola
	 */
	function get_data_pengelola($username){
		$result = $this->db->get_where('tbl_data_pengelola',array('username'=> $username),1);
		$row = $result->row();
		return $row;
	}
	
	/**
	 * @return string jika gagal|NULL jika sukses
	 */
	function set_hashed_password($userName, $newPassWord){
		// == Generate hash untuk password baru
		$cost = 10;
		$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
		$salt = sprintf("$2a$%02d$", $cost) . $salt;
		$passwordHash = crypt($newPassWord, $salt);
		
		$this->db->where('username',$userName);
		$qResult = $this->db->update('tbl_data_pengelola', array('password' => $passwordHash));
		
		if ($this->db->affected_rows() == 0) return ("No affected rows.");
		return null;
	}
}
?>