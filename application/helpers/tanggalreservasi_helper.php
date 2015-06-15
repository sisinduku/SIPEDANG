<?php
function format_tanggal_mysql($tanggalMySQL) {
	return format_tanggal(strtotime($tanggalMySQL));
}
function format_range_tanggal_mysql($tanggalMulaiMySQL, $tanggalSelesaiMySQL) {
	return format_range_tanggal(strtotime($tanggalMulaiMySQL), strtotime($tanggalSelesaiMySQL));
}
function format_tanggal_formal($unixTime, $tampilNamaHari = true, $tampilWaktu = false) {
	global $namaHari, $namaBulan;
	
	$idNamaHari	= date("w", $unixTime);
	$idBulan	= date("n", $unixTime);

	$outputFormat = '';
	if ($tampilNamaHari) $outputFormat = $namaHari[$idNamaHari].", ";

	$outputFormat .= date("j ", $unixTime). $namaBulan[$idBulan]. date(" Y", $unixTime);

	if ($tampilWaktu) $outputFormat .= date(", H:i:s", $unixTime);
	return $outputFormat;
}

function format_tanggal($unixTime) {
	global $namaHari, $namaBulan;
	
	$idNamaHari	= date("w", $unixTime);
	$idBulan	= date("n", $unixTime);

	$outputFormat  = $namaHari[$idNamaHari].", ";
	$outputFormat .= date("j ", $unixTime). $namaBulan[$idBulan]. date(" Y", $unixTime);
	$outputFormat .= date(", H:i", $unixTime);
	return $outputFormat;
}

function format_range_tanggal($unixTimeMulai, $unixTimeSelesai, $separator = ' - ') {
	// Jika tanggal sama...
	if (date('Y-m-d', $unixTimeMulai) == date('Y-m-d', $unixTimeSelesai)) {
		return format_tanggal($unixTimeMulai).$separator.date('H:i', $unixTimeSelesai);
	} else {
		return format_tanggal($unixTimeMulai).$separator.
			format_tanggal($unixTimeSelesai);
	}
}