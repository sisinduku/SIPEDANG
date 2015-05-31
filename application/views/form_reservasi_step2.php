<!-- AM-SIPEDANG-02 -->
<div class="col-lg-4">
	<h1 style="color:green; text-align:center;">STEP 1</h1>
</div>
<div class="col-lg-4">
	<h1 style="color:green; text-align:center;">STEP 2</h1>
</div>
<div class="col-lg-4">
	<h1 style="text-align:center;">STEP 3</h1>
</div><br/><br/><br/><br/><br/><br/><br/>

<div class='box-body pad'>
    <form>
		<div class="form-group">
			<label for="sipedang_deskripsi_kegiatan" class="col-sm-4 control-label" style="text-align:left;">Deskripsi Kegiatan :</label><br/><br/>
			<div class="col-lg-12">
				<textarea class="form-control" id="sipedang_deskripsi_kegiatan" name="editor1" rows="10" cols="80">
					Masukkan Deskripsi Kegiatan
				</textarea>
				<br/><br/>
			</div>
		</div>
		<div class="form-group">
			<label for="sipedang_upload_file" class="col-sm-2 control-label" style="text-align:left;">Upload File Gambar :</label>
			<input type="file" id="sipedang_upload_file">
		</div>
		<div class="form-group" style="padding-left:15px;">
			<div class="g-recaptcha" data-sitekey="6Lc4ogcTAAAAALBjLSKzoebEEm6KITtSJx1TGtrf"></div><br/>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-sm-3"></div>
					<div class=" col-sm-6">
						<button type="button" class="btn btn-primary btn-md btn-block">Lanjut</button>
					</div><br/><br/><br/><br/>
				<div class="col-sm-3"></div>
			</div>
		</div>
    </form>
</div>

<!-- CK Editor -->
<script src="//cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>

<script>
	$(function() {
		CKEDITOR.replace('sipedang_deskripsi_kegiatan');
	});
</script>
