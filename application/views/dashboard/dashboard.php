<?php if ($this->session->userdata('level') == "Admin") { ?>
	<div class="container-fluid">
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
		</div>

		<div class="row">
			<!--Semua Tiket-->
			<div class="col-xl-3 col-md-6 mb-4">
				<div class="card bg-danger text-white shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-uppercase mb-1">Semua Tiket</div>
								<div class="h5 mb-0 font-weight-bold"><?php echo $jml_ticket ?></div>
							</div>
							<div class="col-auto">
								<i class="fas fa-ticket-alt fa-2x"></i>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!--Need Approve-->
			<div class="col-xl-3 col-md-6 mb-4">
				<div class="card bg-warning text-white shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-uppercase mb-1">Tiket Baru</div>
								<div class="h5 mb-0 font-weight-bold"><?php echo $jlm_new ?></div>
								<h4 class="small font-weight-bold">Ditolak :  <span><?php echo $jml_reject ?></span></h4>
							</div>
							<div class="col-auto">
								<i class="fas fa-clipboard-list fa-2x"></i>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!--Process-->
			<div class="col-xl-3 col-md-6 mb-4">
				<div class="card bg-info text-white shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-uppercase mb-1">Sedang dalam proses</div>
								<div class="h5 mb-0 font-weight-bold"><?php echo $jml_process ?></div>
								<h4 class="small font-weight-bold">Di Tahan:  <span><?php echo $jml_pending ?></span></h4>
							</div>
							<div class="col-auto">
								<i class="fas fa-circle-notch fa-2x"></i>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!--Done-->
			<div class="col-xl-3 col-md-6 mb-4">
				<div class="card bg-primary text-white shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-uppercase mb-1">Selesai</div>
								<div class="h5 mb-0 font-weight-bold"><?php echo $jml_done ?></div>
							</div>
							<div class="col-auto">
								<i class="fas fa-check-circle fa-2x"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xl-8 col-lg-7">
				<!-- Bar Chart -->
				<div class="card shadow mb-4">
					<div class="card-header py-3">
						<h6 class="m-0 font-weight-bold text-gray-800">Daftar Tiket (<?php echo $jlmticket ?>)</h6>
  					</div>
					<div class="card-body" style="overflow-x: scroll; height: 390px;">
						<div class="table-responsive-sm">
							<table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>No</th>
										<th>ID Ticket</th>
										<th>Tanggal</th>
										<th>Nama </th>
										<th>Sub Kategori</th>
										<th>Prioritas</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									<?php $no = 1; foreach ($ticket as $row){?>
										<tr>
											<td><?php echo $no ?></td>
											<td><?php echo $row->id_ticket ?></td>
											<td><?php echo $row->tanggal ?></td>
											<td><?php echo $row->nama ?></td>
											<td><?php echo $row->nama_sub_kategori ?></td>
											<?php if($row->id_kondisi == 0){?>
												<td>Belum disetel</td>
											<?php }else{?>
												<td style="color: <?php echo $row->warna?>"><?php echo $row->nama_kondisi ?></td>
											<?php }?> 
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
										</tr>
									<?php $no++;}?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<!-- Pie Chart -->
			<div class="col-xl-4 col-lg-5">
				<div class="card shadow mb-4">
					<!-- Card Header - Dropdown -->
					<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
						<h6 class="m-0 font-weight-bold text-gray-800">IT Support</h6>
					</div>
					<!-- Card Body -->
					<div class="card-body" style="overflow: scroll; height: 450px;">
						<ul>
							<?php $no = 0;
							foreach ($teknisi as $row) : $no++; ?>
									<i class="fas fa-fw fa-user text-black-100"></i>
									<B class="chat-img pull-left">
										<?php echo $row->nama; ?>
									</B>
									<div class="chat-body clearfix">
										<?php if ($row->total == null) {
											echo "Tiket yang Ditugaskan : 0";
										} else {
											echo "Tiket yang Ditugaskan : $row->total";
										}?>
										<p></p>
									</div><hr>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

		<?php
	}else if ($this->session->userdata('level') == "Technician") { ?>
		<div class="container-fluid">
			<div class="d-sm-flex align-items-center justify-content-between mb-4">
				<h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
			</div>
			<div class="row">
				<!--Need Approve-->
				<div class="col-xl-3 col-md-6 mb-4">
					<div class="card bg-danger text-white shadow h-100 py-2">
						<div class="card-body">
							<div class="row no-gutters align-items-center">
								<div class="col mr-2">
									<div class="text-xs font-weight-bold text-uppercase mb-1">Tiket yang Ditugaskan</div>
									<div class="h5 mb-0 font-weight-bold"><?php  echo $tekassign ?></div>
								</div>
								<div class="col-auto">
									<i class="fas fa-ticket-alt fa-2x"></i>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!--Pending-->
				<div class="col-xl-3 col-md-6 mb-4">
					<div class="card bg-warning text-white shadow h-100 py-2">
						<div class="card-body">
							<div class="row no-gutters align-items-center">
								<div class="col mr-2">
									<div class="text-xs font-weight-bold text-uppercase mb-1">Tiket Baru</div>
									<div class="h5 mb-0 font-weight-bold"><?php  echo $tekapprove ?></div>
								</div>
								<div class="col-auto">
									<i class="fas fa-clipboard-list fa-2x"></i>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!--Proses-->
				<div class="col-xl-3 col-md-6 mb-4">
					<div class="card bg-info text-white shadow h-100 py-2">
						<div class="card-body">
							<div class="row no-gutters align-items-center">
								<div class="col mr-2">
									<div class="text-xs font-weight-bold text-uppercase mb-1">Sedang dalam proses</div>
									<div class="h5 mb-0 font-weight-bold"><?php echo $tekkerja ?></div>
									<h4 class="small font-weight-bold">Tertahan : <span><?php echo $tekpending ?></span></h4>
								</div>
								<div class="col-auto">
									<i class="fas fa-circle-notch fa-2x"></i>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!--Done-->
				<div class="col-xl-3 col-md-6 mb-4">
					<div class="card bg-primary text-white shadow h-100 py-2">
						<div class="card-body">
							<div class="row no-gutters align-items-center">
								<div class="col mr-2">
									<div class="text-xs font-weight-bold text-uppercase mb-1">Selesai</div>
									<div class="h5 mb-0 font-weight-bold"><?php echo $tekselesai ?></div>
								</div>
								<div class="col-auto">
									<i class="fas fa-check-circle fa-2x"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
			<div class="card shadow mb-4">
					<div class="card-header py-3">
						<h6 class="m-0 font-weight-bold text-gray-800">Tugas Saya (<?php echo $jlmtugas ?>)</h6>
					</div>
					<div class="card-body" style="overflow-x: scroll; height: 390px;">
						<div class="table-responsive-sm">
							<table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>No</th>
										<th>ID Tiket</th>
										<th>Prioritas</th>
										<th>Tanggal</th>
										<th>Deadline</th>
										<th>Nama</th>
										<th>Sub Kategori</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									<?php $no = 1; foreach ($datatickettek as $row){?>
										<tr>
											<td><?php echo $no ?></td>
											<td><?php echo $row->id_ticket ?></td>
											<?php if($row->id_kondisi == 0){?>
												<td>Belum disetel</td>
											<?php }else{?>
												<td style="color: <?php echo $row->warna?>"><?php echo $row->nama_kondisi ?></td>
											<?php }?> 
											<td><?php echo $row->tanggal ?></td>
											<td><?php echo $row->deadline ?></td>
											<td><?php echo $row->nama ?></td>
											<td><?php echo $row->nama_sub_kategori ?></td>
											<?php if ($row->status == 3) {?>
												<td>
													<strong style="color: #A2B969;">Ditugaskan kepada Anda</strong>
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
											<?php } ?>
										</tr>
									<?php $no++;}?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			<div class="col-xl-8 col-lg-7">
				<!-- Bar Chart -->

			</div>
			<!-- Pie Chart -->
			</div>
		</div>
		</div>

		

		<!--Menu Untuk User-->
		<?php
	}else if ($this->session->userdata('level') == "User") { ?>
		<div class="container-fluid">
			<div class="d-sm-flex align-items-center justify-content-between mb-4">
				<h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
			</div>
			<div class="row">
				<!--All ticket-->
				<div class="col-xl-3 col-md-6 mb-4">
					<div class="card bg-danger text-white shadow h-100 py-2">
						<div class="card-body">
							<div class="row no-gutters align-items-center">
								<div class="col mr-2">
									<div class="text-xs font-weight-bold text-uppercase mb-1">Tiket Anda</div>
									<div class="h5 mb-0 font-weight-bold"><?php  echo $userticket ?></div>
								</div>
								<div class="col-auto">
									<i class="fas fa-ticket-alt fa-2x"></i>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!--Approved-->
				<div class="col-xl-3 col-md-6 mb-4">
					<div class="card bg-warning text-white shadow h-100 py-2">
						<div class="card-body">
							<div class="row no-gutters align-items-center">
								<div class="col mr-2">
									<div class="text-xs font-weight-bold text-uppercase mb-1">Tiket Baru</div>
									<div class="h5 mb-0 font-weight-bold"><?php  echo $userapprove ?></div>
									<h4 class="small font-weight-bold">Ditolak: <span><?php echo $userreject ?></span></h4>
								</div>
								<div class="col-auto">
									<i class="fas fa-clipboard-list fa-2x"></i>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!--On Process-->
				<div class="col-xl-3 col-md-6 mb-4">
					<div class="card bg-info text-white shadow h-100 py-2">
						<div class="card-body">
							<div class="row no-gutters align-items-center">
								<div class="col mr-2">
									<div class="text-xs font-weight-bold text-uppercase mb-1">Sedang dalam proses</div>
									<div class="h5 mb-0 font-weight-bold"><?php echo $userprocess ?></div>
									<h4 class="small font-weight-bold">Menunggu keputusan: <span><?php echo $userpending ?></span></h4>
								</div>
								<div class="col-auto">
									<i class="fas fa-circle-notch fa-2x"></i>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!--Done-->
				<div class="col-xl-3 col-md-6 mb-4">
					<div class="card bg-primary text-white shadow h-100 py-2">
						<div class="card-body">
							<div class="row no-gutters align-items-center">
								<div class="col mr-2">
									<div class="text-xs font-weight-bold text-uppercase mb-1">Selesai</div>
									<div class="h5 mb-0 font-weight-bold"><?php echo $userdone ?></div>
								</div>
								<div class="col-auto">
									<i class="fas fa-check-circle fa-2x"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card shadow mb-4">
					<div class="card-header py-3">
						<h6 class="m-0 font-weight-bold text-gray-800">Ringkasan Tiket Saya</h6>
					</div>
					<div class="card-body" style="overflow-x: scroll; height: 390px;">
						<div class="table-responsive-sm">
							<table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>No</th>
										<th>ID Tiket</th>
										<th>Tanggal</th>
										<th>Nama</th>
										<th>Sub Kateori</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									<?php $no = 1; foreach ($dataticketuser as $row){?>
										<tr>
											<td><?php echo $no ?></td>
											<td><?php echo $row->id_ticket ?></td>
											<td><?php echo $row->tanggal ?></td>
											<td><?php echo $row->nama ?></td>
											<td><?php echo $row->nama_sub_kategori ?></td>
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
										</tr>
									<?php $no++;}?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			<div class="row">
			
			<div class="col-xl-8 col-lg-7">
			
				<!-- Bar Chart -->

			</div>
			<!-- Pie Chart -->
			</div>
		</div>
	</div>
<?php } ?>

<?php
    //Inisialisasi nilai variabel awal
    $subkat 	= "";
    $jumlah		=null;

    $kondisi 	= "";
    $BGkondisi 	= "";
    $jkondisi 	=null;

    $bulan 		= "";
    $Jbulan		=null;

    $Tstat     = "";
    $BGstat   = "";
    $Jstat    = null;

    foreach ($lbl_subkat as $data)
    {
        $sub=$data->nama_sub_kategori;
        $subkat .= "'$sub'". ", ";
        $jum=$data->total;
        $jumlah .= "$jum". ", ";
    }

    foreach ($lbl_kondisi as $data)
    {
    	$id=$data->id_kondisi;
    	if($id == 0){
    		$knds= "Belum disetel";
    	}else{
    		$knds=$data->nama_kondisi;
    	}
        $kondisi .= "'$knds'". ", ";
        $bg=$data->warna;
        $BGkondisi .= "'$bg'". ", ";
        $jumk=$data->jumkondisi;
        $jkondisi .= "$jumk". ", ";
    }

    foreach ($lbl_perbulan as $data)
    {
        $bul=$data->bulan;
        $bulan .= "'$bul'". ", ";
        $Jumb=$data->jumbulan;
        $Jbulan .= "$Jumb". ", ";
    }

    foreach ($lbl_status as $data)
    {
        if ($data->status == 0) {
            $stat = "Tiket Ditolak";
            $bg = "#F36F13";
        } else if ($data->status == 1) {
            $stat = "Tiket Dikirim";
            $bg = "#946038";
        } else if ($data->status == 2) {
            $stat = "Kategory Berubah";
            $bg = "#FFB701";
        } else if ($data->status == 3) {
            $stat = "Ditugaskan ke Teknisi";
            $bg = "#A2B969";
        } else if ($data->status == 4) {
            $stat = "Sedang dalam proses";
            $bg = "#0D95BC";
        } else if ($data->status == 5) {
            $stat = "Menunggu keputusan";
            $bg = "#023047";
        } else if ($data->status == 6) {
            $stat = "Menyelesaikan";
            $bg = "#2E6095";
        } else if ($data->status == 7) {
            $stat = "Terlambat Selesai";
            $bg = "#C13018";
        }
        $Tstat  .= "'$stat'". ", ";
        $BGstat .= "'$bg'". ", ";
        $jstat   =$data->jumstat;
        $Jstat  .= "$jstat". ", ";
    }
?>

