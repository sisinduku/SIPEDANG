<?php

/**
 * Kelas untuk objek DataReserasi
 * @author Saptanto
 * 
 */
class DataReservasi extends CI_Model {
	
	/**
	 * Konstruktor kelas Model DataReservasi
	 */
	function __construct()
	{
		$this->load->database('db_sipedang');
	}
	
	/**
	 * Fungsi untuk menambahkan kegiatan baru
	 * @param string $namaTamu Nama peminjam
	 * @param string $kegiatan Nama kegiatan yang ingin diselenggarakan
	 * @param DateTime $waktuMulaiPinjam Waktu mulai peminjaman
	 * @param DateTime $waktuSelesaiPinjam Waktu berakhir peminjaman
	 * @param DateTime $waktuReservasi Waktu peminjam melakukan reservasi
	 * @param string $penyelenggara Instansi/Organisasi peminjam
	 * @param int $kategoriKegiatan Kategori kegiatan yang ingin diselanggarakan [0 = Seminar PKL, 1 = Seminar TA1, 2 = Himpunan/Organisasi, 3 = Jurusan, 4 = Lain-lain]
	 * @param string $deskripsiKegiatan Deskripsi kegiatan yang akan diselenggarakan
	 * @param int $statusReservasi Status reservasi tersebut [0 = Pending, 1 = Accepted, 2 = Expired, 3 = Rejected] default = 0
	 * @return null jika sukses dan keterangan gagal jika gagal
	 */
	function set_kegiatan($namaTamu, $kegiatan, $waktuMulaiPinjam, $waktuSelesaiPinjam, $waktuReservasi, $penyelenggara, $kategoriKegiatan, $deskripsiKegiatan, $statusReservasi=0) {
		
		$query = "INSERT INTO tbl_data_reservasi (namaTamu, kegiatan, waktuMulaiPinjam, waktuSelesaiPinjam, waktuReservasi, penyelenggara, kategoriKegiatan, deskripsiKegiatan, statusReservasi)";
		
		$query .= sprintf(" VALUES(%s, %s, %s, %s, %s, %s, %d, %s, %d)",
							$this->db->escape($namaTamu),
							$this->db->escape($kegiatan),
							$this->db->escape($waktuMulaiPinjam),
							$this->db->escape($waktuSelesaiPinjam),
							$this->db->escape($waktuReservasi),
							$this->db->escape($penyelenggara),
							kategoriKegiatan,
							$this->db->escape($deskripsiKegiatan),
							$statusReservasi
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
		global $mysqli; //Koneksi Database
		
		$query = sprintf("SELECT * FROM tbl_data_reservasi WHERE idReservasi = %d", $idReservasi);
		
		$result = $mysqli->query($query);
		
		$row = $result->fetch_array(MYSQLI_ASSOC);
		return $row;
	}
	
	
}