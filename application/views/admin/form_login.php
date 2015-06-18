    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h1 class="panel-title" >PENGELOLA RUANG SIDANG</h1>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
<?php 
	if (!empty($submitErrors)) {
		echo "<div class=\"alert alert-danger\" role=\"alert\">\n";
		foreach ($submitErrors as $errorItem) {
			echo "<div>".$errorItem."</div>\n";
		}
		echo "</div>\n";
	}
?>
                            <fieldset>
                                <div class="form-group">
									<label for="sipedang_username">Username</label>
                                    <input class="form-control" required placeholder="Username"
                                    	id="sipedang_username" name="sipedang_username" type="text" autofocus>
                                </div>
                                <div class="form-group">
									<label for="sipedang_sandi">Password</label>
                                    <input class="form-control" required placeholder="Password"
                                    	id="sipedang_sandi" name="sipedang_sandi" type="password">
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
								<div>
									<a href="<?php echo site_url("/autentikasi/reset_password"); ?>">Lupa Password?</a>
								</div>
								<div>
                                	<a href="<?php echo site_url("/"); ?>" class="btn btn-default">
                                		<span class="glyphicon glyphicon-chevron-left"></span> Home</a>
									<button type="submit" class="btn btn-primary">
										<span class="glyphicon glyphicon-lock"></span> Log me in</button>
								</div>
                            </fieldset>
                            <input type="hidden" name="sipedang_submit" value="<?php echo "submit-".date("Ymd-His"); ?>" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>