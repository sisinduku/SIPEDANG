<?php

/**
 * Kelas untuk objek DataReserasi
 * @author Saptanto
 * 
 */
class DataReservasi extends CI_Model {
	
	/**
	 * @param array $data array yang berisi namaTamu, kegiatan, waktuMulaiPinjam, waktuSelesaiPinjam, waktuReservasi, penyelenggara, kategoriKegiatan, deskripsiKegiatan, statusReservasi
	 * @return NULL|string error
	 */
	function set_kegiatan($data) {
		
		$query = "INSERT INTO tbl_data_reservasi (namaTamu, kegiatan, waktuMulaiPinjam, waktuSelesaiPinjam, waktuReservasi, penyelenggara, kategoriKegiatan, deskripsiKegiatan, statusReservasi)";
		
		$query .= sprintf(" VALUES(%s, %s, %s, %s, %s, %s, %d, %s, %d)",
							$this->db->escape($data['namaTamu']),
							$this->db->escape($data['kegiatan']),
							$this->db->escape($data['waktuMulaiPinjam']),
							$this->db->escape($data['waktuSelesaiPinjam']),
							$this->db->escape($data['waktuReservasi']),
							$this->db->escape($data['penyelenggara']),
							$data['kategoriKegiatan'],
							$this->db->escape($data['deskripsiKegiatan']),
							$data['statusReservasi']
						);
		if($this->db->query($query) === true){
			return null;
		}else{
			return "Kegiatan gagal ditambahkan : ".$this->db->error();
		}
	}
	
	
	/**
	 * Fungsi untuk merubah status dari reservasi yang sudah dibuat
	 * @param int $idReservasi ID dari reservasi yang dilakukan
	 * @param int $statusReservasi Status reservasi tersebut [0 = Pending, 1 = Accepted, 2 = Expired, 3 = Rejected]
	 * @return null jika sukses dan "Query failed!" jika gagal 
	 */
	function set_status_reservasi($idReservasi, $statusReservasi){
		
		$query = sprintf("UPDATE tbl_data_reservasi SET statusReservasi=%d WHERE id=%d", 
							$statusReservasi, $idReservasi);
		
		$result = $this->db->query($query);
		if ($result === false) return ("Query failed! : ".$this->db->error());
	}
	
	
	/**
	 * Fungsi untuk mendapatkan kegiatan, jika parameter diisi maka akan didapatkan kegiatan berdasarkan statusnya
	 * @param int $statusReservasi Status reservasi tersebut [0 = Pending, 1 = Accepted, 2 = Expired, 3 = Rejected] Default null
	 * @return multitype:unknown 
	 */
	function get_kegiatan($statusReservasi = null){
		
		$query = "SELECT * FROM tbl_data_reservasi";
		
		if ($statusReservasi != null)
			$query .= " WHERE statusReservasi = ".$statusReservasi;
		
		$result = $this->db->query($query);
		$index = 0;
		$query_result = array();
		
		foreach ($result->result_array() as $row){
			$query_result[$index] = $row;
			$index++;
		}
		
		return $query_result;
	}
	
	/**
	 * Fungsi untuk mengambil kegiatan berdasarkan idReservasi
	 * @param int $idReservasi ID dari reservasi yang dilakukan
	 * @return DataReservasi Object reserasi berdasarkan idReservasi
	 */
	function get_kegiatan_by_id($idReservasi){
		
		$query = sprintf("SELECT * FROM tbl_data_reservasi WHERE idReservasi = %d", $idReservasi);
		
		$result = $this->db->query($query);
		
		$row = $result->result_array();
		return $row;
	}
	
	
}