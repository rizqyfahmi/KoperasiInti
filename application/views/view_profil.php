<?php include 'header.php';?>
<?php include 'library.php';?>
<script>
	$(document).ready(function() {
		$('#defaultForm').validate({
			rules: {
				nama: {
					required : true
				},
				alamat: {
					required : true
				},
				gaji: {
					required : true,
					digits:true
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
		
		$('#passwordForm').validate({
			rules: {
				password: {
					required : true
				},
				repassword: {
					required : true,
					equalTo: "#password"
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
							<div class="muted pull-left">Sunting Profil</div>
						</div>
						<div class="block-content collapse in">
							<div class="span12">
								<form id="defaultForm" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>Profil/updateData" style="padding-top:1%">
									<fieldset>
										<div class="control-group" style="padding-left:20%">
											<label class="control-label"><strong>Nama</strong></label>
											<div class="controls">
												<input type="text" name="nama" class="input-xlarge" value="<?php echo $anggota->nama?>"/>
											</div>
										</div>
										<div class="control-group" style="padding-left:20%">
											<label class="control-label"><strong>Alamat</strong></label>
											<div class="controls">
												<input type="text" name="alamat" class="input-xlarge" value="<?php echo $anggota->alamat?>"/>
											</div>
										</div>										
										<div class="control-group" style="padding-left:20%">
											<label class="control-label"><strong>Foto</strong></label>
											<div class="controls">
												<input type="file" name="foto" accept=".jpg" class="input-xlarge" value=""/>
											</div>
										</div>
										<div class="form-actions" style="margin-bottom:-2%; padding-left:39%">
											<button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
											<button type="button" name="clear" class="btn">Batal</button>
										</div>
									</fieldset>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="block">
						<div class="navbar navbar-inner block-header">
							<div class="muted pull-left">Sunting Password</div>
						</div>
						<div class="block-content collapse in">
							<div class="span12">
								<form id="passwordForm" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>Profil/updatePassword" style="padding-top:1%">
									<fieldset>
										<div class="control-group" style="padding-left:20%">
											<label class="control-label"><strong>Password</strong></label>
											<div class="controls">
												<input type="password" id="password" name="password" class="input-xlarge" value="" placeholder="Password Baru"/>
											</div>
										</div>
										<div class="control-group" style="padding-left:20%">
											<label class="control-label"><strong>Ulangi Password</strong></label>
											<div class="controls">
												<input type="password" name="repassword" class="input-xlarge" value="" placeholder="Ulangi Password Baru"/>
											</div>
										</div>									
										<div class="form-actions" style="margin-bottom:-2%; padding-left:39%">
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