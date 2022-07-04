<div class="row">
    <div class="col-12 grid-margin">

        <?= $this->session->flashdata('notify'); ?>

        <div class="card">
            <div class="card-header py-3">
                <h4 class="">Tambah Surat <?= $jenis; ?> </h4>
                <p class="card-subtitle">Admin / Surat Internal / Tambah <?= $jenis; ?> </p>
            </div>
            <div class="card-body">
                <?= form_open_multipart('surat-internal/tambah/keluar?act=submit_keluar', array('id' => 'form')); ?>
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" name="id_surat_internal" />
                        <input type="hidden" name="asal_surat" value="<?= $pembuat; ?>">
                        <div class="form-group">
                            <label>Nomor Surat</label>
                            <input type="text" name="nomor_surat" class="form-control <?php if (form_error('nomor_surat')) {
                                                                                            echo "is-invalid";
                                                                                        }; ?>" value="<?= set_value('nomor_surat') ?>">
                            <?php if (form_error('nomor_surat')) { ?>
                                <div class="invalid-feedback">
                                    <?= form_error('nomor_surat'); ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label>Perihal</label>
                            <input type="text" name="perihal" class="form-control <?php if (form_error('perihal')) {
                                                                                        echo "is-invalid";
                                                                                    }; ?>" value="<?= set_value('perihal') ?>">
                            <?php if (form_error('perihal')) { ?>
                                <div class="invalid-feedback">
                                    <?= form_error('perihal'); ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label>Destinasi Surat</label>
                            <textarea name="destinasi_surat" class="form-control <?php if (form_error('destinasi_surat')) {
                                                                                        echo "is-invalid";
                                                                                    }; ?>"></textarea>
                            <?php if (form_error('destinasi_surat')) { ?>
                                <div class="invalid-feedback">
                                    <?= form_error('destinasi_surat'); ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label>Isi Ringkas</label>
                            <textarea name="isi_ringkas" class="form-control <?php if (form_error('isi_ringkas')) {
                                                                                    echo "is-invalid";
                                                                                }; ?>"><?= set_value('isi_ringkas') ?></textarea>
                            <?php if (form_error('isi_ringkas')) { ?>
                                <div class="invalid-feedback">
                                    <?= form_error('isi_ringkas'); ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Surat</label>
                            <input type="date" name="tanggal_surat" class="form-control <?php if (form_error('tanggal_surat')) {
                                                                                            echo "is-invalid";
                                                                                        }; ?>" value="<?= set_value('tanggal_surat') ?>">
                            <?php if (form_error('tanggal_surat')) { ?>
                                <div class="invalid-feedback">
                                    <?= form_error('tanggal_surat'); ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Transaksi</label>
                            <input type="date" name="tanggal_transaksi" class="form-control <?php if (form_error('tanggal_transaksi')) {
                                                                                                echo "is-invalid";
                                                                                            }; ?>" value="<?= set_value('tanggal_transaksi') ?>">
                            <?php if (form_error('tanggal_transaksi')) { ?>
                                <div class="invalid-feedback">
                                    <?= form_error('tanggal_transaksi'); ?>
                                </div>
                            <?php } ?>
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
                            <textarea name="lokasi_surat" class="form-control <?php if (form_error('lokasi_surat')) {
                                                                                    echo "is-invalid";
                                                                                }; ?>"><?= set_value('lokasi_surat') ?></textarea>
                            <?php if (form_error('lokasi_surat')) { ?>
                                <div class="invalid-feedback">
                                    <?= form_error('lokasi_surat'); ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label>Unggah Berkas</label><br />
                            <input type="file" class="form-control-file" name="file_path">
                            <?= $this->session->flashdata('uploadError'); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-primary p-3"><i class="fa fa-save"></i>Tambah</button>
                </div>
                <?= form_close(); ?>

            </div>
        </div>

        <!-- Container Hack -->
        <div style="min-width: 1336px !important">
        </div>
        <!-- -->

    </div>
</div>

<script>
    $(document).ready(function() {
        $('#form')[0].reset();
        <?php if ($jenis == 'Keluar') { ?>
            $('#form').attr({
                'action': '<?= site_url('surat-internal/tambah/keluar?act=submit_keluar'); ?>',
                'enctype': 'multipart/form-data'
            });
        <?php } else { ?>
            $('#form').attr({
                'action': '<?= site_url('surat-internal/tambah/masuk?act=submit_masuk'); ?>',
                'enctype': 'multipart/form-data'
            });
        <?php } ?>
    });
</script>