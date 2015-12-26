<?php include 'header.php';?>
<?php include 'library.php';?>
<script>
	$(document).ready(function(){
		$("#data tr").each(function(){
			if($(this).find(".nominal .text-center").html()!=undefined){
				$(this).find(".nominal .text-center").html(toRp($(this).find(".nominal .text-center").html()));
			}
		});
		//TOMBOL KOSONGKAN
		$("button[name=ubah]").hide();
		$("button[name=clear]").click(function(){
			$("button[name=simpan]").show();
			$("button[name=ubah]").hide();
			$("input[name=aksi]").val("Simpan");
			$("input[type=text]").val("");
			//$('#defaultForm').data('bootstrapValidator').resetForm(true);
		});
		
		//TOMBOL UPDATE
		$(".update").click(function(){
			$("button[name=simpan]").hide();
			$("button[name=ubah]").show();
			$("input[name=aksi]").val("Ubah");
			var index = $(".update").index(this);
			var element = "#data tr:gt("+index+") ";
			$("#id_jenis_simpanan").val($(element+".id_jenis_simpanan .text-center").html());
			$("input[name=id_jenis_simpanan]").val($(element+".id_jenis_simpanan .text-center").html());
			$("input[name=detail]").val($(element+".detail .text-center").html());
			var angka = $(element+".nominal .text-center").html();
			angka = angka.replace(/([.Rp. *+?^$|(){}\[\]])/mg, '');			
			$("input[name=nominal]").val(angka);		
		});
		
		$(".delete").click(function(){
            var index = $(".delete").index(this);
            var element = "#data tr:gt("+index+") ";
            window.location.href = '/KoperasiInti/Jenis_Simpanan/deleteData/'+$(element+" td .text-center").html();
		});
		$('#data').dataTable({});
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
							<div class="muted pull-left">Form Jenis Simpanan</div>
						</div>
						<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>Jenis_Simpanan/createData" style="padding-top:1%">
							<fieldset>
								<div class="control-group" style="padding-left:20%">
									<label class="control-label"><strong>Detail</strong></label>
									<div class="controls">
										<input type="text" name="detail" class="input-xlarge" value=""/>
									</div>
								</div>
								<div class="control-group" style="padding-left:20%">
									<label class="control-label"><strong>Nominal</strong></label>
									<div class="controls">
										<input type="text" name="nominal" class="input-xlarge" value=""/>
									</div>
								</div>
								<div class="form-actions" style="margin-bottom:-2%; padding-left:39%">
									<input type="hidden" class="input-xlarge" name="id_jenis_simpanan" value=""/>
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
							<div class="muted pull-left">Data Jenis Simpanan</div>
						</div>
						<div class="block-content collapse in">
							<div class="span12">
								<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="data">
									<thead>
										<tr>
											<th><div class='text-center'>ID</div></th>
											<th><div class='text-center'>Detail</div></th>
											<th><div class='text-center'>Nominal</div></th>
											<th style="width:130px"></th>
										</tr>
									</thead>
									<tbody>
									<?php 
									if(count($records)>0) { 
										foreach($records as $row) {?>
										<tr>
											<td class="id_jenis_simpanan"><div class='text-center'><?php echo $row->id_jenis_simpanan; ?></div></td>
											<td class="detail"><div class='text-center'><?php echo $row->detail; ?></div></td>
											<td class="nominal"><div class='text-center'><?php echo $row->nominal; ?></div></td>
											<td>
												<center>
													<button type="button" class="update btn btn-warning">Ubah</button>
													<button type="button" class="delete btn btn-danger">Hapus</button>
												</center>
											</td>
										</tr>
										<?php } ?>
										<?php }else{  ?>
										<tr>
											<td colspan="4">
												<div class="">
													NO DATA
												</div>
											</td>
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