<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	<h4 class="modal-title" id="sipedang_dlg_header"><?php
		echo htmlspecialchars($dataKegiatan->kegiatan);
	?></h4>
</div>
<div class="modal-body" id="sipedang_dlg_detilbody">
	<div class="row">
		<div class="col-md-12">
			<img src="<?php echo base_url($dataKegiatan->gambar); ?>" alt="Gambar Kegiatan" 
				class="img-responsive center-block"/>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<table class="table">
				<tr>
					<td>Nama Kegiatan</td>
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
			</table>
		</div>
	</div>
</div>