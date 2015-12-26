<?php include 'header.php';?>
<?php include 'library.php';?>
<style>
.datepicker{z-index:1151;}
</style>
<script>
	$(document).ready(function(){
		$("#data tr").each(function(){
			if($(this).find(".nominal_pinjaman .text-center").html()!=undefined){
				//$("#data tr").find(".nominal_pinjaman .text-center").html();
				//alert($(this).find(".nominal_pinjaman .text-center").html());
				$(this).find(".nominal_pinjaman .text-center").html(toRp($(this).find(".nominal_pinjaman .text-center").html()))
				//alert();
			}
		});
		
		//TOMBOL VIEW
		$(".view").click(function(){
			var index = $(".view").index(this);
			var element = "#data tr:gt("+index+") ";
			var id = $(element+".id_anggota .text-center").html();
			var html = "";
			var k = 1;
			$.each(getJSON().pinjaman, function(i, obj){
				if(id==obj.id_anggota){
					html += "<tr>";
					html += "<td><div class='text-center'>"+k+"</div></td>";
					html += "<td class='id_pinjaman'><div class='text-center'>"+obj.id_pinjaman+"</div></td>";
					html += "<td><div class='text-center'>"+obj.nominal_pinjaman+"</div></td>";
					html += "<td><div class='text-center'>"+getSisa(getJSON(), obj.id_pinjaman)+"</div></td>";
					html += "<td class='rupiah'><div class='text-center'>"+getStatus(obj.status_pembayaran)+"</div></td>";
					if(obj.acc==1){
						html += "<td><div class='text-center'><button class='angsur btn btn-warning' data-target='#myCarousel' data-slide-to='1'>Angsur</button></div></td>";
						html += "<td><div class='text-center'><button class='detail btn btn-info' data-target='#myCarousel' data-slide-to='2'>Detail</button></div></td>";
					}else{
						html += "<td><div class='text-center'><button class='tolak btn btn-warning'>Tolak</button></div></td>";
						html += "<td><div class='text-center'><button class='terima btn btn-info'>Terima</button></div></td>";
					}
					
					html += "</tr>";
					k++;
				}
			});
			$("#carousel tbody").html(html);
			$("#modal").modal('show');
			//TOMBOL ANGSUR
			$(".angsur").click(function(){
				var index = $(this).closest('tr').index();
				var element = "#carousel tr:gt("+index+") ";
				var id = $(element+".id_pinjaman .text-center").html();
				$.each(getJSON().pinjaman, function(i, obj){
					var id2 = obj.id_pinjaman.trim();
					if(id==id2){
						$("input[name=id_pinjaman]").val(obj.id_pinjaman);
						$("input[name=id_anggota]").val(obj.id_anggota);
					}
				});
			});
			//TOMBOL DETAIL
			$(".detail").click(function(){
				var index = $(this).closest('tr').index();
				var element = "#carousel tr:gt("+index+") ";
				var id = $(element+".id_pinjaman .text-center").html();
				var html = "";
				$.each(getJSON().pinjaman, function(i, obj){
					if(id==obj.id_pinjaman){
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
			});
			
			$(".tolak").click(function(){
				var index = $(this).closest('tr').index();
				var element = "#carousel tr:gt("+index+") ";
				var id = $(element+".id_pinjaman .text-center").html();
				window.location.href = '/KoperasiInti/Pinjaman/konfirmasiPinjaman?id_pinjaman='+id+'&acc=0';
				
			});
			
			$(".terima").click(function(){
				var index = $(this).closest('tr').index();
				var element = "#carousel tr:gt("+index+") ";
				var id = $(element+".id_pinjaman .text-center").html();
				window.location.href = '/KoperasiInti/Pinjaman/konfirmasiPinjaman?id_pinjaman='+id+'&acc=1';
				
			});
		});
		
		$('.carousel').each(function(){
			$(this).carousel({
				interval: false
			});
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
							<div class="muted pull-left">Data Level</div>
						</div>
						<div class="block-content collapse in">
							<div class="span12">
								<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="data">
									<thead>
										<tr>
											<th><div class='text-center'>ID Anggota</div></th>
											<th><div class='text-center'>Nama</div></th>
											<th><div class='text-center'>Jumlah Pinjaman</div></th>
											<th><div class='text-center'>Total Pinjaman</div></th>
											<th style="width:50px"></th>
										</tr>
									</thead>
									<tbody>
									<?php 
									if(count($records)>0) { 
										foreach($records as $row) {?>
										<tr>
											<td class="id_anggota"><div class='text-center'><?php echo $row->id_anggota; ?></div></td>
											<td class="nama"><div class='text-center'><?php echo $row->nama; ?></div></td>
											<td class="nominal_pinjaman"><div class='text-center'><?php echo $row->nominal_pinjaman; ?></div></td>
											<td class="total_pinjaman"><div class='text-center'><?php echo $row->total_pinjaman; ?></div></td>
											<td>
												<center>
													<button class="view btn btn-warning">View</button>
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
	<div id="modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:50%">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 id="myModalLabel">Detail Pinjaman</h3>
		</div>
		<div class="modal-body">
			<div id="myCarousel" class="carousel slide" data-interval="3000" data-ride="carousel">
				<!-- Carousel indicators -->
				<!--ol class="carousel-indicators">
					<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
					<li data-target="#myCarousel" data-slide-to="1"></li>
					<li data-target="#myCarousel" data-slide-to="2"></li>
				</ol-->   
			   <!-- Carousel items -->
				<div class="carousel-inner">
					<div class="active item">
						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="carousel">
							<thead>
								<tr>
									<th style="width:130px"><div class='text-center'>No</div></th>
									<th style="width:130px"><div class='text-center'>ID Pinjaman</div></th>
									<th style="width:130px"><div class='text-center'>Nominal Pinjaman</div></th>
									<th style="width:130px"><div class='text-center'>Sisa Pembayaran</div></th>
									<th style="width:130px"><div class='text-center'>Status Pembayaran</div></th>
									<th style="width:130px"><div class='text-center'></div></th>
								</tr>
							</thead>
							<tbody>
							
							</tbody>
						</table>
					</div>
					<div class="item">
						<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>Angsuran/createData" style="padding-top:1%">
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
										<!--div class="input-append date datepicker no-padding" data-date-format="dd-mm-yyyy">
											<input class="input-medium" size="16" type="text"><span class="add-on"><i class="icon-th"></i></span>
										</div-->
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
								<!--div class="form-actions" style="margin-bottom:-2%; padding-left:39%">
									<button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
									<button type="button" name="clear" class="btn">Batal</button>
								</div-->
							</fieldset>
						</form>
					</div>
					<div class="item">
						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="detail">
							<thead>
								<tr>
									<th style="width:130px" rowspan="2"><div class='text-center'>Bulan Ke</div></th>
									<th style="width:130px" rowspan="2"><div class='text-center'>Pinjaman</div></th>
									<th style="width:130px" colspan="3"><div class='text-center'>Angsuran</div></th>
									<th style="width:130px" rowspan="2"><div class='text-center'>Tanggal Pembayaran</div></th>
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
		<div class="modal-footer">
			<!--button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button-->
			<button class="main btn" data-target="#myCarousel" data-slide-to="0"><i class="icon-home"></i></button>
		</div>
	</div>		
	<script>
		$(document).ready(function() {
			$('input[name=tanggal_pembuatan]').datepicker({
				autoclose: true,
				format: 'yyyy-mm-dd',
				startDate: new Date()
			});
			
		});
	</script>
<?php include 'footer.php';?>