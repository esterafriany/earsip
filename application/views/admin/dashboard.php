<div class="row">
    <div class="col-12 grid-margin">
        <!-- OVERVIEW -->
        <div class="card">
            <div class="card-header py-3">
                <h3 class="">Dashboard</h3>
                <!--<p class="card-subtitle">Selamat Datang Administrator</p>-->
            </div>
            <div class="card-body">
                <div class="row">
                    <!--<div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                                    <div class="card card-statistics">
                                        <div class="card-body">
                                        <div class="clearfix">
                                            <div class="float-left">
										    <i class="lnr lnr-envelope text-danger icon-lg"></i>
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
                    <!-- <div class="col-md-6 grid-margin stretch-card">
                        <div class="card card-statistics">
                            <div class="card-body">
                                <div class="clearfix">
                                    <div class="float-left"><i class="lnr lnr-envelope text-danger icon-lg"></i></div>
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
                                    <div class="float-left"><i class="lnr lnr-envelope text-danger icon-lg"></i></div>
                                    <div class="float-right">
                                        <h3 class="font-weight-medium text-right mb-0"><?= $set_eksternal_masuk; ?></h3>
                                        <p class="mb-0 text-right">Surat Eksternal Masuk</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!--<div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                                <div class="card card-statistics">
                                    <div class="card-body">
                                    <div class="clearfix">
                                        <div class="float-left"><i class="lnr lnr-envelope text-danger icon-lg"></i></div>
										<div class="float-right">
                                        <h3 class="font-weight-medium text-right mb-0"><?php //echo $set_eksternal_keluar;
                                                                                        ?></h3>
                                        <p class="mb-0 text-right">Surat Eksternal Keluar</p>
                                            </div>
                                        </div>
                                        </div>
									</div>
								</div>-->
                </div>
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                        <div class="card card-statistics">
                            <div class="card-body">
                                <div class="clearfix">
                                    <div class="float-left"><i class="lnr lnr-user text-info icon-lg"></i></div>
                                    <div class="float-right">
                                        <h3 class="font-weight-medium text-right mb-0"><?= $set_akun; ?></h3>
                                        <p class="mb-0 text-right">Akun Pengguna</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                        <div class="card card-statistics">
                            <div class="card-body">
                                <div class="clearfix">
                                    <div class="float-left"><i class="lnr lnr-apartment text-primary icon-lg"></i></div>
                                    <div class="float-right">
                                        <h3 class="font-weight-medium text-right mb-0"><?= $set_unit; ?></h3>
                                        <p class="mb-0 text-right">Unit Kerja</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                        <div class="card card-statistics">
                            <div class="card-body">
                                <div class="clearfix">
                                    <div class="float-left"><i class="lnr lnr-star text-success icon-lg"></i></div>
                                    <div class="float-right">
                                        <h3 class="font-weight-medium text-right mb-0"><?= $set_jabatan; ?></h3>
                                        <p class="mb-0 text-right">Jabatan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                        <div class="card card-statistics">
                            <div class="card-body">
                                <div class="clearfix">
                                    <div class="float-left"><i class="lnr lnr-users text-warning icon-lg"></i></div>
                                    <div class="float-right">
                                        <h3 class="font-weight-medium text-right mb-0"><?= $set_pegawai; ?></h3>
                                        <p class="mb-0 text-right">Pegawai</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <br />

        <div class="card">
            <div class="card-body">
                <h3 class="mb-4">Laporan <span class="card-subtitle">Jumlah</span></h3>
                <div class="row">
                    <div class="col-md-6 pt-3">
                        <h4 class="mb-3">Dokumen Menurut Jenis</h4>
                        
                        <div class="tab-content tab-content-basic">
                            <div id="internal-jenis" class="tab-pane fade show active">
                                <div class="table-responsive">
                                    <table class="table" id="data1">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Jenis Dokumen</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1 ?>
                                            <?php foreach ($view_internal_jenis as $row_internal_jenis) { ?>
                                                <tr>
                                                    <td><?= $i++ ?></td>
                                                    <td>
                                                        <?php if ($row_internal_jenis->jenis_surat == NULL) { ?>
                                                            <small>Kosong</small>

                                                        <?php } else { ?>
                                                            <small><?= $row_internal_jenis->jenis_surat; ?></small>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($row_internal_jenis->jumlah == NULL) { ?>
                                                            <small>Kosong</small>

                                                        <?php } else { ?>
                                                            <small><?= $row_internal_jenis->jumlah; ?></small>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 pt-3">
                    <h4 class="mb-3">Dokumen Menurut Sifat </h4>
                        <div class="tab-content">
                            <div id="internal-sifat" class="tab-pane fade show active">
                                <div class="table-responsive">
                                    <table class="table" id="data5">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Sifat Dokumen</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1 ?>
                                            <?php foreach ($view_internal_sifat as $row_internal_sifat) { ?>
                                                <tr>
                                                    <td><?= $i++ ?></td>
                                                    <td>
                                                        <?php if ($row_internal_sifat->sifat_surat == NULL) { ?>
                                                            <small>Kosong</small>

                                                        <?php } else { ?>
                                                            <small><?= $row_internal_sifat->sifat_surat; ?></small>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($row_internal_sifat->jumlah == NULL) { ?>
                                                            <small>Kosong</small>

                                                        <?php } else { ?>
                                                            <small><?= $row_internal_sifat->jumlah; ?></small>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <!-- <h4 class="mb-3">Surat Menurut Prioritas Surat</h4>
                        <ul class="nav nav-tabs tab-basic" role="tablist">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#internal-prioritas">Internal</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#eksternal-prioritas">Eksternal</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="internal-prioritas" class="tab-pane fade show active">
                                <div class="table-responsive">
                                    <table class="table" id="data3">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Prioritas Surat</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1 ?>
                                            <?php foreach ($view_internal_prioritas as $row_internal_prioritas) { ?>
                                                <tr>
                                                    <td><?= $i++ ?></td>
                                                    <td>
                                                        <?php if ($row_internal_prioritas->prioritas_surat == NULL) { ?>
                                                            <small>Kosong</small>

                                                        <?php } else { ?>
                                                            <small><?= $row_internal_prioritas->prioritas_surat; ?></small>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($row_internal_prioritas->jumlah == NULL) { ?>
                                                            <small>Kosong</small>

                                                        <?php } else { ?>
                                                            <small><?= $row_internal_prioritas->jumlah; ?></small>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="eksternal-prioritas" class="tab-pane fade">
                                <div class="table-responsive">
                                    <table class="table" id="data4">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Prioritas Surat</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1 ?>
                                            <?php foreach ($view_eksternal_prioritas as $row_eksternal_prioritas) { ?>
                                                <tr>
                                                    <td><?= $i++ ?></td>
                                                    <td>
                                                        <?php if ($row_eksternal_prioritas->prioritas_surat == NULL) { ?>
                                                            <small>Kosong</small>

                                                        <?php } else { ?>
                                                            <small><?= $row_eksternal_prioritas->prioritas_surat; ?></small>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($row_eksternal_prioritas->jumlah == NULL) { ?>
                                                            <small>Kosong</small>

                                                        <?php } else { ?>
                                                            <small><?= $row_eksternal_prioritas->jumlah; ?></small>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> -->
                    </div>                    
                </div>

                <hr />

                <div class="row">
                    <div class="col-md-6 pt-3">
                    </div>

                    <!-- <div class="col-md-6 pt-3">
                        <h4 class="mb-3">Surat Menurut Media Pengiriman</h4>
                        <ul class="nav nav-tabs tab-basic" role="tablist">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#internal-media">Internal</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#eksternal-media">Eksternal</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="internal-media" class="tab-pane fade show active">
                                <div class="table-responsive">
                                    <table class="table" id="data7">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Media Pengiriman</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1 ?>
                                            <?php foreach ($view_internal_media as $row_internal_media) { ?>
                                                <tr>
                                                    <td><?= $i++ ?></td>
                                                    <td>
                                                        <?php if ($row_internal_media->media_surat == NULL) { ?>
                                                            <small>Kosong</small>

                                                        <?php } else { ?>
                                                            <small><?= $row_internal_media->media_surat; ?></small>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($row_internal_media->jumlah == NULL) { ?>
                                                            <small>Kosong</small>

                                                        <?php } else { ?>
                                                            <small><?= $row_internal_media->jumlah; ?></small>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="eksternal-media" class="tab-pane fade">
                                <div class="table-responsive">
                                    <table class="table" id="data8">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Media Pengiriman</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1 ?>
                                            <?php foreach ($view_eksternal_media as $row_eksternal_media) { ?>
                                                <tr>
                                                    <td><?= $i++ ?></td>
                                                    <td>
                                                        <?php if ($row_eksternal_media->media_surat == NULL) { ?>
                                                            <small>Kosong</small>

                                                        <?php } else { ?>
                                                            <small><?= $row_eksternal_media->media_surat; ?></small>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($row_eksternal_media->jumlah == NULL) { ?>
                                                            <small>Kosong</small>

                                                        <?php } else { ?>
                                                            <small><?= $row_eksternal_media->jumlah; ?></small>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>