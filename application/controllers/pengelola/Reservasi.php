<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Objek Reservasi
 * @author M Nur Hardyanto
*/
class Reservasi extends CI_Controller {
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
		$this->load->model("Datareservasi");
		
		$data['jumlahKegiatan'] 	= $this->Datareservasi->get_jumlah_kegiatan();
		$data['jumlahPending']		= $this->Datareservasi->get_jumlah_kegiatan(
				Datareservasi::STAT_PENDING);
		$this->nativesession->set(MY_Loader::SESS_ID_PENDING, $data['jumlahPending']);
		
		$data['jumlahUpComing']		= $this->Datareservasi->get_jumlah_kegiatan(
				Datareservasi::STAT_ACCEPTED, date("Y-m-d H:i:s"));
		$data['listReservasi'] =
			$this->Datareservasi->get_kegiatan(Datareservasi::STAT_ACCEPTED,-1,date("Y-m-d H:i:s"));
		
		$data['listKategori'] = $this::$listKategori;
		$this->load->template_admin("admin/dashboard", $data);
	}
	
	public function list_reservasi($statusReservasi = "pending", $tglMulai = null, $tglAkhir = null) {
		if (!$this->load->check_session()) return;
		$data['loggedInUser'] = $this->nativesession->get(MY_Loader::SESS_ID_UID);
		$data['jumlahPending']	= $this->nativesession->get(MY_Loader::SESS_ID_PENDING);
		
		$patternTanggal = '/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|1[0-9]|2[0-9]|3(0|1))$/';
		$dateValid = true;
		$tanggalMulaiSafe = $tanggalAkhirSafe = null;
		$data['useFilter'] = false;
		$labelTanggal = "";
		
		if (($tglMulai != null) || ($tglAkhir != null)) {
			// Validasi format tanggal
			if (!preg_match($patternTanggal, $tglMulai)) {
				$dateValid = false;
			} else {
				$tanggalMulaiSafe = $tglMulai;
			}
			if (!preg_match($patternTanggal, $tglAkhir)) {
				$dateValid = false;
			} else {
				$tanggalAkhirSafe = $tglAkhir;
			}
		}
		
		if (!$dateValid) {
			$this->output->set_header("Location: ".site_url("/pengelola/reservasi/list_reservasi"));
			return;
		}
		
		$this->load->model("Datareservasi");
		$this->load->helper("tanggalreservasi");
		$data['tampil_tombol_cetak'] = 0;
		
		// Jika disertakan tanggal
		if (($tglMulai != null) && ($tglAkhir != null)) {
			$data['sipedang_tglmulai'] = $tanggalMulaiSafe;
			$data['sipedang_tglselesai'] = $tanggalAkhirSafe;
			
			$data['sipedang_lblrange']		= date("Y-m-d", strtotime($tanggalMulaiSafe))." s/d ";
			$data['sipedang_lblrange']	   .= date("Y-m-d", strtotime($tanggalAkhirSafe));
		
			$labelTanggal  = " (".format_tanggal_formal(strtotime($tanggalMulaiSafe), false, false);
			$labelTanggal .= " sampai ". format_tanggal_formal(strtotime($tanggalAkhirSafe), false, false).")";
		
			$data['labelRangeTanggal']	= $labelTanggal;
			$data['useFilter'] = true;
		
		} else {

			$data['sipedang_tglmulai']		= date("Y-m-d");
			$data['sipedang_tglselesai']	= date("Y-m-d");
		}
		
		if ($statusReservasi == "approved") {
			$data['pageTitle'] = "List Reservasi [Approved]";
			$data['tampil_tombol_cetak'] = 1;
			$data['listReservasi'] =
				$this->Datareservasi->get_kegiatan(Datareservasi::STAT_ACCEPTED,-1);
			$data['listTag'] = $statusReservasi;
		} else if ($statusReservasi == "upcoming") {
			$data['pageTitle'] = "List Reservasi [Upcoming]";
			$data['tampil_tombol_cetak'] = 0;
			$data['listReservasi'] =
				$this->Datareservasi->get_kegiatan(Datareservasi::STAT_ACCEPTED,-1,date("Y-m-d H:i:s"));
			$data['listTag'] = $statusReservasi;
		} else if ($statusReservasi == "archive") {
			$data['pageTitle'] = "List Reservasi [Arsip]";
			if ($data['useFilter']) {
				$data['listReservasi'] =
					$this->Datareservasi->get_kegiatan_by_daterange(
						$tanggalMulaiSafe, $tanggalAkhirSafe);
			} else {
				$data['listReservasi'] = $this->Datareservasi->get_kegiatan();
			}
			$data['tampil_tombol_cetak'] = 1; // Tampilkan tombol cetak
			$data['listTag'] = $statusReservasi;
		} else {
			$data['pageTitle'] = "List Reservasi [Pending]";
			$data['listReservasi'] =
				$this->Datareservasi->get_kegiatan(Datareservasi::STAT_PENDING,-1);
			$data['tampil_tombol_cetak'] = 0;
			$data['listTag'] = "pending";
		}
		
		$outputType = $this->input->get('type');
		if ($outputType=='pdf') {
			$this->generate_pdf_arsip($data['listReservasi'], $data['pageTitle'].$labelTanggal);
		} else { // Output HTML
			$data['listKategori'] = $this::$listKategori;
			$this->load->template_admin("admin/list_reservasi", $data);
		}
		
	}
	
	public function detil_reservasi($idReservasi = -1) {
		if (!$this->load->check_session()) return;
		$data['loggedInUser'] = $this->nativesession->get(MY_Loader::SESS_ID_UID);
		$data['jumlahPending']	= $this->nativesession->get(MY_Loader::SESS_ID_PENDING);
		
		$data['pageTitle'] = "Detil Reservasi";
		if ($idReservasi > 0) {
			$this->load->model("Datareservasi");
			$this->load->helper('tanggalreservasi');
			
			$data['dataReservasi'] = $this->Datareservasi->get_kegiatan_by_id($idReservasi);
			if ($data['dataReservasi'] != null) { // Jika ditemukan
				if (empty($data['dataReservasi']->gambar))
					$data['dataReservasi']->gambar = "/assets/images/cover_small.png";
			} else {
				$this->output->set_header("Location: ".site_url("/pengelola/reservasi/list_reservasi"));
				return;
			}
		} else {
			$this->output->set_header("Location: ".site_url("/pengelola/reservasi/list_reservasi"));
			return;
		}
		$data['listKategori'] = $this::$listKategori;
		$this->load->template_admin("admin/detil_reservasi", $data);
	}
	
	public function bukti_reservasi($idReservasi = -1) {
		if (!$this->load->check_session()) return;
		$data['loggedInUser'] = $this->nativesession->get(MY_Loader::SESS_ID_UID);
		$data['jumlahPending']	= $this->nativesession->get(MY_Loader::SESS_ID_PENDING);
		
		if ($idReservasi > 0) {
			$this->load->model("Datareservasi");
			$data['dataReservasi'] = $this->Datareservasi->get_kegiatan_by_id($idReservasi);
			if ($data['dataReservasi'] != null) { // Jika ditemukan
				$this->load->helper('tanggalreservasi');
				$fileType = $this->input->get('type');
				if ($fileType == 'pdf') {
					$this->generate_pdf_bukti($data['dataReservasi']);
				} else {
					$data['pageTitle'] = "Bukti Reservasi";
					$data['listKategori'] = $this::$listKategori;
					$this->load->template_admin("admin/bukti_reservasi", $data);
				}
			} else {
				$this->output->set_header("Location: ".site_url("/pengelola/reservasi/list_reservasi"));
				return;
			}
		} else {
			$this->output->set_header("Location: ".site_url("/pengelola/reservasi/list_reservasi"));
			return;
		}
		
	}
	
	private function generate_pdf_arsip($listReservasi, $listTitle, $outputFile = null) {
		// Asumsi helper tanggalreservasi sudah di-load
		$this->load->helper('fpdf');
		
		fpdf();
		
		$pdf = new PDF_MC_Table();
		$pdf->SetMargins(20,20,20);
		$pdf->AddPage('L');
		
		// Header
		$pdf->SetFont('Times','B',14); // Arial, BOLD, 14pt
		$pdf->Cell(257,10,"ARSIP RESERVASI",0,0,'C');
		$pdf->Ln(15);
		
		$pdf->SetFont('Times','',12);
		$pdf->MultiCell(257,5,$listTitle,0,'C');
		$pdf->Ln(5);
		
		$pdf->SetFont('Times','',10);
		$pdf->Cell(260,5,"Dicetak tanggal ".format_tanggal_formal(time(), false, true));
		$pdf->Ln(8);
		
		$pdf->SetFont('Times','',12);
		$pdf->setHeaders(array('No.','Tanggal Peminjaman','Kegiatan','Penyelenggara','Status'));
		$pdf->SetWidths(array(10,70,80,40,30));
		$cntItem = 0;
		$pdf->headerRow();
		
		$strTanggal = '';
		foreach ($listReservasi as $itemReservasi) {
			$cntItem++;
			$unixTimeMulai		= strtotime($itemReservasi->waktuMulaiPinjam);
			$unixTimeSelesai	= strtotime($itemReservasi->waktuSelesaiPinjam);
			
			if (date('Y-m-d', $unixTimeMulai) == date('Y-m-d', $unixTimeSelesai)) {
				$strTanggal  = format_tanggal_formal($unixTimeMulai, true, false);
				$strTanggal .= "\r\n";
				$strTanggal .= date('H:i', $unixTimeMulai) . ' - ' . date('H:i', $unixTimeSelesai);
			} else {
				$strTanggal  = format_tanggal_formal($unixTimeMulai, true, true);
				$strTanggal .= " - \r\n";
				$strTanggal .= format_tanggal_formal($unixTimeSelesai, true, true);
			}
			
			if ($itemReservasi->statusReservasi == Datareservasi::STAT_ACCEPTED) {
				$labelStatus = "Approved";
			} else if ($itemReservasi->statusReservasi == Datareservasi::STAT_REJECTED) {
				$labelStatus = "Rejected";
			} else if ($itemReservasi->statusReservasi == Datareservasi::STAT_PENDING) {
				if ($itemReservasi->expireTime < time() ) {
					$labelStatus = "Expired";
				} else {
					$labelStatus = "Pending";
				}
			} else {
				$labelStatus = "Unknown";
			}
			$pdf->Row(array(
					$cntItem,
					$strTanggal,
					$itemReservasi->kegiatan,
					$itemReservasi->penyelenggara,
					$labelStatus
			));
		}
		if ($outputFile==null) {
			$pdf->Output("arsip_sipedang.pdf",'I');
		} else {
			$pdf->Output($outputFile,'D');
		}
		
	}
	private function generate_pdf_bukti($rowReservasi) {
		$this->load->helper('fpdf');
		fpdf();
		
		$pdf = new FPDF();
		$pdf->AddPage();
		
		/*
		for ($i=0;$i<=200;$i++) {
			if (($i % 10) == 0) {
				$pdf->Rect(0, ($i*2), 5, 1, 'F');
				$pdf->Rect(($i*2), 0, 1, 5, 'F');
				$pdf->Line(0, ($i*2), 280, ($i*2));
				$pdf->Line(($i*2), 0, ($i*2), 280);
			} else {
				$pdf->Rect(0, ($i*2), 3, 1, 'F');
				$pdf->Rect(($i*2), 0, 1, 3, 'F');
			}
			
		}
		*/
		$jarakMenjorok	= 20;
		// Header
		$pdf->SetFont('Times','B',14);
		//$pdf->SetFillColor(255,255,255);
		//$pdf->SetDrawColor(0, 31, 63);
		$pdf->Rect(9, 9, 190, 7);
		$pdf->Cell(190,5,"BUKTI RESERVASI",0,0,'C');
		$pdf->Ln(20);
		
		$pdf->SetFont('Times','',12);
		$pdf->MultiCell(190,5,"Jurusan Informatika selaku pengelola ruang sidang Informatika".
				" gedung E lantai 3 dengan ini menyatakan bahwa reservasi:");
		$pdf->Ln(5);
		
		$pdf->SetX($jarakMenjorok);
		$pdf->Cell(45,5,"Kegiatan");
		$pdf->Cell(5,5,":");
		$pdf->MultiCell(125,5,$rowReservasi->kegiatan);
		$pdf->Ln(2);
		
		$pdf->SetX($jarakMenjorok);
		$pdf->Cell(45,5,"Nama pemesan");
		$pdf->Cell(5,5,":");
		$pdf->MultiCell(125,5,$rowReservasi->namaTamu);
		$pdf->Ln(2);
		
		$pdf->SetX($jarakMenjorok);
		$pdf->Cell(45,5,"Penyelenggara");
		$pdf->Cell(5,5,":");
		$pdf->MultiCell(125,5,$rowReservasi->penyelenggara);
		$pdf->Ln(2);
		
		$strWaktu = format_range_tanggal_mysql(
				$rowReservasi->waktuMulaiPinjam,
				$rowReservasi->waktuSelesaiPinjam);
		$pdf->SetX($jarakMenjorok);
		$pdf->Cell(45,5,"Waktu peminjaman");
		$pdf->Cell(5,5,":");
		$pdf->MultiCell(125,5,$strWaktu);
		$pdf->Ln(2);
		
		$pdf->SetX($jarakMenjorok);
		$pdf->Cell(45,5,"Kategori Kegiatan");
		$pdf->Cell(5,5,":");
		$pdf->MultiCell(125,5,
				$this::$listKategori[$rowReservasi->kategoriKegiatan]);
		$pdf->Ln(2);
		
		$pdf->SetX($jarakMenjorok);
		$pdf->Cell(45,5,"Tanggal Reservasi");
		$pdf->Cell(5,5,":");
		$pdf->MultiCell(125,5,
				format_tanggal_formal(
						strtotime($rowReservasi->waktuReservasi), false, true));
		
		$pdf->Ln(5);
		$pdf->MultiCell(190,5,"telah disetujui dan kegiatan tersebut dapat dilaksanakan sesuai ".
				"tanggal pemesanan.");
		$pdf->Ln(2);
		$pdf->MultiCell(190,5,"Demikian surat bukti reservasi ini, mohon digunakan sebagaimana mestinya.");
		
		$pdf->Ln(20);
		$pdf->SetX(140);
		$pdf->Cell(45,5,"Semarang, ".format_tanggal_formal(time(),false,false));
		$pdf->Ln(5);
		$pdf->SetX(140);
		$pdf->Cell(45,5,"Pengelola,");
		
		$pdf->Ln(20);
		$pdf->SetX(140);
		$pdf->Cell(45,5,". . . . . . . . . . . . . . . .");
		
		$pdf->Output("bukti_reservasi.pdf",'I');
		
		
	}
	public function arsip_reservasi() {
		if (!$this->load->check_session()) return;
		$data['loggedInUser'] = $this->nativesession->get(MY_Loader::SESS_ID_UID);
		$data['jumlahPending']	= $this->nativesession->get(MY_Loader::SESS_ID_PENDING);
		
		$data['pageTitle'] = "Arsip Reservasi";
		$this->load->template_admin("admin/list_arsip_reservasi", $data);
	}
	
	public function approve_reservasi() {
		if (!$this->load->check_session(false)) {
			$this->output->append_output('Access denied');
			return;
		}
		$backRef = "/pengelola/reservasi/list_reservasi";
		if ($this->input->post("sipedang_submit")) {
			$idReservasi = $this->input->post("sipedang_idreservasi");
			$this->load->model("Datareservasi");
			$actionStatus = $this->Datareservasi->set_status_reservasi($idReservasi, Datareservasi::STAT_ACCEPTED);
			
			// Perbaharui jumlah pending
			$jumlahPending = $this->Datareservasi->get_jumlah_kegiatan(
				Datareservasi::STAT_PENDING);
			$this->nativesession->set(MY_Loader::SESS_ID_PENDING, $jumlahPending);
			if ($actionStatus != null) {
				$this->output->append_output("Approve error: ".$actionStatus);
				return;
			}
			if ($this->input->get("ref") == "detil") {
				$backRef = "/pengelola/reservasi/detil_reservasi/".$idReservasi;
			}
		}
		$this->output->set_header("Location: ".site_url($backRef));
	}
	
	public function reject_reservasi() {
		if (!$this->load->check_session(false)) {
			$this->output->append_output('Access denied');
			return;
		}
		$backRef = "/pengelola/reservasi/list_reservasi";
		if ($this->input->post("sipedang_submit")) {
			$idReservasi = $this->input->post("sipedang_idreservasi");
			$this->load->model("Datareservasi");
			$actionStatus = $this->Datareservasi->set_status_reservasi($idReservasi, Datareservasi::STAT_REJECTED);
			
			// Perbaharui jumlah pending
			$jumlahPending = $this->Datareservasi->get_jumlah_kegiatan(
					Datareservasi::STAT_PENDING);
			if ($actionStatus != null) {
				$this->output->append_output("Approve error: ".$actionStatus);
				return;
			}
			if ($this->input->get("ref") == "detil") {
				$backRef = "/pengelola/reservasi/detil_reservasi/".$idReservasi;
			}
		}
		$this->output->set_header("Location: ".site_url($backRef));
	}
	
	public function cetak_list_reservasi($statusReservasi = 1) {
		if (!$this->load->check_session()) return;
		$data['loggedInUser'] = $this->nativesession->get(MY_Loader::SESS_ID_UID);
		$data['jumlahPending']	= $this->nativesession->get(MY_Loader::SESS_ID_PENDING);
		
		$this->load->model("Datareservasi");
		$listReservasi = $this->Datareservasi->get_kegiatan($statusReservasi);
		$this->load->helper('tanggalreservasi');
		$this->generate_pdf_arsip($listReservasi);
	}
	//=================== AJAX =========================
	public function ajax_get_listreservasi_admin() {
		if (!$this->load->check_session(false)) {
			$this->output->append_output('Access denied');
			return;
		}
		
		$this->load->model("Datareservasi");
	
		$startDate	= $_GET['start'];
		$endDate	= $_GET['end'];
	
		if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$startDate))
			die("Invalid date format!");
		if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$endDate))
			die("Invalid date format!");
	
		$listReservasi = $this->Datareservasi->get_kegiatan_by_daterange(
				$startDate, $endDate, Datareservasi::STAT_ACTIVE_RESERVATION
		);
	
		$ajaxOutput = array();
		foreach ($listReservasi as $itemReservasi) {
			if ($itemReservasi->statusReservasi == Datareservasi::STAT_PENDING) {
				$eventColor = '#F0AD4E';
			} else {
				$eventColor = '#CEE4ED';
			}
			$ajaxOutput[] = array(
					'id'		=> $itemReservasi->idReservasi,
					'title'		=> $itemReservasi->kegiatan,
					'allDay'	=> false,
					'url'		=> site_url("/pengelola/reservasi/detil_reservasi/".$itemReservasi->idReservasi),
					'start'		=> $itemReservasi->waktuMulaiPinjam,
					'end'		=> $itemReservasi->waktuSelesaiPinjam,
					'backgroundColor' => $eventColor
			);
		}
		$this->output->append_output(json_encode($ajaxOutput));
	}
	
	
}