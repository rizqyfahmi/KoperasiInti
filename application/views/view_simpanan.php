<?php include 'header.php';?>
<?php include 'library.php';?>
<script>
	$(document).ready(function(){
		rupiahConverter("#data tbody tr", ".jumlah_simpanan .text-center");
		customValidation();
		actionViewSimpanan();
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
							<div class="muted pull-left">Form Simpanan</div>
						</div>
						<form id="defaultForm" class="form-horizontal" method="post" action="<?php echo base_url(); ?>Simpanan/createData" style="padding-top:1%">
							<fieldset>
								<div class="control-group" style="padding-left:20%">
									<label class="control-label"><strong>ID Anggota</strong></label>
									<div class="controls">
										<input type="text" class="input-xlarge" name="id_anggota" value="" data-provide="typeahead" data-val="true" data-val-required="Password is required" />
									</div>
								</div>
								<div class="control-group" style="padding-left:20%">
									<label class="control-label"><strong>Nama</strong></label>
									<div class="controls">
										<input type="text" class="input-xlarge" id="nama_anggota" value="" readonly="true"/>
									</div>
								</div>
								<div class="control-group" style="padding-left:20%">
									<label class="control-label"><strong>Jabatan</strong></label>
									<div class="controls">
										<input type="text" class="input-xlarge" id="jabatan" value="" readonly="true"/>
									</div>
								</div>
								<div class="control-group" style="padding-left:20%">
									<label class="control-label"><strong>Jenis Simpanan</strong></label>
									<div class="controls">
										<select name="id_jenis_simpanan" style="width:45%">
											<?php foreach($jenis_simpanan as $row){
												echo "<option value='".$row->id_jenis_simpanan."'>".$row->detail."</option>";
											}?>
										</select>
									</div>
								</div>
								<div class="control-group" style="padding-left:20%">
									<label class="control-label"><strong>Jumlah Simpanan</strong></label>
									<div class="controls">
										<div class="input-prepend">
											<span class="add-on">Rp</span>
											<input type="text" name="jumlah_simpanan" value="" style="width:125%" readonly="true"/>
										</div>										
									</div>
								</div>
								<div class="control-group" style="padding-left:20%">
									<label class="control-label"><strong>Tanggal Pembuatan</strong></label>
									<div class="controls">
										<input type="text" name="tanggal_pembuatan" class="input-xlarge" value="" />
									</div>
								</div>
								<div class="form-actions" style="margin-bottom:-2%; padding-left:39%">
									<input type="hidden" name="id_simpanan" value="" readonly="true"/>
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
							<div class="muted pull-left">Data Simpanan</div>
						</div>
						<div class="block-content collapse in">
							<div class="span12">
								<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="data">
									<thead>
										<tr>
											<th><div class='text-center'>Id Anggota</div></th>
											<th><div class='text-center'>Nama Anggota</div></th>
											<th><div class='text-center'>Jenis Anggota</div></th>
											<th><div class='text-center'>Tanggal Pembuatan</div></th>
											<th><div class='text-center'>Jumlah Simpanan</div></th>
											<th style="width:60px"></th>
										</tr>
									</thead>
									<tbody>
									<?php 
									if(count($records)>0) { 
										foreach($records as $row) {?>
										<tr>
											<td class="id_anggota"><div class='text-center'><?php echo $row->id_anggota; ?></div></td>
											<td class="nama_anggota"><div class='text-center'><?php echo $row->nama; ?></div></td>
											<td class="id_jenis_anggota"><div class='text-center'><?php echo $row->jabatan; ?></div></td>
											<td class="tanggal_pembuatan"><div class='text-center'><?php echo $row->tanggal_pembuatan; ?></div></td>
											<td class="jumlah_simpanan">
												<div class='text-center'>
													<?php 
														$id_anggota = $row->id_anggota;
														$jumlah_simpanan = $row->jumlah_simpanan;
														if(count($penarikan)>0) { 
															foreach($penarikan as $row) {
																if($id_anggota==$row->id_anggota){
																	$jumlah_simpanan = $jumlah_simpanan - $row->jumlah_penarikan;
																}
															}
														}
														echo $jumlah_simpanan;
													?>
												</div>
											</td>
											<td>
												<center>
													<button type="button" class="view btn btn-warning">View</button>
												</center>
											</td>
										</tr>
										<?php }
										} ?>
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