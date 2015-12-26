<script>
	$(document).ready(function(){
		$("#sidebar ul li").each(function(i){
			$("#sidebar ul li").removeClass("active");
		});
		if(document.URL.indexOf("Level")!=-1){
			$("#sidebar-level").addClass("active");
		}else if(document.URL.indexOf("Jenis_Anggota")!=-1){
			$("#sidebar-jenis-anggota").addClass("active");
		}else if(document.URL.indexOf("Jenis_Simpanan")!=-1){
			$("#sidebar-jenis-simpanan").addClass("active");
		}else if(document.URL.indexOf("Jenis_Pinjaman")!=-1){
			$("#sidebar-jenis-pinjaman").addClass("active");
		}else if(document.URL.indexOf("Anggota")!=-1){
			$("#sidebar-anggota").addClass("active");
		}else if(document.URL.indexOf("Simpanan")!=-1){
			$("#sidebar-simpanan").addClass("active");
		}else if(document.URL.indexOf("Pinjaman")!=-1){
			$("#sidebar-pinjaman").addClass("active");
		}else if(document.URL.indexOf("Angsuran")!=-1){
			$("#sidebar-angsuran").addClass("active");
		}
	});
</script>
<div class="span3" id="sidebar" style="margin-left:0%; margin-right:-2%;">
	<ul class="span3 nav nav-list bs-docs-sidenav nav-collapse affix">
		<li><a href="<?php echo base_url(); ?>Profil/">
				<?php 
				if(empty($this->session->userdata('pengguna')->foto)){
					echo img(array('src'=>'holder.js/100x100', 'class'=> 'img-rounded', 'width' => '100', 'height' => '100')); 
				}else{
					echo img(array('src'=>base_url().$this->session->userdata('pengguna')->foto, 'class'=> 'img-rounded', 'width' => '100', 'height' => '100')); 
				}
				?>
				<div class="divider"></div>
				<p><strong>Nama : </strong> <br/> <?php echo $this->model_anggota->getDataByIdAnggota($this->session->userdata('pengguna')->id_anggota)[0]->nama; ;?> </p>
				<p><strong>Jabatan : </strong> <br/> <?php echo $this->session->userdata('pengguna')->jabatan;?></p>
			</a>
		</li>
		<?php if($this->session->userdata('pengguna')->id_level=="LVL-01"){?>
			<li id="sidebar-anggota"><a href="<?php echo base_url(); ?>Anggota/"><i class="icon-chevron-right"></i> Anggota</a></li>
		<?php }?>
		<li id="sidebar-simpanan"><a href="<?php echo base_url(); ?>Simpanan/"><i class="icon-chevron-right"></i> Simpanan</a></li>
		<li id="sidebar-pinjaman"><a href="<?php echo base_url(); ?>Pinjaman/"><i class="icon-chevron-right"></i> Pinjaman</a></li>
		<!--li id="sidebar-angsuran"><a href="<?php echo base_url(); ?>Angsuran/"><i class="icon-chevron-right"></i> Angsuran</a></li-->
	</ul>
</div>