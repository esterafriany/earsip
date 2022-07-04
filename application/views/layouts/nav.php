<!-- NAVBAR -->
<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
	<div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
		<a class="navbar-brand brand-logo text-dark" href="<?= site_url('/admin'); ?>">
			e-Arsip</a>
		<a class="navbar-brand brand-logo-mini text-dark" href="<?= site_url('/admin'); ?>">
			e</a>
	</div>
	<div class="navbar-menu-wrapper d-flex align-items-center">
		<button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
			<span class="mdi mdi-menu"></span>
		</button>
		<ul class="navbar-nav navbar-nav-right">
			<?php if ($this->session->userdata('level') == 0) { ?>
				<li class="nav-item dropdown">
					<a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
						<i class="mdi mdi-bell-outline mdi-24px"></i>
						<?php if ($get_disposisi_internal > 0 || $get_disposisi_eksternal > 0) { ?>
							<span class="count"><?= $get_disposisi_internal + $get_disposisi_eksternal; ?></span>
						<?php } ?>
					</a>
					<div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="messageDropdown">
						<a class="dropdown-item py-3" href="#">
							<p class="mb-0 font-weight-medium float-left">Notifikasi Disposisi</p>
							<span class="badge badge-pill badge-primary float-right">View all</span>
						</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item py-3" href="<?= site_url('/user/inbox-internal'); ?>">
							<p class="mb-0 float-left">Disposisi Internal</p><span id="count1" class="font-weight-bold  text-danger ml-auto"></span>
						</a>
						<a class="dropdown-item py-3" href="<?= site_url('/user/inbox-eksternal'); ?>">
							<p class="mb-0 float-left">Disposisi Eksternal</p><span id="count2" class="font-weight-bold text-danger ml-auto"></span>
						</a>
					</div>
				</li>
			<?php } ?>
			<li class="nav-item dropdown d-none d-xl-inline-block">
				<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-user"></i> <?= $_SESSION['name'] ?></a>
				<div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
					<a class="dropdown-item p-0">
						<div class="d-flex border-bottom">
							<div class="py-3 px-4 d-flex align-items-center justify-content-center">
								<i class="mdi mdi-bookmark-plus-outline mr-0 text-gray"></i>
							</div>
							<div class="py-3 px-4 d-flex align-items-center justify-content-center border-left border-right">
								<i class="mdi mdi-account-outline mr-0 text-gray"></i>
							</div>
							<div class="py-3 px-4 d-flex align-items-center justify-content-center">
								<i class="mdi mdi-alarm-check mr-0 text-gray"></i>
							</div>
						</div>
					</a>
					<a class="dropdown-item mt-3" href="<?= base_url('login/signout'); ?>"><i class="lnr lnr-exit"></i> Keluar</a>
				</div>
			</li>
		</ul>
		<button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
			<span class="mdi mdi-menu"></span>
		</button>
	</div>
</nav>

<!-- page-body-wrapper -->
<div class="container-fluid page-body-wrapper">

	<!-- LEFT SIDEBAR -->
	<div id="sidebar-nav" class="sidebar">
		<div class="sidebar-scroll">
			<nav class="sidebar sidebar-offcanvas dynamic-active-class-disabled" id="sidebar">
				<ul class="nav">
					<?php if ($this->session->userdata('level') == 1) { ?>
						<?php if($this->session->userdata('id_user') == 1) { ?>
							<li class="nav-item"><a href="<?= site_url('user'); ?>" class="nav-link"><i class="menu-icon lnr lnr-home text-dark font-weight-bold"></i> <span class="menu-title">Dashboard</span></a></li>
							<li class="nav-item"><a href="<?= site_url('admin/arsip-dokumen'); ?>" class="nav-link"><i class="menu-icon lnr lnr-inbox text-dark font-weight-bold"></i> <span class="menu-title">Arsip & Dokumen</span></a></li>
							<li class="nav-item"><a href="<?= base_url('login/signout'); ?>"  class="nav-link"><i class="menu-icon lnr lnr-exit text-dark font-weight-bold"></i> <span class="menu-title">Keluar</span></a></li>
						<?php }else{ ?>
							<li class="nav-item">
								<a class="nav-link" href="<?= site_url('admin'); ?>">
									<i class="menu-icon lnr lnr-home text-dark font-weight-bold"></i>
									<span class="menu-title">Dashboard</span>
								</a>
							</li>
							<!--<li class="nav-item"><a href="<?= site_url('admin/surat-eksternal/masuk'); ?>" class="nav-link"><i class="menu-icon lnr lnr-envelope text-dark font-weight-bold"></i> <span class="menu-title">Surat Masuk</span></a></li>
							<li class="nav-item"><a href="<?= site_url('admin/surat-internal/keluar'); ?>" class="nav-link"><i class="menu-icon lnr lnr-envelope text-dark font-weight-bold"></i> <span class="menu-title">Surat Keluar</span></a></li>
							<li class="nav-item">
									<a href="#subPages" class="nav-link" data-toggle="collapse" aria-expanded="false" aria-controls="resources-dropdown"><i class="menu-icon lnr lnr-arrow-right text-dark font-weight-bold"></i>
									<span class="menu-title">Surat Internal</span>
									<i class="menu-arrow"></i>
									</a>
									<div id="subPages" class="collapse">
										<ul class="nav flex-column sub-menu">
											<li class="nav-item"><a href="<?= site_url('admin/surat-internal/masuk'); ?>" class="nav-link">Surat Masuk</a></li>
											<li class="nav-item"><a href="<?= site_url('admin/surat-internal/keluar'); ?>" class="nav-link">Surat Keluar</a></li>
										</ul>
									</div>
								
								</li>
								<li class="nav-item">
									<a href="#subPages2" data-toggle="collapse" class="nav-link" aria-expanded="false" aria-controls="resources-dropdown"><i class="menu-icon lnr lnr-arrow-left text-dark font-weight-bold"></i> 
									<span class="menu-title">Surat Eksternal</span> 
									<i class="menu-arrow"></i></a>
									<div id="subPages2" class="collapse">
										<ul class="nav flex-column sub-menu">
											<li class="nav-item"><a href="<?= site_url('admin/surat-eksternal/masuk'); ?>" class="nav-link">Surat Masuk</a></li>
											<li class="nav-item"><a href="<?= site_url('admin/surat-eksternal/keluar'); ?>" class="nav-link">Surat Keluar</a></li>
										</ul>
									</div>
								</li>-->

							<li class="nav-item"><a href="<?= site_url('admin/arsip-dokumen'); ?>" class="nav-link"><i class="menu-icon lnr lnr-inbox text-dark font-weight-bold"></i> <span class="menu-title">Arsip & Dokumen</span></a></li>
							<!-- <li class="nav-item"><a href="<?= site_url('admin/arsip-formulir'); ?>" class="nav-link"><i class="menu-icon lnr lnr-inbox text-dark font-weight-bold"></i> <span class="menu-title">Formulir & Blanko</span></a></li> -->
							<li class="nav-item">
								<a href="#subPages3" data-toggle="collapse" class="nav-link"><i class="menu-icon lnr lnr-cog text-dark font-weight-bold"></i> <span class="menu-title">Pengaturan</span> <i class="menu-arrow"></i></a>
								<div id="subPages3" class="collapse">
									<ul class="nav flex-column sub-menu">
										<li class="nav-item"><a href="<?= site_url('admin/pengaturan'); ?>" class="nav-link">Pengaturan Situs</a></li>
										<li class="nav-item"><a href="<?= site_url('admin/akun'); ?>" class="nav-link">Pengaturan Akun</a></li>
										<!-- <li class="nav-item"><a href="<?= site_url('admin/prioritas-surat'); ?>" class="nav-link">Prioritas Surat</a></li>
										<li class="nav-item"><a href="<?= site_url('admin/media-surat'); ?>" class="nav-link">Media Surat</a></li>
										<li class="nav-item"><a href="<?= site_url('admin/perintah-disposisi'); ?>" class="nav-link">Perintah Disposisi</a></li> -->
									</ul>
								</div>
							</li>
							
							<li class="nav-item">
								<a href="#subPages4" data-toggle="collapse" class="nav-link"><i class="menu-icon lnr lnr-user text-dark font-weight-bold"></i> <span class="menu-title">Master Data</span> <i class="menu-arrow"></i></a>
								<div id="subPages4" class="collapse">
									<ul class="nav flex-column sub-menu">
										<li class="nav-item"><a href="<?= site_url('admin/sifat-surat'); ?>" class="nav-link">Sifat Dokumen</a></li>
										<li class="nav-item"><a href="<?= site_url('admin/jenis-surat'); ?>" class="nav-link">Jenis Dokumen</a></li>
										<li class="nav-item"><a href="<?= site_url('admin/unit-kerja'); ?>" class="nav-link">Unit Kerja</a></li>
										<li class="nav-item"><a href="<?= site_url('admin/jabatan'); ?>" class="nav-link">Jabatan</a></li>
										<li class="nav-item"><a href="<?= site_url('admin/pegawai'); ?>" class="nav-link">Pegawai</a></li>
									</ul>
								</div>
							</li>

							<li class="nav-item"><a href="<?= site_url('admin/backup'); ?>" class="nav-link"><i class="menu-icon lnr lnr-database text-dark font-weight-bold"></i> <span class="menu-title">Backup DB</span></a></li>
							<li class="nav-item"><a href="<?= base_url('login/signout'); ?>"  class="nav-link"><i class="menu-icon lnr lnr-exit text-dark font-weight-bold"></i> <span class="menu-title">Keluar</span></a></li>
						<?php } ?>
					<?php } else if ($this->session->userdata('level') == 0) { ?>
						
						<li class="nav-item"><a href="<?= site_url('user'); ?>" class="nav-link"><i class="menu-icon lnr lnr-home text-dark font-weight-bold"></i> <span class="menu-title">Dashboard</span></a></li>
						<!-- <li class="nav-item">
							<a href="#subPages" data-toggle="collapse" class="nav-link"><i class="menu-icon lnr lnr-inbox text-dark font-weight-bold"></i> <span class="menu-title">Inbox Disposisi</span> <i class="menu-arrow"></i></a>
							<div id="subPages" class="collapse ">
								<ul class="nav flex-column sub-menu">
									<li class="nav-item"><a href="<?= site_url('user/inbox-internal'); ?>" class="nav-link">Disposisi Internal</a></li>
									<li class="nav-item"><a href="<?= site_url('user/inbox-eksternal'); ?>" class="nav-link">Disposisi Eksternal</a></li>
								</ul>
							</div>
						</li> -->
						<li class="nav-item"><a href="<?= site_url('user/arsip-dokumen'); ?>" class="nav-link"><i class="menu-icon lnr lnr-inbox text-dark font-weight-bold"></i> <span class="menu-title">Arsip & Dokumen</span></a></li>

						<!-- <li class="nav-item"><a href="<?= site_url('user/surat-eksternal/masuk'); ?>" class="nav-link"><i class="menu-icon lnr lnr-arrow-right text-dark font-weight-bold"></i> <span class="menu-title">Surat Masuk</span></a></li>
						<li class="nav-item"><a href="<?= site_url('user/surat-internal/keluar'); ?>" class="nav-link"><i class="menu-icon lnr lnr-arrow-left text-dark font-weight-bold"></i> <span class="menu-title">Surat Keluar</span></a></li> -->

						<li class="nav-item"><a href="<?= base_url('login/signout'); ?>" class="nav-link" ><i class="menu-icon lnr lnr-exit text-dark font-weight-bold"></i> <span class="menu-title">Keluar</span></a></li>
						<!--<li class="nav-item">
							<a href="#subPages" data-toggle="collapse" class="nav-link"><i class="menu-icon lnr lnr-arrow-right text-dark font-weight-bold"></i> <span class="menu-title">Surat Internal</span> <i class="menu-arrow"></i></a>
							<div id="subPages" class="collapse ">
								<ul class="nav flex-column sub-menu">
									<li class="nav-item"><a href="<?php //echo site_url('user/surat-internal/masuk');
																	?>" class="nav-link">Surat Masuk</a></li>
									<li class="nav-item"><a href="<?php //echo site_url('user/surat-internal/keluar');
																	?>" class="nav-link">Surat Keluar</a></li>
								</ul>
							</div>
						</li>
                       <li class="nav-item">
							<a href="#subPages2" data-toggle="collapse" class="nav-link"><i class="menu-icon lnr lnr-arrow-left text-dark font-weight-bold"></i> <span class="menu-title">Surat Eksternal</span> <i class="menu-arrow"></i></a>
							<div id="subPages2" class="collapse ">
								<ul class="nav flex-column sub-menu">
									<li class="nav-item"><a href="<?php //echo site_url('user/surat-eksternal/masuk');
																	?>" class="nav-link">Surat Masuk</a></li>
									<li class="nav-item"><a href="<?php //echo site_url('user/surat-eksternal/keluar');
																	?>" class="nav-link">Surat Keluar</a></li>
								</ul>
							</div>
						</li>-->
				
					<?php } ?>

				</ul>
			</nav>
		</div>
	</div>
	<!-- END LEFT SIDEBAR -->

	<div class="main-panel">
	<div class="content-wrapper">