<!-- Bootstrap core JavaScript-->
<script src="<?php echo base_url("resources/vendor/jquery/jquery.min.js");?>"></script>
<script src="<?php echo base_url("resources/vendor/bootstrap/js/bootstrap.bundle.min.js");?>"></script>

<!-- Core plugin JavaScript-->
<script src="<?php echo base_url("resources/vendor/jquery-easing/jquery.easing.min.js");?>"></script>



<!-- Page level plugin JavaScript-->
<script src="<?php echo  base_url("resources/vendor/datatables/jquery.dataTables.js");?>"></script>
<script src="<?php echo  base_url("resources/vendor/datatables/dataTables.bootstrap4.js");?>"></script>





<!-- Custom scripts for all pages-->
<script src="<?php echo base_url("resources/js/sb-admin-2.min.js");?>"></script>
<script src="<?php echo base_url("resources/stacktable/stacktable.js");?>"></script>

<script type="text/javascript">
	var t=null;
	function contadorInactividad() {
		t=setTimeout("inactividad()",300000);
	}
	window.onblur=window.onmousemove=function() {
		if(t) clearTimeout(t);
		contadorInactividad();
	}
	function inactividad() {
		$.ajax({
			url: '<?php echo site_url("Login/logOut")?>',
			type: 'post',
			dataType: 'json'
		});
		Swal.fire({
			title: 'Tiempo Agotado!',
			text: "Sesión cerrada por inactividad",
			icon: 'warning',
			showCancelButton: false,
			confirmButtonColor: '#3085d6',
			confirmButtonText: '¡OK!'
		}).then((result) => {
			if (result.isConfirmed) {
				setTimeout(function () {
					location = ('<?php echo site_url("Login/logOut")?>');
				});
			}
		})

	}
</script>


