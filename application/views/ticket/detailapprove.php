<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Detail Tiket <?php echo $detail['id_ticket']?></h1>
	</div><hr>

	<div class="flash-data" data-flashdata="<?php echo $this->session->flashdata('status')?>"></div>
	
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-gray-800">
				<?php echo " Tiket Dari ".$detail['nama']." (" .$detail['tanggal'].")" ?>
			</h6>
		</div>
		<div class="card-body">
			<div style="text-align: center">
				<?php if (pathinfo($detail['filefoto'], PATHINFO_EXTENSION) == 'pdf'){?>
					<a href="<?php echo base_url('uploads/'.$detail['filefoto']) ?>" class="btn btn-light btn-icon-split">
						<span class="icon text-gray-600">
							<i class="fas fa-file-pdf"></i>
						</span>
						<span class="text"><?php echo $detail['filefoto'] ?></span>
					</a><br>
					Klik untuk Mengunduh
				<?php } else {?>
					<a data-fancybox="gallery"  href="<?php echo base_url('uploads/'.$detail['filefoto']) ?>">
						<img src="<?php echo base_url('uploads/'.$detail['filefoto']) ?>" style="width:100%;max-width:300px">
					</a><br>
					Klik untuk Perbesar
				<?php }?>
			</div><hr>
			<h6 class="m-0 font-weight-bold text-primary">Departmen</h6>
			<div class="font-weight-bold">
				<?php echo $detail['nama_dept']." (".$detail['nama_bagian_dept'].")" ?><p></p>
			</div><hr>
			<h6 class="m-0 font-weight-bold text-primary">Jabatan</h6>
			<div class="font-weight-bold">
				<?php echo $detail['nama_jabatan'] ?><br>
			</div><hr>
			<h6 class="m-0 font-weight-bold text-primary">Kategori</h6>
			<div class="font-weight-bold">
				<?php echo $detail['nama_kategori']." (".$detail['nama_sub_kategori'].")" ?><p></p>
			</div><hr>
			<h6 class="m-0 font-weight-bold text-primary">Email</h6>
			<div class="font-weight-bold">
				<?php echo $detail['email'] ?><p></p>
			</div><hr>
			<h6 class="m-0 font-weight-bold text-primary">Lokasi</h6>
			<div class="font-weight-bold">
				<?php echo $detail['lokasi'] ?><p></p>
			</div><hr>
			<h6 class="m-0 font-weight-bold text-primary">Subyek</h6>
			<div class="font-weight-bold">
				<?php echo $detail['problem_summary'] ?><p></p>
			</div><hr>
			<h6 class="m-0 font-weight-bold text-primary">Deskripsi</h6>
			<div class="font-weight-bold">
				<?php echo nl2br($detail['problem_detail']) ?><p></p>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-6 mb-4">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">Pelacakan Sistem</h6>
				</div>
				<div class="card-body" style="overflow-x: scroll; height: 320px;">
					<?php $no = 1; foreach ($tracking as $row){?>
						<div class="tracking-item">
							<div class="tracking-icon status-intransit text-primary" data-icon="circle">
								<?php echo $no?>
							</div>
							<div class="tracking-date">
								<div class="font-weight-bold"><?php echo $row->tanggal?></div>
							</div>
							<div class="tracking-content">
								<div class="font-weight-bold text-primary"><?php echo $row->status?></div>
								<h4 class="small font-weight-bold">By: <?php echo $row->nama?></h4>
								<?php if($row->filefoto!="")
						        	{?>
						        		<?php if (pathinfo($row->filefoto, PATHINFO_EXTENSION) == 'pdf'){?>
						        			<p><?php echo nl2br($row->deskripsi)?></p>
						        			<a href="<?php echo base_url('teknisi/'.$row->filefoto) ?>" class="btn btn-light btn-icon-split">
						        				<span class="icon text-gray-600">
						        					<i class="fas fa-file-pdf"></i>
						        				</span>
						        				<span class="text"><?php echo $row->filefoto ?></span>
						        			</a>
						        		<?php } else {?>
						        			<p><?php echo nl2br($row->deskripsi)?></p>
						        			<a data-fancybox="gallery"  href="<?php echo base_url('teknisi/'.$row->filefoto) ?>">
						        				<img src="<?php echo base_url('teknisi/'.$row->filefoto) ?>" style="width:100%;max-width:300px">
						        			</a><br>
						        			Klik untuk perbesar
						        		<?php }?>
						        	<?php } else {
						        		echo nl2br($row->deskripsi);
						        	}?>
							</div>
						</div>
					<?php $no++;}?>
				</div>
			</div>
		</div>
		<div class="col-lg-6 mb-4">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">
						<?php echo " Di Proses Oleh ".$detail['nama_teknisi'] ?></h6>
				</div>
				<div class="card-body">
					<h6 class="font-weight-bold text-primary">Kemajuan <span class="float-right text-primary"><?php echo $detail['progress'] ?>%</span></h6>
					<div class="progress mb-4">
						<div class="progress-bar" role="progressbar" style="width: <?php echo $detail['progress'] ?>%" aria-valuenow="<?php echo $detail['progress'] ?>" aria-valuemin="0" aria-valuemax="100">
						</div>
					</div><hr>
					<h6 class="m-0 font-weight-bold text-primary">Tanggal Batas Waktu</h6>
					<div class="font-weight-bold">
						<?php if ($detail['deadline'] == "0000-00-00 00:00:00") 
						{ 
							echo "Belum di Setel";
						} else { ?>
							<span class="label label-primary"><?php echo $detail['deadline']; ?> </span>
						<?php } ?><br>
					</div><hr>
					<h6 class="m-0 font-weight-bold text-primary">Tanggal Proses</h6>
					<div class="font-weight-bold">
						<?php if ($detail['tanggal_proses'] == "0000-00-00 00:00:00") 
						{ 
							echo "Belum dimulai";
						} else { ?>
							<span class="label label-primary"><?php echo $detail['tanggal_proses']; ?> </span>
						<?php } ?><br>
					</div><hr>
					<h6 class="m-0 font-weight-bold text-primary">Tanggal Terselesaikan</h6>
					<div class="font-weight-bold">
						<?php if ($detail['tanggal_solved'] == "0000-00-00 00:00:00") 
						{ 
							echo "Belum terpecahkan";
						} else { ?>
							<span class="label label-primary"><?php echo $detail['tanggal_solved']; ?> </span>
						<?php } ?><br>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	const flashData = $('.flash-data').data('flashdata');
	if (flashData){
		Swal.fire(
			'Success!',
			'Priority of Ticket Has Been ' + flashData + ' Successfully',
			'success'
			)
	}
</script>