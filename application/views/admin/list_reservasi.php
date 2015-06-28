<!-- AM-SIPEDANG-09 dan AM-SIPEDANG-10 -->

<script>
function init_page() {
<?php if ($tampil_tombol_cetak == 1) { //======= ?>
	$('#sipedang_filtertanggal').daterangepicker({
		<?php if (!empty($sipedang_tglmulai)) echo "startDate: '$sipedang_tglmulai',\n"; ?>
		<?php if (!empty($sipedang_tglselesai)) echo "endDate: '$sipedang_tglselesai',\n"; ?>
		format: 'YYYY-MM-DD',
		opens: 'right',
		drops: 'down'
	},function(start, end, label) {
        $('#sipedang_tglmulai').val(start.format('YYYY-MM-DD'));
        $('#sipedang_tglselesai').val(end.format('YYYY-MM-DD'));
    });
    $("#sipedang_btnsubmit_filter").removeClass('disabled');
<?php } //=============== ?>
}
</script>
<div class="col-lg-12">
	<h2>List Reservasi (<?php echo $listTag; ?>)</h2>
<?php if ($tampil_tombol_cetak==1) { //============= Jika tombol cetak ditampilkan... ?>
		<script src="<?php echo base_url('/assets/js/daterangepicker.js')?>" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/css/daterangepicker-bs3.css"); ?>" />
		<script>
		function apply_filter() {
			var tglMulai = $('#sipedang_tglmulai').val();
			var tglSelesai = $('#sipedang_tglselesai').val();
			var filterUrl = '<?php echo site_url('/pengelola/reservasi/list_reservasi/'.$listTag); ?>';
			filterUrl += '/' + encodeURIComponent(tglMulai) + '/' + encodeURIComponent(tglSelesai) + '/';
			if (tglMulai && tglSelesai) {
				window.location.href = filterUrl;
			}
			
			return false;
		}
		</script>
		<div class="row">
			<div class="col-md-6">
				<form class="form-inline" action="#" method="POST" onsubmit="return apply_filter();">
  					<div class="form-group">
  						<label for="sipedang_filtertanggal">Range Tanggal:</label>
						<div class="input-group" style="width: 350px;">
							<input id="sipedang_filtertanggal" type="text"
								name="sipedang_filtertanggal" class="form-control"
								value="<?php if (isset($sipedang_lblrange)) echo htmlspecialchars($sipedang_lblrange); ?>"
							/>
							<span class="input-group-btn">
								<button class="btn btn-primary disabled" id="sipedang_btnsubmit_filter" type="submit">
									<span class="glyphicon glyphicon-filter"></span>
										Filter</button>
							</span>
						</div>
					</div>
					<input type="hidden" name="sipedang_tglmulai" id="sipedang_tglmulai"
						value="<?php if (isset($sipedang_tglmulai)) echo htmlspecialchars($sipedang_tglmulai); ?>" />
					<input type="hidden" name="sipedang_tglselesai" id="sipedang_tglselesai"
						value="<?php if (isset($sipedang_tglselesai)) echo htmlspecialchars($sipedang_tglselesai); ?>" />
				</form>
			</div>
			<div class="col-md-2">
				<a class="btn btn-default<?php if (count($listReservasi)==0) echo " disabled"; ?>"
					href="<?php
					$downloadPdfUrl = "/pengelola/reservasi/list_reservasi/".$listTag;
					if ($useFilter) {
						$downloadPdfUrl .= "/".$sipedang_tglmulai."/".$sipedang_tglselesai;
					}
					$downloadPdfUrl .= "?type=pdf";
					echo site_url($downloadPdfUrl); ?>">
					<i class="glyphicon glyphicon-print"></i> Versi PDF
				</a>
			</div>
		</div>
<?php } //============================= ?>
		<div class="panel-body">
			<div class="dataTable_wrapper">
<?php if (isset($labelRangeTanggal))
	echo "<p>Range tanggal: <b>".$labelRangeTanggal."</b></p>"; ?>
				
				<table class="table table-striped table-bordered table-hover"
					id="sipedang_tabelreservasi">
					<thead>
						<tr>
							<th>Nama Kegiatan</th>
							<th>Tanggal dan Waktu</th>
							<th>Nama Penyelenggara</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
<?php
$nowTimeStamp = strtotime ( "now" );
foreach ( $listReservasi as $itemReservasi ) {
	$selisihHari = ceil ( (strtotime ( $itemReservasi->waktuMulaiPinjam ) - $nowTimeStamp) / 60 / 60 / 24 );
	$actionList = "<a href=\"" . site_url ( "/pengelola/reservasi/detil_reservasi/" . $itemReservasi->idReservasi ) . "\"><span class=\"fa fa-search\"></span> Detil</a>\n";
	if ($itemReservasi->statusReservasi == 0) {
		$actionList .= "<a href=\"#\" class=\"btn btn-success btn-xs\" onclick=\"return approve_reservasi(" . $itemReservasi->idReservasi . ");\">" . "<span class=\"fa fa-check\"></span> Approve</a>\n";
	}
	echo "	<tr>\n";
	echo " 		<td>" . htmlspecialchars ( $itemReservasi->kegiatan ) . "<br>";
	echo "<div class=\"spd-meta\"><span class=\"fa fa-tag\"></span> <b>" . $listKategori [$itemReservasi->kategoriKegiatan] . "</b></div></td>\n";
	echo "		<td>" . format_range_tanggal_mysql ( $itemReservasi->waktuMulaiPinjam, $itemReservasi->waktuSelesaiPinjam );
	if ($selisihHari > 0)
		echo "<div class=\"spd-meta\">" . $selisihHari . " hari lagi.</div>";
	
	echo "</td>\n";
	echo "		<td>" . htmlspecialchars ( $itemReservasi->penyelenggara ) . "</td>\n";
	echo "		<td>" . MY_Loader::$htmlStatus [$itemReservasi->statusReservasi] . " ";
	if ($itemReservasi->statusReservasi == 0)
		if ($itemReservasi->expireTime < strtotime ( "now" ))
			echo "<br><span class=\"label label-danger\">Expired</span>";
	echo "</td>\n";
	echo "		<td>" . $actionList . "</td>\n";
	echo "	</tr>\n";
}

?>
                                    </tbody>
				</table>
			</div>
			<!-- /.table-responsive -->
		</div>
		<!-- /.panel-body -->
	</div>
	<!-- /.panel -->

	<!-- DataTables JavaScript -->
	<script
		src="<?php echo base_url('/assets/bower_components/datatables/media/js/jquery.dataTables.min.js')?>"></script>
	<script
		src="<?php echo base_url('/assets/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js')?>"></script>

	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
	<script>
    $(document).ready(function() {
        $('#sipedang_tabelreservasi').DataTable({
                responsive: true
        });
    });
    function approve_reservasi(idReservasi) {
		var userResp = confirm("Setujui reservasi?");
		if (!userResp) return false;

		$("#sipedang_loadingbox").show();
		$("body").append('<form action="<?php echo site_url('/pengelola/reservasi/approve_reservasi'); ?>" method="POST" id="sipedang_acceptor">');
		$("#sipedang_acceptor").append('<input type="hidden" name="sipedang_idreservasi" value="'+idReservasi+'" />');
		$("#sipedang_acceptor").append('<input type="hidden" name="sipedang_submit" value="submit-"/>');
		$("#sipedang_acceptor").submit();
		return false;
    }
    </script>