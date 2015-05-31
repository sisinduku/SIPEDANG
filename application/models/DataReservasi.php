<?php

/**
 * Kelas untuk objek DataReservasi
 * @author Saptanto
 * 
 */
// Changelog:
//  (30/05/2015): penambahan $dataKegiatan dan $idKegiatan
class DataReservasi extends CI_Model {
	
	const STAT_PENDING = 0;
	const STAT_ACCEPTED = 1;
	const STAT_EXPIRED = 2;
	const STAT_REJECTED = 3;
	
	private $idReservasi, $kodeReservasi, $namaTamu, $email, $kontak, $kegiatan, $gambar;
	private $waktuMulaiPinjam, $waktuSelesaiPinjam, $waktuReservasi, $penyelenggara;
	private $kategoriKegiatan, $deskripsiKegiatan, $statusReservasi;
	public static $listKategori = array(
			1 => "Seminar PKL",
			2 => "Seminar TA",
			3 => "Kegiatan Jurusan",
			4 => "Kegiatan Organisasi",
			99 => "Lain-lain"
	);
	public function __construct(){
		// Call the CI_Model constructor
		parent::__construct();
	}
	
	/**
	 * Fungsi untuk menambah atau mengupdate kegiatan
	 * @param array $dataKegiatan Associative array berisi data kegiatan yang akan disimpan
	 * @param int $idReservasi ID reservasi yang akan diupdate, -1 jika ingin buat baru
	 * @return NULL|string error
	 */
	function set_kegiatan($dataKegiatan, $idReservasi = -1) {
		// Set informasi pemensan
		$this->namaTamu			= $dataKegiatan['namaTamu'];
		$this->kontak			= $dataKegiatan['kontak'];
		$this->email			= $dataKegiatan['email'];
		
		// Set informasi kegiatan
		$this->kegiatan			= $dataKegiatan['kegiatan'];
		$this->gambar			= $dataKegiatan['gambar'];
		$this->waktuMulaiPinjam		= $dataKegiatan['waktuMulaiPinjam'];
		$this->waktuSelesaiPinjam	= $dataKegiatan['waktuSelesaiPinjam'];
		$this->penyelenggara		= $dataKegiatan['penyelenggara'];
		$this->kategoriKegiatan		= $dataKegiatan['kategoriKegiatan'];
		$this->deskripsiKegiatan	= $dataKegiatan['deskripsiKegiatan'];
		
		// Set informasi reservasi
		$now = new DateTime();
		$this->waktuReservasi		= $now->format('Y-m-d H:i:s');
		$this->statusReservasi		= $this::STAT_PENDING;
		
		// Generate data array
		$data = array(
			'namaTamu'			=> $this->namaTamu,
			'kegiatan'			=> $this->kegiatan,
			'waktuMulaiPinjam'	=> $this->waktuMulaiPinjam,
			'waktuSelesaiPinjam'	=> $this->waktuSelesaiPinjam,
			'penyelenggara'		=> $this->penyelenggara,
			'kategoriKegiatan'	=> intval($this->kategoriKegiatan),
			'deskripsiKegiatan'	=> $this->deskripsiKegiatan,
			'kontak'		=> $this->kontak,
			'email'			=> $this->email
		);
		
		if (!empty($this->gambar)) {
			// Update/tambah gambar jika ada...
			$data['gambar']		= $this->gambar;
		}
		if ($idReservasi > 0) {
			$this->db->where('idReservasi',$idReservasi);
			$this->db->update('tbl_data_reservasi', $data);
		} else {
			$data['waktuReservasi']		= $this->waktuReservasi;
			$data['statusReservasi']	= $this->statusReservasi;
			
			$this->db->insert('tbl_data_reservasi', $data);
		}
		
		
		if($this->db->affected_rows() != 0) {
			if ($idReservasi > 0) {
				
			} else {
				// Generate kode reservasi (khusus tambah baru)
				$rand = substr(md5(microtime()),rand(0,26),5);
				$insert_id = $this->db->insert_id();
				$this->kodeReservasi = sprintf("%04d-%s",$insert_id,$rand);
				$this->db->update('tbl_data_reservasi',
					array('kodeReservasi'=>$this->kodeReservasi),
					array('idReservasi'=>$insert_id)
				);
			}
			return null;
		}else{
			return "Kegiatan gagal ditambahkan : ".$this->db->error();
		}
	}
	
	
	/**
	 * Fungsi untuk merubah status dari reservasi yang sudah dibuat
	 * @return null jika sukses dan "Query failed!" jika gagal 
	 */
	function set_status_reservasi(){
		
		$this->idReservasi = $this->input->post('idReservasi');
		$this->statusReservasi = $this->input->post('statusReservasi');
		$this->db->update('tbl_data_reservasi', array('statusReservasi'=>$this->statusReservasi), array('idReservasi'=>$this->idReservasi));
		
		if ($this->db->affected_rows() == 0) return ("Query failed! : ".$this->db->error());
	}
	
	
	/**
	 * Fungsi untuk mendapatkan kegiatan, jika parameter diisi maka akan didapatkan kegiatan berdasarkan statusnya
	 * @param int $statusReservasi Filter status reservasi yang akan diambil
	 * @param int $limit Batas maksimal item yang diambil
	 * @param string $limitTanggal Batas bawah tanggal item yang akan diambil
	 * @return multitype:unknown 
	 */
	function get_kegiatan($statusReservasi = null, $limit = -1, $limitTanggal = null){
		
		if ($statusReservasi != null)
			$this->db->where('statusReservasi', $statusReservasi);
		if ($limit > 0)
			$this->db->limit($limit);
		if($limitTanggal != null)
			$this->db->where('waktuMulaiPinjam >=', $limitTanggal);
		
		$this->db->order_by("waktuMulaiPinjam ASC");
		
		$result = $this->db->get('tbl_data_reservasi');
		$index = 0;
		$query_result = array();
		
		foreach ($result->result() as $row){
			$query_result[$index] = $row;
			$index++;
		}
		
		return $query_result;
	}
	
	/**
	 * Fungsi untuk mengambil kegiatan berdasarkan idReservasi
	 * @return DataReservasi Object reserasi berdasarkan idReservasi
	 */
	function get_kegiatan_by_id($idReservasi){
		
		$result = $this->db->get_where('tbl_data_reservasi', array('idReservasi'=>$idReservasi), 1);
		
		$row = $result->row();
		return $row;
	}
	
	/**
	 * Mendapatkan jumlah reservasi berdasarkan filter yang disebutkan
	 * @param string $statusReservasi filter status reservasi
	 * @param string $limitTanggal Batas bawah tanggal kegiatan
	 * @return Jumlah kegiatan 
	 */
	function get_jumlah_kegiatan($statusReservasi = -1, $limitTanggal = null){
		
		$this->db->from('tbl_data_reservasi');
		if ($statusReservasi >= 0)
			$this->db->where('statusReservasi', $statusReservasi);
		if ($limitTanggal != null)
			$this->db->where('waktuMulaiPinjam >=', $limitTanggal);
		
		$result = $this->db->count_all_results();
		return $result;
	}
	
}