<!-- AM-SIPEDANG-13 -->
<h2>Cetak Bukti Reservasi</h2>
<div class="col-lg-12">
	<!-- /.row -->
	<div class="row">
		<!-- /.col-lg-12 -->
		<div class="col-lg-12">
			<div>
				<a href="<?php
				echo site_url("/pengelola/reservasi/bukti_reservasi/".
						$dataReservasi->idReservasi."?type=pdf"); ?>" class="btn btn-danger"
						target="_blank">
					<span class="glyphicon glyphicon-print"></span> Versi PDF</a>
			</div>
			<div class="panel panel-default">
				<!-- /.panel-heading -->
				<div class="panel-body">
					<div class="dataTable_wrapper">
						<table class="table">
							<tbody>
								<tr>
									<td>Nama Kegiatan</td>
									<td>: <?php echo htmlspecialchars($dataReservasi->kegiatan); ?></td>
								</tr>
								<tr>
									<td width=200>Nama Pemesan</td>
									<td>: <?php echo htmlspecialchars($dataReservasi->namaTamu); ?></td>
								</tr>
								<tr>
									<td>Penyelenggara Kegiatan</td>
									<td>: <?php echo htmlspecialchars($dataReservasi->penyelenggara); ?></td>
								</tr>
								<tr>
									<td>Waktu Pelaksanaan</td>
									<td>: <?php 
										$strTglMulai	= strtotime($dataReservasi->waktuMulaiPinjam);
										$strTglSelesai	= strtotime($dataReservasi->waktuSelesaiPinjam);
										$strTglRange	= format_range_tanggal($strTglMulai, $strTglSelesai);
										echo "<b>".$strTglRange."</b>";
									?></td>
								</tr>
								<tr>
									<td>Kategori Kegiatan</td>
									<td>: <?php echo $listKategori[$dataReservasi->kategoriKegiatan]; ?></td>
								</tr>
								<tr>
									<td>Waktu Pemesanan</td>
									<td>: <?php echo ($dataReservasi->waktuReservasi); ?></td>
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
	<div class="row">
		<div class="col-lg-8"></div>
		<div class="col-lg-4">
			<div class="panel panel-default">
				<!-- /.panel-heading -->
				<div class="panel-body">
					<b>Semarang, <?php echo format_tanggal_formal(strtotime("now"), false, false); ?></b><br>
					<b>Pengelola</b>
					<div style="height:75px;"></div>
					<b>Nama Pengelola</b>
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
	</div>
</div>