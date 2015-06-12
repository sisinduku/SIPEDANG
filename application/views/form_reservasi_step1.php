<!-- TIDAK ADA DLM DOKUMEN -->
<div class="col-lg-12">
<div class="row">
	<div class="col-sm-4">
		<h1 class="steplagi"><b>Langkah 1</b></h1>
	</div>
	<div class="col-sm-4">
		<h1 class="stepbelum">Langkah 2</h1>
	</div>
	<div class="col-sm-4">
		<h1 class="stepbelum">Langkah 3</h1>
	</div>
</div>

<?php 
	if (!empty($submitErrors)) {
		echo "<div class=\"alert alert-danger\" role=\"alert\">\n";
		foreach ($submitErrors as $errorItem) {
			echo "<div>".$errorItem."</div>\n";
		}
		echo "</div>\n";
	}
?>

	<form action="<?php echo site_url("/ControlReservasi/form_reservasi"); ?>" method="post">
		<div class="row panel panel-default" style="margin: 0px 10px 0px 10px;">
			<div class="panel-heading">
				<h3 class="panel-title">Formulir Reservasi</h3>
			</div>
			<div class="panel-body">
				<div class="col-md-6 form-horizontal">
					<div class="form-group">
						<label class="col-sm-3 control-label" for="sipedang_namakegiatan">Kegiatan</label>
						<div class="col-sm-9">
							<input type="text" required name="sipedang_namakegiatan" class="form-control"
								id="sipedang_namakegiatan" placeholder="Masukan Nama Kegiatan"
								value="<?php if (isset($sipedang_namakegiatan)) echo htmlspecialchars($sipedang_namakegiatan)?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label" for="sipedang_pemesan">Pemesan</label>
						<div class="col-sm-9">
							<input type="text" required name="sipedang_pemesan" class="form-control"
							id="sipedang_pemesan" placeholder="Masukan Nama Pemesan"
							value="<?php if (isset($sipedang_pemesan)) echo htmlspecialchars($sipedang_pemesan)?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label" for="sipedang_penyelenggara">Penyelenggara</label>
						<div class="col-sm-9">
							<input type="text" required name="sipedang_penyelenggara" class="form-control"
							id="sipedang_penyelenggara" placeholder="Masukan Penyelenggara"
							value="<?php if (isset($sipedang_penyelenggara)) echo htmlspecialchars($sipedang_penyelenggara)?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label" for="sipedang_kategori">Kategori</label>
						<div class="col-sm-9">
							<select name="sipedang_kategori" required class="form-control" id="sipedang_kategori" onchange="pilih_tambah_kategori()">
								<option value="">- Pilih Kategori Event -</option>
								<?php 
								$selectedKategori = (isset($sipedang_kategori)?$sipedang_kategori:0);
								foreach ($listKategori as $idx => $itemKategori) {
									echo "<option value=\"".$idx."\" ";
									if ($idx == $selectedKategori) echo "selected";
									echo ">".$itemKategori."</option>\n";
								}
								?>
							</select>
						</div>
					</div>
				</div> <!-- End col-6 -->
				
				<div class="col-md-6 form-horizontal" >
					<div class="form-group">
						<label class="col-sm-3 control-label" for="sipedang_waktupelaksanaan_step1">Pelaksanaan</label>
						<div class="col-sm-9" id="sipedang_ctr_waktupelaksanaan">
							<input type="text" required name="sipedang_waktupelaksanaan" class="form-control"
								id="sipedang_waktupelaksanaan_step1" placeholder="Waktu Pelaksanaan"
								value="<?php if (isset($sipedang_daterange)) echo htmlspecialchars($sipedang_daterange);?>"/>
							<input type="hidden" name="sipedang_tglmulai" id="sipedang_tglmulai_step1"
								value="<?php if (isset($sipedang_tglmulai)) echo htmlspecialchars($sipedang_tglmulai); ?>" />
							<input type="hidden" name="sipedang_tglselesai" id="sipedang_tglselesai_step1"
								value="<?php if (isset($sipedang_tglselesai)) echo htmlspecialchars($sipedang_tglselesai); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label" for="sipedang_email">E-Mail</label>
						<div class="col-sm-9">
							<input type="email" required name="sipedang_email" class="form-control"
								id="sipedang_email" placeholder="Masukan E-Mail"
								value="<?php if (isset($sipedang_email)) echo htmlspecialchars($sipedang_email); ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label" for="sipedang_kontak">Kontak</label>
						<div class="col-sm-9">
							<input type="text" required name="sipedang_kontak" class="form-control"
							id="sipedang_kontak" placeholder="Masukan Nomor Kontak"
							value="<?php if (isset($sipedang_kontak)) echo htmlspecialchars($sipedang_kontak); ?>"/>
						</div>
					</div>
					<div class="form-group">
						<div class=" col-sm-12">
						  <input type="hidden" name="sipedang_submit" value="<?php echo "submit-".date("Ymd-His"); ?>" />
						  <button type="submit" name="sipedang_btnsubmit" class="btn btn-primary btn-md btn-block">
							Daftar <span class="glyphicon glyphicon-chevron-right"></span> </button>
						</div>
					</div>
				</div>
			</div>
		</div> <!-- End row form -->
	</form>
</div>
<script>
function initPage() {
	$('#sipedang_waktupelaksanaan_step1').daterangepicker({
		startDate: '<?php if (isset($sipedang_tglmulai)) echo $sipedang_tglmulai; ?>',
		endDate: '<?php if (isset($sipedang_tglselesai)) echo $sipedang_tglselesai; ?>',
		format: 'YYYY-MM-DD HH:mm',
		timePicker: true,
		timePicker12Hour: false,
		dateLimit: { days: 2 },
		opens: 'left',
		drops: 'down',
		timePickerIncrement: 10,
	    minDate: '<?php echo date("Y/m/d"); ?>',
	},function(start, end, label) {
        $('#sipedang_tglmulai_step1').val(start.format('YYYY-MM-DD HH:mm'));
        $('#sipedang_tglselesai_step1').val(end.format('YYYY-MM-DD HH:mm'));
    });
}
</script>