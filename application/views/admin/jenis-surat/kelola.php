<div class="row">
    <div class="col-12 grid-margin">
            <?= $this->session->flashdata('notify'); ?>
            <?= validation_errors(); ?>
            <!-- OVERVIEW -->
            <a href="#" class="act-btn" onclick="add_jenis()">+</a>
            <div class="card">
                <div class="card-header py-3">
                    <h4>Kelola Jenis Surat</h4>
                    <p class="card-subtitle">Admin / Pengaturan / Jenis Surat</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Jenis Surat</th>
                                    <th>Keterangan</th>
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
                <h4 class="modal-title">Tambah Jenis Surat</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal needs-validation" novalidate="novalidate">
                    <input type="hidden" value="" name="id_jenis" />

                    <div class="form-group">
                        <label>Jenis Surat</label>
                        <input type="text" name="nama_jenis" class="form-control form-control-lg">
                        <div class="invalid-feedback">
                            <span id="nama_jenisError"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" name="keterangan" class="form-control form-control-lg">
                        <div class="invalid-feedback">
                            <span id="keteranganError"></span>
                        </div>
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
                "url": "<?= site_url('jenis_surat/jenis_list') ?>",
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [-1], //last column
                "orderable": false, //set not orderable
            }, ],
        });
    });

    function add_jenis() {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $(".select2").val(null).trigger("change");
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Jenis Surat'); // Set Title to Bootstrap modal title
        $('#btnSave').text('Simpan');
        $('[name="nama_jenis').removeClass('is-invalid');
        $('[name="nama_jenis').removeClass('is-valid');
        $('#nama_jenisError').html('');
        $('[name="keterangan"]').removeClass('is-invalid');
        $('[name="keterangan"]').removeClass('is-valid');
        $('#keteranganError').html('');
    }

    function edit_jenis(id) {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('#btnSave').text('Update');
        $('[name="nama_jenis').removeClass('is-invalid');
        $('[name="nama_jenis').removeClass('is-valid');
        $('#nama_jenisError').html('');
        $('[name="keterangan"]').removeClass('is-invalid');
        $('[name="keterangan"]').removeClass('is-valid');
        $('#keteranganError').html('');
        //Ajax Load data from ajax
        $.ajax({
            url: "<?= site_url('jenis_surat/jenis_edit/') ?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="id_jenis"]').val(data.id_jenis);
                $('[name="nama_jenis"]').val(data.nama_jenis);
                $('[name="keterangan"]').val(data.keterangan);

                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Jenis Surat'); // Set title to Bootstrap modal title

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
            url = "<?= site_url('jenis_surat/jenis_add') ?>";
        } else {
            url = "<?= site_url('jenis_surat/jenis_update') ?>";
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
                    if (data.nama_jenisError != '') {
                        $('[name="nama_jenis"]').addClass('is-invalid');
                        $('#nama_jenisError').html(data.nama_jenisError);
                    } else {
                        $('[name="nama_jenis').removeClass('is-invalid');
                        $('[name="nama_jenis').addClass('is-valid');
                        $('#nama_jenisError').html('');
                    }
                    if (data.keteranganError != '') {
                        $('[name="keterangan"]').addClass('is-invalid');
                        $('#keteranganError').html(data.keteranganError);
                    } else {
                        $('[name="keterangan"]').removeClass('is-invalid');
                        $('[name="keterangan"]').addClass('is-valid');
                        $('#keteranganError').html('');
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

    function delete_jenis(id) {
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
                    url: "<?= site_url('jenis_surat/jenis_delete') ?>/" + id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        if (data.response == 'error' || data.error) {
                            Swal.fire(
                                'Error!',
                                'Jenis Surat sedang digunakan',
                                'error'
                            );
                            toastr.error("Jenis Surat sedang digunakan");
                        } else {
                            //if success reload ajax table
                            $('#modal_form').modal('hide');
                            reload_table();
                            Swal.fire(
                                'Deleted!',
                                'Data Anda telah dihapus',
                                'success'
                            );
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error delete data');
                    }
                });


            }
        })
    }
</script>