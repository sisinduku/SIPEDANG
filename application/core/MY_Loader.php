<?php

/**
 * MY_Loader merupakan extends dari CI_Loader
 * @author M Nur Hardyanto
 * 
 */
class MY_Loader extends CI_Loader {
	const SESS_ID_UID		= "sipedang_sess_uid";
	const SESS_ID_UEMAIL	= "sipedang_sess_uemail";
	const SESS_ID_PENDING	= "sipedang_sess_pending";
	
	public static $htmlStatus = array(
			0 => "<span class=\"label label-warning\">Pending</span>",
			1 => "<span class=\"label label-success\">Approved</span>",
			2 => "<span class=\"label label-danger\">Rejected</span>"
	);
	/**
	 * Mengubah tanggal menjadi format Indonesia
	 * @param int $time_ UNIX time
	 * @param boolean $hari_ TRUE apabila ingin menampilkan nama hari (Senin, Selasa, dsb)
	 * @param boolean $waktu_ TRUE apabila ingin menampilkan waktu dalam HH:mm:ss
	 * @return string Tanggal yang sudah terformat
	 */
	function tanggalIndonesia($time_, $hari_ = true, $waktu_ = false) {
		$hari="";
		if ($hari_) {
			switch (date("w", $time_)) {
				case "0" : $hari="Minggu, ";break;
				case "1" : $hari="Senin, ";break;
				case "2" : $hari="Selasa, ";break;
				case "3" : $hari="Rabu, ";break;
				case "4" : $hari="Kamis, ";break;
				case "5" : $hari="Jumat, ";break;
				case "6" : $hari="Sabtu, ";break;
			}
		}

		switch (date("m", $time_)) {
			case "1" : $bulan="Januari";break;
			case "2" : $bulan="Februari";break;
			case "3" : $bulan="Maret";break;
			case "4" : $bulan="April";break;
			case "5" : $bulan="Mei";break;
			case "6" : $bulan="Juni";break;
			case "7" : $bulan="Juli";break;
			case "8" : $bulan="Agustus";break;
			case "9" : $bulan="September";break;
			case "10" : $bulan="Oktober";break;
			case "11" : $bulan="November";break;
			case "12" : $bulan="Desember";break;
		}
		
		return $hari. date("j", $time_) ." $bulan". date(" Y", $time_).($waktu_ ? date(", H:i:s", $time_):"");
	}
	
	/**
	 * @param string $text Teks yang ingin dioutputkan
	 * @param boolean $return TRUE jika outputnya ingin direturn
	 * @return NULL|string
	 */
	public function append_output($text, $return = FALSE) {
		$this->output->append_output($text);
		if ($return) return $text;
	}
    /**
     * Mengoutputkan konten dengan template front-end
     * @param string $template_name File konten yang akan ditampilkan
     * @param array $vars Array nilai
     * @param boolean $return Minta return output?
     * @return Output <string>
     */
    public function template($template_name, $vars = array(), $return = FALSE)
    {
        $this->view('skin/header', $vars, $return);
		$this->view($template_name, $vars, $return);
        $this->view('skin/footer', $vars, $return);
    }

	public function template_admin($template_name, $vars = array(), $return = FALSE)
    {
        $this->view('admin/skin/header', $vars, $return);
		if (!isset($vars['simplePage']))
			$this->view('admin/skin/navigasi', $vars, $return);
		$this->view($template_name, $vars, $return);
        $this->view('admin/skin/footer', $vars, $return);
    }
	public function template_admin_full($template_name, $vars = array(), $return = FALSE)
    {
        $content  = $this->view('admin/header', $vars, $return);
		$content .= $this->append_output("<div id='site_content'>\n");
		$content .= $this->view($template_name, $vars, $return);
        $content .= $this->view('admin/footer', $vars, $return);
		
        if ($return) {
            return $content;
        }
    }
	public function template_admin_simple($template_name, $vars = array(), $return = FALSE)
    {
		$_vars = $vars;
		$_vars['no_bodyhead'] = true;
        $content  = $this->view('admin/header', $_vars, $return);
		$content .= $this->view($template_name, $vars, $return);
		// tidak ada footer. Ditutup secara manual
		$content .= $this->append_output("\n</BoDY >\n</HTmL >");
		
        if ($return) {
            return $content;
        }
    }
	
	/**
	 * Cek sesi pengelola
	 * @param string $enableRedirect Jika TRUE, maka akan redirect jika tidak ada sesi
	 * @return boolean TRUE jika ada sesi, sebaliknya FALSE
	 */
	public function check_session($enableRedirect = true) {
		$ci =& get_instance();
		
		if (!$ci->nativesession->get($this::SESS_ID_UID)) {
			if ($enableRedirect) {
				$ci->output->set_header('Location: '.site_url('/autentikasi/login?next='.urlencode($_SERVER['REQUEST_URI'])));
			} 
			return false;
		}
		return true;
	}
}