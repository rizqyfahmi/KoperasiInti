<?php include 'header.php';?>
<?php include 'library.php';?>
<!--script src="<!?php echo base_url(); ?>assets/bootstrap/js/bootstrap-carousel.js"></script-->
<script type="text/javascript">
   $(document).ready(function(){
		actionViewLogin();
   })
</script>
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container-fluid">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			
			<div class="nav-collapse collapse">
				<ul class="nav pull-right">
					<li><a class="brand" href="<?php echo base_url(); ?>">Koperasi Inti</a></li>
					<li>
						<form class="navbar-form pull-left" method="POST" action="<?php echo base_url(); ?>Main/validate">
						  <input type="text" name="username" class="span2" placeholder="username"/>
						  <input type="password" name="password" class="span2" placeholder="password"/>
						  <button type="button" id="simpan" data-loading-text="Validasi..." class="btn btn-primary">Masuk</button>
						</form>
					</li>
				</ul>
			</div>
       </div>
	</div>
</div>	
<div id="modal_alert" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:50%">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3 id="myModalLabel">Error!</h3>
	</div>
	<div class="modal-body">
		
	</div>
</div>
<?php include 'footer.php';?>