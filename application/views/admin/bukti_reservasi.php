<!-- AM-SIPEDANG-13 -->
<h2>Cetak Bukti Reservasi</h2>
<div class="col-lg-12">
	<!-- /.row -->
	<div class="row">
		<!-- /.col-lg-12 -->
		<div class="col-lg-12">
			<div>
				<button type="button" class="btn btn-danger disabled">
					<span class="glyphicon glyphicon-print"></span> Cetak</button>
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
										$strTglMulai	= MY_Loader::tanggalIndonesia(strtotime($dataReservasi->waktuMulaiPinjam), true, true);
										$strTglSelesai	= MY_Loader::tanggalIndonesia(strtotime($dataReservasi->waktuSelesaiPinjam), true, true);
										echo "<b>".$strTglMulai."</b> sampai <b>".$strTglSelesai."</b>";
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
					<h4>Semarang, <?php echo MY_Loader::tanggalIndonesia(strtotime("now"), false); ?></h4>
					<h4>Pengelola</h4>
					<br><br>
					<h4>Nama Pengelola</h4>
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
	</div>