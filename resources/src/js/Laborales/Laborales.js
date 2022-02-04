$("#txtFind").keyup(function () {
	var Cliente = document.getElementById("txtFind").value;
	$.ajax({
		data: {Cliente:Cliente},
		url:   'findCliente',
		type:  'post',
		beforeSend: function () {
		},
		success:  function (response) {
			$(".result").html(response);
		},
		error:function(){
			alert("Error al Buscar Cliente");
		}
	});
});

$('#ClienteNuevoForm').on('submit',function(e) {
	e.preventDefault();
	var formData = new FormData($(this)[0]);

	Swal.fire({
		title: '¿Estas segur@ que desea guardar?',
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Continuar',
		cancelButtonText: 'Cancelar',
		reverseButtons: true
	}).then((result) => {
		if (result.isConfirmed) {

			$.ajax({
				url:'saveCliente',
				data: formData,
				async: false,
				cache: false,
				dataType: 'json',
				contentType: false,
				processData: false,
				type:'POST',
				success:function(data){
					if (data.estado==true) {
						Swal.fire({
							icon: 'success',
							title: '¡Exito!',
							text: data.descripcion,
						});
						setTimeout( function(){
							location.reload();
						}, 1000 );
					}else{
						Swal.fire({
							icon: 'error',
							title: '¡Error!',
							text: data.descripcion,
						});
					}
				}
			});
		}
	});
});

$(document).on('click', '.edit', function() {

	var id = $(this).val();

	$.post("getAgencias",{
		idAgencia : $('#Agencia'+id).text()
	}, function (data) {
		$("#txtUAgencia").html(data);
	});

	$.ajax({
		url: "getInfo",
		type: "POST",
		data: {id: id},
	})
		.done(function (output) {
			var datos = JSON.parse(output);
			console.log(datos);
			$('#txtid').val(datos[0].id);
			$('#txtUNombre').val(datos[0].Demandante);
			$('#txtUfecha').val(datos[0].FechaDemanda);
			$("#cmbUestado option[value='"+ datos[0].Estado +"']").attr("selected",true);
			$('#txtUObservaciones').val(datos[0].Observaciones);
			$('#EditarClienteModal').modal('show');
		});
});

$('#EditarClienteForm').on('submit',function(e) {
	e.preventDefault();
	var formData = new FormData($(this)[0]);

	Swal.fire({
		title: '¿Estas segur@ que desea actualizar?',
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Continuar',
		cancelButtonText: 'Cancelar',
		reverseButtons: true
	}).then((result) => {
		if (result.isConfirmed) {

			$.ajax({
				url:'updateCliente',
				data: formData,
				async: false,
				cache: false,
				dataType: 'json',
				contentType: false,
				processData: false,
				type:'POST',
				success:function(data){
					if (data.estado==true) {
						Swal.fire({
							icon: 'success',
							title: '¡Exito!',
							text: data.descripcion,
						});
						setTimeout( function(){
							location.reload();
						}, 1000 );
					}else{
						Swal.fire({
							icon: 'error',
							title: '¡Error!',
							text: data.descripcion,
						});
					}
				}
			});
		}
	});
});
