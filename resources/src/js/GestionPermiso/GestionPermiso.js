$(document).ready(function(){
	$("#GestionPermiso").DataTable({
		"bFilter": false,
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
	$("#GestionPermiso tr").click(function(){
		$(this).addClass('selected').siblings().removeClass('selected');
		$('#txtAgencia').val($(this).find('#Agencia').html());
		$('#txtNombre').val($(this).find('#Nombre').html());
		$('#txtUsuario').val($(this).find('#Usuario').html());
		$('#txtGrupo').val($(this).find('#Grupo').html());
		var id_Usuario = document.getElementById("txtUsuario").value;
		$.post("getPermisos",{
			id_Usuario: id_Usuario
		}, function (permisos) {
			$("#tablePermiso").html(permisos);
		});
	});
	$(document).on("click",".btnGestionPermiso",  function(){
		var selected = [];
		$(":checkbox[name=rbtPermiso]").each(function() {
			if (this.checked) {
				// agregas cada elemento.
				selected.push($(this).val());
			}
		});
		var usuario = document.getElementById("txtUsuario").value;
		swal({
				title: "Advertencia",
				text: "¿Está seguro de otorgar los permisos?",
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "No",
				confirmButtonText: "Si",
				confirmButtonColor: "#00A59D",
				closeOnConfirm: false,
				closeOnCancel: true
			},
			function (isConfirm) {
				if (isConfirm) {
					$.ajax({
						type: 'POST',
						async: false,
						dataType: 'json',
						data: {usuario:usuario,selected:selected},
						url: "GetParameters",
						cache:false,
						success: function (data)
						{
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
						},
						error: function (xhr, status)
						{
						}
					});
				} else {
				}
			});
	});
});


