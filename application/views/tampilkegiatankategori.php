<!-- AM-SIPEDANG-04 -->
<div class="col-lg-12">
<div style="background-color:#686868;padding:3px;border-radius:3px;">
	<div class="main-gallery js-flickity" style="background-color:#999; color: #fff;">
<?php foreach ($listKategori as $idx => $itemKategori) { //======= ?>
		<div class="gallery-cell" style="width:100%;height:500px;">
			<h1 style="text-align: center;"><?php echo $itemKategori; ?></h1>
			<div class="row">
				<div class="col-md-offset-3 col-md-6">
				<?php if (!empty($listKegiatanKategori[$idx])) { //======== ?>
					<table class="table" style="font-size: 1.2em;">
					<?php foreach ($listKegiatanKategori[$idx] as $itemKegiatan) { //============?>
						<tr><td><b><?php echo htmlspecialchars($itemKegiatan->kegiatan);?></b>
							<div style="font-size: 0.9em;">Oleh <?php echo htmlspecialchars($itemKegiatan->penyelenggara);?></div>
							<div style="font-size: 0.9em;"><?php echo htmlspecialchars($itemKegiatan->waktuMulaiPinjam);?></div></td>
						<td style="text-align: right;width:100px;">
						<a href="#" class="btn btn-default" onclick="return detil_event(<?php echo $itemKegiatan->idReservasi; ?>);">Selengkapnya</a></td></tr>
					<?php } //=======================?>
					</table>
				<?php } else { //================================ ?>
					<div style="text-align:center;"><span class="glyphicon glyphicon-exclamation-sign"></span> Tidak Ada Kegiatan</div>
				<?php } //======================================= ?>
				</div>
			</div>
		</div>
<?php } //======================= END WHILE === ?>
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