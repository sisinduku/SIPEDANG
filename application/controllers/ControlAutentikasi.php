<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Objek ControlAutentikasi
 * @author M Nur Hardyanto
*/
class ControlAutentikasi extends CI_Controller {
	public function index() {
		if ($this->check_session(false)) {
			$this->output->set_header("Location: ".site_url("/pengelola"));
			return;
		}
		$this->login();
	}
	
	/**
	 * Akses halaman login
	 */
	public function login() {
		$data['pageTitle'] = "Administrator";
		$data['simplePage'] = true;
		
		$data['submitErrors'] = array();
		if ($this->input->post("sipedang_submit") != false) {
			$userName = trim($this->input->post("sipedang_username"));
			$userPass = $this->input->post("sipedang_sandi");
			
			if (!empty($userName)) {
				$this->load->model("DataPengelola");
				$dataPengelola = $this->DataPengelola->get_data_pengelola($userName);
				if ($dataPengelola != null) {
					if ((crypt($userPass, $dataPengelola->password)) === $dataPengelola->password) { // Password benar...
						$this->nativesession->set(MY_Loader::SESS_ID_UID, $userName);
						$this->nativesession->set(MY_Loader::SESS_ID_UEMAIL, $dataPengelola->email);
						
						$this->output->set_header("Location: ".site_url("/pengelola"));
						return;
					}
				}
				$data['submitErrors'][] = "Username atau password salah.".
						"Pastikan telah Anda tuliskan dengan benar!";
			}
			
		}
		$this->load->template_admin("admin/form_login", $data);
	}
	
	public function logout() {
		$this->nativesession->delete(MY_Loader::SESS_ID_UID);
		$this->nativesession->delete(MY_Loader::SESS_ID_UEMAIL);
		
		$this->output->set_header("Location: ".site_url("/ControlAutentikasi/login"));
	}
	
	public function ubah_password() {
		if (!$this->load->check_session()) return;
		$data['loggedInUser'] = $this->nativesession->get(MY_Loader::SESS_ID_UID);
		
		$data['pageTitle'] = "Ubah kata sandi";
		$data['submitErrors'] = array();
		if ($this->input->post("sipedang_submit") != false) {
			$passLama	= ($this->input->post("sipedang_sandi_lama"));
			$passBaru1	= ($this->input->post("sipedang_sandi_baru1"));
			$passBaru2	= ($this->input->post("sipedang_sandi_baru2"));
				
			if (!empty($passLama)) {
				// Cek password baru...
				$hashPassLama = md5($passLama);
				$hashPassBaru = md5($passBaru1);
				
				if ($hashPassLama == $hashPassBaru) {
					$data['submitErrors'][] = "Password lama dan baru sama.";
				} else if ($hashPassBaru != md5($passBaru2)) {
					$data['submitErrors'][] = "Password baru dan konfirmasi tidak sama.";
				} else {
					$this->load->model("DataPengelola");
					$hashPasswordLama = $this->DataPengelola->get_hashed_password($data['loggedInUser']);
					if ($hashPasswordLama != null) {
						if ((crypt($passLama, $hashPasswordLama)) === $hashPasswordLama) { // Password benar...
							$queryResult = $this->DataPengelola->set_hashed_password($data['loggedInUser'], $passBaru1);
							if ($queryResult == null) {
								$data['submitInfos'][] = "<span class=\"fa fa-check\"></span> Kata sandi berhasil diperbaharui.";
								$data['hideForm'] = true;
							} else {
								$data['submitErrors'][] = $queryResult;
							}
						} else {
							$data['submitErrors'][] = "Username atau password salah. ".
									"Pastikan telah Anda tuliskan dengan benar!";
						}
					}
				}
				
			} // End if empty post
		} // End if submit
		$this->load->template_admin("admin/form_ubah_password", $data);
	}
}