<div class="row">
    <div class="col-12 grid-margin">

        <?= $this->session->flashdata('notify'); ?>
        <?= validation_errors(); ?>

        <div class="card">
            <div class="card-header py-3">
                <h4 class="">Kelola Pengaturan</h4>
                <p class="card-subtitle">Admin / Pengaturan / Pengaturan Situs</p>
            </div>
            <div class="card-body">
                <?= form_open_multipart('pengaturan/update', array('id' => 'form')); ?>

                <input type="hidden" name="id_pengaturan" value="<?= $setting->id_pengaturan ?>" />
                <div class="form-group">
                    <label>Site Title <small style="color:red">*required</small></label>
                    <input type="text" name="site_title" class="form-control" value="<?= $setting->site_title ?>">
                </div>
                <div class="form-group">
                    <label>Logo</label><br />
                    <img src="<?= base_url(); ?><?= $setting->site_logo ?>" alt="Logo" width="30%">
                </div>
                <div class="form-group">
                    <label>Nama <small style="color:red">*required</small></label>
                    <input type="text" name="site_nama" class="form-control" value="<?= $setting->site_nama ?>">
                </div>
                <div class="form-group">
                    <label>Alamat <small style="color:red">*optional</small></label>
                    <textarea name="site_alamat" class="form-control"><?= $setting->site_alamat ?></textarea>
                </div>
                <div class="form-group">
                    <label>Unggah Logo</label><br />
                    <label class="file-upload btn btn-secondary p-2">
                        Cari File Logo...<input type="file" name="file_path">
                    </label>
                </div>
                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-primary p-3"><i class="mdi mdi-content-save mdi-18px"></i>Update</button>
                </div>

                <?= form_close(); ?>
                <!--
                        <div class="table-responsive">
							<table class="table" id="data">
							    <thead>
							        <tr>
                                        <th>No.</th>
                                        <th>Title</th>
							            <th>Logo</th>
							            <th>Nama</th>
							            <th>Alamat</th>
							            <th>Opsi</th>
							        </tr>
							    </thead>
							    <tbody>
                                <?php $no = 1;
                                foreach ($set as $row) { ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $row->site_title; ?> </td>
                                        <td><?= $row->site_logo; ?></td>
                                        <td><?= $row->site_nama; ?></td>
                                        <td><?= $row->site_alamat; ?></td>                                   
                                        <td>
                                        <button class="btn btn-warning p-2" onclick="edit_supplier(<?= $row->id_pengaturan; ?>)"><i class="fa fa-edit"></i> Edit</button> 
                                        </td>
							        </tr>
							         <?php } ?>   
							        
							    </tbody>
							</table>
                            </div>
                                -->
            </div>
        </div>

        <!-- Container Hack -->
        <div style="min-width: 1336px !important">
        </div>
        <!-- -->
    </div>
</div>

<!--<script>
        function edit_supplier(id) {
            save_method = 'update';
            $('#form')[0].reset(); // reset form on modals

            //Ajax Load data from ajax
            $.ajax({
                url: "<?= base_url('pengaturan/get') ?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('[name="id_pengaturan"]').val(data.id_pengaturan);
                    $('[name="site_title"]').val(data.site_title);
                    $('[name="site_nama"]').val(data.site_nama);
                    $('[name="site_alamat"]').val(data.site_alamat);
                    $('#myModal').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Edit Pengaturan'); // Set title to Bootstrap modal title
                    $('[name=submit]').val('Edit').show();
                    $('.modal-footer').show();
                    $('#form').attr({
                        'action': '<?= site_url('pengaturan/update'); ?>',
                        'enctype': 'multipart/form-data'
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax' + jqXHR);
                }
            });
        }
    </script>

    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
          
            <div class="modal-content">
                <?= form_open('pengaturan/update', array('id' => 'form')); ?>
                <div class="modal-header py-3">
                    <h4 class="modal-title">Pengaturan</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_pengaturan" />
                    <div class="form-group">
                        <label>Site Title</label>
                        <input type="text" name="site_title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Logo</label><br />
                        <img src="<?= base_url(); ?><?= $setting->site_logo ?>" alt="Logo" width="40%">
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="site_nama" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Alamat <small style="color:red">*optional</small></label>
                        <textarea name="site_alamat" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Unggah Berkas</label><br />
                        <label class="file-upload btn btn-primary p-2">
                            Cari Berkas...<input type="file" name="file_path">
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="submit" value="Tambah" class="btn btn-success p-3">
                </div>
                <?= form_close(); ?>
            </div>

        </div>
    </div> -->