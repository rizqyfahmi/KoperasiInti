<?php include 'header.php';?>


<?php include 'library.php';?>
<script>
	$(document).ready(function(){
		//TO RP
		rupiahConverter("#data tbody tr", ".gaji .text-center");
		actionViewAnggota();
	});
</script>

<?php include 'navbar.php';?>
	<div class="container-fluid">
		<div class="row-fluid">
			<?php include 'sidebar.php';?>
			<div class="span9" id="content">
				<div class="row-fluid">
					<div class="block">
						<div class="navbar navbar-inner block-header">
							<div class="muted pull-left">Form Anggota</div>
						</div>
						<form id="defaultForm" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>Anggota/createData" style="padding-top:1%">
							<fieldset>
								<div class="control-group" style="padding-left:20%">
									<label class="control-label"><strong>Nama</strong></label>
									<div class="controls">
										<input type="text" name="nama" class="input-xlarge" value=""/>
									</div>
								</div>
								<div class="control-group" style="padding-left:20%">
									<label class="control-label"><strong>Alamat</strong></label>
									<div class="controls">
										<input type="text" name="alamat" class="input-xlarge" value=""/>
									</div>
								</div>
							
								<div class="control-group" style="padding-left:20%">
									<label class="control-label"><strong>Tanggal Masuk</strong></label>
									<div class="controls">
										<input type="text" name="tanggal_masuk" class="input-xlarge"/>
									</div>
								</div>
								<div class="control-group" style="padding-left:20%">
									<label class="control-label"><strong>Gaji</strong></label>
									<div class="controls">
										<input type="text" name="gaji" class="input-xlarge" value=""/>
									</div>
								</div>
								<div class="control-group" style="padding-left:20%">
									<label class="control-label"><strong>Foto</strong></label>
									<div class="controls">
										<input type="file" name="foto" accept=".jpg" class="input-xlarge" value=""/>
									</div>
								</div>
								<div class="control-group" style="padding-left:20%">
									<label class="control-label"><strong>Jenis Anggota</strong></label>
									<div class="controls">
										<select name="id_jenis_anggota">
											<?php foreach($jenis_anggota as $row) {?>
											<option value="<?php echo $row->id_jenis_anggota; ?>"><?php echo $row->jabatan; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="control-group" style="padding-left:20%">
									<label class="control-label"><strong>Status</strong></label>
									<div class="controls">
										<select name="status">
											<option value="1">Aktif</option>
											<option value="0">Non-Aktif</option>
										</select>
									</div>
								</div>
								<div class="form-actions" style="margin-bottom:-2%; padding-left:39%">
									<input type="hidden" name="id_anggota" value="" readonly="true"/>
									<input type="hidden" name="aksi" value="Simpan"/>
									<button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
									<button type="submit" name="ubah" class="btn btn-warning">Ubah</button>
									<button type="button" name="clear" class="btn">Batal</button>
								</div>
							</fieldset>
						</form>
					</div>
                </div>
				<div class="row-fluid">
					<div class="block">
						<div class="navbar navbar-inner block-header">
							<div class="muted pull-left">Data Anggota</div>
						</div>
						<div class="block-content collapse in">
							<div class="span12">
								<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="data">
									<thead>
										<tr>
											<th style="width:90px"><div class='text-center'>ID</div></th>
											<th style="width:130px"><div class='text-center'>Nama</div></th>
											<th style="width:130px"><div class='text-center'>Alamat</div></th>
											<th style="width:130px"><div class='text-center'>Tanggal Masuk</div></th>
											<th style="width:130px"><div class='text-center'>Gaji</div></th>
											<th style="width:50px"><div class='text-center'>Foto</div></th>
											<th><div class='text-center'>Jenis Anggota</div></th>
											<th><div class='text-center'>Status</div></th>
											<th style="width:150px"></th>
										</tr>
									</thead>
									<tbody>
										<?php 
										if(count($records)>0) { 
										foreach($records as $row) {?>
										<tr>
											<td class="id_anggota"><div class='text-center'><?php echo $row->id_anggota; ?></div></td>
											<td class="nama"><div class='text-center'><?php echo $row->nama; ?></div></td>
											<td class="alamat"><div class='text-center'><?php echo $row->alamat; ?></div></td>
											<td class="tanggal_masuk"><div class='text-center'><?php echo $row->tanggal_masuk; ?></div></td>
											<td class="gaji"><div class='text-center'><?php echo $row->gaji; ?></div></td>
											<td class="foto"><div class='text-center'>
												<?php 
												if(empty($row->foto)){
													echo img(array('src'=>'holder.js/50x50', 'class'=> 'img-rounded', 'width' => '50', 'height' => '50')); 
												}else{
													echo img(array('src'=>base_url().$row->foto, 'class'=> 'img-rounded', 'width' => '50', 'height' => '50')); 
												}
												?>
											</div></td>
											<td><div class='text-center'><?php echo $row->jabatan; ?></div><div class="id_jenis_anggota" style="display:none"><?php echo $row->id_jenis_anggota; ?></div></td>
											<td class="status"><div class='text-center'><?php if($row->status==1) echo "Aktif"; else echo "Non-Aktif"; ?></div></td>
											<td>
												<center>
													<button type="button" class="update btn btn-warning">Ubah</button>
													<button type="button" class="delete btn btn-danger">Hapus</button>
												</center>
											</td>
										</tr>
										<?php } 
											}?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
		<hr>
		<!--footer></footer-->
	</div>
<?php include 'footer.php';?>