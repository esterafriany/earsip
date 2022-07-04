<div class="container-fluid page-body-wrapper full-page-wrapper">
	<div class="content-wrapper d-flex align-items-center auth register-bg-1 theme-one">
		<div class="row w-100">
			<div class="pl-5 col-md-4 mx-auto">
				<div class="auto-form-wrapper">
					<div class="text-center">
						<h4><?= $setting->site_title ?> <i><b>Development & Testing</b></i></h4>
					</div>
					<br />
					<?= $this->session->flashdata('notify'); ?>
					<?= form_open('login/signin', array('class' => 'form-auth-small')); ?>
					<div class="form-group">
						<label for="signin-email" class="control-label sr-only">Email</label>
						<div class="input-group">
							<input type="email" class="form-control" id="signin-email" name="email" placeholder="Email">
							<div class="input-group-append">
								<span class="input-group-text">
									<i class="mdi mdi-account"></i>
								</span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="signin-password" class="control-label sr-only">Password</label>
						<div class="input-group">
							<input type="password" class="form-control" id="signin-password" name="password" placeholder="Password">
							<div class="input-group-append">
								<span class="input-group-text">
									<i class="mdi mdi-lock"></i>
								</span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<input type="submit" name="submit" class="btn btn-primary btn-lg btn-block" value="Masuk">
					</div>
					<div class="form-group d-flex justify-content-between">
						<div class="form-check form-check-flat mt-0">
							<label class="form-check-label">
								<input type="checkbox" class="form-check-input" checked> Biarkan saya tetap masuk </label>
						</div>
						<!--<a href="#" class="text-small forgot-password text-black">Forgot Password</a>-->
					</div>
					<?= form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
</div>