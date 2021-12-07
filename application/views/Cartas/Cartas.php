<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Empleados</title>
	<p1></p1>
</head>
<body>
<div class="form-column col-md-12 col-sm-12 col-xs-12 col-lg-12">
	<center><h3 class="form-group">Cartas de cobros</label></h3>
</div>
<div class="clearfix"></div>
<div class="container navbar-light bg-light col-md-12">
	<form action="" method="post">
		<div class="row">
			<div class="form-column col-md-12 col-sm-12 col-xs-12 col-lg-12">
				<div class="form-group">
					<div>
						<button class='btn btn-info' type="button" data-toggle="modal" data-target="#NuevoEmpleadoModal">
							<i class="fas fa-user-plus"></i>
							Ingresar Cliente
						</button>
					</div>
				</div>
			</div>

			<div class="form-column col-md-12 col-sm-12 col-xs-12 col-lg-12">
				<div class="form-inline">
					<a class="navbar-brand">Nombre</a>
					<input class="form-control col-md-10 col-sm-10 col-xs-10 col-lg-10" name="txtFind" id="txtFind" type="search" required="required" ">
				</div>
			</div>
			<div class="clearfix"></div>

		</div>
	</form>
	<br>
	<div class="result"></div>
</div>
<!--Ingresar Nuevo Cliente-->
<div class="modal fade" id="NuevoEmpleadoModal" tabindex="-1" role="dialog" aria-labelledby="NuevoProductoModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="NuevoEmpleadoModalLabel">Nuevo Cliente</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form  method="post" id="ClienteNuevoForm" name="ClienteNuevoForm">
				<div class="modal-body">
					<div class="row">
						<div class="clearfix"></div>
						<div class="form-column col-md-8 col-sm-8 col-xs-8 col-lg-8">
							<div class="form-group">
								<label for="cliente" class="control-label">Nombre</label>
								<input type="text" id="txtNombre" name="txtNombre" class="form-control" required>
							</div>
						</div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Sexo</label>
								<select class="form-control estado" id="cmbsexo" name="cmbsexo" required="required">
									<option value="0">Seleccione...</option>
									<option value="M">Masculino</option>
									<option value="F">Femenino</option>
								</select>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Agencia</label>
								<select class="form-control" name="txtAgencia" id="txtAgencia"><option value="0" >Seleccione:</option>

									<?php
									foreach ($agencias as $dt){
										?>
										<option  value="<?php echo $dt->ccodofi; ?>"><?php echo $dt->cnomofi; ?></option>

										<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">DUI</label>
								<input type="text" id="txtDui" name="txtDui" class="form-control" maxlength="10" required>
							</div>
						</div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">NIT</label>
								<input type="text" id="txtNIT" name="txtNIT" class="form-control" maxlength="17" required>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Monto</label>
								<input type="text" id="txtMonto" name="txtMonto" class="form-control" onkeypress="return filterFloat(event,this)" required>
							</div>
						</div>

						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Dias en Mora</label>
								<input type="text" id="txtMora" name="txtMora" class="form-control " onkeypress="return validarNumeros(event,this)" required>
							</div>
						</div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">BC / GS</label>
								<input type="text" id="txtGrupo" name="txtGrupo" class="form-control" required>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<input class='btn btn-success' type="submit" value="Añadir">
				</div>
			</form>
		</div>
	</div>
</div>


<div class="modal fade" id="EditarClienteModal" tabindex="-1" role="dialog" aria-labelledby="NuevoProductoModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="NuevoEmpleadoModalLabel">Editar Cliente</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form  method="post" id="EditarClienteForm" name="EditarClienteForm">
				<div class="modal-body">
					<div class="row">
						<div class="clearfix"></div>
						<div class="form-column col-md-8 col-sm-8 col-xs-8 col-lg-8">
							<div class="form-group">
								<label for="cliente" class="control-label">Nombre</label>
								<input type="text" id="txtUNombre" name="txtUNombre" class="form-control" required>
								<input type="hidden" id="txtid" name="txtid" class="form-control" required>
							</div>
						</div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Sexo</label>
								<select class="form-control estado" id="cmbUsexo" name="cmbUsexo" required="required">
									<option value="0">Seleccione...</option>
									<option value="M">Masculino</option>
									<option value="F">Femenino</option>
								</select>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Agencia</label>
								<select class="form-control" name="txtUAgencia" id="txtUAgencia"><option value="0" >Seleccione:</option>

									<?php
									foreach ($agencias as $dt){
										?>
										<option  value="<?php echo $dt->ccodofi; ?>"><?php echo $dt->cnomofi; ?></option>

										<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">DUI</label>
								<input type="text" id="txtUDui" name="txtUDui" class="form-control" maxlength="10" required>
							</div>
						</div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">NIT</label>
								<input type="text" id="txtUNIT" name="txtUNIT" class="form-control" maxlength="17" required>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Monto</label>
								<input type="text" id="txtUMonto" name="txtUMonto" class="form-control" onkeypress="return filterFloat(event,this)" required>
							</div>
						</div>

						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Dias en Mora</label>
								<input type="text" id="txtUMora" name="txtUMora" class="form-control " onkeypress="return validarNumeros(event,this)" required>
							</div>
						</div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">BC / GS</label>
								<input type="text" id="txtUGrupo" name="txtUGrupo" class="form-control" required>
							</div>
						</div>
						<?php
							if($_SESSION["oficina"]=="004"){

						?>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Fecha Dación</label>
								<input type="datetime-local" id="txtfecha" name="txtfecha" class="form-control">
							</div>
						</div>

						<?php
							}
						?>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<input class='btn btn-success' type="submit" value="Actualizar">
				</div>
			</form>
		</div>
	</div>
</div>







