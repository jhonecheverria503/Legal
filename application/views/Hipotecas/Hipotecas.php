<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Empleados</title>
	<p1></p1>
</head>
<body>
<div class="form-column col-md-12 col-sm-12 col-xs-12 col-lg-12">
	<center><h3 class="form-group">Cancelaciones de Hipotecas</label></h3>
</div>
<div class="clearfix"></div>
<div class="container navbar-light bg-light col-md-12">
	<form action="" method="post">
		<div class="row">
			<?php
			if($_SESSION["oficina"]=="004"){
			?>
			<div class="form-column col-md-12 col-sm-12 col-xs-12 col-lg-12">
				<div class="form-group">
					<div>
						<button class='btn btn-danger' type="button" data-toggle="modal" data-target="#NuevoEmpleadoModal">
							<i class="fas fa-user-plus"></i>
							Ingresar Cliente
						</button>
					</div>
				</div>
			</div>
			<?php
			}
			?>

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
<!--Ingresar Nuevo Empleado-->
<div class="modal fade" id="NuevoEmpleadoModal" tabindex="-1" role="dialog" aria-labelledby="NuevoProductoModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="NuevoEmpleadoModalLabel">Cancelaciones de Hipotecas (Nuevo Cliente)</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form  method="post" id="ClienteNuevoForm" name="ClienteNuevoForm">
				<div class="modal-body">
					<div class="row">
						<div class="clearfix"></div>
						<div class="form-column col-md-12 col-sm-12 col-xs-12 col-lg-12">
							<div class="form-group">
								<label for="cliente" class="control-label">Nombre</label>
								<input type="text" id="txtNombre" name="txtNombre" class="form-control" required>
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
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Fecha Otorgamiento crédito</label>
								<input type="date" id="txtfecha" name="txtfecha" class="form-control" >
							</div>
						</div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Estado Tramite</label>
								<select class="form-control estado" id="cmbestado" name="cmbestado" >
									<option value="0">Seleccione...</option>
									<option value="Proceso">En Proceso</option>
									<option value="Observada">Observada</option>
									<option value="Inscrita">Inscrita</option>
								</select>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Matricula de Inmueble</label>
								<input type="text" id="txtPlaca" name="txtPlaca" class="form-control" >
							</div>
						</div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Finalizacion del tramite</label>
								<input type="date" id="txtfechaCancelacion" name="txtfechaCancelacion" class="form-control" >
							</div>
						</div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Fecha presentacion (CNR)</label>
								<input type="date" id="txtfechaLegal" name="txtfechaLegal" class="form-control" >
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Número de Presentación</label>
								<input type="text" id="txtpresentacion" name="txtpresentacion" class="form-control" >
							</div>
						</div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Estado Finalizado de Tramite</label>
								<select class="form-control estado" id="cmbTramite" name="cmbTramite" >
									<option value="0">Seleccione...</option>
									<option value="Operaciones">Entrega a Operaciones</option>
									<option value="Cliente">Entregado a Cliente</option>
									<option value="Agencia">Entregado a la Agencia</option>
								</select>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="form-column col-md-12 col-sm-12 col-xs-12 col-lg-12">
							<label for="cliente" class="control-label">Observaciones</label>
							<textarea class="form-control" id="txtObservaciones" rows="5" name="txtObservaciones" style="overflow:auto;resize:none"></textarea>
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
				<h5 class="modal-title" id="NuevoEmpleadoModalLabel">Cancelaciones de Hipotecas (Editar Cliente)</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form  method="post" id="EditarClienteForm" name="EditarClienteForm">
				<div class="modal-body">
					<div class="row">
						<div class="clearfix"></div>
						<div class="form-column col-md-12 col-sm-12 col-xs-12 col-lg-12">
							<div class="form-group">
								<label for="cliente" class="control-label">Nombre</label>
								<input type="text" id="txtUNombre" name="txtUNombre" class="form-control" required>
								<input type="hidden" id="txtid" name="txtid" class="form-control">
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
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Fecha Otorgamiento del crédito</label>
								<input type="date" id="txtUfecha" name="txtUfecha" class="form-control" >
							</div>
						</div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Estado Tramite</label>
								<select class="form-control estado" id="cmbUestado" name="cmbUestado" >
									<option value="0">Seleccione...</option>
									<option value="Proceso">En Proceso</option>
									<option value="Observada">Observada</option>
									<option value="Inscrita">Inscrita</option>
								</select>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Matricula de Inmueble</label>
								<input type="text" id="txtUPlaca" name="txtUPlaca" class="form-control" >
							</div>
						</div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Finalizacion del Tramite</label>
								<input type="date" id="txtUfechaCancelacion" name="txtUfechaCancelacion" class="form-control">
							</div>
						</div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Fecha Presentacion (CNR)</label>
								<input type="date" id="txtUfechaLegal" name="txtUfechaLegal" class="form-control" >
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Número de Presentación</label>
								<input type="text" id="txtUpresentacion" name="txtUpresentacion" class="form-control" >
							</div>
						</div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Estado Finalizado de Tramite</label>
								<select class="form-control estado" id="cmbUTramite" name="cmbUTramite">
									<option value="0">Seleccione...</option>
									<option value="Operaciones">Entrega a Operaciones</option>
									<option value="Cliente">Entregado a Cliente</option>
									<option value="Agencia">Entregado a la Agencia</option>
								</select>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="form-column col-md-12 col-sm-12 col-xs-12 col-lg-12">
							<label for="cliente" class="control-label">Observaciones</label>
							<textarea class="form-control" id="txtUObservaciones" rows="5" name="txtUObservaciones" style="overflow:auto;resize:none"></textarea>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<?php
					if($_SESSION["oficina"]=="004"){
					?>
					<input class='btn btn-success' type="submit" value="Actualizar">
					<?php
					}
					?>
				</div>
			</form>
		</div>
	</div>
</div>




