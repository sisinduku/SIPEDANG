<!-- AM-SIPEDANG-09 dan AM-SIPEDANG-10 -->

              <div class="col-lg-12">
				<h2>List Reservasi</h2>
                    <div class="panel panel-default">
						<?php
							if ($tampil_tombol_cetak==1)
							{
								echo '<a class="btn btn-primary" href="'.site_url("/pengelola/reservasi/list_reservasi/".$listTag."?type=pdf").'"><i class="glyphicon glyphicon-print"></i> Cetak Arsip</a>';
							}
						?>
						
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="sipedang_tabelreservasi">
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
	$nowTimeStamp = strtotime("now");
	foreach ($listReservasi as $itemReservasi) {
		$selisihHari = ceil((strtotime($itemReservasi->waktuMulaiPinjam) - $nowTimeStamp)/60/60/24);
		$actionList = "<a href=\"".site_url("/pengelola/reservasi/detil_reservasi/".
				$itemReservasi->idReservasi)."\"><span class=\"fa fa-search\"></span> Detil</a>\n";
		if ($itemReservasi->statusReservasi == 0) {
			$actionList .= "<a href=\"#\" class=\"btn btn-success btn-xs\" onclick=\"return approve_reservasi(".
				$itemReservasi->idReservasi.");\">".
				"<span class=\"fa fa-check\"></span> Approve</a>\n";
		}
		echo "	<tr>\n";
		echo " 		<td>".htmlspecialchars($itemReservasi->kegiatan)."<br>";
		echo "<div class=\"spd-meta\"><span class=\"fa fa-tag\"></span> <b>".$listKategori[$itemReservasi->kategoriKegiatan]."</b></div></td>\n";
		echo "		<td>".format_range_tanggal_mysql($itemReservasi->waktuMulaiPinjam,$itemReservasi->waktuSelesaiPinjam);
		echo "<div class=\"spd-meta\">".$selisihHari." hari lagi.</div></td>\n";
		echo "		<td>".htmlspecialchars($itemReservasi->penyelenggara)."</td>\n";
		echo "		<td>".MY_Loader::$htmlStatus[$itemReservasi->statusReservasi]." ";
		if ($itemReservasi->statusReservasi == 0)
			if ($itemReservasi->expireTime < strtotime("now")) echo
				"<br><span class=\"label label-danger\">Expired</span>";
		echo "</td>\n";
		echo "		<td>".$actionList."</td>\n";
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
    <script src="<?php echo base_url('/assets/bower_components/datatables/media/js/jquery.dataTables.min.js')?>"></script>
    <script src="<?php echo base_url('/assets/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js')?>"></script>

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

