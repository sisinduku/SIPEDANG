<?php

/**
 * Kelas untuk objek DataReserasi
 * @author Saptanto
 * 
 */
class DataReservasi extends CI_Model {
	
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
		global $mysqli; //Koneksi Database
		
		$query = "INSERT INTO tbl_data_reservasi (namaTamu, kegiatan, waktuMulaiPinjam, waktuSelesaiPinjam, waktuReservasi, penyelenggara, kategoriKegiatan, deskripsiKegiatan, statusReservasi)";
		
		$query .= sprintf(" VALUES('%s', '%s', '%s', '%s', '%s', '%s', %d, '%s', %d)",
							$mysqli->real_escape_string($namaTamu),
							$mysqli->real_escape_string($kegiatan),
							$mysqli->real_escape_string($waktuMulaiPinjam),
							$mysqli->real_escape_string($waktuSelesaiPinjam),
							$mysqli->real_escape_string($waktuReservasi),
							$mysqli->real_escape_string($penyelenggara),
							kategoriKegiatan,
							$mysqli->real_escape_string($deskripsiKegiatan),
							$statusReservasi
						);
		if($mysqli->query($query) === true){
			return null;
		}else{
			return "Kegiatan gagal ditambahkan : ".$mysqli->error;
		}
	}
	
	
	/**
	 * Fungsi untuk merubah status dari reservasi yang sudah dibuat
	 * @param int $idReservasi ID dari reservasi yang dilakukan
	 * @param int $statusReservasi Status reservasi tersebut [0 = Pending, 1 = Accepted, 2 = Expired, 3 = Rejected]
	 * @return null jika sukses dan "Query failed!" jika gagal 
	 */
	function set_status_reservasi($idReservasi, $statusReservasi){
		global $mysqli; //Koneksi Database
		
		$query = sprintf("UPDATE tbl_data_reservasi SET statusReservasi=%d WHERE id=%d", 
							$statusReservasi, $idReservasi);
		
		$result = $mysqli->query($query);
		if ($result === false) return ("Query failed!");
	}
	
	/**
	 * Fungsi untuk mengambil semua kegiatan
	 * @return multitype:array Array yang berisi objek-objek kegiatan
	 */
	function get_kegiatan(){
		global $mysqli; //Koneksi Database
		
		$query = "SELECT * FROM tbl_data_reservasi";
		
		$result = $mysqli->query($query);
		$index = 0;
		$query_result = array();
		
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
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
	
	/**
	 * Fungsi untuk mengambil kegiatan berdasarkan statusReservasi
	 * @param int $statusReservasi Status reservasi tersebut [0 = Pending, 1 = Accepted, 2 = Expired, 3 = Rejected]
	 * @return multitype:array Array yang berisi objek-objek kegiatan
	 */
	function get_kegiatan_by_status($statusReservasi){
		global $mysqli; //Koneksi Database
		
		$query = sprintf("SELECT * FROM tbl_data_reservasi WHERE statusReservasi = %d", $statusReservasi);
		
		$result = $mysqli->query($query);
		$index = 0;
		$query_result = array();
		
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$query_result[$index] = $row;
			$index++;
		}
		return $query_result;
	}
}