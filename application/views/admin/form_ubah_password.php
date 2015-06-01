<!-- AM-SIPEDANG-15 -->
<div class="col-lg-12">
	<div class="row">
		<div class="col-lg-12">
			<h2 class="page-header">Ubah Password</h2>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-6">
<?php 
	if (!empty($submitErrors)) {
		echo "<div class=\"alert alert-danger\" role=\"alert\">\n";
		foreach ($submitErrors as $errorItem) {
			echo "<div>".$errorItem."</div>\n";
		}
		echo "</div>\n";
	}
	if (!empty($submitInfos)) {
		echo "<div class=\"alert alert-success\" role=\"alert\">\n";
		foreach ($submitInfos as $infoItem) {
			echo "<div>".$infoItem."</div>\n";
		}
		echo "</div>\n";
	}
	if (!isset($hideForm)) { //================== ?>
			<form role="form"
				action="<?php echo site_url("/ControlAutentikasi/ubah_password"); ?>"
				method="post">
				<div class="form-group">
					<label for="sipedang_sandi_lama">Password Lama</label> <input
						type="password" class="form-control" placeholder="Password Lama"
						id="sipedang_sandi_lama" name="sipedang_sandi_lama" required/>
				</div>
				<div class="form-group">
					<label for="sipedang_sandi_baru1">Password Baru</label> <input
						type="password" class="form-control" placeholder="Password Baru"
						id="sipedang_sandi_baru1" name="sipedang_sandi_baru1" required/>
				</div>
				<div class="form-group">
					<label for="sipedang_sandi_baru2">Konfirmasi Password</label> <input
						type="password" class="form-control" placeholder="Ketik Lagi"
						id="sipedang_sandi_baru2" name="sipedang_sandi_baru2" required/>
				</div>
				<button type="submit" class="btn btn-primary">
					<span class="fa fa-check"></span> Submit
				</button>
				<input type="hidden" name="sipedang_submit"
					value="<?php echo "submit-".date("Ymd-His"); ?>" />
			</form>
<?php } //=============== END IF ====================== ?>
			<!-- /.col-lg-6 (nested) -->
		</div>
		<!-- /.row (nested) -->
	</div>
	<!-- /.panel-body -->
</div>
<!-- /#page-wrapper -->
