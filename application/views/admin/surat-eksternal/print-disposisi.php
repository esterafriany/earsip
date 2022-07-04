<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Disposisi</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css');?>">
    <style>
        #wrapper {
            width:600px;
            margin:auto;
        }
    </style>
</head>

<body>
  <div id="wrapper">
   <center>
       <img src="<?= base_url();?><?=$setting->site_logo?>" alt="Logo" width="40%">
       <h2>LEMBAR DISPOSISI</h2>
       <h4>
       <?=$setting->site_nama?><br/>
           <small>
           <?=$setting->site_alamat?>
           </small>
       </h4>
   
   </center>
   <hr/>
    <label>Surat:</label>
    <?php foreach($set_surat as $row_surat){ ?>
    <?php $tanggal = date_create($row_surat->tanggal_surat); $tgl = date_format($tanggal,'d-F-Y');?>
    
            <table class="table table-sm">
                <tr>
                    <td>Nomor Surat</td>
                    <td>:</td>
                    <td><?= $row_surat->nomor_surat;?> </td>
                </tr>
                 <tr>
                    <td>Tanggal Surat</td>
                    <td>:</td>
                    <td><?= $tgl;?></td>
                </tr>
                <tr>
                    <td>Asal Surat</td>
                    <td>:</td>
                    <td><?= $row_surat->asal_surat_luar;?></td>
                </tr>
                 <tr>
                    <td>Perihal</td>
                    <td>:</td>
                    <td><?= $row_surat->perihal;?></td>
                </tr>
                <tr>
                    <td>Jenis Surat</td>
                    <td>:</td>
                    <td><?= $row_surat->nama_jenis;?></td>
                </tr>
                <tr>
                    <td>Prioritas Surat</td>
                    <td>:</td>
                    <td><?= $row_surat->nama_prioritas;?></td>
                </tr>
                <tr>
                    <td>Sifat Surat</td>
                    <td>:</td>
                    <td><?= $row_surat->nama_sifat;?></td>
                </tr>
                <tr>
                    <td>Media Pengiriman</td>
                    <td>:</td>
                    <td><?= $row_surat->nama_media;?></td>
                </tr>
            </table>

             <?php } ?>
    <label>Disposisi:</label>
    <?php foreach($set as $row) { ?>
       <?php $tanggal = date_create($row->tanggal_disposisi); $tgl_disposisi = date_format($tanggal,'d-F-Y');?>
        <table>
            
            <tr>
                <td>Tanggal Disposisi</td>
                <td>:</td>
                <td><?= $tgl_disposisi;?></td>
            </tr>
            <tr>
                <td>Diteruskan Kepada</td>
                <td>:</td>
                <td><?= $row->nama_pegawai;?></td>
            </tr>
            <tr>
                <td>Penyelesaian</td>
                <td>:</td>
                <td><?= $row->nama_perintah;?></td>
            </tr>
        </table>
<br/>
    <label>Isi Disposisi:</label>
    <p><?= $row->isi_disposisi;?></p>
    </div>
     <?php } ?>
    <script>
		window.print();
	</script>
</body>
</html>

