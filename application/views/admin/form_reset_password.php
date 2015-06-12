<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">
					<h1 class="panel-title">RESET PASSWORD</h1>
				</div>
				<div class="panel-body"><?php
	if (!empty($submitErrors)) {
		echo "<div class=\"alert alert-danger\">\n";
		foreach ($submitErrors as $itemError) {
			echo "<div>".$itemError."</div>\n";
		}
		echo "</div>\n";
	}
	if (!empty($submitInfos)) {
		echo "<div class=\"alert alert-success\">\n";
		foreach ($submitInfos as $itemInfo) {
			echo "<div>".$itemInfo."</div>\n";
		}
		echo "</div>\n";
	}
	if (empty($hideForm)) { //===================== ?>
					<form role="form" action="<?php echo site_url($formAction); ?>" method="post">
						<fieldset>
							<div class="form-group">
								<h4>Password Baru</h4>
								<input class="form-control" placeholder="Password Baru"
									name="sipedang_sandi_baru1" type="password" autofocus required />
							</div>
							<div class="form-group">
								<h4>Konfirmasi Password Baru</h4>
								<input class="form-control" placeholder="Konfirmasi Password"
									name="sipedang_sandi_baru2" type="password" required />
							</div>
							<!-- Change this to a button or input when using this as a form -->

							<div>
								<button type="submit" class="btn btn-default">Submit</button>
							</div>
						</fieldset>
						<input type="hidden" name="sipedang_submit" value="resetpass" />
					</form>
<?php } else { //================ ELSE ========== ?>
					<div>
						<a href="<?php echo site_url("/pengelola"); ?>" class="btn btn-default">Kembali</a>
					</div>
<?php } // =============== END IF =============== ?>

				</div>
			</div>
		</div>
	</div>
</div>
