<!-- AM-SIPEDANG-01 -->
<div class="col-md-8">
	<div class="well">
		<h3>Kegiatan Terdekat:</h3>
<?php
if (! empty ( $kegiatanTerdekat [0] )) {
	$waktuKegiatan = strtotime ( $kegiatanTerdekat [0]->waktuMulaiPinjam );
	echo "Nama kegiatan: " . htmlspecialchars ( $kegiatanTerdekat [0]->kegiatan ) . "<br>\n";
	echo "Oleh: " . htmlspecialchars ( $kegiatanTerdekat [0]->penyelenggara ) . "<br>\n";
	
	echo $this->load->tanggalIndonesia ( $waktuKegiatan, true, false );
	echo date ( "H:i", $waktuKegiatan );
}

?>
	</div>

	<ul class="media-list">
<?php
foreach ( $kegiatanTerdekat as $itemKegiatan ) {
	echo "<li class=\"media\">\n";
	echo "	<div class=\"media-left\">\n";
	echo "		<a href=\"#\">\n";
	echo "			<img class=\"media-object\" src=\"" . base_url ( "/assets/images/hmif_32.png" ) . "\"\n";
	echo "				alt=\"ICO\" style=\"width:32px;height:32px;\">\n";
	echo "		</a>\n";
	echo "	</div>\n";
	echo "	<div class=\"media-body\">\n";
	echo "		<h4 class=\"media-heading\"><a href=\"#\" onclick=\"return detil_event(" . $itemKegiatan->idReservasi . ");\">" . htmlspecialchars ( $itemKegiatan->kegiatan ) . "</a></h4>\n";
	echo "			<p>Oleh: " . htmlspecialchars ( $itemKegiatan->penyelenggara ) . "</p>\n";
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
				<span class="glyphicon glyphicon-calendar"></span> Kalendar Kegiatan
			</h3>
		</div>
		<div class="panel-body">
			<div id="datepicker"></div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				<span class="glyphicon glyphicon-list"></span> Cara Peminjaman
			</h3>
		</div>
		<div class="panel-body">
			<ol>
				<li>Isi formulir</li>
				<li>Datang ke ruang jurusan (konfirmasi) dalam kurang dari 3 jam
					dari pemesanan</li>
				<li>Selesai</li>
			</ol>
		</div>
	</div>
</div>
<div class="modal fade" tabindex="-1" role="dialog"
	id="sipedang_dlg_detilevent">
	<div class="modal-dialog modal-lg">
		<div class="modal-dialog">
			<div class="modal-content">
				<div id="sipedang_dlg_loader">
					<div class="modal-body">
						<img src="<?php echo base_url("/assets/images/loader.gif")?>"
							alt="Loading..." /> <b>Loading....</b>
					</div>
				</div>
				<div id="sipedang_dlg_main">
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	var activeId = 0;
	function detil_event(idEvent) {
		$('#sipedang_dlg_loader').show();
		$('#sipedang_dlg_main').hide();
		
		activeId = idEvent;
		$('#sipedang_dlg_detilevent').modal({
            keyboard: false,
            backdrop: 'static'
        });
		return false;
	}
	$(function() {
	    $( "#datepicker" ).datepicker();
	    $('#sipedang_dlg_detilevent').on('shown.bs.modal',function(e){
	    	$.ajax({
		    	method: 'POST',
				url: "<?php echo site_url("/ControlReservasi/ajax_detil_kegiatan"); ?>",
				data:{id: activeId},
				type: 'html'
    		}).done(function(data) {
    			$('#sipedang_dlg_loader').hide();
    			$('#sipedang_dlg_main').html(data).show();
    		});
	    });
	});

	
  </script>