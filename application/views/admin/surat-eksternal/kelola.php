<div class="row">
    <div class="col-12 grid-margin">
        <?= $this->session->flashdata('notify'); ?>

        <?= validation_errors(); ?>

        <?php if ($jenis == 'Masuk') { ?>
            <a href="<?= base_url('/surat-eksternal/tambah/masuk'); ?>" class="act-btn">+</a>
        <?php } else { ?>
            <a href="<?= base_url('/surat-eksternal/tambah/keluar'); ?>" class="act-btn">+</a>
        <?php } ?>

        <div class="card">
            <div class="card-header py-3">
                <h4 class="">Kelola Surat <?= $jenis; ?> </h4>
                <p class="card-subtitle">Admin / Surat Eksternal / Surat <?= $jenis; ?> </p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="data">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th width="200">Isi Ringkas</th>
                                <?php if ($jenis == 'Keluar') { ?>
                                    <th width="100">Destinasi Surat</th>
                                <?php } else { ?>
                                    <th width="100">Asal Surat</th>
                                <?php } ?>
                                <th>Keterangan Surat</th>
                                <th>Atribut Surat</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($set as $row) { ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <?php if ($jenis == 'Keluar') { ?>
                                        <?php if (empty($row->file_path)) { ?>
                                            <td>
                                                <p class="text-wrap mb-0" style="width: 100%;"><?= $row->isi_ringkas; ?></p>
                                                <span class="badge badge-primary">Tidak ada berkas yang di unggah</span>
                                            </td>
                                        <?php } else { ?>
                                            <td>
                                                <p class="text-wrap mb-0" style="width: 100%;"><?= $row->isi_ringkas; ?></p>
                                                <span class="badge badge-success">Berkas telah di unggah</span>
                                            </td>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <?php if (empty($row->file_path)) { ?>
                                            <td>
                                                <p class="text-wrap mb-0" style="width: 100%;"><?= $row->isi_ringkas; ?></p>
                                                <span class="badge badge-primary">Tidak ada berkas yang di unggah</span>
                                            </td>
                                        <?php } else { ?>
                                            <td>
                                                <p class="text-wrap mb-0" style="width: 100%;"><?= $row->isi_ringkas; ?></p>
                                                File: <a href="<?= base_url($row->file_path); ?>">Download</a>
                                            </td>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if ($jenis == 'Keluar') { ?>
                                        <td>
                                            <p class="text-wrap mb-0" style="width: 100%;">
                                                <?= $row->tujuan_surat_luar; ?>
                                            </p>
                                        </td>
                                    <?php } else { ?>
                                        <td>
                                            <p class="text-wrap mb-0" style="width: 100%;">
                                                <?= $row->asal_surat_luar; ?>
                                            </p>
                                        </td>
                                    <?php } ?>
                                    <td>
                                        <small>
                                            No. Surat: <font color="green"><?= $row->nomor_surat; ?></font><br />
                                            <?php $tanggal = date_create($row->tanggal_surat);
                                            $tgl = date_format($tanggal, 'd-F-Y'); ?>
                                            Tanggal Surat: <?= $tgl; ?> <br />
                                            Perihal: <?= $row->perihal; ?>
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            Jenis Surat: <?= $row->nama_jenis; ?><br />
                                            Prioritas Surat: <?= $row->nama_prioritas; ?><br />
                                            Sifat Surat: <?= $row->nama_sifat; ?><br />
                                            Media asalan: <?= $row->nama_media; ?>
                                        </small>
                                    </td>
                                    <?php if ($jenis == 'Keluar') { ?>
                                        <td>
                                            <a href="<?= base_url('/surat-eksternal/destroy/'); ?><?= $row->id_surat_eksternal; ?>" class="btn btn-danger p-2" onclick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="fa fa-trash"></i> Hapus</a>
                                        </td>
                                    <?php } else { ?>
                                        <td>
                                            <a href="<?= base_url('disposisi-eksternal/daftar-disposisi/'); ?><?= $row->id_surat_eksternal; ?>" class="btn btn-success p-2"><i class="fa fa-file"></i> Disposisi</a>

                                            <a href="<?= base_url('/surat-eksternal/destroy/'); ?><?= $row->id_surat_eksternal; ?>" class="btn btn-danger p-2" onclick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="fa fa-trash"></i> Hapus</a>
                                        </td>
                                    <?php } ?>

                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <script>
    function add_supplier() {
        $('#form')[0].reset();
        $("#myModal").modal('show');
        <?php if ($jenis == 'Keluar') { ?>
            $('.modal-title').text('Tambah Surat Eksternal Keluar');
            $('#form').attr({
                'action': '<?= site_url('surat-eksternal/create'); ?>',
                'enctype': 'multipart/form-data'
            });
        <?php } else { ?>
            $('.modal-title').text('Tambah Surat Eksternal Masuk');
            $('#form').attr({
                'action': '<?= site_url('surat-eksternal/create2'); ?>',
                'enctype': 'multipart/form-data'
            });
        <?php } ?>
        // Set title to Bootstrap modal title
        $('[name=submit]').val('Tambah').show();
        $('.modal-footer').show();
    }
</script>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <?= form_open_multipart('surat-internal/create', array('id' => 'form')); ?>
            <div class="modal-header py-3">
                <h4 class="modal-title">Tambah Surat Eksternal</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" name="id_surat_eksternal" />
                        <div class="form-group">
                            <label>Nomor Surat</label>
                            <input type="text" name="nomor_surat" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Perihal</label>
                            <input type="text" name="perihal" class="form-control">
                        </div>
                        <?php if ($jenis == 'Keluar') { ?>
                            <div class="form-group">
                                <label>Destinasi Surat</label>
                                <textarea name="tujuan_surat_luar" class="form-control"></textarea>
    -->
<!--<input type="hidden" name="asal_surat_pengguna" value="<?php //echo $this->session->userdata('id_user');
                                                            ?>"/>-->
<!-- </div>
                            <div class="form-group">
                                <label>Asal Surat Pengguna</label>
                                <select name="asal_surat_pengguna" class="form-control" id="pegawai-akun" style="width:100%!important;">
                                    <?php foreach ($set_destinasi as $row_des) { ?>
                                        <option value="<?= $row_des->id_user; ?>"><?= $row_des->nama_pegawai; ?> (<?= $row_des->nama_jabatan; ?> - <?= $row_des->nama_unit; ?>)</option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php } else if ($jenis == 'Masuk') { ?> 
    -->
<!--<input type="hidden" name="tujuan_surat_pengguna" value="<?php //echo $this->session->userdata('id_user');
                                                                ?>">-->
<!--
                            <div class="form-group">
                                <label>Asal Surat</label>
                                <textarea class="form-control" name="asal_surat_luar"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Tujuan Surat Pengguna</label>
                                <select name="tujuan_surat_pengguna" class="form-control" id="pegawai-akun" style="width:100%!important;">
                                    <?php foreach ($set_destinasi as $row_des) { ?>
                                        <option value="<?= $row_des->id_user; ?>"><?= $row_des->nama_pegawai; ?> (<?= $row_des->nama_jabatan; ?> - <?= $row_des->nama_unit; ?>)</option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label>Isi Ringkas</label>
                            <textarea name="isi_ringkas" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Surat</label>
                            <input type="date" name="tanggal_surat" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Tanggal Transaksi</label>
                            <input type="date" name="tanggal_transaksi" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Jenis Surat</label>
                            <select name="id_jenis" class="form-control">
                                <?php foreach ($set_jenis as $row_jenis) { ?>
                                    <option value="<?= $row_jenis->id_jenis; ?>">
                                        <?= $row_jenis->nama_jenis; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label> Prioritas Surat</label>
                            <select name="id_prioritas" class="form-control">
                                <?php foreach ($set_prioritas as $row_prioritas) { ?>
                                    <option value="<?= $row_prioritas->id_prioritas; ?>">
                                        <?= $row_prioritas->nama_prioritas; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label> Sifat Surat</label>
                            <select name="id_sifat" class="form-control">
                                <?php foreach ($set_sifat as $row_sifat) { ?>
                                    <option value="<?= $row_sifat->id_sifat; ?>">
                                        <?= $row_sifat->nama_sifat; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label> Media Pengiriman Surat</label>
                            <select name="id_media" class="form-control">
                                <?php foreach ($set_media as $row_media) { ?>
                                    <option value="<?= $row_media->id_media; ?>">
                                        <?= $row_media->nama_media; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Lokasi Penyimpanan Berkas</label>
                            <textarea name="lokasi_surat" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Unggah Berkas</label><br />
                            <label class="file-upload btn btn-primary p-2">
                                Upload Berkas...<input type="file" name="file_path">
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" name="submit" value="Tambah" class="btn btn-success p-3">
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div> -->