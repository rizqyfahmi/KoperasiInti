<?php include 'header.php';?>
<?php include 'library.php';?>
<script>
	$(document).ready(function(){
		rupiahConverter("#data tbody tr", ".nominal_pinjaman .text-center");
		rupiahConverter("#data tbody tr", ".nominal_angsuran .text-center");
		
		//TOMBOL KOSONGKAN
		$("button[name=ubah]").hide();
		$("button[name=clear]").click(function(){
			$("button[name=simpan]").show();
			$("button[name=ubah]").hide();
			$("input[name=aksi]").val("Simpan");
			$("#id_pinjaman").val(id);
			$("input[name=id_pinjaman]").val(id);
			$("select[name=id_anggota]").val($("select[name=id_anggota] option:first").val());
			$("select[name=id_jenis_pinjaman]").val($("select[name=id_jenis_pinjaman] option:first").val());
			$("input[name=nominal_pinjaman]").val("");
			$("input[name=nominal_angsuran]").val("");
			$("input[name=jumlah_angsuran]").val("");
			//$('#defaultForm').data('bootstrapValidator').resetForm(true);
		});
		
		
		getData();
		function getData(){
			var url =  "/KoperasiInti/Anggota/getJSON";
			$.getJSON(url,  function(data) {
				var id_anggota = $("input[name=id_anggota]").val();
				var jumlah_simpanan = 0;
				$.each(data.anggota, function(i, obj){
					if(id_anggota==obj.id_anggota){
						$("#nama_anggota").val(obj.nama);
						$("#jabatan").val(obj.jabatan);
						$("#gaji").val(obj.gaji);
					}
				});
				$("input[name=nominal_pinjaman]").on("input",function(){
					var val = $(this).val();
					if(val.trim()!="" && val>=1000000){
						var length = data.jenis_pinjaman.length;
						$.each(data.jenis_pinjaman, function(i, obj){
							if((i+1)<length){
								if(parseInt(val)>=parseInt(data.jenis_pinjaman[i].jumlah_pinjaman) && parseInt(val)<=parseInt(data.jenis_pinjaman[i+1].jumlah_pinjaman)){
									$("#id_jenis_pinjaman").val(data.jenis_pinjaman[i].detail);
									$("input[name=id_jenis_pinjaman]").val(data.jenis_pinjaman[i].id_jenis_pinjaman);
									
								}else if(parseInt(val)>parseInt(data.jenis_pinjaman[i+1].jumlah_pinjaman)){
									$("#id_jenis_pinjaman").val(data.jenis_pinjaman[i+1].detail);
									$("input[name=id_jenis_pinjaman]").val(data.jenis_pinjaman[i+1].id_jenis_pinjaman);
								}
							}
						});
						var option = "";
						$.each(data.jenis_angsuran, function(i, obj){
							if($("input[name=id_jenis_pinjaman]").val() == obj.id_jenis_pinjaman){
								option += "<option value='"+obj.id_jenis_angsuran+"'>"+obj.periode+"</option>";
							}
						});
						$("select[name=id_jenis_angsuran]").html(option);
						var val = $($("select[name=id_jenis_angsuran] option:first")).val();
						$.each(data.jenis_angsuran, function(i, obj){
							if(val == obj.id_jenis_angsuran){
								setPinjaman(obj);
							}
						});
					}else{
						$("select[name=id_jenis_angsuran]").html("");
						$("#id_jenis_pinjaman").val("");
						$("input[name=id_jenis_pinjaman]").val("");
						$("#flat").val("");
						$("input[name=jumlah_angsuran]").val("");
						$("#nominal_angsuran").val("");
					}
				});
				
				$("select[name=id_jenis_angsuran]").change(function(){
					var val = $(this).val();
					$.each(data.jenis_angsuran, function(i, obj){
						if(val == obj.id_jenis_angsuran){
							setPinjaman(obj);
						}
					});
				})
			});
		}
		function setPinjaman(obj){
			var pinjaman = $("input[name=nominal_pinjaman]").val();
			$("#flat").val(obj.flat);
			$("input[name=jumlah_angsuran]").val(obj.jumlah_angsuran);
			var pokok = $("input[name=nominal_pinjaman]").val() / obj.jumlah_angsuran;
			var jasa = ((obj.flat/100) / 12) * $("input[name=nominal_pinjaman]").val();
			$("#nominal_angsuran").val(parseInt(Math.ceil(pokok))+parseInt(Math.ceil(jasa)));
			$("input[name=angsuran_pokok]").val(Math.ceil(pokok));
			$("input[name=angsuran_bunga]").val(Math.ceil(jasa));
			var data = "";
			var jml_pokok = 0, jml_jasa = 0, jml = 0;
			for(var j=0;j<obj.jumlah_angsuran;j++){
				data += "<tr>";
				data += "<td><div class='text-center'>"+(j+1)+"</div></td>";
				data += "<td><div class='text-center'>"+Math.ceil(pinjaman)+"</div></td>";
				data += "<td><div class='text-center'>"+Math.ceil(pokok)+"</div></td>";
				data += "<td><div class='text-center'>"+Math.ceil(jasa)+"</div></td>";
				data += "<td><div class='text-center'>"+(parseInt(Math.ceil(pokok))+parseInt(Math.ceil(jasa)))+"</div></td>";
				data += "</tr>";
				pinjaman = Math.ceil(pinjaman) - Math.ceil(pokok);
				jml_pokok += Math.ceil(pokok);
				jml_jasa += Math.ceil(jasa);
				jml += Math.ceil(pokok)+Math.ceil(jasa);
			}
			data += "<tr>";
			data += "<td><div class='text-center'></div></td>";
			data += "<td><div class='text-center'></div></td>";
			data += "<td><div class='text-center'>"+jml_pokok+"</div></td>";
			data += "<td><div class='text-center'>"+jml_jasa+"</div></td>";
			data += "<td><div class='text-center'>"+jml+"</div></td>";
			data += "</tr>";
			$("#simulasi tbody").html(data);
		}
		
		$(".detail").click(function(){
			var index = $(this).closest('tr').index();
			var element = "#data tr:gt("+index+") ";
			var id_pinjaman = $(element+".id_pinjaman .text-center").html();
			var id_anggota = $("#id_anggota").html();
			var html = "";
			$.each(getJSON().pinjaman, function(i, obj){
				if(id_pinjaman==obj.id_pinjaman){
					var nominal_pinjaman = obj.nominal_pinjaman;
					for(var j=0;j<obj.jumlah_angsuran; j++){
						html += "<tr>";
						html += "<td><div class='text-center'>"+(j+1)+"</div></td>";
						html += "<td><div class='text-center'>"+nominal_pinjaman+"</div></td>";
						html += "<td><div class='text-center'>"+obj.angsuran_pokok+"</div></td>";
						html += "<td><div class='text-center'>"+obj.angsuran_bunga+"</div></td>";
						html += "<td><div class='text-center'>"+(parseInt(obj.angsuran_pokok)+parseInt(obj.angsuran_bunga))+"</div></td>";
						html += "<td><div class='text-center'>"+getTanggal(getJSON(), obj.id_pinjaman)[j]+"</div></td>";
						html += "</tr>";
						nominal_pinjaman = nominal_pinjaman - parseInt(obj.angsuran_pokok);
					}
				}
			});
			$("#detail tbody").html(html);
			$("#modal_detail").modal('show');
		});
		$('#data').dataTable({});
		
		$('#defaultForm').validate({
				rules: {
					nominal_pinjaman: {
						required: true,
						digits: true
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
							<div class="muted pull-left">Form Pinjaman</div>
						</div>
						<form id="defaultForm" class="form-horizontal" method="post" action="<?php echo base_url(); ?>Pinjaman/createData" style="padding-top:1%">
							<fieldset>
								<div class="control-group" style="padding-left:20%">
									<label class="control-label"><strong>ID Anggota</strong></label>
									<div class="controls">
										<input type="text" class="input-xlarge" id="id_anggota" name="id_anggota" value="<?php echo $this->session->userdata('pengguna')->id_anggota; ?>" readonly="true"/>
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
									<label class="control-label"><strong>Gaji Pokok</strong></label>
									<div class="controls">
										<div class="input-prepend">
											<span class="add-on">Rp</span>
											<input type="text" id="gaji" value="" style="width:125%" readonly="true"/>
										</div>
									</div>
								</div>
								<div class="control-group" style="padding-left:20%">
									<label class="control-label"><strong>Nominal Peminjaman</strong></label>
									<div class="controls">
										<div class="input-prepend">
											<span class="add-on">Rp</span>
											<input type="text" name="nominal_pinjaman" value="" style="width:125%"/>
										</div>
									</div>
								</div>
								<div class="control-group" style="padding-left:20%">
									<label class="control-label"><strong>Jenis Pinjaman</strong></label>
									<div class="controls">
										<input type="text" id="id_jenis_pinjaman" class="input-xlarge" value="" readonly="true"/>
										<input type="hidden" name="id_jenis_pinjaman" class="input-xlarge" value="" />
									</div>
								</div>
								<div class="control-group" style="padding-left:20%">
									<label class="control-label"><strong>Jangka Waktu</strong></label>
									<div class="controls">
										<select name="id_jenis_angsuran" style="width:32%">
										
										</select>
										<div class="input-append">
											<input type="text" value="" id="flat" style="width:20%" readonly="true"/>
											<span class="add-on">%</span>
										</div>
									</div>
								</div>
								<div class="control-group" style="padding-left:20%">
									<label class="control-label"><strong>Nominal Angsuran</strong></label>
									<div class="controls">
										<div class="input-prepend input-append">
											<span class="add-on">Rp</span>
											<input type="text" id="nominal_angsuran" value="" style="width:80%" readonly="true"/>
											<span class="add-on">/Bulan</span>
										</div>
									</div>
								</div>
								<div class="control-group" style="padding-left:20%">
									<label class="control-label"><strong>Jumlah Angsuran</strong></label>
									<div class="controls">
										<div class="input-append">
											<input type="text" name="jumlah_angsuran" value="" style="width:15%" readonly="true"/>
											<span class="add-on">Kali</span>
										</div>
									</div>
								</div>
								<div class="form-actions" style="margin-bottom:-2%; padding-left:39%">
									<input type="hidden" name="angsuran_pokok" value=""/>
									<input type="hidden" name="angsuran_bunga" value=""/>
									<input type="hidden" name="id_pinjaman" value=""/>
									<input type="hidden" name="acc" value="2"/>
									<input type="hidden" name="status_pembayaran" value="2"/>
									<input type="hidden" name="aksi" value="Simpan"/>
									<button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
									<button type="submit" name="ubah" class="btn btn-warning">Ubah</button>
									<button type="button" name="clear" class="btn">Batal</button>
									<a href="#modal_simulasi" role="button" class="btn btn-info" data-toggle="modal">Simulasi</a>
								</div>
							</fieldset>
						</form>
					</div>
                </div>
				<div class="row-fluid">
					<div class="block">
						<div class="navbar navbar-inner block-header">
							<div class="muted pull-left">Data Pinjaman</div>
						</div>
						<div class="block-content collapse in">
							<div class="span12">
								<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="data">
									<thead>
										<tr>
											<th style="width:130px"><div class='text-center'>ID</div></th>
											<th><div class='text-center'>Nominal Peminjaman</div></th>
											<th><div class='text-center'>Nominal Angsuran</div></th>
											<th><div class='text-center'>Jenis Pinjaman</div></th>
											<th><div class='text-center'>Status</div></th>
											<th><div class='text-center'></div></th>
										</tr>
									</thead>
									<tbody>
									<?php 
									if(count($records)>0) { 
										foreach($records as $row) {?>
										<tr>
											<td class="id_pinjaman"><div class='text-center'><?php echo $row->id_pinjaman; ?></div></td>
											<td class="nominal_pinjaman"><div class='text-center'><?php echo $row->nominal_pinjaman; ?></div></td>
											<td class="nominal_angsuran"><div class='text-center'><?php echo $row->angsuran_pokok+$row->angsuran_bunga; ?></div></td>
											<td class="id_jenis_pinjaman"><div class='text-center'><?php echo $row->jenis_pinjaman; ?></div></td>
											<td class="acc"><div class='text-center'><?php 
												if($row->acc==1){
													echo "Diterima";
												}else if($row->acc==2){
													echo "Menunggu";
												}else if($row->acc==0){
													echo "Ditolak";
												}
											?></div></td>
											<td>
												<?php if($row->acc==1){ ?>
													<div class='text-center'><button class='detail btn btn-info'>Detail</button></div>
												<?php }else{ ?>
													<div class='text-center'><button class='detail btn btn-info' disabled="true">Detail</button></div>
												<?php } ?>
												
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
		
		<!--Modal Simulasi-->
		<div id="modal_simulasi" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:50%">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 id="myModalLabel">Simulasi Pinjaman</h3>
			</div>
			<div class="modal-body">
				<div id="myCarousel" class="carousel slide" data-interval="3000" data-ride="carousel">
					<div class="carousel-inner">
						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="simulasi">
							<thead>
								<tr>
									<th style="width:130px" rowspan="2"><div class='text-center'>Bulan Ke</div></th>
									<th style="width:130px" rowspan="2"><div class='text-center'>Pinjaman</div></th>
									<th style="width:130px"><div class='text-center'>Angsuran</div></th>
								</tr>
								<tr>
									<th><div class='text-center'>Pokok</div></th>
									<th><div class='text-center'>Bunga</div></th>
									<th><div class='text-center'>Jumlah</div></th>
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