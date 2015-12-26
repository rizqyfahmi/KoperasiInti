<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container-fluid">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<div class="nav-collapse collapse">
				<ul class="nav pull-right">
					<li><a class="brand" href="<?php echo base_url(); ?>">Koperasi Inti</a></li>
					<li>
						<li><a href="<?php echo base_url(); ?>"><i class="icon-home"></i> Beranda</a></li>
					</li>
					<?php if($this->session->userdata('pengguna')->id_level=="LVL-01"){?>
					<li class="dropdown">
						<a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-wrench"></i> Pengaturan<i class="caret"></i></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo base_url(); ?>Level/">Jenis Pengguna</a></li>
							<li><a href="<?php echo base_url(); ?>Jenis_Anggota/">Jenis Simpanan Wajib Anggota</a></li>
							<li><a href="<?php echo base_url(); ?>Jenis_Simpanan/">Jenis Simpanan</a></li>
							<li><a href="<?php echo base_url(); ?>Jenis_Pinjaman/">Jenis Pinjaman</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-list-alt"></i> Laporan <i class="caret"></i></a>
						<ul class="dropdown-menu">
							<li id="navbar-jurnal"><a href="<?php echo base_url(); ?>Jurnal/">Jurnal</a></li>
							<li id="navbar-jurnal"><a href="<?php echo base_url(); ?>Buku_Besar/">Buku Besar</a></li>
						</ul>
					</li>
					<?php }?>
					<li class="dropdown">
						<a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i> Pengguna<i class="caret"></i></a>
						<ul class="dropdown-menu">
							<li>
								<a tabindex="-1" href="<?php echo base_url(); ?>Profil/">Profile</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="<?php echo base_url(); ?>Main/logout">Logout</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
       </div>
	</div>
</div>