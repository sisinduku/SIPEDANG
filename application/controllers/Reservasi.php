<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Objek Reservasi
 * @author M Nur Hardyanto
 */
class Reservasi extends CI_Controller {
	private $secretKeyCaptcha = '6Lc4ogcTAAAAAJtYinvnbh-Y1CuhMlAKsIJFkNMn';
	public static $listKategori = array(
			1 => "Seminar PKL",
			2 => "Seminar TA",
			3 => "Kegiatan Jurusan",
			4 => "Kegiatan Organisasi",
			99 => "Lain-lain"
	);
	/**
	 * Halaman Home reservasi
	 */
	public function index()
	{
		//$this->load->template_admin("home.php");
		$data['pageTitle'] = "Home";
		$data['pageMenuId'] = 1;
		
		$this->load->model("Datareservasi");
		$data['kegiatanTerdekat'] = $this->Datareservasi->get_kegiatan(
				Datareservasi::STAT_ACCEPTED, 5, date("Y-m-d H:i:s"));
		
		$data['needJQueryUI'] = true;
		$data['listKategori']		= $this::$listKategori;
		$this->load->template("home", $data);
	}
	
	public function kategori() {
		$data['pageTitle'] = "Kegiatan per Kategori";
		$data['pageMenuId'] = 2;
		$data['listKategori'] = $this::$listKategori;
		
		$this->load->model("Datareservasi");
		foreach ($data['listKategori'] as $idx => $itemKategori) {
			$data['listKegiatanKategori'][$idx] =
				$this->Datareservasi->get_kegiatan_by_kategori(
						$idx, Datareservasi::STAT_ACCEPTED, 5, date("Y-m-d H:i:s"));
		}
		
		$this->load->template("tampilkegiatankategori", $data);
	}
	/**
	 * Menampilkan halaman kalender
	 */
	public function tampil_kalender() {
		$data['pageTitle'] = "Kalendar";
		$data['pageMenuId'] = 3;
		$this->load->model("Datareservasi");
		$data['listKategori']		= $this::$listKategori;
		$this->load->template("kalenderkegiatan", $data);
	}
	
	public function form_reservasi() {
		$data['pageTitle'] = "Reservasi Ruang Sidang";
		$data['pageMenuId'] = 1;
		
		$data['submitErrors'] = array();
		if ($this->input->post('sipedang_submit')) {
			//==== Assign
			$data['sipedang_namakegiatan']	= trim($this->input->post('sipedang_namakegiatan'));
			$data['sipedang_pemesan']		= trim($this->input->post('sipedang_pemesan'));
			$data['sipedang_penyelenggara']	= trim($this->input->post('sipedang_penyelenggara'));
			$data['sipedang_kategori']		= intval($this->input->post('sipedang_kategori'));
			$data['sipedang_tglmulai']		= trim($this->input->post('sipedang_tglmulai'));
			$data['sipedang_tglselesai']	= trim($this->input->post('sipedang_tglselesai'));
			$data['sipedang_kontak']		= trim($this->input->post('sipedang_kontak'));
			$data['sipedang_email']			= trim($this->input->post('sipedang_email'));
			
			//==== Validasi
			// Format datetime mysql
			$patternFormatDateTime = '/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|1[0-9]|2[0-9]|3(0|1))\s([0-1][0-9]|2[0-3]):([0-5]0)$/';
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
					'tanggal mulai', 'trim|required');
			$this->form_validation->set_rules('sipedang_tglselesai',
					'tanggal selesai', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) {
				$data['submitErrors'][] = validation_errors("<div>","</div>");
			} else {
				if ((preg_match($patternFormatDateTime, $data['sipedang_tglmulai'])) &&
						(preg_match($patternFormatDateTime, $data['sipedang_tglselesai']))) {
					if (strtotime($data['sipedang_tglmulai']) >= strtotime($data['sipedang_tglselesai'])) {
						$data['submitErrors'][] = "Range waktu peminjaman tidak valid!";
					} else {
						$this->load->model("Datareservasi");
						$listReservasiKonflik = $this->Datareservasi->get_kegiatan_by_daterange(
							$data['sipedang_tglmulai'], $data['sipedang_tglselesai'],
							Datareservasi::STAT_ACTIVE_RESERVATION, 1
						);
						if (count($listReservasiKonflik) > 0) {
							$data['submitErrors'][] = "Maaf, range tanggal yang Anda masukkan bertabrakan dengan ".
								"reservasi berikut:<br><a href=\"".site_url("/Reservasi/detil_kegiatan/".$listReservasiKonflik[0]->idReservasi)."\">".htmlspecialchars($listReservasiKonflik[0]->kegiatan)."</a>".
								"<br>Silakan pilih tanggal atau jam lain." ;
						}
					}
					$data['sipedang_daterange']		= date("Y-m-d H:i", strtotime($data['sipedang_tglmulai']))." s/d ";
					$data['sipedang_daterange']	   .= date("Y-m-d H:i", strtotime($data['sipedang_tglselesai']));
				} else {
					$data['submitErrors'][] = "Format tanggal tidak valid!";
				}
				
				if (!array_key_exists($data['sipedang_kategori'], $this::$listKategori)) {
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
				$this->nativesession->set('spd_rsv_status',true);
				$this->nativesession->set('spd_rsv_timestamp',date("Y-m-d H:i:s"));
				$this->nativesession->set('spd_rsv_data',$dataReservasi);
				
				// Kirim e-mail, bila perlu...
				$this->output->set_header("Location: ".site_url("/Reservasi/form_reservasi_step_2"));
				return;
			} else {
				
			}
		} else {
			if (($this->nativesession->get('spd_rsv_status')==true) &&
					is_array($this->nativesession->get('spd_rsv_data'))) {
						
				$dataReservasi = $this->nativesession->get('spd_rsv_data');
				
				$data['sipedang_namakegiatan']	= $dataReservasi['kegiatan'];
				$data['sipedang_pemesan']		= $dataReservasi['namaTamu'];
				$data['sipedang_penyelenggara']	= $dataReservasi['penyelenggara'];
				$data['sipedang_kategori']		= $dataReservasi['kategoriKegiatan'];
				$data['sipedang_tglmulai']		= $dataReservasi['waktuMulaiPinjam'];
				$data['sipedang_tglselesai']	= $dataReservasi['waktuSelesaiPinjam'];
				$data['sipedang_kontak']		= $dataReservasi['kontak'];
				$data['sipedang_email']			= $dataReservasi['email'];
				
				$data['sipedang_daterange']		= date("Y-m-d H:i", strtotime($data['sipedang_tglmulai']))." s/d ";
				$data['sipedang_daterange']	   .= date("Y-m-d H:i", strtotime($data['sipedang_tglselesai']));
			} else {
				$data['sipedang_tglmulai']		= date("Y-m-d 08:00:00");
				$data['sipedang_tglselesai']	= date("Y-m-d 10:00:00");
			}
		}
		$data['listKategori']		= $this::$listKategori;
		$data['hideFormReservasi'] = true;
		$this->load->template("form_reservasi_step1", $data);
	}
	
	public function form_reservasi_step_2() {
		// Pastikan data reservasi pada tahap 1 sudah ada/tersimpan
		if ($this->nativesession->get('spd_rsv_status')!=true) {
			$this->output->set_header("Location: ".site_url("/Reservasi/form_reservasi"));
			return;
		}
		$data['pageTitle'] = "Deskripsi Kegiatan";
		$data['pageMenuId'] = 1;
		$data['submitErrors'] = array();
		if ($this->input->post('sipedang_submit')) {
			//==== Assign ============================
			$data['sipedang_deskripsi']		= trim($this->input->post('sipedang_deskripsi'));
			// Hilangkan tag script...
			$data['sipedang_deskripsi']		= preg_replace('/<script\b[^>]*>(.*?)<\/script>/is',
					"", $data['sipedang_deskripsi']);
			
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
				$config['max_size']			= '2048';
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
				$dataReservasi 		= $this->nativesession->get('spd_rsv_data');
				$dataReservasi['deskripsiKegiatan'] = $data['sipedang_deskripsi'];
				$dataReservasi['gambar'] 			= $data['sipedang_filegambar'];
				
				$this->load->model("Datareservasi");
				$this->Datareservasi->set_kegiatan($dataReservasi);
				$this->output->set_header("Location: ".site_url("/Reservasi/form_reservasi_step_3"));
				return;
			} else {
		
			}
		}
		$data['hideFormReservasi'] = true;
		$this->load->template("form_reservasi_step2", $data);
	}
	
	public function form_reservasi_step_3() {
		// Pastikan data reservasi pada tahap 2 sudah ada/tersimpan
		if ($this->nativesession->get('spd_rsv_status')!=true) {
			$this->output->set_header("Location: ".site_url("/Reservasi/form_reservasi"));
			return;
		}
		
		// Hapus sesi
		$this->nativesession->delete('spd_rsv_status');
		$this->nativesession->delete('spd_rsv_data');
		
		$data['pageTitle'] = "Informasi Reservasi";
		$data['pageMenuId'] = 1;
	
		$data['hideFormReservasi'] = true;
		$this->load->template("form_reservasi_step3", $data);
	}
	
	public function tampil_kategori() {
		$data['pageTitle'] = "Informasi Peminjaman [Kategori]";
		$data['pageMenuId'] = 1;
	
		$this->load->template("form_reservasi_step3", $data);
	}
	
	public function ajax_detil_kegiatan() {
		$idKegiatan = $this->input->post('id');
		
		$this->load->model("Datareservasi");
		$this->load->helper("tanggalreservasi");
		
		$data['dataKegiatan'] = $this->Datareservasi->get_kegiatan_by_id($idKegiatan);
		if ($data['dataKegiatan']) {
			$this->load->view("detil_kegiatan", $data);
		} else {
			$this->output->append_output("Kegiatan tidak ditemukan...");
		}
		
	}
	public function ajax_get_listreservasi() {
		$this->load->model("Datareservasi");
		
		$startDate	= $_GET['start'];
		$endDate	= $_GET['end'];
	
		if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$startDate))
			die("Invalid date format!");
		if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$endDate))
			die("Invalid date format!");
	
		$listReservasi = $this->Datareservasi->get_kegiatan_by_daterange(
				$startDate, $endDate, Datareservasi::STAT_ACCEPTED
		);
	
		$ajaxOutput = array();
		foreach ($listReservasi as $itemReservasi) {
			// Karena pada fullCalendar, endDate bersifat eksklusif, maka endDate secara
			//	manual ditambah satu hari -_-
			$ajaxOutput[] = array(
					'id'		=> $itemReservasi->idReservasi,
					'title'		=> $itemReservasi->kegiatan,
					'allDay'	=> false,
					'url'		=> '#',
					'start'		=> $itemReservasi->waktuMulaiPinjam,
					'end'		=> $itemReservasi->waktuSelesaiPinjam
			);
		}
		$this->output->append_output(json_encode($ajaxOutput));
	}
}
