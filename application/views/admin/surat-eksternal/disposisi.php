<div class="row">
    <div class="col-12 grid-margin">
        <div class="card mb-3">
            <div class="card-header py-2">
                <h4><span class="mdi mdi-email"></span> Isi Surat</h4>
            </div>
            <?php foreach ($set_surat as $row_surat) { ?>
                <div class="card-body py-3">
                    <blockquote class="blockquote py-2 mb-2">
                        <h6>
                            <b>Nomor Surat: </b> <?= $row_surat->nomor_surat; ?> <br />
                            <b>Asal:</b> <?= $row_surat->asal_surat_luar; ?> <br />
                            <b>Perihal: </b> <?= $row_surat->perihal; ?><br />
                            <?php $tanggal = date_create($row_surat->tanggal_surat);
                            $tgl = date_format($tanggal, 'd-F-Y'); ?>
                            <b>Tanggal Surat:</b> <?= $tgl; ?>
                        </h6>
                        <?= $row_surat->isi_ringkas; ?><br />
                    </blockquote>
                    <small>Keterangan:</small>
                    <small>
                        <b>Jenis Surat:</b> <?= $row_surat->nama_jenis; ?> -
                        <b>Prioritas Surat:</b> <?= $row_surat->nama_prioritas; ?> -
                        <b>Sifat Surat:</b> <?= $row_surat->nama_sifat; ?> -
                        <b>Media Pengiriman:</b> <?= $row_surat->nama_media; ?>
                    </small>
                </div>
            <?php } ?>
        </div>

    </div>
    <div class="container-fluid">
        <?= $this->session->flashdata('notify'); ?>
        <?= validation_errors(); ?>
        <!-- OVERVIEW -->

        <a href="#" class="act-btn" onclick="add_supplier() ">+</a>

        <div class="card">
            <div class="card-header py-3">
                <h4>Kelola Disposisi </h4>
                <p class="card-subtitle">Surat Internal / Disposisi </p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="data">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Diteruskan Kepada</th>
                                <th>Isi Disposisi</th>

                                <th>Keterangan</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($set as $row) { ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $row->nama_pegawai; ?></td>
                                    <td><?= $row->isi_disposisi; ?></td>

                                    <td>
                                        <?php $tanggal = date_create($row->tanggal_disposisi);
                                        $tgl = date_format($tanggal, 'd-F-Y'); ?>
                                        <small>
                                            Tanggal Disposisi: <?= $tgl; ?><br />
                                            Perintah: <?= $row->nama_perintah; ?><br />
                                        </small>
                                    </td>
                                    <td>
                                        <?= anchor('disposisi_eksternal/print/' . $row->id_disposisi_eksternal, '<button class="btn btn-warning p-2"><i class="fa fa-print"></i> Print</button>', array('target', '_BLANK')); ?>
                                        <button class="btn btn-success p-2" onclick="edit_supplier(<?= $row->id_disposisi_eksternal; ?>)"><i class="fa fa-edit"></i> Ubah</button>
                                        <?= anchor('disposisi_eksternal/destroy/' . $row->id_disposisi_eksternal, '<button class="btn btn-danger p-2"><i class="fa fa-trash"></i> Hapus </button>'); ?>
                                    </td>
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
        $('.modal-title').text('Tambah Disposisi'); // Set title to Bootstrap modal title
        $('[name=submit]').val('Tambah').show();
        $('#form').attr('action', '<?= site_url('disposisi_eksternal/create'); ?>');
        $('.modal-footer').show();
    }

    function edit_supplier(id) {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals

        //Ajax Load data from ajax
        $.ajax({
            url: "<?= base_url('disposisi_eksternal/get') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="id_disposisi_eksternal"]').val(data.id_disposisi_eksternal);
                $('[name="id_surat_internal"]').val(data.id_surat_internal);
                $('[name="isi_disposisi"]').val(data.isi_disposisi);
                $('[name="tanggal_disposisi"]').val(data.tanggal_disposisi);
                $('[name="keterangan"]').val(data.keterangan);
                $('#myModal').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Unit Kerja'); // Set title to Bootstrap modal title
                $('[name=submit]').val('Edit').show();
                $('.modal-footer').show();
                $('#form').attr('action', '<?= site_url('disposisi_eksternal/update'); ?>');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax' + jqXHR);
            }
        });
    }
</script>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <?= form_open('disposisi/create', array('id' => 'form')); ?>
            <div class="modal-header py-3">
                <h4 class="modal-title">Tambah Disposisi</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--modal-header-->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" name="id_disposisi_eksternal" />
                        <input type="hidden" name="id_surat_eksternal" value="<?= $id_surat_eksternal; ?>" />
                        <div class="form-group">
                            <label>Isi Disposisi</label>
                            <textarea name="isi_disposisi" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Disposisi</label>
                            <input type="date" name="tanggal_disposisi" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Penyelesaian</label>
                            <select name="id_perintah" class="form-control">
                                <?php foreach ($set_perintah as $row_perintah) { ?>
                                    <option value="<?= $row_perintah->id_perintah; ?>"><?= $row_perintah->nama_perintah; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Unit Kerja</label>
                            <select class="form-control select2" id="set_unit_kerja" style="width:100% !important;">
                                <option value="">-- Pilih Unit Kerja --</option>
                                <?php foreach ($set_unit as $row_unit) { ?>
                                    <option <?= $unit_selected == $row_unit->id_unit ? 'selected="selected"' : '' ?> value="<?= $row_unit->id_unit; ?>"><?= $row_unit->nama_unit; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jabatan</label>
                            <select class="form-control select2" id="set_jabatan" style="width:100% !important;">
                                <option value="">-- Pilih Jabatan --</option>
                                <?php foreach ($set_jabatan as $row_jabatan) { ?>
                                    <option <?= $jabatan_selected == $row_jabatan->id_unit ? 'selected="selected"' : '' ?> value="<?= $row_jabatan->id_jabatan; ?>" class="<?= $row_jabatan->id_unit; ?>"><?= $row_jabatan->nama_jabatan; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Pegawai (Tujuan Disposisi)</label>
                            <select name="tujuan_disposisi" class="form-control select2" id="set_pegawai" style="width:100% !important;">
                                <option value="">-- Pilih Pegawai --</option>
                                <?php foreach ($set_pegawai as $row_pegawai) { ?>
                                    <option <?= $pegawai_selected == $row_pegawai->id_jabatan ? 'selected="selected"' : '' ?> value="<?= $row_pegawai->id_pegawai; ?>" class="<?= $row_pegawai->id_jabatan; ?>"><?= $row_pegawai->nama_pegawai; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!--modal-body-->
            <div class="modal-footer">
                <input type="submit" name="submit" value="Tambah" class="btn btn-success p-3">
            </div>
            <!--modal-footer-->
            <?= form_close(); ?>
        </div>
        <!--modal-content-->
    </div>
    <!--modal-dialog-->
</div>
<!--modal-->