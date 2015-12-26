function auto(str, length){
	var def = "";
	var start = length;
	for(var i=0;i<length;i++){
		if(str.split('')[i]>0){
			start = i;
			break;
		}
	}
	str = parseInt(str.substr(start, length))+1;
	length = length - str.toString().split('').length;
	for(var i=0;i<length;i++){
		def += "0";
	}
	str = def+str;
	return str;
}

function customValidation(){
	//VALIDASI MAX SALDO
	jQuery.validator.addMethod("maxSaldo", function(value, param) {
		var simpanan_wajib = $('#simpanan_wajib').html();
		simpanan_wajib = simpanan_wajib.replace(/([.Rp. *+?^$|(){}\[\]])/mg, '');	
		return parseInt(value) <= parseInt(simpanan_wajib);
	}, "Saldo tidak mencukupi!");
	//VALIDASI KELIPATAN
	jQuery.validator.addMethod("validPenarikan", function(value, param) {
		return (parseInt(value) % 100000) == 0;
	}, "Kelipatan Rp. 100.000!");
	//VALIDASI NOT EQUALS
	jQuery.validator.addMethod("notEqualAngsuran", function(value, element, param) {
		var equals = false
		var id_anggota = $('input[name=id_anggota]').val();
		var id_pinjaman = $('input[name=id_pinjaman]').val();
		value_tanggal = value.split('-')[0]+"-"+value.split('-')[1];
		$.each(param, function(i, obj){
			obj_tanggal = obj.tanggal_pembuatan.split('-')[0]+"-"+obj.tanggal_pembuatan.split('-')[1];
			if((id_anggota == obj.id_anggota) && (value_tanggal == obj_tanggal) && (id_pinjaman == obj.id_pinjaman)){
				equals = true;
			}
		});
		return this.optional(element) || equals == false;
	}, "Data Sudah Ada!");
	//VALIDASI TANGGAL SIMPANAN
	jQuery.validator.addMethod("notEqualSimpanan", function(value, element, param) {
		var equals = false
		var id_anggota = $('input[name=id_anggota]').val();
		value_tanggal = value.split('-')[0]+"-"+value.split('-')[1];
		$.each(param, function(i, obj){
			obj_tanggal = obj.tanggal_pembuatan.split('-')[0]+"-"+obj.tanggal_pembuatan.split('-')[1];
			if((id_anggota == obj.id_anggota) && (value_tanggal == obj_tanggal)){
				 equals = true;
			}
		});
		return this.optional(element) || equals == false;
	}, "Data Sudah Ada!");
	jQuery.validator.addMethod("tanggalSimpanan", function(value, element, param) {
		var equals = false;
		var id_anggota = $('input[name=id_anggota]').val();
		var value_tanggal = parseInt(value.split('-')[0])+parseInt(value.split('-')[1])+parseInt(value.split('-')[2]);
		$.each(param, function(i, obj){
			obj_tanggal = parseInt(obj.tanggal_masuk.split('-')[0])+parseInt(obj.tanggal_masuk.split('-')[1])+parseInt(obj.tanggal_masuk.split('-')[2]);
			if((id_anggota == obj.id_anggota) && (value_tanggal > obj_tanggal)){
				equals = true;
			}
		});
		return this.optional(element) || equals == true;
	}, "Anda belum terdaftar pada tanggal tersebut!");
	
	//VALIDASI ANGGOTA
	jQuery.validator.addMethod("validateAnggota", function(value, element, param) {
		var found = false
		var id_anggota = $('input[name=id_anggota]').val();
		$.each(param, function(i, obj){
			if(id_anggota == obj.id_anggota){
				 found = true;
			}
		});
		return this.optional(element) || found == true;
	}, "ID Anggota Tidak Ditemukan!");
}

function rupiahConverter(element, subElement){
	$(element).each(function(){
		var rupiah = $(this).find(subElement).html();
		$(this).find(subElement).html(toRp(rupiah));
	});
}

function rupiahConverterNonSub(element){
	$(element).each(function(){
		var rupiah = $(this).html();
		$(this).html(toRp(rupiah));
	});
}

function toRp(angka){
	var rev     = parseInt(angka, 10).toString().split('').reverse().join('');
	var rev2    = '';
	for(var i = 0; i < rev.length; i++){
		rev2  += rev[i];
		if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
			rev2 += '.';
		}
	}
	return 'Rp. ' + rev2.split('').reverse().join('');
}

function replaceRegex(kata){
	kata = kata.replace(/([.Rp. *+?^$|(){}\[\]])/mg, '');
	return kata;
}

function getStatus(status){
	if(status==0) status = "Sedang Mengangsur"; else if(status==1) status = "Lunas"; else if(status==2) status = "-";
	return status;
}

function getJSON(){
	var data = [];
	$.ajax({
		url: '/KoperasiInti/Json/',
		async: false,
		dataType: 'json',
		success: function (json) {
			data = json;
		}
	});
	return data;
}
		
function getSisa(id_pinjaman){
	var sisa = 0;
	$.each(getJSON().pinjaman, function(i, obj){
		if(id_pinjaman == obj.id_pinjaman){
			sisa = obj.jumlah_angsuran;
		}
	});
			
	if(getJSON().angsuran!=undefined){
		$.each(getJSON().angsuran, function(i, obj){
			if(id_pinjaman == obj.id_pinjaman){
				sisa = obj.sisa_pembayaran;
			}
		});
	}
	return sisa;
}
		
function getTanggal(data, id_pinjaman){
	var length = 0;
	$.each(data.pinjaman, function(i, obj){
		if(id_pinjaman == obj.id_pinjaman){
			length = obj.jumlah_angsuran;
		}
	});
	var tanggal = [];
	if(data.angsuran!=undefined){
		$.each(data.angsuran, function(i, obj){
			if(id_pinjaman == obj.id_pinjaman){
				tanggal.push(obj.tanggal_pembuatan);
			}
		});
	}
	length = length - tanggal.length; 
				
	for(var j=0;j<length; j++){
		tanggal.push("-");
	}
	return tanggal;
}

function getSimpananWajib(id_anggota){
	var id_jenis_anggota = '';
	var jumlah_simpanan = 0;
	$.each(getJSON().anggota, function(i, obj){
		if(id_anggota==obj.id_anggota){
			jumlah_simpanan = obj.jumlah_simpanan;
		}
	});
	return jumlah_simpanan;
}

function getSimpananSukarela(id_jenis_simpanan){
	var jumlah_simpanan = 0;
	$.each(getJSON().jenis_simpanan, function(i, obj){
		if(id_jenis_simpanan == obj.id_jenis_simpanan){
			jumlah_simpanan = obj.nominal;
		}
	});
	return jumlah_simpanan;
}


/*-----------------------------------------------------------------------JAVASCRIPT ACTION-----------------------------------------------*/
function actionViewSimpanan(){
		//TOMBOL KOSONGKAN
		$("button[name=ubah]").hide();
		$("button[name=clear]").click(function(){
			$("button[name=simpan]").show();
			$("button[name=ubah]").hide();
			$("input[name=aksi]").val("Simpan");
			$("input[type=text]").val("");
			setIdJenisSimpanan();
			$('#defaultForm').data('bootstrapValidator').resetForm(true);
		});
		//TOMBOL VIEW
		$(".view").click(function(){
            var index = $(".view").index(this);
            var element = "#data tr:gt("+index+") ";
            window.location.href = '/KoperasiInti/Simpanan/detailSimpanan/'+$(element+" td .text-center").html();
		});
		//DATA TABLE
		$('#data').dataTable({});
		//DATE PICKER
		$('input[name=tanggal_pembuatan]').datepicker({
			autoclose: true,
			format: 'yyyy-mm-dd',
			startDate: new Date()
		});
		//AUTOCOMPLETE	
		$('input[name=id_anggota]').typeahead({
			source: function (q, process) {
					return $.get('/KoperasiInti/Json/', {
					q: q
				}, function (response) {
					var data = [];
					$.each(response.anggota, function(i, obj){
						data.push(obj.id_anggota + "#" + obj.nama + "#" + obj.foto + "#" + obj.alamat + "#" + obj.jabatan);
					});
					return process(data);
				});
			},
			highlighter: function (item) {
				var parts = item.split('#'),
				html = '<div class="typeahead">';
				html += '<div class="pull-left"><img src="/KoperasiInti/' + parts[2] + '" width="32" height="32"></div>';
				html += '<div class="pull-left margin-small">';
				html += '<div class="text-left"><strong>' + parts[1] + '</strong></div>';
				html += '<div class="text-left">' + parts[3] + '</div>';
				html += '</div>';
				html += '<div class="clearfix"></div>';
				html += '</div>';
				return html;
			},
			updater: function (item) {
				var parts = item.split('#');
				$("#nama_anggota").val(parts[1]);
				$("#jabatan").val(parts[4]);
				return parts[0];
			},
		});
			//AUTOCOMPLETE:SELECTED
		$('input[name=id_anggota]').on('change', function(obj){
			var id_jenis_simpanan = $("select[name=id_jenis_simpanan]").val();
			var id_anggota = $(this).val();
			var jumlah_simpanan = 0;
			if(id_jenis_simpanan == "JSMP-02"){
				jumlah_simpanan = getSimpananWajib(id_anggota);
			}else if(id_jenis_simpanan == "JSMP-03"){
				jumlah_simpanan = getSimpananSukarela("JSMP-03");
			}
			$("input[name=jumlah_simpanan]").val(jumlah_simpanan);
		});
		//JENIS SIMPANAN ONCHANGE
		$("select[name=id_jenis_simpanan]").change(function(){
			var id_jenis_simpanan = $(this).val();
			var id_anggota = $("input[name=id_anggota]").val();
			var jumlah_simpanan = 0;
			if(id_jenis_simpanan == "JSMP-02"){
				jumlah_simpanan = getSimpananWajib(id_anggota);
			}else if(id_jenis_simpanan == "JSMP-03"){
				jumlah_simpanan = getSimpananSukarela("JSMP-03");
			}
			$("input[name=jumlah_simpanan]").val(jumlah_simpanan);
		});
		//VALIDASI
		$('#defaultForm').validate({
			rules: {
				id_anggota: {
					required: true,
					validateAnggota: getJSON().anggota
				},
				id_jenis_simpanan: {
					required: true
				},
				tanggal_pembuatan: {
					required: true,
					dateISO: true,
					notEqualSimpanan: getJSON().simpanan_non_sukarela,	
					tanggalSimpanan: getJSON().anggota
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
}

function actionViewLogin(){
	$("#simpan").click(function() {
		var dataString = 'username='+ $("input[name=username]").val() + '&password=' + $("input[name=password]").val();
		$.ajax({
			type: "POST",
			url: "/KoperasiInti/Main/validate",
			data: dataString,
			asyc:false,
			success: function(response) {
				if(response == 1){
					window.location.href = '/KoperasiInti/';
				}else{
					$(".modal-body").html("Username dan Password yang anda masukkan salah!");
					$("#modal_alert").modal("show");
				}
			},
			error: function(response){
				//alert("Input Gagal");	
			},
			beforeSend: function () {
				//alert ("loading");        
			}
		});
		return false;
	});
}

function actionViewPinjamanDetail(){
	//JQUERY ACTION
		$('input[name=tanggal_pembuatan]').datepicker({
			autoclose: true,
			format: 'yyyy-mm-dd',
			startDate: new Date()
		});
		var angka = $("#takeHomePay").html();
		angka = angka.replace(/([.Rp. *+?^$|(){}\[\]])/mg, '');
		$("#data tbody tr").each(function(i){
			var nominal_angsuran = $(this).find(".nominal_angsuran .text-center").html();
			nominal_angsuran = nominal_angsuran.replace(/([.Rp. *+?^$|(){}\[\]])/mg, '');
			if(angka-nominal_angsuran < 1000000){
				$(this).find(".terima").prop("disabled", true);
				$(this).css("background-color","red");
			}
			
			var status_pembayaran = $(this).find(".status_pembayaran .text-center").html();
			var sisa_pembayaran = $(this).find(".sisa_pembayaran .text-center").html();
			var id_pinjaman = $(this).find(".id_pinjaman .text-center").html();
			$(this).find(".status_pembayaran .text-center").html(getStatus(status_pembayaran));
			$(this).find(".sisa_pembayaran .text-center").html(getSisa(id_pinjaman));
			
		});
		
		$(".tolak").click(function(){
			var index = $(this).closest('tr').index();
			var element = "#data tr:gt("+index+") ";
			var id = $(element+".id_pinjaman .text-center").html();
			window.location.href = '/KoperasiInti/Pinjaman/konfirmasiPinjaman?id_pinjaman='+id+'&acc=0';
		});
			
		$(".terima").click(function(){
			var index = $(this).closest('tr').index();
			var element = "#data tr:gt("+index+") ";
			var id = $(element+".id_pinjaman .text-center").html();
			window.location.href = '/KoperasiInti/Pinjaman/konfirmasiPinjaman?id_pinjaman='+id+'&acc=1';
		});
		
		$(".angsur").click(function(){
			var index = $(this).closest('tr').index();
			var element = "#data tr:gt("+index+") ";
			var id_pinjaman = $(element+".id_pinjaman .text-center").html();
			var id_anggota = $("#id_anggota").html();
			$("input[name=id_pinjaman]").val(id_pinjaman);
			$("input[name=id_anggota]").val(id_anggota);
			$("#modal_angsur").modal('show');
		});
		
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
		
		$('#data, #info').dataTable({});
		
		$('#defaultForm').validate({
			rules: {
				tanggal_pembuatan: {
					required: true,
					dateISO: true,
					notEqualAngsuran: getJSON().angsuran	
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
		
}
function actionViewAnggota(){
	//TOMBOL KOSONGKAN
		$("button[name=ubah]").hide();
		$("button[name=clear]").click(function(){
			$("button[name=simpan]").show();
			$("button[name=ubah]").hide();
			$("input[name=aksi]").val("Simpan");
			$("input[type=text]").val("");
			$("select[name=id_jenis_anggota]").val($("select[name=id_jenis_anggota] option:first").val());
			$("select[name=status]").val($("select[name=status] option:first").val());
			//$('#defaultForm').data('bootstrapValidator').resetForm(true);
		});
		
		//TOMBOL UPDATE
		$(".update").click(function(){
			$("button[name=simpan]").hide();
			$("button[name=ubah]").show();
			$("input[name=aksi]").val("Ubah");
			var index = $(".update").index(this);
			var element = "#data tr:gt("+index+") ";
			$("#id_anggota").val($(element+".id_anggota .text-center").html());
			$("input[name=id_anggota]").val($(element+".id_anggota .text-center").html());
			$("input[name=nama]").val($(element+".nama .text-center").html());
			$("input[name=alamat]").val($(element+".alamat .text-center").html());
			$("input[name=tanggal_masuk]").val($(element+".tanggal_masuk .text-center").html());
			var angka = $(element+".gaji .text-center").html();
			angka = angka.replace(/([.Rp. *+?^$|(){}\[\]])/mg, '');
			$("input[name=gaji]").val(angka);
			$("select[name=id_jenis_anggota]").val($(element+".id_jenis_anggota").html());
			$("select[name=status]").val($(element+".status .text-center").html());
		});
		
		$(".delete").click(function(){
            var index = $(".delete").index(this);
            var element = "#data tr:gt("+index+") ";
            window.location.href = '/KoperasiInti/Anggota/deleteData/'+$(element+" td .text-center").html();
		});
		$('input[name=tanggal_masuk]').datepicker({
			autoclose: true,
			format: 'yyyy-mm-dd',
			startDate: new Date()
		});
		$('#data').dataTable({});
		
		$('#defaultForm').validate({
				rules: {
					nama: {
						required: true
					},
					alamat: {
						required: true
					},
					tanggal_masuk: {
						required: true,
						dateISO: true
					},
					gaji: {
						required: true,
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
}

