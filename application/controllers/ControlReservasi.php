<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Objek ControlReservasi
 * @author M Nur Hardyanto
 */
class ControlReservasi extends CI_Controller {
	private $secretKeyCaptcha = '6Lc4ogcTAAAAAJtYinvnbh-Y1CuhMlAKsIJFkNMn';
	/**
	 * Halaman Home reservasi
	 */
	public function index()
	{
		//$this->load->template_admin("home.php");
		$data['pageTitle'] = "Home";
		$data['pageMenuId'] = 1;
		
		$this->load->model("DataReservasi");
		$data['kegiatanTerdekat'] = $this->DataReservasi->get_kegiatan(
				DataReservasi::STAT_ACCEPTED, 5, date("Y-m-d H:i:s"));
		
		$data['needJQueryUI'] = true;
		$this->load->template("home", $data);
	}
	
	/**
	 * Menampilkan halaman kalender
	 */
	public function tampil_kalender() {
		$data['pageTitle'] = "Kalendar";
		$data['pageMenuId'] = 3;
		$this->load->model("DataReservasi");
		$this->load->template("kalenderkegiatan", $data);
	}
	
	public function form_reservasi() {
		$data['pageTitle'] = "Reservasi Ruang Sidang";
		$data['pageMenuId'] = 1;
		
		$data['submitErrors'] = array();
		if ($this->input->post('submit')) {
			//==== Assign
			$data['sipedang_namakegiatan']	= trim($this->input->post('sipedang_namakegiatan'));
			$data['sipedang_pemesan']		= trim($this->input->post('sipedang_pemesan'));
			$data['sipedang_penyelenggara']	= trim($this->input->post('sipedang_penyelenggara'));
			$data['sipedang_kategori']		= intval($this->input->post('sipedang_kategori'));
			$data['sipedang_tglmulai']		= trim($this->input->post('sipedang_tglmulai'));
			$data['sipedang_tglselesai']	= trim($this->input->post('sipedang_tglselesai'));
			
			//==== Validasi
			// Format datetime mysql
			$ruleFormatDateTime = 'trim|required|regex_match[(0[1-9]|1[0-9]|2[0-9]|3(0|1))-(0[1-9]|1[0-2])-\d{4}] ([0-1][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]';
			$this->load->library('form_validation');
			$this->form_validation->set_rules('sipedang_namakegiatan' ,
					'nama kegiatan', 'trim|required|max_length[128]');
			$this->form_validation->set_rules('sipedang_pemesan',
					'pemesan', 'trim|required|max_length[64]');
			$this->form_validation->set_rules('sipedang_penyelenggara',
					'penyelenggara', 'trim|required|max_length[32]');
			$this->form_validation->set_rules('sipedang_kategori',
					'kategori', 'trim|required|integer');
			$this->form_validation->set_rules('sipedang_kontak',
					'kontak', 'trim|required|max_length[16]');
			$this->form_validation->set_rules('sipedang_email',
					'kontak', 'trim|required|valid_email|max_length[128]');
			$this->form_validation->set_rules('sipedang_tglmulai',
					'tanggal mulai', $ruleFormatDateTime);
			$this->form_validation->set_rules('sipedang_tglselesai',
					'tanggal selesai', $ruleFormatDateTime);
			
			if ($this->form_validation->run() == FALSE) {
				$data['submitErrors'][] = validation_errors("<div>","</div>");
			} else {
				if (strtotime($data['sipedang_tglmulai']) > strtotime($data['sipedang_tglselesai'])) {
					$data['submitErrors'][] = "Range waktu peminjaman tidak valid!";
				}
				if (!array_key_exists($data['sipedang_kategori'], DataReservasi::$listKategori)) {
					$data['submitErrors'][] = "Kategori kegiatan tidak valid!";
				}
			}
			
			//==== Jika Sukses
			if (empty($data['submitErrors'])) {
				// Simpan data dalam session jika data valid
				$dataReservasi = array(
						'kegiatan'				=> $data['sipedang_namakegiatan'],
						'namaTamu'				=> $data['sipedang_pemesan'],
						'penyelenggara'			=> $data['sipedang_penyelenggara'],
						'kategoriKegiatan'		=> $data['sipedang_kategori'],
						'kontak'				=> $data['sipedang_kontak'],
						'email'					=> $data['sipedang_email'],
						'waktuMulaiPinjam'		=> $data['sipedang_tglmulai'],
						'waktuSelesaiPinjam'	=> $data['sipedang_tglselesai']
				);
				$this->Nativesession->set('spd_rsv_status',true);
				$this->Nativesession->set('spd_rsv_timestamp',date("Y-m-d H:i:s"));
				$this->Nativesession->set('spd_rsv_data',$dataReservasi);
				
				$this->output->set_header("Location: ".site_url("/ControlReservasi/form_reservasi_step_2"));
				return;
			} else {
				
			}
		}
		$this->load->template("form_reservasi_step1", $data);
	}
	
	public function form_reservasi_step_2() {
		// Pastikan data reservasi pada tahap 1 sudah ada/tersimpan
		if (($this->Nativesession->get('spd_rsv_status')!=true) &&
				is_array($this->Nativesession->get('spd_rsv_data'))) {
			$this->output->set_header("Location: ".site_url("/ControlReservasi/form_reservasi"));
			return;
		}
		$data['pageTitle'] = "Deskripsi Kegiatan";
		$data['pageMenuId'] = 1;
		$data['submitErrors'] = array();
		if ($this->input->post('submit')) {
			//==== Assign ============================
			$data['sipedang_deskripsi']		= trim($this->input->post('sipedang_deskripsi'));
			$data['sipedang_filegambar']	= '';
			
			//==== Upload gambar kegiatan ============
			$uploadPath = '/assets/uploads/poster/';
			// Buat folder jika belum ada...
			if (!file_exists(FCPATH.$uploadPath)) mkdir(FCPATH.$uploadPath, 0777, true);
				
			$this->load->library('upload');
			if (!empty($_FILES['sipedang_filegambar']['name'])) {
			
				$dateChunk = date("Ymd-His");
				$saltChunk = substr(md5(uniqid(rand(), true)), 0, 5);
				$fileNameSegments = explode(".", $_FILES['sipedang_filegambar']['name']);
				$ekstensi = end($fileNameSegments);
				$ekstensi = strtolower($ekstensi);
			
				$uploadFileName = sprintf('%s-%s', $dateChunk, $saltChunk);
				$config['upload_path']		= FCPATH.$uploadPath;
				$config['allowed_types']	= 'gif|jpg|jpeg|png';
				$config['file_name']		= $uploadFileName;
				$config['max_size']			= '256';
				$config['overwrite']		= TRUE;
			
				$this->upload->initialize($config);
			
				if (!$this->upload->do_upload('sipedang_filegambar')) {
					$data['submitErrors'][] = "Error mengunggah file gambar:".
						$this->upload->display_errors("<div>","</div>\n");
				} else {
					$upladedData = $this->upload->data();
					$data['sipedang_filegambar'] = $uploadPath.$upladedData['file_name'];
				}
			}
			//==== Jika Sukses
			if (empty($data['submitErrors'])) {
				$dataReservasi 		= $this->Nativesession->get('spd_rsv_data');
				$dataReservasi['deskripsiKegiatan'] = $data['sipedang_deskripsi'];
				$dataReservasi['gambar'] 			= $data['sipedang_filegambar'];
				
				$this->DataReservasi->set_kegiatan($dataReservasi);
				$this->output->set_header("Location: ".site_url("/ControlReservasi/form_reservasi_step_3"));
				return;
			} else {
		
			}
		}
		$this->load->template("form_reservasi_step2", $data);
	}
	
	public function form_reservasi_step_3() {
		$data['pageTitle'] = "Informasi Reservasi";
		$data['pageMenuId'] = 1;
	
		$this->load->template("form_reservasi_step3", $data);
	}
	
	public function tampil_kategori() {
		$data['pageTitle'] = "Informasi Peminjaman [Kategori]";
		$data['pageMenuId'] = 1;
	
		$this->load->template("form_reservasi_step3", $data);
	}
	
	public function admin()
	{
		//$this->load->template_admin("home.php");
		//$this->load->model("DataReservasi");
		//$data['kegiatanTerdekat'] = $this->DataReservasi->get_kegiatan(null, 1);
		$this->load->view('header');
		$this->load->view('navigasi');
		$this->load->view('footer');
	}
}
