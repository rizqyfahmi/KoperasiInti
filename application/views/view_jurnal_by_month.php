<?php include 'header.php';?>
<?php include 'library.php';?>
<script>
	$(document).ready(function(){
		$("#data tr").each(function(){
			if($(this).find(".rupiah .text-center").html()!=undefined){
				$(this).find(".rupiah .text-center").html(toRp($(this).find(".rupiah .text-center").html()));
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
							<div class="muted pull-left"></div>
						</div>
						<div class="block-content collapse in">
							<div class="span12">
								<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="data">
									<thead>
										<tr>
											<th><div class='text-center'>Tanggal</div></th>
											<th><div class='text-center'>Keterangan</div></th>
											<th><div class='text-center'>Deskripsi</div></th>
											<th><div class='text-center'>No. Ref</div></th>
											<th><div class='text-center'>Debit</div></th>
											<th><div class='text-center'>Kredit</div></th>
										</tr>
									</thead>
									<tbody>
									<?php 
									if(count($records)>0) {
										$id_jurnal = "";
										$kredit = 0; $debit = 0;
										foreach($records as $row) { ?>
										<tr>
											<?php if($row->id_jurnal!=$id_jurnal){ 
													$id_jurnal = $row->id_jurnal;?>
													<td><div class='text-center'><?php echo $row->tanggal_transaksi; ?></div></td>
													<td><?php echo $row->keterangan; ?></td>
											<?php }else{?>
													<td></td>
													<td></td>
											<?php }?>
											
											
											<td><?php echo $row->deskripsi; ?></td>
											<td><div class='text-center'><?php echo $row->no_ref; ?></div></td>
											
											<?php	if($row->posisi=="Debit"){?>
											<?php $debit += $row->jumlah; ?>
												<!--Debet-->
												<td class="rupiah"><div class='text-center'><?php echo $row->jumlah; ?></div></td>
												<td><div class='text-center'>-</div></td>											
											<?php	}else if($row->posisi=="Kredit"){ ?>
											<?php $kredit += $row->jumlah; ?>
												<!--Kredit-->
												<td><div class='text-center'>-</div></td>
												<td class="rupiah"><div class='text-center'><?php echo $row->jumlah; ?></div></td>
											<?php	} ?>
											
											
										</tr>
										<?php } 
										}?>
										<tr>
											<td></td>
											<td><div class='text-center'><strong>TOTAL</strong></div></td>
											<td></td>
											<td></td>
											<td class="rupiah"><strong><div class='text-center'><?php echo $kredit; ?></div></strong></td>
											<td class="rupiah"><strong><div class='text-center'><?php echo $debit; ?></div></strong></td>
										</tr>
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