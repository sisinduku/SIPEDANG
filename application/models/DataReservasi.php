<?php

/**
 * Kelas untuk objek DataReserasi
 * @author Saptanto
 * 
 */
class DataReservasi extends CI_Model {
	
	const STAT_PENDING = 0;
	const STAT_ACCEPTED = 1;
	const STAT_EXPIRED = 2;
	const STAT_REJECTED = 3;
	
	private $idReservasi, $kodeReservasi, $namaTamu, $email, $kontak, $kegiatan, $gambar, $waktuMulaiPinjam, $waktuSelesaiPinjam, $waktuReservasi, $penyelenggara, $kategoriKegiatan, $deskripsiKegiatan, $statusReservasi;
	private $listKategori = array(
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
	 * Fungsi untuk menambah kegiatan
	 * @return NULL|string error
	 */
	function set_kegiatan() {
		
		$this->namaTamu = $this->input->post('namaTamu');
		$this->kegiatan = $this->input->post('kegiatan');
		$this->gambar = $this->input->post('gambar');
		$this->waktuMulaiPinjam = $this->input->post('waktuMulaiPinjam');
		$this->waktuSelesaiPinjam = $this->input->post('waktuSelesaiPinjam');
		$now = new DateTime();
		$this->waktuReservasi = $now->format('Y-m-d H:i:s');
		$this->penyelenggara = $this->input->post('penyelenggara');
		$this->kategoriKegiatan = $this->input->post('kategoriKegiatan');
		$this->deskripsiKegiatan = $this->input->post('deskripsiKegiatan');
		$this->statusReservasi = 0;
		
		$data = array('namaTamu' => $this->namaTamu, 'kegiatan' => $this->kegiatan, 'gambar' => $this->gambar, 'waktuMulaiPinjam' => $this->waktuMulaiPinjam,
						'waktuSelesaiPinjam' => $this->waktuSelesaiPinjam, 'waktuReservasi' => $this->waktuReservasi, 'penyelenggara' => $this->penyelenggara,
						'kategoriKegiatan' => $this->kategoriKegiatan, 'deskripsiKegiatan' => $this->deskripsiKegiatan, 'statusReservasi' => $this->statusReservasi);
		
		$this->db->insert('tbl_data_reservasi', $data);
		
		if($this->db->affected_rows() != 0){
			$rand = substr(md5(microtime()),rand(0,26),5);
			$insert_id = $this->db->insert_id();
			$this->kodeReservasi = $insert_id.$rand;
			$this->db->update('tbl_data_reservasi', array('kodeReservasi'=>$this->kodeReservasi), array('idReservasi'=>$insert_id));
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
	
}