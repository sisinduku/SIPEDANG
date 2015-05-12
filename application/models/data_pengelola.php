<?php

/**
 * Kelas untuk objek DataPengelola
 * @author Saptanto S
 *
 */
class DataPengelola extends CI_Model{
	/**
	 * Konstruktor kelas Model DataPengelola
	 */
	function __construct()
	{
		$this->load->database('db_sipedang');
	}
	
	
}
?>