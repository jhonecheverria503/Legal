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
		title: '¿Estas segur@ de editar la garantia?',
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
			$('#txtUNombre').val(datos[0].Nombre);
			$('#txtUPlaca').val(datos[0].Placa);
			$('#txtUfechaLegal').val(datos[0].FechaLegal);
			$('#txtUpresentacion').val(datos[0].NumeroPresentacion);
			$('#txtUfecha').val(datos[0].FecOtor);
			$('#txtUfechaCancelacion').val(datos[0].FechaCancelacion);
			$("#cmbUestado option[value='"+ datos[0].Estado +"']").attr("selected",true);
			$("#cmbUTramite option[value='"+ datos[0].EstadoTramite +"']").attr("selected",true);
			$('#txtUObservaciones').val(datos[0].Observaciones);
			$('#EditarClienteModal').modal('show');
		});
});

$('#EditarClienteForm').on('submit',function(e) {
	e.preventDefault();
	var formData = new FormData($(this)[0]);

	Swal.fire({
		title: '¿Estas segur@ de editar la garantia?',
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

function filterFloat(evt, input) {
	// Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
	var key = window.Event ? evt.which : evt.keyCode;
	var chark = String.fromCharCode(key);
	var tempValue = input.value + chark;
	if (key >= 48 && key <= 57) {
		if (filter(tempValue) === false) {
			return false;
		} else {
			return true;
		}
	} else {
		if (key == 8 || key == 13 || key == 0) {
			return true;
		} else if (key == 46) {
			if (filter(tempValue) === false) {
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
}

function filter(__val__) {
	var preg = /^([0-9]+\.?[0-9]{0,2})$/;
	if (preg.test(__val__) === true) {
		return true;
	} else {
		return false;
	}

}

