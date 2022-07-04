<div class="row">
	<div class="col-12 grid-margin">
		<!--<div class="container-fluid">
			        <div class="card">
			            <div class="card-header py-2">
			                <h4>Isi Surat</h4>
			                <?php /**foreach($set_surat as $row_surat){ ?>
			                <div class="card-body">
                                <blockquote>
                                    <h6>
                                            <b>Nomor Surat: </b> <?= $row_surat->nomor_surat;?> <br/>
                                            <b>Asal:</b>  <?= $row_surat->asal_surat_luar;?><br/>
                                            <b>Perihal: </b><?= $row_surat->perihal;?><br/>
                                            <?php $tanggal = date_create($row_surat->tanggal_surat); $tgl = date_format($tanggal,'d-F-Y');?>
                                            <b>Tanggal Surat:</b> <?= $tgl;?>
                                        
                                    </h6>
                                    <?= $row_surat->isi_ringkas;?><br/>
                                    
                                    
                                </blockquote>
                                <hr/>
                                
                                <label>Keterangan:</label><br/>
                                <small>
                                    <b>Jenis Surat:</b><?= $row_surat->nama_jenis;?><br/>
                                    <b>Prioritas Surat:</b><?= $row_surat->nama_prioritas;?><br/>
                                    <b>Sifat Surat:</b><?= $row_surat->nama_sifat;?><br/>
                                    <b>Media Pengiriman:</b><?= $row_surat->nama_media;?>
                                </small>
			                </div>
			                <?php }*/ ?>
			            </div>
			        </div>
			    </div>-->

		<?= $this->session->flashdata('notify'); ?>
		<?= validation_errors(); ?>
		<!-- OVERVIEW -->

		<div class="card">
			<div class="card-header py-3">
				<h4>Inbox Disposisi </h4>
				<p class="card-subtitle">Inbox Internal / Disposisi </p>
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
										<?= anchor('disposisi-eksternal/print/' . $row->id_disposisi_eksternal, '<button class="btn btn-warning p-2"><i class="fa fa-print"></i> Print</button>', array('target', '_BLANK')); ?>
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