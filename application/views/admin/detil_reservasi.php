<!-- AM-SIPEDANG-11 dan AM-SIPEDANG-12 -->
<div class="col-lg-12">
	<h2>Detil Reservasi</h2>
	<!-- /.row -->
	<a href="<?php echo site_url("/pengelola/ControlReservasi/list_reservasi"); ?>">
		<span class="glyphicon glyphicon-chevron-left"></span> Kembali ke list</a>
	<div class="row">
		<div class="col-lg-4">
			<div class="panel panel-default">
				<!-- /.panel-heading -->
				<div class="panel-body">
					<h4>Picture</h4>
					<div style="border: 1px solid #FFB6C1">
						<img src="<?php echo base_url($dataReservasi->gambar);?>"
							alt="Gambar Kegiatan" style="width: 100%;" />
					</div>
					<p>
<?php if ($dataReservasi->statusReservasi == 0) { //======= Jika status pending ================ ?>
	<button type="button" class="btn btn-danger"
			onclick="reject_reservasi(<?php echo $dataReservasi->idReservasi; ?>);">
		<span class="fa fa-remove"></span> Tolak</button>
	<button type="button" class="btn btn-success"
			onclick="approve_reservasi(<?php echo $dataReservasi->idReservasi; ?>);">
		<span class="fa fa-check"></span> Terima</button>
<?php } else if ($dataReservasi->statusReservasi == 1) {  //============================================ ?>
	<button type="button" class="btn btn-danger"
			onclick="reject_reservasi(<?php echo $dataReservasi->idReservasi; ?>);">
		<span class="fa fa-remove"></span> Cancel</button>
	<a href="<?php
		echo site_url("/pengelola/ControlReservasi/bukti_reservasi/".
				$dataReservasi->idReservasi);
	?>" class="btn btn-primary">
		<span class="fa fa-file"></span> Cetak Bukti</a>
<?php } //==================================================== ?>
					</p>
					<br>
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-6 -->
		<div class="col-lg-8">
			<div class="panel panel-default">
				<!-- /.panel-heading -->
				<div class="panel-body">
					<div class="dataTable_wrapper">
						<table class="table">
							<tbody>
								<tr>
									<td style="width: 30%;">Nama Kegiatan</td>
									<td>: <?php echo htmlspecialchars($dataReservasi->kegiatan);?></td>
								</tr>
								<tr>
									<td>Nama Pemesan</td>
									<td>: <?php echo htmlspecialchars($dataReservasi->namaTamu);?></td>
								</tr>
								<tr>
									<td>Penyelenggara Kegiatan</td>
									<td>: <?php echo htmlspecialchars($dataReservasi->penyelenggara);?></td>
								</tr>
								<tr>
									<td>Tempat dan Waktu Pelaksanaan</td>
									<td>: <?php 
										echo format_range_tanggal_mysql(
												$dataReservasi->waktuMulaiPinjam,
												$dataReservasi->waktuSelesaiPinjam,
												' s/d '
											);
									?></td>
								</tr>
								<tr>
									<td>Kategori Kegiatan</td>
									<td>: <?php echo $listKategori[$dataReservasi->kategoriKegiatan];?></td>
								</tr>
								<tr>
									<td>Status</td>
									<td>: <?php echo MY_Loader::$htmlStatus[$dataReservasi->statusReservasi];?></td>
								</tr>
								<tr>
									<td colspan="2">Deskripsi Kegiatan<br>
										<div class="well well-sm" style="min-height: 100px;">
											<?php echo ($dataReservasi->deskripsiKegiatan);?>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
						<!-- /.panel-body -->
					</div>
					<!-- /.panel -->
				</div>
			</div>
		</div>
	</div>
</div>
<script>
function approve_reservasi(idReservasi) {
	var userResp = confirm("Setujui reservasi?");
	if (!userResp) return false;

	$("#sipedang_loadingbox").show();
	$("body").append('<form action="<?php echo site_url('/pengelola/ControlReservasi/approve_reservasi?ref=detil'); ?>" method="POST" id="sipedang_acceptor">');
	$("#sipedang_acceptor").append('<input type="hidden" name="sipedang_idreservasi" value="'+idReservasi+'" />');
	$("#sipedang_acceptor").append('<input type="hidden" name="sipedang_submit" value="submit-"/>');
	$("#sipedang_acceptor").submit();
	return false;
}
function reject_reservasi(idReservasi) {
	var userResp = confirm("Tolak/batalkan reservasi?");
	if (!userResp) return false;

	$("#sipedang_loadingbox").show();
	$("body").append('<form action="<?php echo site_url('/pengelola/ControlReservasi/reject_reservasi?ref=detil'); ?>" method="POST" id="sipedang_acceptor">');
	$("#sipedang_acceptor").append('<input type="hidden" name="sipedang_idreservasi" value="'+idReservasi+'" />');
	$("#sipedang_acceptor").append('<input type="hidden" name="sipedang_submit" value="submit-"/>');
	$("#sipedang_acceptor").submit();
	return false;
}
</script>