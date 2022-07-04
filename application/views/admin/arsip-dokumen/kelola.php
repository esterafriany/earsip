<div class="row">
    <div class="col-12 grid-margin">
        <?= $this->session->flashdata('notify'); ?>
        <?= validation_errors(); ?>
        <!-- OVERVIEW -->
        <a href="#" class="act-btn" onclick="add_dokumen() ">+</a>
        <div class="card">
            <div class="card-header py-3">
                <h4 class="">Kelola Arsip Dokumen</h4>
                <p class="card-subtitle">Admin / Arsip Dokumen</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
            
                <table id="table" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Perihal</th>
                            <th>Jenis Dokumen</th>
                            <th>Nomor Dokumen</th>
                            <th>Tanggal</th>
                            <th>User Upload</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <thead class="filters">
                    <tr>
                        <td>No.</td>
                        <td>Perihal</td>
                        <td>Jenis Dokumen</td>
                        <td>Nomor Dokumen</td>
                        <td>Tanggal</td>
                        <td>User Upload</td>
                        <td>Opsi</td>
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
<div class="modal fade bd-example-modal-lg" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Arsip Dokumen</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body form">
                <div class="row">
                    <div class="col-sm-6">
                    <ul class="list-group">
                        <li class="list-group-item">
                        <form id="form" class="form-horizontal needs-validation"?>
	                        <input type="hidden" value="" name="id_dokumen" id="id_dokumen"/>
                            <div class="form-group">
                                <label><b>Jenis Dokumen</b></label>
                                <select name="id_jenis" id="id_jenis" class="form-control">
                                    <option value="" disabled selected hidden>Pilihan</option>
                                    <?php foreach ($set_jenis as $row_jenis) { ?>
                                        <option value="<?= $row_jenis->id_jenis; ?>">
                                            <?= $row_jenis->nama_jenis; ?>
                                        </option>
                                    <?php } ?>
                                </select>

                                <div class="invalid-feedback">
                                    <span id="id_jenisError"></span>
                                </div>
                            </div>
                            <div class="form-group" id="div_nomor_dokumen">
                                <label><b>Nomor Dokumen</b></label>
                                <input type="text" name="nomor_dokumen" id="nomor_dokumen" class="form-control form-control-lg">
                                <div class="invalid-feedback">
                                    <span id="nomor_dokumenError"></span>
                                </div>
                            </div>
                            <div class="form-group" id="div_tanggal_dokumen">
                                <label><b>Tanggal Dokumen</b></label>
                                <input type="date" name="tanggal_dokumen" id="tanggal_dokumen" class="form-control form-control-lg">
                                <div class="invalid-feedback">
                                    <span id="tanggal_dokumenError"></span>
                                </div>
                            </div>
                            <div class="form-group" id="div_nama_dokumen">
                                <label><b>Perihal</b></label>
                                <input type="text" name="nama_dokumen" id="nama_dokumen"class="form-control form-control-lg">
                                <div class="invalid-feedback">
                                    <span id="nama_dokumenError"></span>
                                </div>
                            </div>
                            <div class="form-group" id="div_id_sifat">
                                <label><b>Sifat Dokumen</b></label>
                                <select name="id_sifat" id="id_sifat" class="form-control">
                                    <option value="" disabled selected hidden>Pilihan</option>
                                    <?php foreach ($set_sifat as $row_sifat) { ?>
                                        <option value="<?= $row_sifat->id_sifat; ?>">
                                            <?= $row_sifat->nama_sifat; ?>
                                        </option>
                                    <?php } ?>
                                </select>

                                <div class="invalid-feedback">
                                    <span id="id_jenisError"></span>
                                </div>
                            </div>
                            <div class="form-group" id="div_dari">
                                <label><b>Dari</b></label>
                                <input type="text" name="dari" id="dari"class="form-control form-control-lg">
                                <div class="invalid-feedback">
                                    <span id="dariError"></span>
                                </div>
                            </div>
                            <div class="form-group" id="div_tujuan">
                                <label><b>Tujuan</b></label>
                                <input type="text" name="tujuan" id="tujuan"class="form-control form-control-lg">
                                <div class="invalid-feedback">
                                    <span id="tujuanError"></span>
                                </div>
                            </div>
                        </li>
                    </ul>
                    </div>

                    <div class="col-sm-6">
                    <ul class="list-group">
                       <li class="list-group-item">
                            <div class="form-group" id="div_nomor_disposisi">
                                <label><b>Nomor Disposisi</b></label>
                                <input type="text" name="nomor_disposisi" id="nomor_disposisi" class="form-control form-control-lg">
                                <div class="invalid-feedback">
                                    <span id="nomor_disposisiError"></span>
                                </div>
                            </div>
                            <div class="form-group" id="div_pihak" style="display:none">
                                <label><b>Pihak</b></label>
                                <div id="pihakList" name="pihakList">
                                    
                                </div><br/>
                                <div style="text-align:right;">
                                    <button type="button" class="btn btn-outline-primary btn-xs" id="add-more-pihak">Tambah </button>
                                </div>
                            </div>
                            <input type="hidden" name="list_pihak" id="list_pihak" class="form-control">
                            <div class="form-group">
                                <label><b>Owner</b></label> 
                                <div id="pemilikDokumenList" name="pemilikDokumenList">
                                    
                                </div>
                                <br/>
                                <div style="text-align:right;">
                                    <button type="button" class="btn btn-outline-primary btn-xs" id="add-more-pemilik">Tambah </button>
                                </div>
                            </div>
                            <input type="hidden" name="list_unit_kerja" id="list_unit_kerja" class="form-control">
                            
                            <div class="form-group">
                                <label><b>Keterangan</b> <small style="color:red">*optional</small></label>
                                <textarea name="keterangan" class="form-control"></textarea>
                            </div>

                            <div class="form-group">
                                <label id="title" name="title"><b>Replace Dokumen</b></label>
                                
                                <input type="file" name="file_path" class="form-control-file">
                                <div class="invalid-feedback">
                                    <span id="file_pathError"></span>
                                </div>

                                <p id="file_update"></p>
                                <!-- <div class="form-group">
                                    <div id="DokumenList" name="DokumenList">

                                    </div>
                                    <div class="invalid-feedback">
                                        <span id="file_pathError"></span>
                                    </div>
                                    <div style="text-align:center;">
                                        <button type="button" class="btn btn-outline-primary btn-xs" id="add-more-file">Tambah </button>
                                    </div>
                                </div> -->
                            </div> 
                        </li> 
                    </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary p-3" data-dismiss="modal">Tutup</button>
                <button type="button" id="btnSave" onClick="save()" class="btn btn-primary p-3">Simpan</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal_view" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Lihat Arsip Dokumen</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group" hidden>
                            <label>ID Dokumen:</label>
                            <p id="id_dokumen"></p>
                        </div>
                        <div class="form-group">
                            <label><strong>Jenis Dokumen:</strong></label>
                            <p id="nama_jenis"></p>
                        </div>
                        <div class="form-group">
                            <label><strong>Nomor Dokumen:</strong></label>
                            <p id="nomor_dokumen_view"></p>
                        </div>
                        <div class="form-group">
                            <label ><strong>Perihal:</strong></label>
                            <p id="perihal"></p>
                        </div>
                        <div class="form-group">
                            <label><strong>Tanggal Dokumen:</strong></label>
                            <p id="tanggal_dokumen_view"></p>
                        </div>
                        <div class="form-group">
                            <label><strong>Sifat Dokumen:</strong></label>
                            <p id="nama_sifat_view"></p>
                        </div>
                        <div class="form-group" id="div_dari_view">
                            <label><strong>Dari:</strong></label>
                            <p id="dari_view"></p>
                        </div>
                        <div class="form-group" id="div_tujuan_view">
                            <label><strong>Tujuan:</strong></label>
                            <p id="tujuan_view"></p>
                        </div>
                        <div class="form-group" id="div_nomor_disposisi_view">
                            <label><strong>Nomor Disposisi:</strong></label>
                            <p id="nomor_disposisi_view"></p>
                        </div>
                        <div class="form-group" id="div_keterangan_view">
                            <label><strong>Keterangan:</strong></label>
                            <p id="keterangan_view"></p>
                        </div>
                        <div class="form-group" id="div_pihak_view">
                            <label><strong>Pihak:</strong></label>
                            <div id="pihakDokumenList_View">
                            </div>
                        </div>
                        <div class="form-group" id="div_pemilik_dokumen_view">
                            <label><strong>Pemilik Dokumen:</strong></label>
                            <div id="pemilikDokumenList_view">
                            </div>
                        </div>
                        <div class="form-group">
                            <label><strong>File:</strong></label>
                            <p id="file"></p>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6><strong>File Preview:</strong></h6>
                        <div id="viewer"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12" style="align:right;">
                <p style="font-size: x-small;">
                    Uploaded by: <text id="created_by">-</text> at <text id="created_at">-</text>|
                    Last Updated by: <text id="updated_by">-</text> at <text id="updated_at">-</text>
                </p>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<script type="text/javascript">
    var save_method; //for save method string
    var table;
    var table_test;
    var i = 0;
    $(document).ready(function() {


     
        // $(function(){
        //     $('#table tfoot th').each(function(){
        //         var title = $(this).text();
        //         $(this).html('<input type="text" placeholder="Cari ' + title + '" />');
            
        //     });
        //     table = $('#table').DataTable();

        //     table.columns().every( function () {
        //         var that = this;
        //         $('input', this.footer()).on('keyup change', function(){
        //             if(that.search() !== this.value){
        //                 that.search(this.value).draw();
        //             }
        //         });
        //     });    
        // });
        // Setup - add a text input to each footer cell
        $('#table .filters td').each( function () {
            var title = $('#table thead th').eq( $(this).index() ).text();
            $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
        } );
 
        table = $('#table').DataTable({ 
			scrollCollapse: true,
			scroller:       true,
			serverMethod: 'post',
			order: [[2, 'asc']],
            searching: true,
            deferRender: true,
            lengthMenu: [
                [5, 10, 20, -1],
                [5, 10, 20, "All"]
            ],
            processing: true, //Feature control the processing indicator.
            serverSide: true, //Feature control DataTables' server-side processing mode.
			iDisplayLength: 10,
			language: {
				emptyTable: "Belum ada Arsip.",
				zeroRecords: "Tidak ada Data Arsip ditemukan.",
			},
            // Load data for the table's content from an Ajax source
            ajax: {
                "url": "<?= site_url('arsip_dokumen/dokumen_list') ?>",
                "type": "GET",

                'data': function(data) {
                    console.log(data);
                },
            },
            
            //Set column definition initialisation properties.
            columnDefs: [{
                "targets": [0,1,2,-1], //last column
                
                "orderable": false, //set not orderable
                "searching": true, //set not orderable
            }, ],
        });


    // Apply the search
    table.columns().eq( 0 ).each( function ( colIdx ) {
        $( 'input', $('.filters td')[colIdx] ).on( 'keyup change', function () {
            table
                .column( colIdx )
                .search( this.value )
                .draw();
        } );
    } );

    
        $.ajax({
			url : "<?=site_url('unit_kerja/get_unit_kerja_list')?>/",
			type: "GET",
			dataType: "JSON",
			success: function(result)
			{
				var penampung = "";
				var penampung2 = "";
				var option_unit_kerja = "";
				var count1 = result.length;

                penampung += `<table width="110%">
									<tr>
										<td>
											<select class="form-control" name="unit_kerja[]" id="unit_kerja">
                                                <option value="0" disabled selected hidden>Pilihan</option>`;
                                                for(i = 0; i < count1; i++){
                                                    option_unit_kerja += `<option value="${result[i]['id_unit']}">${result[i]['nama_unit']}</option>`;
                                                }

                                                penampung += option_unit_kerja + 
                                                `</select>
                                        </td>
                                        <td>
                                            <button type="button" id="add-more-pemilik" class="btn btn-outline-danger btn-xs remove1" name="remove1" >Hapus</button>
                                        </td>
                                    </tr>
                                </table>`;
				document.getElementById("pemilikDokumenList").innerHTML = penampung;
                
                penampung2 += `<table width="120%">
									<tr>
										<td>
                                            <input type="text" name="pihak[]" id="pihak" class="form-control form-control-lg">
					
                                        </td>
                                        <td>
                                            <button type="button" id="add-more-pihak" class="btn btn-outline-danger btn-xs removes" name="removes" >Hapus</button>
                                        </td>
                                    </tr>
                                </table>`;
				document.getElementById("pihakList").innerHTML = penampung2;
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				console.log(jqXHR);
				alert('Data tidak ditemukan.');
			}
		});

        $("#add-more-pemilik").click(function () {
			var list_unit_kerja = get_list_unit_kerja();
			var option_unit_kerja = "";
			var count = list_unit_kerja.length;
            
			for( var j = 0; j < count; j++){
				option_unit_kerja += `<option value="${list_unit_kerja[j]['id_unit']}">${list_unit_kerja[j]['nama_unit']}</option>`;
			}
			$("#pemilikDokumenList").last().append(
                        `<table width="110%">
							<tr>
								<td>
									<select class="form-control" name="unit_kerja[]" id="unit_kerja">
										<option value="" disabled selected hidden >Pilihan</option>
										`+  option_unit_kerja +`
									</select>	
								</td>
								<td>
									<button type="button" id="" class="btn btn-outline-danger btn-xs remove1" name="remove1" >Hapus</button>
								</td>
							</tr>
						</table>`);
		});


        $("#add-more-pihak").click(function () {
            $("#pihakList").last().append(
                `<table width="120%">
                    <tr>
                        <td>
                            <input type="text" name="pihak[]" id="pihak" class="form-control form-control-lg">
                        </td>
                        <td>
                            <button type="button" id="add-more-pihak" class="btn btn-outline-danger btn-xs removes" name="removes" >Hapus</button>
                        </td>
                    </tr>
                </table>`);
		});

        $(document).on('click', '.remove1', function () {
			$(this).parents('tr').remove();
		});

        $(document).on('click', '.removes', function () {
			$(this).parents('tr').remove();
		});

        $('#id_jenis').change(function(){
            var pilih = $(this).val();
            if(pilih == 1){
                $('#div_nomor_disposisi').show();

                document.getElementById("div_pihak").style.display= "none";
            }else if(pilih == 2 || pilih == 3 || pilih == 4 || pilih == 5 || pilih == 6 || pilih == 7 || pilih == 8 || pilih == 11 ){
                $('#div_dari').show();
                $('#div_tujuan').show();

                document.getElementById("div_nomor_disposisi").style.display= "none";
                document.getElementById("div_pihak").style.display= "none";
            }else if(pilih == 9 || pilih == 10){
                $('#div_pihak').show();
                
                document.getElementById("div_nomor_disposisi").style.display= "none";
                document.getElementById("div_tujuan").style.display= "none";
                document.getElementById("div_dari").style.display= "none";
            }
        });
    });

    function add_dokumen() {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $(".select2").val(null).trigger("change");
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Arsip Dokumen'); // Set Title to Bootstrap modal title
        $('#form').attr({
            'enctype': 'multipart/form-data'
        });
        $('#btnSave').text('Simpan');
        $('#title').html('<b>Unggah Dokumen</b>');

        $('#pemilikDokumenList').empty();
        $('#pihakList').empty();
        $('#file_update').empty();

        $('[name="nama_dokumen').removeClass('is-invalid');
        $('[name="nama_dokumen').removeClass('is-valid');
        $('#nama_dokumenError').html('');
        $('[name="nomor_dokumen').removeClass('is-invalid');
        $('[name="nomor_dokumen').removeClass('is-valid');
        $('#nomor_dokumenError').html('');
        $('[name="keterangan"]').removeClass('is-invalid');
        $('[name="keterangan"]').removeClass('is-valid');
        $('#keteranganError').html('');
    
    }

    function update_dokumen(id){
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        //Ajax Load data from ajax
        $.ajax({
            url: "<?= site_url('arsip_dokumen/dokumen_view/') ?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                var list_unit_kerja = get_list_unit_kerja();
                var option_unit_kerja = "";
                var penampung = "";
                
                var count = list_unit_kerja.length;
				var count2 = data['list_owner'].length;
                
                for(i = 0; i < count2; i++){
                    for( var j = 0; j < count; j++){
                        if(data['list_owner'][i]['id_unit_kerja'] == list_unit_kerja[j]['id_unit']){
                            option_unit_kerja += `<option value="${list_unit_kerja[j]['id_unit']}" selected>${list_unit_kerja[j]['nama_unit']}</option>`;
                        }else{
                            option_unit_kerja += `<option value="${list_unit_kerja[j]['id_unit']}">${list_unit_kerja[j]['nama_unit']}</option>`;
                        }
                    }
                    
					penampung += `
                            <table width="110%">
                                <tr>
                                    <td>
                                        <select class="form-control" name="unit_kerja[]" id="unit_kerja">
                                            <option value="" disabled selected hidden >Pilihan</option>
                                            `+  option_unit_kerja +`
                                        </select>	
                                    </td>
                                    <td>
                                        <button type="button" id="" class="btn btn-outline-danger btn-xs remove1" name="remove1" >Hapus</button>
                                    </td>
                                </tr>
                            </table>`;
                            option_unit_kerja="";
                }
				document.getElementById("pemilikDokumenList").innerHTML = penampung;

                //pihak dokumen
                var list_pihak = get_list_pihak(data['data'].id_dokumen);
                
                var penampung2 = "";
                var k =0;
                for(k = 0; k < list_pihak.length; k++){
                    penampung2 += 
                                `<table width="120%">
									<tr>
										<td>
                                            <input type="text" name="pihak[]" id="pihak" value="${list_pihak[k]['pihak']}" class="form-control form-control-lg">
					
                                        </td>
                                        <td>
                                            <button type="button" id="add-more-pihak" class="btn btn-outline-danger btn-xs removes" name="removes" >Hapus</button>
                                        </td>
                                    </tr>
                                </table>`;
                }
				document.getElementById("pihakList").innerHTML = penampung2;

                $('#id_dokumen').val(data['data'].id_dokumen);
                $('#id_jenis').val(data['data'].id_jenis);
                $('#nomor_dokumen').val(data['data'].nomor_dokumen);
                $('#nama_dokumen').val(data['data'].nama_dokumen);
                $('#tanggal_dokumen').val(data['data'].tanggal_dokumen);
                $('#keterangan').val(data['data'].keterangan);

                $('#dari').val(data['data'].dari);
                $('#tujuan').val(data['data'].tujuan);
                $('#id_sifat').val(data['data'].id_sifat);
                $('#nomor_disposisi').val(data['data'].nomor_disposisi);
                
                $('#file_update').html('<br/><a href="<?= base_url() ?>' + data['data'].file_path + '"><i class="fa fa-download fa-lg"></i> Lihat Dokumen</a>');
                $('#title').html('<b>Replace Dokumen</b>');


                var pilih = data['data'].id_jenis; 
                if(pilih == 1){
                    $('#div_nomor_disposisi').show();

                    document.getElementById("div_pihak").style.display= "none";
                }else if(pilih == 2 || pilih == 3 || pilih == 4 || pilih == 5 || pilih == 6 || pilih == 7 || pilih == 8 || pilih == 11 ){
                    $('#div_dari').show();
                    $('#div_tujuan').show();
                    $('#div_pemilik_dokumen').show();

                    document.getElementById("div_nomor_disposisi").style.display= "none";
                    document.getElementById("div_pihak").style.display= "none";
                    

                }else if(pilih == 9 || pilih == 10){
                    $('#div_pihak').show();
                    
                    document.getElementById("div_nomor_disposisi").style.display= "none";
                    document.getElementById("div_tujuan").style.display= "none";
                    document.getElementById("div_dari").style.display= "none";
                }

                $('#btnSave').html('Update');
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Ubah Arsip Dokumen'); // Set title to Bootstrap modal title

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function view_dokumen(id) {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        //Ajax Load data from ajax
        $.ajax({
            url: "<?= site_url('arsip_dokumen/dokumen_view/') ?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#id_dokumen').html(data['data'].id_dokumen);
                $('#perihal').html(data['data'].nama_dokumen);
                $('#nama_jenis').html(data['data'].nama_jenis);
                $('#nomor_dokumen_view').html(data['data'].nomor_dokumen);
                $('#tanggal_dokumen_view').html(data['data'].tanggal_dokumen);
                $('#nama_sifat_view').html(data['data'].nama_sifat);
                $('#dari_view').html(data['data'].dari);
                $('#tujuan_view').html(data['data'].tujuan);
                $('#nomor_disposisi_view').html(data['data'].nomor_disposisi);
                $('#keterangan_view').html(data['data'].keterangan);
                  
                $('#created_by').html(data['data'].created_by_name);
                $('#created_at').html(data['data'].created_at);

                data['data'].updated_by == 0 ? $('#updated_by').html('-') : $('#updated_by').html(data['data'].updated_by);
                data['data'].updated_at == "NULL" ? $('#updated_at').html('-') : $('#updated_at').html(data['data'].updated_at);
               
                //pemilik dokumen
                var i  = 0;
                var num  = 1;
                var penampung = "";
                penampung += '<p>';
                for(i = 0; i < data['list_owner'].length; i++){
                    penampung += `${num}. ${data['list_owner'][i]['nama_unit']}<br/>`;
                    num+= 1;
                }
                penampung += '</p>';
				document.getElementById("pemilikDokumenList_view").innerHTML = penampung;

                //pihak dokumen
                i  = 0;
                num  = 1;
                penampung = "";
                penampung += '<p>';
                for(i = 0; i < data['list_pihak'].length; i++){
                    penampung += `${num}. ${data['list_pihak'][i]['pihak']}<br/>`;
                    num+= 1;
                }
                penampung += '</p>';
				document.getElementById("pihakDokumenList_View").innerHTML = penampung;

                $('#file_name').html(data['data'].file_name);
                $('#file_path').html(data['data'].file_path);
                $('#file').html('<a href="<?= base_url() ?>' + data['data'].file_path + '"><i class="fa fa-download fa-lg"></i> Download</a>');
                var extension = data['data'].file_name.split('/').pop().split('.')[1].toLowerCase();
               
                //test
                if (extension == "pdf") {
                    $('#viewer').html('<iframe id="pdf-js-viewer" src="<?= base_url('/assets/js/pdfjs/web/viewer.html?file=') ?><?= base_url() ?>' + data['data'].file_path + '" title="webviewer" width="100%" frameborder="0" scrolling="yes" style="display:block; width:100%; height:80vh;"></iframe>');
                } else if (extension == "jpg" || extension == "jpeg" || extension == "png" || extension == "bmp" || extension == "gif" || extension == "tiff" || extension == "svg") {
                    $('#viewer').html('<img src="<?= base_url(); ?>' + data['data'].file_path + '" class="img-fluid" alt="' + data['data'].file_path + '" width="100%" />');
                } else {
                    $('#viewer').html('<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> Tidak ada preview</p>');
                }

                //hide and unhide
                var pilih = data['data'].id_jenis; 
                if(pilih == 1){
                    $('#div_nomor_disposisi_view').show();

                    document.getElementById("div_pihak_view").style.display= "none";
                }else if(pilih == 2 || pilih == 3 || pilih == 4 || pilih == 5 || pilih == 6 || pilih == 7 || pilih == 8 || pilih == 11 ){
                    $('#div_dari_view').show();
                    $('#div_tujuan_view').show();
                    $('#div_pemilik_dokumen_view').show();

                    document.getElementById("div_nomor_disposisi_view").style.display= "none";
                    document.getElementById("div_pihak_view").style.display= "none";
                    

                }else if(pilih == 9 || pilih == 10){
                    $('#div_pihak_view').show();
                    
                    document.getElementById("div_nomor_disposisi_view").style.display= "none";
                    document.getElementById("div_tujuan_view").style.display= "none";
                    document.getElementById("div_dari_view").style.display= "none";
                }

                $('#modal_view').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Lihat Arsip Dokumen'); // Set title to Bootstrap modal title

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function get_list_unit_kerja(){
		var a;
		$.ajax({
			url : "<?=site_url('unit_kerja/get_unit_kerja_list')?>",
			type: "GET",
			dataType: "json",
			async: false,
			success: function(data)
			{
				a = data;
			}
		});
		return a;
	}

    function get_list_pihak(id){
		var a;

		$.ajax({
			url : "<?=site_url('unit_kerja/get_pihak_list/')?>" + id,
			type: "GET",
			dataType: "json",
			async: false,
			success: function(data)
			{
				a = data;
			}
		});
		return a;
	}

    function reload_table() {
        table.ajax.reload(null, false); //reload datatable ajax 
    }

    function save() {
        var url;
        if (save_method == 'add') {
            url = "<?= site_url('arsip_dokumen/dokumen_add') ?>";
        } else {
            url = "<?= site_url('arsip_dokumen/dokumen_update') ?>";
        }

        // Get form
        var form = $('#form')[0];

        // Create an FormData object 
        var input = document.getElementsByName('unit_kerja[]');
        var arr_unit_kerja = [];
        var penampung = "";
        for (var i = 0; i < input.length; i++) {
            var a = input[i];
            arr_unit_kerja[i] = a.value;
            if(i == input.length - 1){
                penampung = penampung + a.value;	
            }else{
                penampung = penampung + a.value + "#";	
            }	
        }

        var input2 = document.getElementsByName('pihak[]');
        var arr_pihak = [];
        var penampung2 = "";
        for (var j = 0; j < input2.length; j++) {
            var a = input2[j];
            arr_pihak[j] = a.value;
            if(j == input2.length - 1){
                penampung2 = penampung2 + a.value;	
            }else{
                penampung2 = penampung2 + a.value + "#";	
            }	
        }

        document.getElementById('list_pihak').value = penampung2;
        document.getElementById('list_unit_kerja').value = penampung;
        // form.append('unit_kerja', penampung);
        // form.append('pihak', penampung2);
        var data = new FormData(form);

        // ajax adding data to database
        $.ajax({
            url: url,
            type: "POST",
            enctype: 'multipart/form-data',
            data: data,
            processData: false,
            contentType: false,
            //cache: false,
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
                console.log(data);
                if (data.response == 'error' || data.error) {
                    $('#modal_form').modal('show');
                    toastr.error("Semua inputan wajib di isi!");
                   
                    // if (data.nama_dokumenError != '') {
                    //     $('[name="nama_dokumen"]').addClass('is-invalid');
                    //     $('#nama_dokumenError').html(data.nama_dokumenError);
                    // } else {
                    //     $('[name="id_jenis').removeClass('is-invalid');
                    //     $('[name="id_jenis').addClass('is-valid');
                    //     $('#id_jenisError').html('');
                    // }
                    
                    // if (data.tanggal_dokumenError != '') {
                    //     $('[name="tanggal_dokumen"]').addClass('is-invalid');
                    //     $('#tanggal_dokumenError').html(data.tanggal_dokumenError);
                    // } else {
                    //     $('[name="tanggal_dokumen"]').removeClass('is-invalid');
                    //     $('[name="tanggal_dokumen"]').addClass('is-valid');
                    //     $('#tanggal_dokumenError').html('');
                    // }

                    // if (data.file_pathError != '') {
                    //     $('[name="file_path"]').addClass('is-invalid');
                    //     $('#file_pathError').html(data.file_pathError);
                    // } else {
                    //     $('[name="file_path"]').removeClass('is-invalid');
                    //     $('[name="file_path"]').addClass('is-valid');
                    //     $('#file_pathError').html('');
                    // }

                    // if (data.dariError != '') {
                    //     $('[name="dari"]').addClass('is-invalid');
                    //     $('#dariError').html(data.dariError);
                    // } else {
                    //     $('[name="dari').removeClass('is-invalid');
                    //     $('[name="dari').addClass('is-valid');
                    //     $('#dariError').html('');
                    // }

                    // if (data.tujuanError != '') {
                    //     $('[name="tujuan"]').addClass('is-invalid');
                    //     $('#tujuanError').html(data.tujuanError);
                    // } else {
                    //     $('[name="tujuan').removeClass('is-invalid');
                    //     $('[name="tujuan').addClass('is-valid');
                    //     $('#tujuanError').html('');
                    // }
                } else {
                    //if success close modal and reload ajax table
                    $('#modal_form').modal('hide');
                    table.ajax.reload(); //reload datatable ajax 

                    //reload_table();
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

    function delete_dokumen(id) {
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
                    url: "<?= site_url('arsip_dokumen/dokumen_delete') ?>/" + id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        console.log(data);
                        Swal.fire(
                                'Deleted!',
                                'Data Anda telah dihapus',
                                'success'
                            );
                            reload_table();
                        // if (data.response == 'error' || data.error) {
                        //     Swal.fire(
                        //         'Error!',
                        //         'Media Surat sedang digunakan',
                        //         'error'
                        //     );
                        //     toastr.error("Media Surat sedang digunakan");
                        // } else {
                        //     //if success reload ajax table
                        //     $('#modal_form').modal('hide');
                        //     reload_table();
                        //     Swal.fire(
                        //         'Deleted!',
                        //         'Data Anda telah dihapus',
                        //         'success'
                        //     );
                        // }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error delete data');
                    }
                });
            }
        })
    }
</script>