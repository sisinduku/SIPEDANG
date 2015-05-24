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
		$this->load->model("DataReservasi");
		$data['kegiatanTerdekat'] = $this->DataReservasi->get_kegiatan(1, 5);
		$this->load->view("template", $data);
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
