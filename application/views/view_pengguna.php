<?php include 'header.php';?>
<?php include 'library.php';?>
<script>
	$(document).ready(function(){
		var id = "";
		if($("#example tr:last td:first").html() === undefined){
				id = "LVL-01";
		}else{
				id = $("#example tr:last td:first .text-center").html().split("-")[1];
				id = "LVL-" + auto(id, id.split('').length);
				
		}
		$("#id_level").val(id);
		$("input[name=id_level]").val(id);
		
		//TOMBOL KOSONGKAN
		$("button[name=ubah]").hide();
		$("button[name=clear]").click(function(){
			$("button[name=simpan]").show();
			$("button[name=ubah]").hide();
			$("input[name=aksi]").val("Simpan");
			$("#id_level").val(id);
			$("input[name=id_level]").val(id);
			$("input[name=detail]").val("");
			//$('#defaultForm').data('bootstrapValidator').resetForm(true);
		});
		
		//TOMBOL UPDATE
		$(".update").click(function(){
			$("button[name=simpan]").hide();
			$("button[name=ubah]").show();
			$("input[name=aksi]").val("Ubah");
			var index = $(".update").index(this);
			var element = "#example tr:gt("+index+") ";
			$("#id_level").val($(element+".id_level .text-center").html());
			$("input[name=id_level]").val($(element+".id_level .text-center").html());
			$("input[name=detail]").val($(element+".detail .text-center").html());		
		});
		
		$(".delete").click(function(){
            var index = $(".delete").index(this);
            var element = "#example tr:gt("+index+") ";
            window.location.href = '/KoperasiInti/Level/deleteData/'+$(element+" td .text-center").html();
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
							<div class="muted pull-left">Data Pengguna</div>
						</div>
						<div class="block-content collapse in">
							<div class="span12">
								<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
									<thead>
										<tr>
											<th><div class='text-center'>ID</div></th>
											<th><div class='text-center'>Nama</div></th>
											<th><div class='text-center'>Level</div></th>
											<!--th style="width:130px"></th-->
										</tr>
									</thead>
									<tbody>
									<?php 
									if(count($records)>0) { 
										foreach($records as $row) {?>
										<tr>
											<td class="username"><div class='text-center'><?php echo $row->username; ?></div></td>
											<td class="nama"><div class='text-center'><?php echo $row->nama; ?></div></td>
											<td class="nama"><div class='text-center'><?php echo $row->detail; ?></div></td>
											<!--td>
												<center>
													<button type="button" class="update btn btn-warning">Ubah</button>
													<button type="button" class="delete btn btn-danger">Hapus</button>
												</center>
											</td-->
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