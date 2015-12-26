<?php include 'header.php';?>
<?php include 'library.php';?>
<script>
	$(document).ready(function(){
		rupiahConverter("#profil tbody tr", ".rupiah");
		rupiahConverter("#data tbody tr", ".rupiah");
		rupiahConverter("#simpanan tbody tr", ".rupiah .text-center");
		rupiahConverter("#penarikan tbody tr", ".rupiah .text-center");
		customValidation();
		$('input[name=tanggal_pembuatan]').datepicker({
			autoclose: true,
			format: 'yyyy-mm-dd',
			startDate: new Date()
		});
		$('#simpanan, #penarikan').dataTable({});
		$('#defaultForm').validate({
				rules: {
					jumlah_penarikan: {
						required: true,
						maxSaldo:true, 
						validPenarikan:true, 
						digits: true
					},
					tanggal_pembuatan: {
						required: true
					}
				  
				},
				highlight: function(element) {
					$(element).closest('.control-group').removeClass('success').addClass('error');
				},
				success: function(element) {
						element
						.text('OK!').addClass('valid')
						.closest('.control-group').removeClass('error').addClass('success');
				}
			});
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
							<div class="muted pull-left">Detail Anggota</div>
						</div>
						<div class="block-content collapse in">
							<div class="span12">
								<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="profil">
									<thead>
										<tr>
											<th><div class='text-center'> </div></th>
											<th><div class='text-center' style="width:300px"> </div></th>
										</tr>
									</thead>
									<tbody>
									<?php foreach($anggota as $row) {?>
										<tr>
											<td><b>Id Anggota</b></td>
											<td><?php echo $row->id_anggota; $id_anggota = $row->id_anggota;?></td>
										</tr>
										<tr>
											<td><b>Nama</b></td>
											<td><?php echo $row->nama; ?></td>
										</tr>
										<tr>
											<td><b>Alamat</b></td>
											<td><?php echo $row->alamat; ?></td>
										</tr>
										<tr>
											<td><b>Jabatan</b></td>
											<td><?php echo $row->jabatan; ?></td>
										</tr>
										<tr>
											<td><b>Tanggal Bergabung</b></td>
											<td><?php echo $row->tanggal_masuk; ?></td>
										</tr>
										<tr>
											<td><b>Gaji</b></td>
											<td class="rupiah"><?php echo $row->gaji; ?></td>
										</tr>
										<tr>
											<td><b>Status</b></td>
											<td><?php if($row->status==1) echo "Aktif"; else echo "Non-Aktif"; ?></td>
										</tr>
										
									<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="block">
						<div class="navbar navbar-inner block-header">
							<div class="muted pull-left">Detail Simpanan</div>
						</div>
						<div class="block-content collapse in">
							<div class="span12">
								<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="data">
									<thead>
										<tr>
											<th><div class='text-center'> </div></th>
											<th><div class='text-center' style="width:300px"> </div></th>
										</tr>
									</thead>
									<tbody>
										<?php
											$simpanan_pokok = $records[0]->jumlah_simpanan;
											$simpanan_wajib = 0;
											$simpanan_sukarela = 0;
											if(!empty($records[1])){
												$simpanan_wajib = $records[1]->jumlah_simpanan-$penarikan;
											}
											if(!empty($records[2])){
												$simpanan_sukarela = $records[2]->jumlah_simpanan;
											}
											
											$total = $simpanan_pokok + $simpanan_wajib;
										?>
										<tr>
											<td><b>Simpanan Pokok</b></td>
											<td class="rupiah"><?php echo $simpanan_pokok;?></td>
										</tr>
										<tr>
											<td><b>Simpanan Wajib</b></td>
											<td id="simpanan_wajib" class="rupiah"><?php echo $simpanan_wajib;?></td>
										</tr>
										<tr>
											<td><b>Simpanan Sukarela</b></td>
											<td class="rupiah"><?php echo $simpanan_sukarela; ?></td>
										</tr>
										<tr>
											<td><b>Jumlah Simpanan</b></td>
											<td class="rupiah"><?php echo $total; ?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="block">
						<div class="navbar navbar-inner block-header">
							<div class="muted pull-left">Rekam Jejak Simpanan</div>
						</div>
						<div class="block-content collapse in">
							<div class="span12">
								<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="simpanan">
									<thead>
										<tr>
											<th><div class='text-center'>ID</div></th>
											<th><div class='text-center'>JENIS SIMPANAN</div></th>
											<th><div class='text-center'>TANGGAL</div></th>
											<th><div class='text-center'>NOMINAL</div></th>
										</tr>
									</thead>
									<tbody>
									<?php foreach($history_simpanan as $row) {?>
										<tr>
											<td><div class='text-center'><?php echo $row->id_simpanan;?></div></td>
											<td><div class='text-center'><?php echo $row->detail;?></div></td>
											<td><div class='text-center'><?php echo $row->tanggal_pembuatan;?></div></td>
											<td class="rupiah"><div class='text-center'><?php echo $row->jumlah_simpanan;?></div></td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="block">
						<div class="navbar navbar-inner block-header">
							<div class="muted pull-left">Rekam Jejak Penarikan</div>
						</div>
						<div class="block-content collapse in">
							<div class="span12">
								<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="penarikan">
									<thead>
										<tr>
											<th><div class='text-center'>ID</div></th>
											<th><div class='text-center'>TANGGAL</div></th>
											<th><div class='text-center'>NOMINAL</div></th>
										</tr>
									</thead>
									<tbody>
									<?php foreach($history_penarikan as $row) {?>
										<tr>
											<td><div class='text-center'><?php echo $row->id_penarikan;?></div></td>
											<td><div class='text-center'><?php echo $row->tanggal_pembuatan;?></div></td>
											<td class="rupiah"><div class='text-center'><?php echo $row->jumlah_penarikan;?></div></td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="block">
						<div class="navbar navbar-inner block-header">
							<div class="muted pull-left">Penarikan</div>
						</div>
						<div class="block-content collapse in">
							<div class="span12">
								<form id="defaultForm" class="form-horizontal" method="post" action="<?php echo base_url(); ?>Simpanan/penarikan" style="padding-top:1%">
									<fieldset>
										<div class="control-group" style="padding-left:20%">
											<label class="control-label"><strong>Jumlah Penarikan</strong></label>
											<div class="controls">
												<div class="input-prepend">
													<span class="add-on">Rp</span>
													<input type="text" name="jumlah_penarikan" value="" style="width:125%"/>
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
											<input type="hidden" name="id_anggota" value="<?php echo $id_anggota;?>"/>
											<button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
											<button type="button" name="clear" class="btn">Batal</button>
										</div>
									</fieldset>
								</form>
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