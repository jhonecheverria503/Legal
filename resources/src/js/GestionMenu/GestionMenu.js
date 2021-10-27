$(document).ready(function(){
	$.ajax({
		url:   'getOpciones',
		type:  'post',
		beforeSend: function () { },
		success:  function (response) {
			$("#result").html(response);
			$.post("getPadres",{
			}, function (output) {
				$("#cbxPadre").html(output);
			});
		},
		error:function(){
			swal({
				title: "Error!",
				text: "Error al cargar las opciones del menú",
				type: 'error',
				closeOnConfirm: true,
				closeOnCancel: true
			});
		}
	});
	$(document).on('click', '.edit', function(){
		var id=$(this).val();
		$.post("getPadres",{
		}, function (output) {
			$("#cbxUPadre").html(output);
			$.ajax({
				url: "getOpcion",
				type: "POST",
				data: {id:id},
			})
			.done(function (data){
				var datos =  JSON.parse(data);
				$('#txtUCategoria').val(datos.categoria);
				$('#txtUDescripcion').val(datos.descripcion);
				$('#txtUUrl').val(datos.URL);
				$('#idU').val(datos.idOpcion);
				if(datos.estado==''){
					$('#chkUEstado').attr('checked',true);
				}
				else{
					$('#chkUEstado').attr('checked',false);
				}
				if(datos.idPadre == 0){
					$('#cbxUPadre option[value=Null]').attr('selected',true);
				}
				else{
					$('#cbxUPadre option[value="' + datos.idPadre + '"]').attr('selected',true);
				}
			});
			$('#EditarOpcionModal').modal('show');
		});
	});
	$('#frmOpcionMenu').on('submit',function(e) {
		e.preventDefault();
		var formData = new FormData($(this)[0]);
		$.ajax({
			url:'getParameter',
			data: formData,
			async: false,
			cache: false,
			dataType: 'json',
			contentType: false,
			processData: false,
			type:'POST',
			showConfirmButton: false,
			success:function(data){
				if (data.estado==true) {
					swal({
						title: "Exito!",
						text: data.descripcion,
						type: 'success',
						timer: 2000,
						closeOnConfirm: true,
						closeOnCancel: true
					});
					setTimeout( function(){
						location.reload();
					}, 1000 );
				}else{
					swal({
						title: "Error!",
						text: data.descripcion,
						timer: 1500,
						type: 'error',
						closeOnConfirm: true,
						closeOnCancel: true
					});
				}
			}
		});
	});
	$('#frmUOpcionMenu').on('submit',function(e) {
		e.preventDefault();
		var formData = new FormData($(this)[0]);
		$.ajax({
			url:'getParameter',
			data: formData,
			async: false,
			cache: false,
			dataType: 'json',
			contentType: false,
			processData: false,
			type:'POST',
			showConfirmButton: false,
			success:function(data){
				if (data.estado==true) {
					swal({
						title: "Exito!",
						text: data.descripcion,
						type: 'success',
						timer: 2000,
						closeOnConfirm: true,
						closeOnCancel: true
					});
					setTimeout( function(){
						location.reload();
					}, 1000 );
				}else{
					swal({
						title: "Error!",
						text: data.descripcion,
						timer: 1500,
						type: 'error',
						closeOnConfirm: true,
						closeOnCancel: true
					});
				}
			}
		});
	});
});
