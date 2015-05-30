<!-- AM-SIPEDANG-01 -->
<div class="col-md-8">
<div class="well">
	<h3>Kegiatan Terdekat:</h3>
<?php
if (!empty($kegiatanTerdekat[0])) {
	$waktuKegiatan = strtotime($kegiatanTerdekat[0]->waktuMulaiPinjam);
	echo "Nama kegiatan: ".htmlspecialchars($kegiatanTerdekat[0]->kegiatan)."<br>\n";
	echo "Oleh: ".htmlspecialchars($kegiatanTerdekat[0]->penyelenggara)."<br>\n";
	
	echo $this->load->tanggalIndonesia($waktuKegiatan, true, false);
	echo date("H:i", $waktuKegiatan);
}

?>
	</div>
		
<ul class="media-list">
<?php
foreach ($kegiatanTerdekat as $itemKegiatan) {
	echo "<li class=\"media\">\n";
	echo "	<div class=\"media-left\">\n";
	echo "		<a href=\"#\">\n";
	echo "			<img class=\"media-object\" src=\"".base_url("/assets/images/hmif_32.png")."\"\n";
	echo "				alt=\"ICO\" style=\"width:32px;height:32px;\">\n";
	echo "		</a>\n";
	echo "	</div>\n";
	echo "	<div class=\"media-body\">\n";
	echo "		<h4 class=\"media-heading\"><a href=\"#\">".htmlspecialchars($itemKegiatan->kegiatan)."</a></h4>\n";
	echo "			<p>Oleh: ".htmlspecialchars($itemKegiatan->penyelenggara)."</p>\n";
	echo "	</div>\n";
	echo "</li>\n";
}
?>
	</ul>
</div>
<div class="col-md-4">
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">
	    	<span class="glyphicon glyphicon-calendar"></span> Kalendar Kegiatan</h3>
	  </div>
	  <div class="panel-body">
	    <div id="datepicker"></div>
	  </div>
	</div>
	
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">
	    	<span class="glyphicon glyphicon-list"></span> Cara Peminjaman</h3>
	  </div>
	  <div class="panel-body">
	    <ol>
	    	<li>Isi formulir</li>
	    	<li>Datang ke ruang jurusan (konfirmasi) dalam kurang dari 3 jam dari pemesanan</li>
	    	<li>Selesai</li>
	    </ol>
	  </div>
	</div>
</div>
  <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>