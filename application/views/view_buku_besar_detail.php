<?php include 'header.php';?>
<?php include 'library.php';?>
<script>
	$(document).ready(function(){
		$("#data tr").each(function(i){
			if(i>0){
				$(this).find(".rupiah .text-center").html(toRp($(this).find(".rupiah .text-center").html()));
				$(this).find(".rp .text-center").html(toRp($(this).find(".rp .text-center").html()));
			}
		});
		$('#data').dataTable({
			"bFilter": false
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
							<div class="muted pull-left"></div>
						</div>
						<div class="block-content collapse in">
							<div class="span12">
								<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="data">
									<thead>
										<tr>
											<th colspan="3"><div class='text-center'>Nama Perkiraan : <?php echo $coa->detail;?></div></th>
											<th colspan="3"><div class='text-center'>No. Perkiraan : <?php echo $coa->no_referensi;?></div></th>
										</tr>
										<tr>
											<th><div class='text-center'>Tanggal</div></th>
											<th><div class='text-center'>Keterangan</div></th>
											<th><div class='text-center'>No. Ref</div></th>
											<th><div class='text-center'>Debit</div></th>
											<th><div class='text-center'>Kredit</div></th>
											<th><div class='text-center'>Saldo</div></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><div class='text-center'><?php echo $saldo_awal['tanggal'];?></div></td>
											<td>Saldo Awal</td>
											<td><div class='text-center'><?php echo $saldo_awal['no_ref'];?></div></td>
											<td><div class='text-center'>-</div></td>
											<td><div class='text-center'>-</div></td>
											<td class='rp'><div class='text-center'><?php echo $saldo_awal['saldo_awal'];?></div></td>
										</tr>
										<?php foreach($records as $row) {?>
											<tr>
												<td><div class='text-center'><?php echo $row->tanggal_transaksi;?></div></td>
												<td><?php echo $row->keterangan;?></td>
												<td><div class='text-center'><?php echo $row->no_ref;?></div></td>
												<?php if($row->posisi=="Debit"){
														echo "<td class='rupiah'><div class='text-center'>".$row->jumlah."</div></td>";
														echo "<td><div class='text-center'>-</div></td>";
													}else{
														echo "<td><div class='text-center'>-</div></td>";
														echo "<td class='rupiah'><div class='text-center'>".$row->jumlah."</div></td>";
													}
												?>
												<td class='rp'><div class='text-center'><?php echo $row->saldo;?></div></td>
											</tr>
										<?php } ?>
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