<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	If(!empty($_SESSION)){
?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
		<html lang="es">
			<head>
				<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
				<title>Inicio</title>
				<center>
					<img src="<?php echo base_url(); ?>/resources/img/01.jpg" width="40%" height="40%" >
				</center>

			</head>

		</html>
	<?php
	}
	else{
	?>
	<script type="text/javascript">
		window.setTimeout(function(){
			location = ('<?php echo site_url("Login")?>');
		} ,20);
	</script>
<?php
	}
?>



