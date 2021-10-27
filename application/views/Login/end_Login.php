	<script src="<?php echo  base_url("resources/sweetalert2/dist/sweetalert2.all.min.js");?>"></script>
		</body>
	</html>
			<script type="text/javascript">
				$('#frmLogin').on('submit',function(e) {
				e.preventDefault();
				var formData = new FormData($(this)[0]);
				$.ajax({
				url:'<?php echo site_url("Login/InicioSesion")?>',
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
				Swal.fire({
				icon: 'success',
				title: '¡Bienvenido!',
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
				});
			</script>
