<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Objek ControlAutentikasi
 * @author M Nur Hardyanto
*/
class ControlAutentikasi extends CI_Controller {
	public function index() {
		if ($this->load->check_session(false)) {
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
				$this->load->model("Datapengelola");
				$dataPengelola = $this->Datapengelola->get_data_pengelola($userName);
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
					$this->load->model("Datapengelola");
					$hashPasswordLama = $this->Datapengelola->get_hashed_password($data['loggedInUser']);
					if ($hashPasswordLama != null) {
						if ((crypt($passLama, $hashPasswordLama)) === $hashPasswordLama) { // Password benar...
							$queryResult = $this->Datapengelola->set_hashed_password($data['loggedInUser'], $passBaru1);
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
	
	function reset_password() {
		// Genereate link reset password
		$this->load->model('Datapengelola');
		$this->load->model('Requestresetpassword');
		
		$dataPengelola = $this->Datapengelola->get_data_pengelola("administrator");
		$tujuanEmail = $dataPengelola->email;
		$kontenEmail = $this->Requestresetpassword->sendRequestKey($tujuanEmail);
		
		// Kirim email
		$this->load->library('email');
		
		$this->email->from('panitia@carakafest.org', 'SiPedang');
		$this->email->to($tujuanEmail);
		
		$this->email->subject("[SIPEDANG] Reset Password");
		$this->email->message($kontenEmail);
		
		$berhasil = $this->email->send();
		
		$reportToLog = "\r\n[".date('j F Y, H:i:s')."]\t: mailto [".$tujuanEmail."]\t: ";
		
		if (!$berhasil) {
			$reportToLog .= "Mailer Error!";
		} else {
			$reportToLog .= "Message sent...";
		}
		
		$dateChunk = date("Ymd-His");
		$reportToLog .= "\t[SIPEDANG] | [".$dateChunk.".html]";
		
		file_put_contents(APPPATH."/logs/email.log", $reportToLog, FILE_APPEND);
		file_put_contents(APPPATH."/logs/emails/".$dateChunk.".html", $kontenEmail);
		
		$data['pageTitle'] = "Reset Password";
		$data['submitErrors'] = array();
		$data['simplePage'] = true;
		
		$this->load->template_admin("admin/notif_cek_email", $data);
	}
	
	function do_reset_password($requestKey = null) {
		$data['pageTitle'] = "Reset Password";
		$data['simplePage'] = true;
		if ($requestKey != null) {
			$this->load->model("Requestresetpassword");
			$dataRequest = $this->Requestresetpassword->get_request_key($requestKey);
			if ($dataRequest != null) {
				if (($dataRequest->expiredRequest >= time()) && ($dataRequest->statusRequest == 1)) {
					if ($this->input->post('sipedang_submit')) {
						$passBaru1	= ($this->input->post("sipedang_sandi_baru1"));
						$passBaru2	= ($this->input->post("sipedang_sandi_baru2"));
						
						$hashPassBaru = md5($passBaru1);
					
						if ($hashPassBaru != md5($passBaru2)) {
							$data['submitErrors'][] = "Password baru dan konfirmasi tidak sama.";
						} else {
							$this->load->model("Datapengelola");
							
							$queryResult = $this->Datapengelola->set_hashed_password("administrator", $passBaru1);
							if ($queryResult == null) {
								$this->Requestresetpassword->deactivate_key($requestKey);
								$data['submitInfos'][] = "<span class=\"fa fa-check\"></span> Kata sandi berhasil direset.";
								$data['hideForm'] = true;
							} else {
								$data['submitErrors'][] = $queryResult;
							}
						}
					} // End if POST
				} else {
					$data['submitErrors'] = array("Request sudah tidak berlaku. Silakan request ulang.");
					$data['hideForm'] = true;
				}
			} else {
				$data['submitError'] = array("Kunci request tidak valid.");
				$data['hideForm'] = true;
			}
		} else {
			$this->output->set_header("Location: ".site_url("/pengelola"));
			return;
		}
		$data['formAction'] = "/ControlAutentikasi/do_reset_password/".$requestKey;
		$this->load->template_admin("admin/form_reset_password", $data);
	}
}