<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	<h4 class="modal-title" id="sipedang_dlg_header"><?php
		echo htmlspecialchars($dataKegiatan->kegiatan);
	?></h4>
</div>
<div class="modal-body" id="sipedang_dlg_detilbody">
<?php if (!empty($dataKegiatan->gambar)) { //============ ?>
	<div class="row">
		<div class="col-md-12">
			<img src="<?php echo base_url($dataKegiatan->gambar); ?>" alt="Gambar Kegiatan" 
				class="img-responsive center-block"/>
		</div>
	</div>
<?php } else { //=============== ELSE ======== ?>
	<div class="row">
		<div class="col-md-12">
			<img src="<?php echo base_url('/assets/images/cover_small.png'); ?>" alt="Gambar Kegiatan" 
				class="img-responsive center-block"/>
		</div>
	</div>
<?php } //====================== END IF ====== ?>
	<div class="row">
		<div class="col-md-12">
			<table class="table">
				<tr>
					<td style="width: 300px;">Nama Kegiatan</td>
					<td><?php echo htmlspecialchars($dataKegiatan->kegiatan); ?></td>
				</tr>
				<tr>
					<td>Nama Pemesan</td>
					<td><?php echo htmlspecialchars($dataKegiatan->namaTamu); ?></td>
				</tr>
				<tr>
					<td>Penyelenggara Kegiatan</td>
					<td><?php echo htmlspecialchars($dataKegiatan->penyelenggara); ?></td>
				</tr>
				<tr>
					<td>Tanggal Pelaksanaan</td>
					<td><?php 
							echo format_range_tanggal_mysql(
									$dataKegiatan->waktuMulaiPinjam,
									$dataKegiatan->waktuSelesaiPinjam,
									' s/d '
								);
						?></td>
				</tr>
			</table>
		</div>
	</div>
</div>