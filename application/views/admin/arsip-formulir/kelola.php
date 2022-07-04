<div class="row">
    <div class="col-12 grid-margin">
        <?= $this->session->flashdata('notify'); ?>
        <?= validation_errors(); ?>
        <!-- OVERVIEW -->
        <a href="#" class="act-btn" onclick="add_formulir() ">+</a>
        <div class="card">
            <div class="card-header py-3">
                <h4 class="">Kelola Arsip Formulir</h4>
                <p class="card-subtitle">Admin / Arsip Formulir</p>
            </div>
            <div class="card-body">


            <table id="table_test" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
            <th>No.</th>
                <th width="300">Nama Formulir</th>
                <th>File</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th class="width-sm">Opsi</th>
            </tr>
        </thead>
              
        <tbody>
     

        </tbody>
    </table>



                <div class="table-responsive">
                    <table id="table" class="table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th width="300">Nama Formulir</th>
                                <th>File</th>
                                <th>Tanggal</th>
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
                <h4 class="modal-title">Tambah Arsip Formulir</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" enctype='multipart/form-data' class="form-horizontal needs-validation" novalidate="novalidate">
                    <input type="hidden" value="" name="id_formulir" />

                    <div class="form-group">
                        <label>Nama Formulir</label>
                        <input type="text" name="nama_formulir" class="form-control form-control-lg">
                        <div class="invalid-feedback">
                            <span id="nama_formulirError"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Formulir</label>
                        <input type="date" name="tanggal_formulir" class="form-control form-control-lg">
                        <div class="invalid-feedback">
                            <span id="tanggal_formulirError"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Keterangan <small style="color:red">*optional</small></label>
                        <textarea name="keterangan" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Unggah Berkas</label><br />
                        <input type="file" name="file_path" class="form-control-file">
                        <div class="invalid-feedback">
                            <span id="file_pathError"></span>
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

<div class="modal fade" id="modal_view" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Lihat Arsip Formulir</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>ID Formulir:</label>
                            <p id="id_formulir"></p>
                        </div>

                        <div class="form-group">
                            <label>Nama Formulir:</label>
                            <p id="nama_formulir"></p>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Formulir:</label>
                            <p id="tanggal_formulir"></p>
                        </div>
                        <div class="form-group">
                            <label>Keterangan:</label>
                            <p id="keterangan"></p>
                        </div>
                        <div class="form-group">
                            <label>File:</label>
                            <p id="file"></p>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6>File Preview:</h6>
                        <div id="viewer"></div>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<script type="text/javascript">
    var save_method; //for save method string
    var table;
    var table_test;
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
                "url": "<?= site_url('arsip_formulir/formulir_list') ?>",
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [2, -1], //last column
                "orderable": false, //set not orderable
            }, ],
        });

        table_test = $('#table_test').DataTable({
            "lengthMenu": [
                [5, 10, 20, -1],
                [5, 10, 20, "All"]
            ],
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?= site_url('arsip_dokumen/formulir_list') ?>",
              
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [2, -1], //last column
                "orderable": false, //set not orderable
            }, ],
        });

       
    });

    function add_formulir() {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $(".select2").val(null).trigger("change");
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Arsip Formulir'); // Set Title to Bootstrap modal title
        $('#form').attr({
            'enctype': 'multipart/form-data'
        });
        $('#btnSave').text('Simpan');
        $('[name="nama_formulir').removeClass('is-invalid');
        $('[name="nama_formulir').removeClass('is-valid');
        $('#nama_formulirError').html('');
        $('[name="keterangan"]').removeClass('is-invalid');
        $('[name="keterangan"]').removeClass('is-valid');
        $('#keteranganError').html('');
    }

    function view_formulir(id) {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        //Ajax Load data from ajax
        $.ajax({
            url: "<?= site_url('arsip_formulir/formulir_view/') ?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#id_formulir').html(data.id_formulir);
                $('#nama_formulir').html(data.nama_formulir);
                $('#tanggal_formulir').html(data.tanggal_formulir);
                $('#keterangan').html(data.keterangan);
                $('#file_name').html(data.file_name);
                $('#file_path').html(data.file_path);
                $('#file').html('<a href="<?= base_url() ?>' + data.file_path + '"><i class="fa fa-download fa-lg"></i> Download</a>');
                var extension = data.file_name.split('/').pop().split('.')[1].toLowerCase();
                console.log(extension);
                if (extension == "pdf") {
                    $('#viewer').html('<iframe id="pdf-js-viewer" src="<?= base_url('/assets/js/pdfjs/web/viewer.html?file=') ?><?= base_url() ?>' + data.file_path + '" title="webviewer" width="100%" frameborder="0" scrolling="yes" style="display:block; width:100%; height:60vh;"></iframe>');
                } else if (extension == "jpg" || extension == "jpeg" || extension == "png" || extension == "bmp" || extension == "gif" || extension == "tiff" || extension == "svg") {
                    $('#viewer').html('<img src="<?= base_url(); ?>' + data.file_path + '" class="img-fluid" alt="' + data.file_path + '" width="100%" />');
                } else {
                    $('#viewer').html('<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> Tidak ada preview</p>');
                }
                $('#modal_view').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('View Arsip Formulir'); // Set title to Bootstrap modal title

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
            url = "<?= site_url('arsip_formulir/formulir_add') ?>";
        } else {
            url = "<?= site_url('arsip_formulir/formulir_update') ?>";
        }
        // Get form
        var form = $('#form')[0];

        // Create an FormData object 
        var data = new FormData(form);
        // ajax adding data to database
        $.ajax({
            url: url,
            type: "POST",
            enctype: 'multipart/form-data',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
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
                    if (data.nama_formulirError != '') {
                        $('[name="nama_formulir"]').addClass('is-invalid');
                        $('#nama_formulirError').html(data.nama_formulirError);
                    } else {
                        $('[name="nama_formulir').removeClass('is-invalid');
                        $('[name="nama_formulir').addClass('is-valid');
                        $('#nama_formulirError').html('');
                    }
                    if (data.tanggal_formulirError != '') {
                        $('[name="tanggal_formulir"]').addClass('is-invalid');
                        $('#tanggal_formulirError').html(data.tanggal_formulirError);
                    } else {
                        $('[name="tanggal_formulir"]').removeClass('is-invalid');
                        $('[name="tanggal_formulir"]').addClass('is-valid');
                        $('#tanggal_formulirError').html('');
                    }
                    if (data.file_pathError != '') {
                        $('[name="file_path"]').addClass('is-invalid');
                        $('#file_pathError').html(data.file_pathError);
                    } else {
                        $('[name="file_path"]').removeClass('is-invalid');
                        $('[name="file_path"]').addClass('is-valid');
                        $('#file_pathError').html('');
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

    function delete_formulir(id) {
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
                    url: "<?= site_url('arsip_formulir/formulir_delete') ?>/" + id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        if (data.response == 'error' || data.error) {
                            Swal.fire(
                                'Error!',
                                'Media Surat sedang digunakan',
                                'error'
                            );
                            toastr.error("Media Surat sedang digunakan");
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