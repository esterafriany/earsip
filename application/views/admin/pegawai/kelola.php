<div class="row">
    <div class="col-12 grid-margin">
        <?= $this->session->flashdata('notify'); ?>
        <?= validation_errors(); ?>
        <!-- OVERVIEW -->
        <a href="#" class="act-btn" onclick="add_pegawai()">+</a>
        <div class="card">
            <div class="card-header py-3">
                <h4>Kelola Pegawai</h4>
                <p class="card-subtitle">Admin / Pengaturan Pegawai / Pegawai</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table" class="table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Pegawai</th>
                                <th>Kontak Telepon</th>
                                <th>Unit Kerja</th>
                                <th>Jabatan</th>
                                <th class="width-sm">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Pegawai</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal needs-validation" novalidate="novalidate">
                    <input type="hidden" value="" name="id_pegawai" />

                    <div class="form-group">
                        <label>Nama Pegawai</label>
                        <input type="text" name="nama_pegawai" class="form-control form-control-lg">
                        <div class="invalid-feedback">
                            <span id="nama_pegawaiError"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Telepon</label>
                        <input type="text" name="kontak_telepon" class="form-control form-control-lg">
                        <div class="invalid-feedback">
                            <span id="kontak_teleponError"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Unit Kerja</label>
                        <select name="id_unit" class="form-control select2" id="unit_kerja" style="width:100% !important;">
                            <option value="">-- Pilih Unit Kerja --</option>
                            <?php foreach ($set_unit as $row_unit) { ?>
                                <option value="<?= $row_unit->id_unit; ?>"><?= $row_unit->nama_unit; ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback">
                            <span id="id_unitError"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Jabatan</label>
                        <select name="id_jabatan" class="form-control select2" id="jabatan" style="width:100% !important;">
                            <?php foreach ($set_jabatan as $row_jabatan) { ?>
                                <option class="<?= $row_jabatan->id_unit; ?>" value="<?= $row_jabatan->id_jabatan; ?>"><?= $row_jabatan->nama_jabatan; ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback">
                            <span id="id_jabatanError"></span>
                        </div>
                    </div>
                    <div class="alert alert-info mt-1 mb-0" role="alert">
                        <strong>Informasi!</strong> Tambahkan Akun yang sesuai dengan Nama Pegawai <a href="<?= site_url('admin/akun'); ?>" alt="">disini</a>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary p-3" data-dismiss="modal">Tutup</button>
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary p-3">Simpan</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<script type="text/javascript">
    var save_method; //for save method string
    var table;
    $(document).ready(function() {
        table = $('#table').DataTable({
            "lengthMenu": [
                [5, 10, 20, -1],
                [5, 10, 20, "All"]
            ],
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?= site_url('pegawai/pegawai_list') ?>",
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [3, 4, -1], //last column
                "orderable": false, //set not orderable
            }, ],
        });
    });

    function add_pegawai() {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $(".select2").val(null).trigger("change");
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Pegawai'); // Set Title to Bootstrap modal title
        $('#btnSave').text('Simpan');
        $('[name="nama_pegawai').removeClass('is-invalid');
        $('[name="nama_pegawai').removeClass('is-valid');
        $('#nama_pegawaiError').html('');
        $('[name="kontak_telepon"]').removeClass('is-invalid');
        $('[name="kontak_telepon"]').removeClass('is-valid');
        $('#kontak_teleponError').html('');
        $('[name="id_unit"]').removeClass('is-invalid');
        $('[name="id_unit"]').removeClass('is-valid');
        $('#id_unitError').html('');
        $('[name="id_jabatan"]').removeClass('is-invalid');
        $('[name="id_jabatan"]').removeClass('is-valid');
        $('#id_jabatanError').html('');
    }

    function edit_pegawai(id) {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('#btnSave').text('Update');
        $('[name="nama_pegawai').removeClass('is-invalid');
        $('[name="nama_pegawai').removeClass('is-valid');
        $('#nama_pegawaiError').html('');
        $('[name="kontak_telepon"]').removeClass('is-invalid');
        $('[name="kontak_telepon"]').removeClass('is-valid');
        $('#kontak_teleponError').html('');
        $('[name="id_unit"]').removeClass('is-invalid');
        $('[name="id_unit"]').removeClass('is-valid');
        $('#id_unitError').html('');
        $('[name="id_jabatan"]').removeClass('is-invalid');
        $('[name="id_jabatan"]').removeClass('is-valid');
        $('#id_jabatanError').html('');
        //Ajax Load data from ajax
        $.ajax({
            url: "<?= site_url('pegawai/pegawai_edit/') ?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="id_pegawai"]').val(data.id_pegawai);
                $('[name="nama_pegawai"]').val(data.nama_pegawai);
                $('[name="kontak_telepon"]').val(data.kontak_telepon);
                $('[name="id_unit"]').val(data.id_unit).trigger("change");
                $('[name="id_jabatan"]').val(data.id_jabatan).trigger("change");

                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Pegawai'); // Set title to Bootstrap modal title

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function reload_table() {
        table.ajax.reload(null, false); //reload datatable ajax 
    }

    function save() {
        var url;
        if (save_method == 'add') {
            url = "<?= site_url('pegawai/pegawai_add') ?>";
        } else {
            url = "<?= site_url('pegawai/pegawai_update') ?>";
        }

        // ajax adding data to database
        $.ajax({
            url: url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            beforeSend: function() {
                if (save_method == 'add') {
                    $('#btnSave').html('<i class="fa fa-circle-o-notch fa-spin"></i> Loading');
                } else {
                    $('#btnSave').html('<i class="fa fa-circle-o-notch fa-spin"></i> Loading');
                }
            },
            complete: function() {
                if (save_method == 'add') {
                    $('#btnSave').html('Simpan');
                } else {
                    $('#btnSave').html('Update');
                }
            },
            success: function(data) {
                if (data.response == 'error' || data.error) {
                    $('#modal_form').modal('show');
                    toastr.error("Semua inputan wajib di isi!");
                    if (data.nama_pegawaiError != '') {
                        $('[name="nama_pegawai"]').addClass('is-invalid');
                        $('#nama_pegawaiError').html(data.nama_pegawaiError);
                    } else {
                        $('[name="nama_pegawai').removeClass('is-invalid');
                        $('[name="nama_pegawai').addClass('is-valid');
                        $('#nama_pegawaiError').html('');
                    }
                    if (data.kontak_teleponError != '') {
                        $('[name="kontak_telepon"]').addClass('is-invalid');
                        $('#kontak_teleponError').html(data.kontak_teleponError);
                    } else {
                        $('[name="kontak_telepon"]').removeClass('is-invalid');
                        $('[name="kontak_telepon"]').addClass('is-valid');
                        $('#kontak_teleponError').html('');
                    }
                    if (data.id_unitError != '') {
                        $('[name="id_unit"]').addClass('is-invalid');
                        $('#id_unitError').html(data.id_unitError);
                    } else {
                        $('[name="id_unit"]').removeClass('is-invalid');
                        $('[name="id_unit"]').addClass('is-valid');
                        $('#id_unitError').html('');
                    }
                    if (data.id_jabatanError != '') {
                        $('[name="id_jabatan"]').addClass('is-invalid');
                        $('#id_jabatanError').html(data.id_jabatanError);
                    } else {
                        $('[name="id_jabatan"]').removeClass('is-invalid');
                        $('[name="id_jabatan"]').addClass('is-valid');
                        $('#id_jabatanError').html('');
                    }
                } else {
                    //if success close modal and reload ajax table
                    $('#modal_form').modal('hide');
                    reload_table();
                    Swal.fire({
                        title: 'Good job!',
                        text: "Data telah disimpan!",
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                    })
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
            }
        });
    }

    function delete_pegawai(id) {
        Swal.fire({
            title: 'Apa kamu yakin?',
            text: "Anda tidak akan dapat mengembalikan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
        }).then(function(result) {
            if (result.isConfirmed) {
                // ajax delete data to database
                $.ajax({
                    url: "<?= site_url('pegawai/pegawai_delete') ?>/" + id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        //if success reload ajax table
                        $('#modal_form').modal('hide');
                        reload_table();
                        Swal.fire(
                            'Deleted!',
                            'Data Anda telah dihapus',
                            'success'
                        );
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error delete data');
                    }
                });


            }
        })
    }
</script>