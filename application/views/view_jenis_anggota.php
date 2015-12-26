<?php include 'header.php';?>
<?php include 'library.php';?>
<script>
	$(document).ready(function(){
		$("#data tr").each(function(){
			if($(this).find(".jumlah_simpanan .text-center").html()!=undefined){
				$(this).find(".jumlah_simpanan .text-center").html(toRp($(this).find(".jumlah_simpanan .text-center").html()));
			}
		});
		
		//TOMBOL KOSONGKAN
		$("button[name=ubah]").hide();
		$("button[name=clear]").click(function(){
			$("button[name=simpan]").show();
			$("button[name=ubah]").hide();
			$("input[name=aksi]").val("Simpan");
			$("input[type=text]").val("");
			$("select[name=id_jenis_simpanan]").val($("select[name=id_jenis_simpanan] option:first").val());
			//$('#defaultForm').data('bootstrapValidator').resetForm(true);
		});
		
		//TOMBOL UPDATE
		$(".update").click(function(){
			$("button[name=simpan]").hide();
			$("button[name=ubah]").show();
			$("input[name=aksi]").val("Ubah");
			var index = $(".update").index(this);
			var element = "#data tr:gt("+index+") ";
			$("input[name=id_jenis_anggota]").val($(element+".id_jenis_anggota .text-center").html());
			$("input[name=jabatan]").val($(element+".jabatan .text-center").html());		
			$("select[name=id_jenis_simpanan]").val($(".id_jenis_simpanan .text-center").val());
			var jumlah_simpanan = $(element+".jumlah_simpanan .text-center").html();
			jumlah_simpanan = jumlah_simpanan.replace(/([.Rp. *+?^$|(){}\[\]])/mg, '');
			$("input[name=jumlah_simpanan]").val(jumlah_simpanan);
		});
		
		$(".delete").click(function(){
            var index = $(".delete").index(this);
            var element = "#data tr:gt("+index+")";
            window.location.href = '/KoperasiInti/Jenis_Anggota/deleteData/'+$(element+" td .text-center").html();
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
							<div class="muted pull-left">Form Jenis Simpanan Wajib Anggota</div>
						</div>
						<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>Jenis_Anggota/createData" style="padding-top:1%">
							<fieldset>
								<div class="control-group" style="padding-left:20%">
									<label class="control-label"><strong>Jabatan</strong></label>
									<div class="controls">
										<input type="text" name="jabatan" class="input-xlarge" value=""/>
									</div>
								</div>
								<div class="control-group" style="padding-left:20%">
									<label class="control-label"><strong>Jumlah Simpanan</strong></label>
									<div class="controls">
										<input type="text" name="jumlah_simpanan" class="input-xlarge" value=""/>
									</div>
								</div>
								<div class="form-actions" style="margin-bottom:-2%; padding-left:39%">
									<input type="hidden" name="id_jenis_anggota" value=""/>
									<input type="hidden" name="id_jenis_simpanan" value="JSMP-02"/>
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
							<div class="muted pull-left">Data Jenis Simpanan Wajib Anggota</div>
						</div>
						<div class="block-content collapse in">
							<div class="span12">
								<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="data">
									<thead>
										<tr>
											<th><div class='text-center'>ID</div></th>
											<th><div class='text-center'>Jabatan</div></th>
											<th><div class='text-center'>Jumlah Simpanan</div></th>
											<th style="width:130px"></th>
										</tr>
									</thead>
									<tbody>
									<?php 
									if(count($records)>0) { 
										foreach($records as $row) {?>
										<tr>
											<td class="id_jenis_anggota"><div class='text-center'><?php echo $row->id_jenis_anggota; ?></div></td>
											<td class="jabatan"><div class='text-center'><?php echo $row->jabatan; ?></div></td>
											<td class="jumlah_simpanan"><div class='text-center'><?php echo $row->jumlah_simpanan; ?></div></td>
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