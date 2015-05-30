<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Objek ControlReservasi
 * @author M Nur Hardyanto
 */
class ControlReservasi extends CI_Controller {
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
		
		$this->load->template("form_reservasi_step1", $data);
	}
	
	public function form_reservasi_step_2() {
		$data['pageTitle'] = "Deskripsi Kegiatan";
		$data['pageMenuId'] = 1;
		
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
}
