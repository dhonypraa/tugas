<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-darktheme sidebar sidebar-dark accordion" id="accordionSidebar">

	<!-- Sidebar - Brand -->
	<a class="sidebar-brand d-flex align-items-center justify-content-center bg-white" href="<?php echo site_url('Dashboard') ?>">
		<div class="sidebar-brand-icon">
			<img width="160px" height="50px" src="<?php echo base_url(); ?>assets/img/icon.png">
		</div>
	</a>

	<!--Menu Untuk Admin-->
	<?php if ($this->session->userdata('level') == "Admin") { ?>
		<!-- Divider -->
		<hr class="sidebar-divider my-0">
		<!-- Nav Item - Dashboard -->
		<li class="nav-item active">
			<a class="nav-link" href="<?php echo site_url('Dashboard') ?>">
				<i class="fas fa-fw fa-tachometer-alt"></i>
				<span>Dashboard</span></a>
		</li>

		<!-- Divider -->
		<hr class="sidebar-divider">
		<!-- Nav Item - Pages Collapse Menu -->
		<li class="nav-item">
			<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTicket" aria-expanded="true" aria-controls="collapseTicket">
				<i class="fas fa-fw fa-ticket-alt"></i>
				<span>Tiket</span>
			</a>
			<div id="collapseTicket" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
				<div class="bg-dark py-2 collapse-inner rounded">
					<a class="collapse-item" href="<?php echo site_url('List_ticket/list_approve') ?>">Tiket Diterima

</a>
					<a class="collapse-item" href="<?php echo site_url('List_ticket/index') ?>">Daftar Tiket</a>
				</div>
			</div>
		</li>

		<!-- Divider -->
		<hr class="sidebar-divider">
		<li class="nav-item">
			<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOffice" aria-expanded="true" aria-controls="collapseOffice">
				<i class="fas fa-industry fa-cog"></i>
				<span>Kantor</span>
			</a>
			<div id="collapseOffice" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
				<div class="bg-dark py-2 collapse-inner rounded">
					<a class="collapse-item" href="<?php echo site_url('Pegawai') ?>">Karyawan</a>
				</div>
			</div>
		</li>

		<!-- Divider -->
		<hr class="sidebar-divider">
		<!-- Nav Item - Pages Collapse Menu -->
		<li class="nav-item">
			<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
				<i class="fas fa-fw fa-cog"></i>
				<span>Konfigurasi</span>
			</a>
			<div id="collapseSetting" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
				<div class="bg-dark py-2 collapse-inner rounded">
					<a class="collapse-item" href="<?php echo site_url('User') ?>">Akun pengguna</a>
				</div>
			</div>
		</li>



	<!--Menu Untuk Teknisi-->
	<?php
	}else if ($this->session->userdata('level') == "Technician") { ?>
		<!-- Divider -->
		<hr class="sidebar-divider my-0">
		<!-- Nav Item - Dashboard -->
		<li class="nav-item active">
			<a class="nav-link" href="<?php echo site_url('Dashboard') ?>">
				<i class="fas fa-fw fa-tachometer-alt"></i>
				<span>Dashboard</span></a>
		</li>

		<hr class="sidebar-divider">
		<li class="nav-item">
			<a class="nav-link" href="<?php echo site_url('List_ticket_tek/index_approve') ?>">
				<i class="fas fa-fw fa-ticket-alt"></i>
				<span>Tiket Ditugaskan</span>
			</a>
		</li>

		<hr class="sidebar-divider">
		<li class="nav-item">
			<a class="nav-link" href="<?php echo site_url('List_ticket_tek/index_tugas') ?>">
				<i class="fas fa-fw fa-tasks"></i>
				<span>Daftar Tugas</span>
			</a>
		</li>

	<!--Menu Untuk User-->
	<?php
	}else if ($this->session->userdata('level') == "User") { ?>
		<hr class="sidebar-divider my-0">
		<!-- Nav Item - Dashboard -->
		<li class="nav-item">
			<a href="<?php echo site_url('List_ticket_user/buat') ?>" class="nav-link">
				<div class="btn btn-info">
					<i class="fas fa-plus" style="color: white;"></i>
					<span class="text" style="color: white;">Buat Tiket</span>
				</div>
			</a>
		</li>

		<!-- Divider -->
		<hr class="sidebar-divider my-0">
		<!-- Nav Item - Dashboard -->
		<li class="nav-item">
			<a class="nav-link" href="<?php echo site_url('Dashboard') ?>">
				<i class="fas fa-fw fa-tachometer-alt"></i>
				<span>Dashboard</span></a>
		</li>

		<!-- Divider -->
		<hr class="sidebar-divider">
		<li class="nav-item">
			<a class="nav-link" href="<?php echo site_url('List_ticket_user') ?>">
				<i class="fas fa-fw fa-ticket-alt"></i>
				<span>Tiket Saya</span>
			</a>
		</li>
	<?php } ?>

	<!-- Divider -->
	<hr class="sidebar-divider d-none d-md-block">

	<!-- Sidebar Toggler (Sidebar) -->
	<div class="text-center d-none d-md-inline">
		<button class="rounded-circle border-0" id="sidebarToggle"></button>
	</div>
</ul>