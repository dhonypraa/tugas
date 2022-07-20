<div class="container-fluid">
	<h1 class="h3 mb-0 text-gray-800">Tiket Saya</h1>
	<p class="mb-4">Daftar semua tiket yang sudah Anda kirimkan.</p>

	<div class="flash-data" data-flashdata="<?php echo $this->session->flashdata('status')?>"></div>

	<!-- Datatable -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Daftar Tiket</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>#</th>
							<th>ID Tiket</th>
							<th>Prioritas</th>
							<th>Tanggal</th>
							<th>Sub Kategori</th>
							<th>Lokasi</th>
							<th>Subyek</th>
							<th>Pembaharuan Terakhir</th>
							<th>Teknisi</th>
							<th>Status</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1; foreach ($ticket as $row){?>
							<tr>
								<td><?php echo $no ?></td>
								<td><?php echo $row->id_ticket?></td>
								<?php if ($row->status == 0){?>
									<td style="text-align: center">Ditolak</td>
								<?php }else{?>
									<?php if($row->id_kondisi == 0) {?>
										<td style="text-align: center">Akan ditentukan</td>
									<?php } else { ?>
										<td class="font-weight-bold" style="color: <?php echo $row->warna?>; text-align: center">
										<?php echo $row->nama_kondisi?></td> 
									<?php } ?>
								<?php }?>
								<td><?php echo $row->tanggal?></td>
								<td><?php echo $row->nama_sub_kategori?></td>
								<td><?php echo $row->lokasi?></td>
								<td><?php echo $row->problem_summary?></td>
								<td><?php echo $row->last_update?></td>
								<td style="text-align: center">
								    <?php if($row->status == 0) {
								    	echo "Ditolak";
								    } else {
								    	if($row->teknisi == null){
								    		echo "Akan ditentukan";
								    	} else {
								    		echo "$row->nama_teknisi";
								    	}
								    } ?>
								</td>
								<?php if ($row->status == 0) {?>
									<td>
										<strong style="color: #F36F13;">Tiket Ditolak</strong>
									</td>
								<?php } else if ($row->status == 1) {?>
									<td>
										<strong style="color: #946038;">Tiket Dikirim</strong>
									</td>
								<?php } else if ($row->status == 2) {?>
									<td>
										<strong style="color: #FFB701;">Kategori Berubah</strong>
									</td>
								<?php } else if ($row->status == 3) {?>
									<td>
										<strong style="color: #A2B969;">Ditugaskan ke Teknisi</strong>
									</td>
								<?php } else if ($row->status == 4) {?>
									<td>
										<strong style="color: #0D95BC;">Sedang dalam proses</strong>
									</td>
								<?php } else if ($row->status == 5) {?>
									<td>
										<strong style="color: #023047;">Menunggu keputusan</strong>
									</td>
								<?php } else if ($row->status == 6) {?>
									<td>
										<strong style="color: #2E6095;">Menyelesaikan</strong>
									</td>
								<?php } else if ($row->status == 7) {?>
									<td>
										<strong style="color: #C13018;">Terlambat Selesai</strong>
									</td>
								<?php } ?>
								<td>
									<a href="<?php echo site_url('List_ticket_user/detail/'.$row->id_ticket)?>" class="btn btn-primary btn-circle btn-sm" title="Detail">
										<i class="fas fa-search"></i>
									</a>
								</td>
							</tr>
						<?php $no++;}?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	const flashData = $('.flash-data').data('flashdata');
	console.log(flashData);
	if (flashData === 'Submited'){
		Swal.fire(
			'Berhasil!',
			'Tiket Berhasil Dikirim.',
			'success'
			)
	}
</script>