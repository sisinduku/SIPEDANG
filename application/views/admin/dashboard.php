<!-- AM-SIPEDANG-08 -->
<div class="col-md-12">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
				<span class="fa fa-dashboard"></span> Dasbor
			</h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-3 col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-3">
							<i class="fa fa-comments fa-5x"></i>
						</div>
						<div class="col-xs-9 text-right">
							<div class="huge"><?php echo $jumlahUpComing; ?></div>
							<div>Upcoming Events</div>
						</div>
					</div>
				</div>
				<a href="<?php echo site_url("/pengelola/ControlReservasi/list_reservasi/approved"); ?>">
					<div class="panel-footer">
						<span class="pull-left">Lihat Detil</span> <span
							class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
		</div>
		<div class="col-lg-3 col-md-6">
			<div class="panel panel-yellow">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-3">
							<span class="glyphicon glyphicon-warning-sign"
								style="font-size: 5em;"></span>
						</div>
						<div class="col-xs-9 text-right">
							<div class="huge"><?php echo $jumlahPending; ?></div>
							<div>Request Pending</div>
						</div>
					</div>
				</div>
				<a href="<?php echo site_url("/pengelola/ControlReservasi/list_reservasi/pending"); ?>">
					<div class="panel-footer">
						<span class="pull-left">Lihat Detil</span> <span
							class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
		</div>
		<div class="col-lg-3 col-md-6">
			<div class="panel panel-green">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-3">
							<i class="fa fa-folder fa-5x"></i>
						</div>
						<div class="col-xs-9 text-right">
							<div class="huge"><?php echo $jumlahKegiatan; ?></div>
							<div>Jumlah Kegiatan</div>
						</div>
					</div>
				</div>
				<a href="#">
					<div class="panel-footer">
						<span class="pull-left">Lihat Arsip</span> <span
							class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
		</div>
		<!-- <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-support fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">13</div>
                                    <div>Support Tickets!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div> -->

	</div>
	<!-- /.row -->

	<div class="row">
		<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Kegiatan Akan Datang</h3>
				</div>
				<div class="panel-body">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>Nama Kegiatan</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
<?php

$nowTimeStamp = strtotime ( "now" );
foreach ( $listReservasi as $itemReservasi ) {
	$selisihHari = floor ( (strtotime ( $itemReservasi->waktuMulaiPinjam ) - $nowTimeStamp) / 60 / 60 / 24 );
	$actionList = "<a href=\"" . site_url ( "/pengelola/ControlReservasi/detil_reservasi/" . $itemReservasi->idReservasi ) . "\"><span class=\"fa fa-search\"></span> Detil</a>\n";
	if ($itemReservasi->statusReservasi == 0) {
		$actionList .= "<a href=\"#\" class=\"btn btn-success btn-xs\"><span class=\"fa fa-check\"></span> Approve</a>\n";
	}
	echo "	<tr>\n";
	echo " 		<td>" . htmlspecialchars ( $itemReservasi->kegiatan ) . "<br>";
	echo "<div class=\"spd-meta\"><span class=\"fa fa-tag\"></span> <b>" . $listKategori [$itemReservasi->kategoriKegiatan] . "</b></div>\n";
	echo "<div class=\"spd-meta\">" . $itemReservasi->waktuMulaiPinjam . " - " . $itemReservasi->waktuSelesaiPinjam;
	echo " (" . $selisihHari . " hari lagi.)</div></td>\n";
	echo "		<td>" . $actionList . "</td>\n";
	echo "	</tr>\n";
}

?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Kalender Kegiatan</h3>
				</div>
				<div class="panel-body">
					<div id="sipedang_kalendarreservasi_admin"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<link href='<?php echo base_url("/assets/css/fullcalendar.min.css"); ?>' rel='stylesheet' />
<link href='<?php echo base_url("/assets/css/fullcalendar.print.css"); ?>' rel='stylesheet' media='print' />
<script src='<?php echo base_url("/assets/js/moment.min.js"); ?>'></script>
<script src='<?php echo base_url("/assets/js/fullcalendar.min.js"); ?>'></script>
<script>

	$(document).ready(function() {
	
		$('#sipedang_kalendarreservasi_admin').fullCalendar({
			header: {
				left: 'prev next today',
				center: 'title',
				right: 'month'
			},
			eventLimit: true, // allow "more" link when too many events
			events: {
				url: '<?php echo site_url("/pengelola/ControlReservasi/ajax_get_listreservasi_admin"); ?>',
				error: function() {
					//$('#script-warning').show();
					alert("Terjadi kesalahan.");
				}
			},
			loading: function(bool) {
				$('#sipedang_loadingbox').toggle(bool);
			},
			eventBackgroundColor: "#CEE4ED",
			eventTextColor: "#003751",
			eventBorderColor: "#CEE4ED",
			timeFormat: 'H:mm'
		});
		
	});

</script>