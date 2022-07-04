<div class="row">
	<div class="col-12 grid-margin">
		<!-- OVERVIEW -->
		<div class="card">
			<div class="card-header py-3">
				<h4>Dashboard</h4>
				<p class="card-subtitle">Selamat Datang, <?= $name; ?> !</p>
			</div>
			<div class="card-body">
				<div class="row">
					<!--<div class="col-md-3">
									<div class="card card-statistics">
									<div class="card-body">
                                        <div class="clearfix">
                                            <div class="float-left">
											<i class="lnr lnr-envelope icon-lg"></i>
											</div>
                                        	<div class="float-right">
											<h3 class="font-weight-medium text-right mb-0"><?php //echo $set_internal_masuk;
																							?></h3>
											<p class="mb-0 text-right">Surat Internal Masuk</p>
											</div>
										</div>
									</div>
									</div>
								</div>-->
					<div class="col-md-6 grid-margin stretch-card">
						<div class="card card-statistics">
							<div class="card-body">
								<div class="clearfix">
									<div class="float-left">
										<i class="lnr lnr-envelope text-danger icon-lg"></i>
									</div>
									<div class="float-right">
										<h3 class="font-weight-medium text-right mb-0"><?= $set_internal_keluar; ?></h3>
										<p class="mb-0 text-right">Surat Internal Keluar</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6 grid-margin stretch-card">
						<div class="card card-statistics">
							<div class="card-body">
								<div class="clearfix">
									<div class="float-left">
										<i class="lnr lnr-envelope text-danger icon-lg"></i>
									</div>
									<div class="float-right">
										<h3 class="font-weight-medium text-right mb-0"><?= $set_eksternal_masuk; ?></h3>
										<p class="mb-0 text-right">Surat Eksternal Masuk</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--<div class="col-md-3 grid-margin stretch-card">
									<div class="card card-statistics">
										<div class="card-body">
											<div class="clearfix">
												<div class="float-left">
											<i class="lnr lnr-envelope text-danger icon-lg"></i>
											</div>
                                        	<div class="float-right">
											<h3 class="font-weight-medium text-right mb-0"><?php //echo $set_eksternal_keluar;
																							?></h3>
											<p class="mb-0 text-right">Surat Eksternal Keluar</p>
											</div>
										</div>
									</div>
								</div>-->
				</div>
			</div>
		</div>
	</div>
</div>