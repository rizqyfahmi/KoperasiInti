<?php include 'header.php';?>
<?php include 'library.php';?>

<style>
	.datepicker{z-index:1151;}
</style>
<script>
	$(document).ready(function(){
		rupiahConverter("#data tbody tr", ".nominal_pinjaman .text-center");
		rupiahConverter("#data tbody tr", ".nominal_angsuran .text-center");
		rupiahConverter("#info tbody tr", ".rupiah .text-center");
		rupiahConverterNonSub("#gajiPokok");
		rupiahConverterNonSub("#takeHomePay");
		customValidation();
		actionViewPinjamanDetail();
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
							<div class="muted pull-left">Id Anggota : <?php echo $anggota->id_anggota;?></div>
							<div class="muted pull-right">Nama : <?php echo $anggota->nama;?></div>
							<div id="id_anggota" style="display:none"><?php echo $id_anggota;?></div>
						</div>
						<div class="block-content collapse in">
							<div class="span12">
								<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="data">
									<thead>
										<tr>
											<th style="width:50px"><div class='text-center'>No</div></th>
											<th style="width:130px"><div class='text-center'>ID Pinjaman</div></th>
											<th style="width:130px"><div class='text-center'>Nominal Pinjaman</div></th>
											<th style="width:130px"><div class='text-center'>Nominal Angsuran</div></th>
											<th style="width:130px"><div class='text-center'>Sisa Pembayaran</div></th>
											<th style="width:130px"><div class='text-center'>Status Pembayaran</div></th>
											<th style="width:130px"><div class='text-center'></div></th>
										</tr>
									</thead>
									<tbody>
									<?php $i = 1; foreach($records as $row) {?>
										<tr>
											<td class="no"><div class='text-center'><?php echo $i; ?></div></td>
											<td class="id_pinjaman"><div class='text-center'><?php echo $row->id_pinjaman; ?></div></td>
											<td class="nominal_pinjaman"><div class='text-center'><?php echo $row->nominal_pinjaman; ?></div></td>
											<td class="nominal_angsuran"><div class='text-center'><?php echo $row->angsuran_pokok+$row->angsuran_bunga; ?></div></td>
											<td class="sisa_pembayaran"><div class='text-center'></div></td>
											<td class="status_pembayaran"><div class='text-center'><?php echo $row->status_pembayaran; ?></div></td>
											<td><div class='text-center'>
											<?php if($row->acc==1){ ?>
													<?php if($row->status_pembayaran==1){ ?>
														<button class='angsur btn btn-warning' disabled="true">Angsur</button>
													<?php }else{ ?>
														<button class='angsur btn btn-warning'>Angsur</button>
													<?php } ?>
													<button class='detail btn btn-info'>Detail</button>
											<?php }else{ ?>
													<button class='tolak btn btn-warning'>Tolak</button>
													<button class='terima btn btn-info'>Terima</button>
											<?php } ?>
											</div></td>
										</tr>
										<?php $i++; } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="block">
						<div class="navbar navbar-inner block-header">
							<div class="muted pull-left">Gaji Pokok : <span id="gajiPokok"><?php echo $anggota->gaji;?></span></div>
							<div class="muted pull-right">Take Home Pay : <span id="takeHomePay"><?php echo $takeHomePay;?></span></div>
							<div id="id_anggota" style="display:none"><?php echo $id_anggota;?></div>
						</div>
						<div class="block-content collapse in">
							<div class="span12">
								<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="info">
									<thead>
										<tr>
											<th style="width:130px"><div class='text-center'>No</div></th>
											<th style="width:130px"><div class='text-center'>ID</div></th>
											<th style="width:130px"><div class='text-center'>Keterangan</div></th>
											<th style="width:130px"><div class='text-center'>Jumlah</div></th>
										</tr>
									</thead>
									<tbody>
									<?php $i = 1; foreach($totalAngsuran as $row) {?>
										<tr>
											<td class="no"><div class='text-center'><?php echo $i; ?></div></td>
											<td><div class='text-center'><?php echo $row['id']; ?></div></td>
											<td><div class='text-center'><?php echo $row['detail']; ?></div></td>
											<td class="rupiah"><div class='text-center'><?php echo $row['jumlah']; ?></div></td>
										</tr>
									<?php $i++; } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
		<hr>
		<div id="modal_angsur" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:50%">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 id="myModalLabel">Detail Pinjaman</h3>
			</div>
			<div class="modal-body">
				<div id="myCarousel" class="carousel slide" data-interval="3000" data-ride="carousel">
					<div class="carousel-inner">
						<form id="defaultForm" class="form-horizontal" method="post" action="<?php echo base_url(); ?>Angsuran/createData" style="padding-top:1%">
							<fieldset>
								<div class="control-group">
									<label class="control-label"><strong>ID Pinjaman</strong></label>
									<div class="controls">
										<input type="text" class="input-xlarge" name="id_pinjaman" value="" readonly="true"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><strong>ID Anggota</strong></label>
									<div class="controls">
										<input type="text" class="input-xlarge" name="id_anggota" value="" readonly="true"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><strong>Tanggal Pembayaran</strong></label>
									<div class="controls">
										<input type="text" name="tanggal_pembuatan" class="input-xlarge no-padding"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"></label>
									<div class="controls">
										<input type="hidden" name="aksi" value="Simpan"/>
										<button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
										<button type="button" name="clear" class="btn">Batal</button>
									</div>
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
		
		<!--Modal Detail-->
		<div id="modal_detail" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:50%">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 id="myModalLabel">Detail Pinjaman</h3>
			</div>
			<div class="modal-body">
				<div id="myCarousel" class="carousel slide" data-interval="3000" data-ride="carousel">
					<div class="carousel-inner">
						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="detail">
							<thead>
								<tr>
									<th style="width:130px" rowspan="2"><div class='text-center'>Bulan Ke</div></th>
									<th style="width:130px" rowspan="2"><div class='text-center'>Pinjaman</div></th>
									<th style="width:130px" colspan="4"><div class='text-center'>Angsuran</div></th>
								</tr>
								<tr>
									<th><div class='text-center'>Pokok</div></th>
									<th><div class='text-center'>Bunga</div></th>
									<th><div class='text-center'>Jumlah</div></th>
									<th><div class='text-center'>Tanggal</div></th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<!--footer></footer-->
	</div>

<?php include 'footer.php';?>