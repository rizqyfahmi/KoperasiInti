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
								<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>Buku_Besar/detail" style="padding-top:1%">
									<fieldset>
										<div class="control-group" style="padding-left:20%">
											<label class="control-label"><strong>Bulan</strong></label>
											<div class="controls">
												<select name="bulan">
													<option value="1">Januari</option>
													<option value="2">Februari</option>
													<option value="3">Maret</option>
													<option value="4">April</option>
													<option value="5">Mei</option>
													<option value="6">Juni</option>
													<option value="7">Juli</option>
													<option value="8">Agustus</option>
													<option value="9">September</option>
													<option value="10">Oktober</option>
													<option value="11">November</option>
													<option value="12">Desember</option>
												</select>										
											</div>
										</div>
										<div class="control-group" style="padding-left:20%">
											<label class="control-label"><strong>Tahun</strong></label>
											<div class="controls">
												<select name="tahun">
													<?php
														for($tahun = 2013;$tahun<=$records; $tahun++){
													?>
														<option value="<?php echo $tahun;?>"><?php echo $tahun;?></option>
													<?php 
														} 
													?>
												</select>										
											</div>
										</div>
										<div class="control-group" style="padding-left:20%">
											<label class="control-label"><strong>Akun</strong></label>
											<div class="controls">
												<select name="no_referensi">
													<?php foreach($coa as $row) {?>
														<option value="<?php echo $row->no_referensi;?>"><?php echo $row->detail;?></option>
													<?php } ?>
												</select>									
											</div>
										</div>
										<div class="form-actions" style="margin-bottom:-2%; padding-left:38%">
											<button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
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