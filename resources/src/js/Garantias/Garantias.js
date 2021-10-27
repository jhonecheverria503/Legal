$("#txtFind").keyup(function(){
	var readonly = $(this).attr("readonly"); if(readonly && readonly.toLowerCase()!=='false')
	{

	}
	else {
		var Referencia = document.getElementById("txtFind").value;
		$.ajax({
			data: {Referencia: Referencia},
			url: 'findCredito',
			type: 'post',
			beforeSend: function () {
			},
			success: function (response) {
				$(".result").html(response);
				$("#Creditos").DataTable({
					"ordering": true,
					"language": {
						"sProcessing": "Procesando...",
						"sLengthMenu": "Mostrar _MENU_ registros",
						"sZeroRecords": "No se encontraron resultados",
						"sEmptyTable": "Ningún dato disponible en esta tabla",
						"sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
						"sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
						"sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
						"sInfoPostFix": "",
						"sSearch": "Buscar:",
						"sUrl": "",
						"sInfoThousands": ",",
						"sLoadingRecords": "Cargando...",
						"oPaginate": {
							"sFirst": "Primero",
							"sLast": "Último",
							"sNext": "Siguiente",
							"sPrevious": "Anterior"
						},
						"oAria": {
							"sSortAscending": ": Activar para ordenar la columna de manera ascendente",
							"sSortDescending": ": Activar para ordenar la columna de manera descendente"
						}
					}
				});


			},
			error: function () {
				alert("Error al Buscar Empleado");
			}
		});
	}
});

$(document).on('click', '.edit', function(){
	var id=$(this).val();

	$.ajax({
		url: "getCredito",
		type:"POST",
		data: {id:id},

	})
		.done(function (output){
			var datos= JSON.parse(output);
			$('#txtReferencia').val(datos[0].Referencia);
			$('#txtNombre').val(datos[0].cnomcli);
			$('#txtProducto').val(datos[0].Producto);
			$('#txtLinea').val(datos[0].Linea);
			$('#txtAsesor').val(datos[0].Asesor);
			$('#txtAgencia').val(datos[0].Agencia);
			bloqueo();
			$.ajax({
				url: "getGarantia",
				type:"POST",
				data: {id:id},

			})
				.done(function (output){
					var data=JSON.parse(output);

					$('#txtentregaAbogado').val(data[0].Abogado);
					$('#txtfirma').val(data[0].entregaRepresentante);
					$('#txtresguardo').val(data[0].entregaOperaciones);
					$('#txtentregaFirma').val(data[0].firma);
					$('#txtInscripcion').val(data[0].inscripcion);
					$('#txtDescripcion').text(data[0].Descripcion);
					$("#cbxEstado option[value='"+ data[0].estado +"']").attr("selected",true);


				});

			$('#GarantiasModal').modal("show");
	});

});

$('#actualizarGarantia').on('submit',function(e) {
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
				url:'actualizarGar',
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

$( "#opcion" ).change(function() {
	var opcion = document.getElementById('opcion').value;
	if (opcion==0)
	{
		$('#txtFind').val("");
		$('#txtFind').removeAttr("readonly","readonly");
		$(".result").empty();

	}

	if(opcion=="En Proceso")
	{
		$('#txtFind').val("");
		$('#txtFind').attr("readonly","readonly");
		$(".result").empty();

		var opciones=document.getElementById('opcion').value;

		$.ajax({
			data: {opciones:opciones},
			url:   'listarCredito',
			type:  'post',
			beforeSend: function () {
			},
			success:  function (response) {
				$(".result").html(response);
				$("#Creditos").DataTable({
					"ordering": true,
					"language": {
						"sProcessing":    "Procesando...",
						"sLengthMenu":    "Mostrar _MENU_ registros",
						"sZeroRecords":   "No se encontraron resultados",
						"sEmptyTable":    "Ningún dato disponible en esta tabla",
						"sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
						"sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
						"sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
						"sInfoPostFix":   "",
						"sSearch":        "Buscar:",
						"sUrl":           "",
						"sInfoThousands":  ",",
						"sLoadingRecords": "Cargando...",
						"oPaginate": {
							"sFirst":    "Primero",
							"sLast":    "Último",
							"sNext":    "Siguiente",
							"sPrevious": "Anterior"
						},
						"oAria": {
							"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
							"sSortDescending": ": Activar para ordenar la columna de manera descendente"
						}
					}
				});


			},
			error:function(){
				alert("Error al Buscar Empleado");
			}
		});


	}

	if(opcion=="Observada")
	{
		$('#txtFind').val("");
		$('#txtFind').attr("readonly","readonly");
		$(".result").empty();

		var opciones=document.getElementById('opcion').value;

		$.ajax({
			data: {opciones:opciones},
			url:   'listarCredito',
			type:  'post',
			beforeSend: function () {
			},
			success:  function (response) {
				$(".result").html(response);
				$("#Creditos").DataTable({
					"ordering": true,
					"language": {
						"sProcessing":    "Procesando...",
						"sLengthMenu":    "Mostrar _MENU_ registros",
						"sZeroRecords":   "No se encontraron resultados",
						"sEmptyTable":    "Ningún dato disponible en esta tabla",
						"sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
						"sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
						"sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
						"sInfoPostFix":   "",
						"sSearch":        "Buscar:",
						"sUrl":           "",
						"sInfoThousands":  ",",
						"sLoadingRecords": "Cargando...",
						"oPaginate": {
							"sFirst":    "Primero",
							"sLast":    "Último",
							"sNext":    "Siguiente",
							"sPrevious": "Anterior"
						},
						"oAria": {
							"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
							"sSortDescending": ": Activar para ordenar la columna de manera descendente"
						}
					}
				});


			},
			error:function(){
				alert("Error al Buscar Empleado");
			}
		});



	}

	if(opcion=="Inscrita")
	{
		$('#txtFind').val("");
		$('#txtFind').attr("readonly","readonly");
		$(".result").empty();

		var opciones=document.getElementById('opcion').value;

		$.ajax({
			data: {opciones:opciones},
			url:   'listarCredito',
			type:  'post',
			beforeSend: function () {
			},
			success:  function (response) {
				$(".result").html(response);
				$("#Creditos").DataTable({
					"ordering": true,
					"language": {
						"sProcessing":    "Procesando...",
						"sLengthMenu":    "Mostrar _MENU_ registros",
						"sZeroRecords":   "No se encontraron resultados",
						"sEmptyTable":    "Ningún dato disponible en esta tabla",
						"sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
						"sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
						"sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
						"sInfoPostFix":   "",
						"sSearch":        "Buscar:",
						"sUrl":           "",
						"sInfoThousands":  ",",
						"sLoadingRecords": "Cargando...",
						"oPaginate": {
							"sFirst":    "Primero",
							"sLast":    "Último",
							"sNext":    "Siguiente",
							"sPrevious": "Anterior"
						},
						"oAria": {
							"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
							"sSortDescending": ": Activar para ordenar la columna de manera descendente"
						}
					}
				});


			},
			error:function(){
				alert("Error al Buscar Empleado");
			}
		});


	}

});

function bloqueo() {
	$('#txtReferencia').attr("readonly","readonly");
	$('#txtNombre').attr("readonly","readonly");
	$('#txtProducto').attr("readonly","readonly");
	$('#txtLinea').attr("readonly","readonly");
	$('#txtAsesor').attr("readonly","readonly");
	$('#txtAgencia').attr("readonly","readonly");
	$('#txtDescripcion').attr("readonly","readonly");
}
