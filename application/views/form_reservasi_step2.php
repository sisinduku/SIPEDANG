<!-- AM-SIPEDANG-02 -->
<div class="col-lg-12">
	<div class="row">
		<div class="col-sm-4">
			<a href="<?php echo site_url("/ControlReservasi/form_reservasi"); ?>">
				<h1 style="color:green; text-align:center;">STEP 1</h1>
			</a>
		</div>
		<div class="col-sm-4">
			<h1 style="color:green; text-align:center;">STEP 2</h1>
		</div>
		<div class="col-sm-4">
			<h1 style="text-align:center;">STEP 3</h1>
		</div>
	</div>
	<h2>Langkah Dua</h2>
<?php 
	if (!empty($submitErrors)) {
		echo "<div class=\"alert alert-danger\" role=\"alert\">\n";
		foreach ($submitErrors as $errorItem) {
			echo "<div>".$errorItem."</div>\n";
		}
		echo "</div>\n";
	}
?>
	<form action="<?php echo site_url("/ControlReservasi/form_reservasi_step_2"); ?>" method="post"
			enctype="multipart/form-data">
		<div class='row box-body pad'>
			<div class="col-lg-12">
				<label for="sipedang_deskripsi">Deskripsi Kegiatan :</label><br/>
				<textarea class="form-control" id="sipedang_deskripsi" name="sipedang_deskripsi"
					><?php 
					if (isset($sipedang_deskripsi))
						echo htmlspecialchars($sipedang_deskripsi);
					?></textarea>
				<br/><br/>
			</div>
		</div>
		<div class="form-group">
			<label for="sipedang_filegambar" class="col-sm-2 control-label" style="text-align:left;">Upload File Gambar :</label>
			<input type="file" id="sipedang_filegambar" name="sipedang_filegambar">
		</div>
		<div class="form-group" style="padding-left:15px;">
			<div class="g-recaptcha" data-sitekey="6Lc4ogcTAAAAALBjLSKzoebEEm6KITtSJx1TGtrf"></div>
		</div>
		
		<div class="row">
			<div class="col-sm-3"></div>
			<div class=" col-sm-6">
				<button type="submit" name="" class="btn btn-primary btn-md btn-block">Lanjut</button>
			</div>
			<div class="col-sm-3"></div>
		</div>
		<input type="hidden" name="sipedang_submit" value="<?php echo "submit-".date("Ymd-His"); ?>" />
	</form>
</div>
<!-- CK Editor -->
<script src="//cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>

<script>
	$(function() {
		CKEDITOR.replace('sipedang_deskripsi');
	});
</script>
