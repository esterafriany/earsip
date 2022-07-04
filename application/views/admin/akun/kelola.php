<div class="row">
    <div class="col-12 grid-margin">
        <?= $this->session->flashdata('notify'); ?>
        <?= validation_errors(); ?>
        <!-- OVERVIEW -->
        <a href="#" class="act-btn" data-toggle="modal" data-target="#ModalAdd">+</a>
        <div class="card">
            <div class="card-header py-3">
                <h4>Kelola Akun</h4>
                <p class="card-subtitle">Admin / Pengaturan Pegawai / Akun</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="data">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Akun</th>
                                <th>Jabatan</th>
                                <th>Unit Kerja</th>
                                <th>Status</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody id="show_data">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="ModalAdd" class="modal fade" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <?= form_open('', array('class' => 'class="needs-validation"', 'novalidate' => 'novalidate')); ?>
            <div class="modal-header py-3">
                <h4 class="modal-title">Tambah Akun</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group" id="pegawai">
                    <label>Pegawai</label>
                    <select name="id_pegawai" class="form-control select2" id="id_pegawai" style="width:100% !important;">
                        <option value="">-- Pilih --</option>
                        <?php foreach ($set_pegawai as $row_pegawai) { ?>
                            <option value="<?= $row_pegawai->id_pegawai; ?>"><?= $row_pegawai->nama_pegawai; ?> (Jabatan: <?= $row_pegawai->nama_jabatan; ?> - Unit: <?= $row_pegawai->nama_unit; ?>)</option>
                        <?php } ?>
                    </select>
                    <div class="invalid-feedback">
                        <span id="id_pegawaiError"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label>Nama Akun</label>
                    <input type="text" name="name" id="name" class="form-control">
                    <div class="invalid-feedback">
                        <span id="nameError"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label>Email <small style="color:red">*</small></label>
                    <input type="email" name="email" class="form-control" id="email">
                    <div class="invalid-feedback">
                        <span id="emailError"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label>Password <small style="color:red">*</small></label>
                    <input type="password" name="password" class="form-control" id="password">
                    <div class="invalid-feedback">
                        <span id="passwordError"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password <small style="color:red">*</small></label>
                    <input type="password" name="confirm" class="form-control" id="confirm">
                    <div class="invalid-feedback">
                        <span id="confirmError"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" type="submit" id="btn_save" class="btn btn-primary btn-lg">Simpan</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<div id="ModalEdit" class="modal fade" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <?= form_open('', array('class' => 'class="needs-validation"', 'novalidate' => 'novalidate')); ?>
            <div class="modal-header py-3">
                <h4 class="modal-title">Edit Akun</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_user_edit" id="id_user_edit" />
                <div class="form-group">
                    <label>Nama Akun</label>
                    <input type="text" name="name_edit" id="name_edit" class="form-control">
                    <div class="invalid-feedback">
                        <span id="nameError"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label>Pegawai</label>
                    <select name="id_pegawai_edit" class="form-control select2" id="id_pegawai_edit" style="width:100% !important;">
                        <option value="">-- Pilih --</option>
                        <?php foreach ($set_pegawai as $row_pegawai) { ?>
                            <option value="<?= $row_pegawai->id_pegawai; ?>"><?= $row_pegawai->nama_pegawai; ?> (Jabatan: <?= $row_pegawai->nama_jabatan; ?> - Unit: <?= $row_pegawai->nama_unit; ?>)</option>
                        <?php } ?>
                    </select>
                    <div class="invalid-feedback">
                        <span id="id_pegawaiError"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label>Email <small style="color:red">*</small></label>
                    <input type="email" name="email_edit" class="form-control" id="email_edit">
                    <div class="invalid-feedback">
                        <span id="emailError"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" type="submit" id="btn_update" class="btn btn-primary btn-lg">Update</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<div id="ModalPassword" class="modal fade" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <?= form_open('', array('class' => 'class="needs-validation"', 'novalidate' => 'novalidate')); ?>
            <div class="modal-header py-3">
                <h4 class="modal-title">Reset Password Akun</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_user_edit" id="id_user_edit" />
                <div class="form-group">
                    <label>Password Lama <small style="color:red">*</small></label>
                    <input type="password" name="old_password" class="form-control" id="old_password">
                    <div class="invalid-feedback">
                        <span id="old_passwordError"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label>Password Baru <small style="color:red">*</small></label>
                    <input type="password" name="new_password" class="form-control" id="new_password">
                    <div class="invalid-feedback">
                        <span id="new_passwordError"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password <small style="color:red">*</small></label>
                    <input type="password" name="confirm_password" class="form-control" id="confirm_password">
                    <div class="invalid-feedback">
                        <span id="confirm_passwordError"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" type="submit" id="btn_password" class="btn btn-primary btn-lg">Update</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<!--MODAL DELETE-->
<form>
    <div class="modal fade" id="ModalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Akun</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        &times;
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin akan menghapus data ini?
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id_user_delete" id="id_user_delete" class="form-control">
                    <button type="button" class="btn btn-secondary p-3" data-dismiss="modal">Tutup</button>
                    <button type="button" type="submit" id="btn_delete" class="btn btn-danger p-3">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL DELETE-->

<script>
    $(document).ready(function() {
        show_data(); //call function show all product

        //function show 
        function show_data() {
            $.ajax({
                type: 'GET',
                url: '<?= site_url('pengguna/index') ?>',
                async: false,
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        if (data[i].level == 1) {
                            var level = '<span class="badge badge-dark">Admin</span>'
                        } else {
                            var level = '<span class="badge badge-primary">User</span>'
                        }
                        html += '<tr>' +
                            '<td>' + data[i].id_user + '</td>' +
                            '<td>Nama: ' + data[i].name + '<br/>Pegawai: ' + data[i].nama_pegawai + '<br/>Email: ' + data[i].email + '</td>' +
                            '<td>' + data[i].nama_jabatan + '</td>' +
                            '<td>' + data[i].nama_unit + '</td>' +
                            '<td>' + level + '</td>' +
                            '<td>' +
                            '<a href="javascript:void(0);" class="btn btn-warning p-2 item_edit" data-id_user="' + data[i].id_user + '" data-name="' + data[i].name + '" data-id_pegawai="' + data[i].id_pegawai + '" data-email="' + data[i].email + '"><i class="fa fa-edit"></i> Edit</a>' + ' ' +
                            '<a href="javascript:void(0);" class="btn btn-info p-2 item_password" data-id_user="' + data[i].id_user + '"><i class="fa fa-undo"></i> Password</a>' + ' ' +
                            '<a href="javascript:void(0);" class="btn btn-danger p-2 item_delete" data-id_user="' + data[i].id_user + '"><i class="fa fa-trash"></i> Hapus</a>' +
                            '</td>' +
                            '</tr>';
                    }
                    $('#show_data').html(html);
                }

            });
        }

        //Save
        $('#btn_save').on('click', function() {
            var name = $('#name').val();
            var id_pegawai = $('#id_pegawai').val();
            var email = $('#email').val();
            var password = $('#password').val();
            var confirm = $('#confirm').val();
            $.ajax({
                type: "POST",
                url: "<?= site_url('pengguna/create') ?>",
                dataType: "JSON",
                data: {
                    name: name,
                    id_pegawai: id_pegawai,
                    email: email,
                    password: password,
                    confirm: confirm
                },
                beforeSend: function() {
                    $('#btn_save').html('<i class="fa fa-circle-o-notch fa-spin"></i> Loading');
                },
                complete: function() {
                    $('#btn_save').html('Simpan');
                },
                success: function(data) {
                    if (data.response == 'error' || data.error) {
                        $('#ModalAdd').modal('show');
                        toastr.error("Semua inputan wajib di isi!");
                        if (data.nameError != '') {
                            $('#name').addClass('is-invalid');
                            $('#nameError').html(data.nameError);
                        } else {
                            $('#name').removeClass('is-invalid');
                            $('#name').addClass('is-valid');
                            $('#nameError').html('');
                        }
                        if (data.id_pegawaiError != '') {
                            $('#id_pegawai').addClass('is-invalid');
                            $('#id_pegawaiError').html(data.id_pegawaiError);
                        } else {
                            $('#id_pegawai').removeClass('is-invalid');
                            $('#id_pegawai').addClass('is-valid');
                            $('#id_pegawaiError').html('');
                        }
                        if (data.emailError != '') {
                            $('#email').addClass('is-invalid');
                            $('#emailError').html(data.emailError);
                        } else {
                            $('#email').removeClass('is-invalid');
                            $('#email').addClass('is-valid');
                            $('#emailError').html('');
                        }
                        if (data.passwordError != '') {
                            $('#password').addClass('is-invalid');
                            $('#passwordError').html(data.passwordError);
                        } else {
                            $('#password').removeClass('is-invalid');
                            $('#password').addClass('is-valid');
                            $('#passwordError').html('');
                        }
                        if (data.confirmError != '') {
                            $('#confirm').addClass('is-invalid');
                            $('#confirmError').html(data.confirmError);
                        } else {
                            $('#confirm').removeClass('is-invalid');
                            $('#confirm').addClass('is-valid');
                            $('#confirmError').html('');
                        }
                    } else {
                        $('#name').val("");
                        $('#id_pegawai').val("");
                        $('#email').val("");
                        $('#password').val("");
                        $('#confirm').val("");
                        $('#ModalAdd').modal('hide');
                        toastr.success("Akun Pengguna baru berhasil dibuat");
                        show_data();
                    }
                }
            });
            return false;
        });

        //get data for update record
        $('#show_data').on('click', '.item_edit', function() {
            var id_user = $(this).data('id_user');
            var name = $(this).data('name');
            var id_pegawai = $(this).data('id_pegawai');
            var email = $(this).data('email');

            $('#ModalEdit').modal('show');
            $('#id_user_edit').val(id_user);
            $('#name_edit').val(name);
            $('#id_pegawai_edit').val(id_pegawai).trigger("change");
            $('#email_edit').val(email);
        });

        //update record to database
        $('#btn_update').on('click', function() {
            var id_user = $('#id_user_edit').val();
            var name = $('#name_edit').val();
            var id_pegawai = $('#id_pegawai_edit').val();
            var email = $('#email_edit').val();
            $.ajax({
                type: "POST",
                url: "<?= site_url('pengguna/update') ?>",
                dataType: "JSON",
                data: {
                    id_user: id_user,
                    name: name,
                    id_pegawai: id_pegawai,
                    email: email
                },
                beforeSend: function() {
                    $('#btn_update').html('<i class="fa fa-circle-o-notch fa-spin"></i> Loading');
                },
                complete: function() {
                    $('#btn_update').html('Update');
                },
                success: function(data) {
                    $('[name="name_edit"]').val("");
                    $('[name="id_pegawai_edit"]').val("");
                    $('[name="email_edit"]').val("");
                    $('#ModalEdit').modal('hide');
                    toastr.success("Akun Pengguna berhasil diperbarui");
                    show_data();
                }
            });
            return false;
        });

        //get data for update record
        $('#show_data').on('click', '.item_password', function() {
            var id_user = $(this).data('id_user');
            $('#ModalPassword').modal('show');
            $('#id_user_edit').val(id_user);
        });

        //update record to database
        $('#btn_password').on('click', function() {
            var id_user = $('#id_user_edit').val();
            var old_password = $('#old_password').val();
            var new_password = $('#new_password').val();
            var confirm_password = $('#confirm_password').val();
            $.ajax({
                type: "POST",
                url: "<?= site_url('pengguna/reset_password') ?>",
                dataType: "JSON",
                data: {
                    id_user: id_user,
                    old_password: old_password,
                    new_password: new_password,
                    confirm_password: confirm_password
                },
                beforeSend: function() {
                    $('#btn_password').html('<i class="fas fa-circle-notch fa-spin"></i> Loading');
                },
                complete: function() {
                    $('#btn_password').html('Update');
                },
                success: function(data) {
                    if (data.response == 'error' || data.error) {
                        $('#ModalPassword').modal('show');
                        toastr.error("Periksa inputan kembali");
                        if (data.old_passwordError != '') {
                            $('#old_password').addClass('is-invalid');
                            $('#old_passwordError').html(data.old_passwordError);
                        } else {
                            $('#old_password').removeClass('is-invalid');
                            $('#old_password').addClass('is-valid');
                            $('#old_passwordError').html('');
                        }
                        if (data.new_passwordError != '') {
                            $('#new_password').addClass('is-invalid');
                            $('#new_passwordError').html(data.new_passwordError);
                        } else {
                            $('#new_password').removeClass('is-invalid');
                            $('#new_password').addClass('is-valid');
                            $('#new_passwordError').html('');
                        }
                        if (data.confirm_passwordError != '') {
                            $('#confirm_password').addClass('is-invalid');
                            $('#confirm_passwordError').html(data.confirm_passwordError);
                        } else {
                            $('#confirm_password').removeClass('is-invalid');
                            $('#confirm_password').addClass('is-valid');
                            $('#confirm_passwordError').html('');
                        }
                    } else {
                        $('#old_password').val("");
                        $('#new_password').val("");
                        $('#confirm_password').val("");
                        $('#ModalPassword').modal('hide');
                        toastr.success("Password berhasil diganti");
                        show_data();
                    }
                }
            });
            return false;
        });

        //get data for delete record
        $('#show_data').on('click', '.item_delete', function() {
            var id_user = $(this).data('id_user');

            $('#ModalDelete').modal('show');
            $('[name="id_user_delete"]').val(id_user);
        });

        //delete record to database
        $('#btn_delete').on('click', function() {
            var id_user = $('#id_user_delete').val();
            $.ajax({
                type: "POST",
                url: "<?= site_url('pengguna/delete') ?>",
                dataType: "JSON",
                data: {
                    id_user: id_user
                },
                success: function(data) {
                    $('[name="id_user_delete"]').val("");
                    $('#ModalDelete').modal('hide');
                    toastr.success("Akun Pengguna berhasil diperbarui");
                    show_data();
                }
            });
            return false;
        });
    })
</script>