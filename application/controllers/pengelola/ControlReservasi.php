<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Objek ControlReservasi
 * @author M Nur Hardyanto
*/
class ControlReservasi extends CI_Controller {
	public static $listKategori = array(
			1 => "Seminar PKL",
			2 => "Seminar TA",
			3 => "Kegiatan Jurusan",
			4 => "Kegiatan Organisasi",
			99 => "Lain-lain"
	);
	
	public function index() {
		if (!$this->load->check_session()) return;
		$this->dasbor();
	}
	/**
	 * Halaman dasbor administrator (pengelola)
	 */
	public function dasbor()
	{
		if (!$this->load->check_session()) return;
		$data['loggedInUser'] = $this->nativesession->get(MY_Loader::SESS_ID_UID);
		
		$data['pageTitle'] = "Administrator";
		$this->load->model("DataReservasi");
		
		$data['jumlahKegiatan'] 	= $this->DataReservasi->get_jumlah_kegiatan();
		$data['jumlahPending']		= $this->DataReservasi->get_jumlah_kegiatan(
				DataReservasi::STAT_PENDING, date("Y-m-d H:i:s"));
		$data['jumlahUpComing']		=$this->DataReservasi->get_jumlah_kegiatan(
				DataReservasi::STAT_ACCEPTED, date("Y-m-d H:i:s"));
		$data['listReservasi'] =
			$this->DataReservasi->get_kegiatan(DataReservasi::STAT_ACCEPTED,-1,date("Y-m-d H:i:s"));
		
		$data['listKategori'] = $this::$listKategori;
		$this->load->template_admin("admin/dashboard", $data);
	}
	
	public function list_reservasi($statusReservasi = "pending") {
		
		if (!$this->load->check_session()) return;
		$data['loggedInUser'] = $this->nativesession->get(MY_Loader::SESS_ID_UID);
		
		$this->load->model("DataReservasi");
		if ($statusReservasi == "approved") {
			$data['pageTitle'] = "List Reservasi [Approved]";
			$data['listReservasi'] =
				$this->DataReservasi->get_kegiatan(DataReservasi::STAT_ACCEPTED,-1,date("Y-m-d H:i:s"));
			$data['tampil_tombol_cetak'] = 1;	
			
		} else {
			$data['pageTitle'] = "List Reservasi [Pending]";
			$data['listReservasi'] =
				$this->DataReservasi->get_kegiatan(DataReservasi::STAT_PENDING,-1,date("Y-m-d H:i:s"));
			$data['tampil_tombol_cetak'] = 0;
		}
		$data['listKategori'] = $this::$listKategori;
		$this->load->template_admin("admin/list_reservasi", $data);
	}
	
	public function detil_reservasi($idReservasi = -1) {
		if (!$this->load->check_session()) return;
		$data['loggedInUser'] = $this->nativesession->get(MY_Loader::SESS_ID_UID);
		
		$data['pageTitle'] = "Detil Reservasi";
		if ($idReservasi > 0) {
			$this->load->model("DataReservasi");
			$data['dataReservasi'] = $this->DataReservasi->get_kegiatan_by_id($idReservasi);
			if ($data['dataReservasi'] != null) { // Jika ditemukan
				if (empty($data['dataReservasi']->gambar))
					$data['dataReservasi']->gambar = "/assets/images/cover_small.png";
			} else {
				$this->output->set_header("Location: ".site_url("/pengelola/ControlReservasi/list_reservasi"));
				return;
			}
		} else {
			$this->output->set_header("Location: ".site_url("/pengelola/ControlReservasi/list_reservasi"));
			return;
		}
		$data['listKategori'] = $this::$listKategori;
		$this->load->template_admin("admin/detil_reservasi", $data);
	}
	
	public function bukti_reservasi($idReservasi = -1) {
		if (!$this->load->check_session()) return;
		$data['loggedInUser'] = $this->nativesession->get(MY_Loader::SESS_ID_UID);
		
		$data['pageTitle'] = "Bukti Reservasi";
		if ($idReservasi > 0) {
			$this->load->model("DataReservasi");
			$data['dataReservasi'] = $this->DataReservasi->get_kegiatan_by_id($idReservasi);
			if ($data['dataReservasi'] != null) { // Jika ditemukan
				
			} else {
				$this->output->set_header("Location: ".site_url("/pengelola/ControlReservasi/list_reservasi"));
				return;
			}
		} else {
			$this->output->set_header("Location: ".site_url("/pengelola/ControlReservasi/list_reservasi"));
			return;
		}
		$data['listKategori'] = $this::$listKategori;
		$this->load->template_admin("admin/bukti_reservasi", $data);
	}
	
	public function arsip_reservasi() {
		if (!$this->load->check_session()) return;
		$data['loggedInUser'] = $this->nativesession->get(MY_Loader::SESS_ID_UID);
		
		$data['pageTitle'] = "Arsip Reservasi";
		$this->load->template_admin("admin/list_arsip_reservasi", $data);
	}
	
	public function approve_reservasi() {
		if (!$this->load->check_session(false)) {
			$this->output->append_output('Access denied');
			return;
		}
		$backRef = "/pengelola/ControlReservasi/list_reservasi";
		if ($this->input->post("sipedang_submit")) {
			$idReservasi = $this->input->post("sipedang_idreservasi");
			$this->load->model("DataReservasi");
			$actionStatus = $this->DataReservasi->set_status_reservasi($idReservasi, DataReservasi::STAT_ACCEPTED);
			if ($actionStatus != null) {
				$this->output->append_output("Approve error: ".$actionStatus);
				return;
			}
			if ($this->input->get("ref") == "detil") {
				$backRef = "/pengelola/ControlReservasi/detil_reservasi/".$idReservasi;
			}
		}
		$this->output->set_header("Location: ".site_url($backRef));
	}
	
	public function reject_reservasi() {
		if (!$this->load->check_session(false)) {
			$this->output->append_output('Access denied');
			return;
		}
		$backRef = "/pengelola/ControlReservasi/list_reservasi";
		if ($this->input->post("sipedang_submit")) {
			$idReservasi = $this->input->post("sipedang_idreservasi");
			$this->load->model("DataReservasi");
			$actionStatus = $this->DataReservasi->set_status_reservasi($idReservasi, DataReservasi::STAT_REJECTED);
			if ($actionStatus != null) {
				$this->output->append_output("Approve error: ".$actionStatus);
				return;
			}
			if ($this->input->get("ref") == "detil") {
				$backRef = "/pengelola/ControlReservasi/detil_reservasi/".$idReservasi;
			}
		}
		$this->output->set_header("Location: ".site_url($backRef));
	}
	//=================== AJAX =========================
	public function ajax_get_listreservasi_admin() {
		if (!$this->load->check_session(false)) {
			$this->output->append_output('Access denied');
			return;
		}
		
		$this->load->model("DataReservasi");
	
		$startDate	= $_GET['start'];
		$endDate	= $_GET['end'];
	
		if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$startDate))
			die("Invalid date format!");
		if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$endDate))
			die("Invalid date format!");
	
		$listReservasi = $this->DataReservasi->get_kegiatan_by_daterange(
				$startDate, $endDate, DataReservasi::STAT_ACTIVE_RESERVATION
		);
	
		$ajaxOutput = array();
		foreach ($listReservasi as $itemReservasi) {
			if ($itemReservasi->statusReservasi == DataReservasi::STAT_PENDING) {
				$eventColor = '#F0AD4E';
			} else {
				$eventColor = '#CEE4ED';
			}
			$ajaxOutput[] = array(
					'id'		=> $itemReservasi->idReservasi,
					'title'		=> $itemReservasi->kegiatan,
					'allDay'	=> false,
					'url'		=> site_url("/pengelola/ControlReservasi/detil_reservasi/".$itemReservasi->idReservasi),
					'start'		=> $itemReservasi->waktuMulaiPinjam,
					'end'		=> $itemReservasi->waktuSelesaiPinjam,
					'backgroundColor' => $eventColor
			);
		}
		$this->output->append_output(json_encode($ajaxOutput));
	}
	
	
}