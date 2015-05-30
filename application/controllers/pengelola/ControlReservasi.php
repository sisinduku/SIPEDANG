<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Objek ControlReservasi
 * @author M Nur Hardyanto
*/
class ControlReservasi extends CI_Controller {
	public function index() {
		$this->login();
	}
	/**
	 * Halaman dasbor administrator (pengelola)
	 */
	public function dasbor()
	{
		$data['pageTitle'] = "Administrator";
		$this->load->model("DataReservasi");
		
		$data['jumlahKegiatan'] = $this->DataReservasi->get_jumlah_kegiatan();
		$data['jumlahPending'] = $this->DataReservasi->get_jumlah_kegiatan(DataReservasi::STAT_PENDING, date("Y-m-d H:i:s"));
		$data['jumlahUpComing'] = $this->DataReservasi->get_jumlah_kegiatan(DataReservasi::STAT_ACCEPTED, date("Y-m-d H:i:s"));
		$this->load->template_admin("admin/dashboard", $data);
	}
	
	public function login() {
		$data['pageTitle'] = "Administrator";
		$data['simplePage'] = true;
		$this->load->view("admin/form_login", $data);
	}
	
	public function list_reservasi($statusReservasi = "pending") {
		$data['pageTitle'] = "List Reservasi";
		$this->load->template_admin("admin/list_reservasi", $data);
	}
	
	public function detil_reservasi($idReservasi = -1) {
		$data['pageTitle'] = "Detil Reservasi";
		$this->load->template_admin("admin/detil_reservasi", $data);
	}
	
	public function bukti_reservasi($idReservasi = -1) {
		$data['pageTitle'] = "Bukti Reservasi";
		$this->load->template_admin("admin/bukti_reservasi", $data);
	}
	
	public function arsip_reservasi() {
		$data['pageTitle'] = "Arsip Reservasi";
		$this->load->template_admin("admin/list_arsip_reservasi", $data);
	}
	
	public function ubah_password() {
		$data['pageTitle'] = "Ubah kata sandi";
		$this->load->template_admin("admin/form_ubah_password", $data);
	}
}