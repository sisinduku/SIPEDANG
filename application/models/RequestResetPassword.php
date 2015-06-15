<?php

class Requestresetpassword extends CI_Model {
	
	private $idRequest, $dataPengelola, $requestKey, $tanggalRequest, $expiredRequest, $statusRequest;
	
	public function sendRequestKey($email){
		$this->load->model('DataPengelola');

		$rand = substr(md5($email),rand(0,26),3);
		$rand .= substr(md5(microtime()),rand(0,26),5);
		$this->requestKey = $rand;
		$now = new DateTime();
		$this->tanggalRequest = $now->format('Y-m-d H:i:s');
		$this->expiredRequest = strtotime("+1 hour");
		$this->statusRequest = 1;
		
		$data = array(
			'dataPengelola'		=> $email,
			'requestKey'		=> $this->requestKey,
			'tanggalRequest'	=> $this->tanggalRequest,
			'expiredRequest'	=> $this->expiredRequest,
			'statusRequest'		=> $this->statusRequest
		);
		
		$this->db->insert('tbl_request_resetpass', $data);
		
		$content = "
				<html>
					<title>[SiPedang] Forget Password</title>
					<style>
						body {sans-serif; color: #1B253F; font-size: 12pt;}
						a {color: #00496D;text-decoration: none;}
					</style>
					<body>
						<p>Kami turut bersimpati atas kehilangan password Anda.</p>
						<p>Tetapi jangan khawatir! Anda dapat menggunakan link berikut untuk mereset password anda:</p>
						<p>".site_url("ControlAutentikasi/do_reset_password/".$this->requestKey)."</p>
						<p>Jika anda tidak menggunakan link ini dalam waktu 1 jam, maka link akan dinonaktifkan.</p>
						<p>Thanks<br><b>SiPedang</b></p>
					</body>
				</html>";
		return $content;
	}
	
	public function get_request_key($requestKey) {
		$this->db->where("requestKey", $requestKey);
		$result = $this->db->get("tbl_request_resetpass");
		$row = $result->row();
		return $row;
	}
	
	public function deactivate_key($requestKey) {
		$this->db->where("requestKey",$requestKey);
		$result = $this->db->update("tbl_request_resetpass",array(
				"statusRequest" => 0
		));
		return $result;
	}
} 