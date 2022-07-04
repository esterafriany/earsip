<div class="row">
    <div class="col-12 grid-margin">
        <?= $this->session->flashdata('notify'); ?>
        <?= validation_errors(); ?>
        <!-- OVERVIEW -->
        <?php //if($jenis == 'Keluar') { 
        ?>
        <!-- <a href="#" class="act-btn" onclick="add_supplier() ">+</a>-->
        <?php //} 
        ?>
        <div class="card">
            <div class="card-header py-3">
                <h4>Kelola Surat <?= $jenis; ?> </h4>
                <p class="card-subtitle">Admin / Surat Internal /Surat <?= $jenis; ?> </p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="data">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Isi Ringkas</th>
                                <?php if ($jenis == 'Keluar') { ?>
                                    <th>Destinasi Surat</th>
                                <?php } else { ?>
                                    <th>Asal Surat</th>
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
                                    <?php if ($jenis == "Keluar") { ?>

                                        <?php if (empty($row->file_path)) { ?>
                                            <td>
                                                <p><?= $row->isi_ringkas; ?></p> <br />
                                                <label class="label label-primary">Tidak ada berkas yang di unggah</label>
                                            </td>
                                        <?php } else { ?>
                                            <td>
                                                <small><?= $row->isi_ringkas; ?></small> <br />
                                                <label class="label label-success">Berkas telah di unggah</label>
                                            </td>
                                        <?php } ?>

                                    <?php } else { ?>

                                        <?php if (empty($row->file_path)) { ?>
                                            <td>
                                                <p><?= $row->isi_ringkas; ?></p> <br />
                                                <label class="label label-primary">Tidak ada berkas yang di unggah</label>
                                            </td>
                                        <?php } else { ?>
                                            <td>
                                                <small><?= $row->isi_ringkas; ?></small> <br />
                                                File : <a href="<?= base_url($row->file_path); ?>">Download</a>
                                            </td>
                                        <?php } ?>

                                    <?php } ?>
                                    <?php if ($jenis == 'Keluar') { ?>
                                        <td>
                                            <small>
                                                Tujuan: <?= $row->nama_pegawai_penerima; ?> <br />
                                                Jabatan: <?= $row->nama_jabatan_penerima; ?> <br />
                                                Unit Kerja : <?= $row->nama_unit_penerima; ?>
                                            </small>
                                        </td>
                                    <?php } else { ?>
                                        <td>
                                            <small>
                                                Asal: <?= $row->nama_pegawai_pengirim; ?> <br />
                                                Jabatan: <?= $row->nama_jabatan_pengirim; ?> <br />
                                                Unit Kerja : <?= $row->nama_unit_pengirim; ?>
                                            </small>
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
                                            Media Pengiriman: <?= $row->nama_media; ?>
                                        </small>
                                    </td>
                                    <?php if ($jenis == 'Keluar') { ?>
                                        <td>
                                            <button class="btn btn-warning" onclick="edit_supplier(<?= $row->id_surat_internal; ?>)"><i class="fa fa-edit"></i> Edit</button>
                                            <?= anchor('surat-internal/destroy/' . $row->id_surat_internal, '<button class="btn btn-danger p-2"><i class="fa fa-trash"></i> Hapus</button>', array('onclick' => 'return confirm("Anda yakin ingin menghapus data ini?")')); ?>
                                        </td>
                                    <?php } else { ?>
                                        <td>
                                            <?= anchor('disposisi-internal/daftar-disposisi/' . $row->id_surat_internal, '<button class="btn btn-success p-2"><i class="fa fa-file"></i> Disposisi</button>'); ?>
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

<script>
    function add_supplier() {
        $('#form')[0].reset();
        $("#myModal").modal('show');
        $('.modal-title').text('Tambah Surat Keluar'); // Set title to Bootstrap modal title
        $('[name=submit]').val('Tambah').show();
        $('#form').attr({
            'action': '<?= site_url('surat-internal/create'); ?>',
            'enctype': 'multipart/form-data'
        });
        $('.modal-footer').show();
    }
</script>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <?= form_open_multipart('surat-internal/create', array('id' => 'form')); ?>
            <div class="modal-header py-3">
                <h4 class="modal-title">Tambah Jenis Kegiatan</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" name="id_surat_internal" />
                        <input type="hidden" name="asal_surat" value="<?= $pembuat; ?>">

                        <div class="form-group">
                            <label>Nomor Surat</label>
                            <input type="text" name="nomor_surat" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Perihal</label>
                            <input type="text" name="perihal" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Destinasi Surat</label>
                            <select name="destinasi_surat" class="form-control" id="pegawai-akun" style="width:100%!important;">
                                <?php foreach ($set_destinasi as $row_des) { ?>
                                    <option value="<?= $row_des->id_user; ?>"><?= $row_des->nama_pegawai; ?> (<?= $row_des->nama_jabatan; ?> - <?= $row_des->nama_unit; ?>)</option>
                                <?php } ?>
                            </select>
                        </div>
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
                            <label class="file-upload btn btn-primary">
                                Cari Berkas...<input type="file" name="file_path">
                            </label>

                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <input type="submit" name="submit" value="Tambah" class="btn btn-success">
            </div>
            <?= form_close(); ?>
        </div>

    </div>
</div>