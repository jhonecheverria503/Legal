<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Empleados</title>
	<p1></p1>
</head>
<body>
<div class="form-column col-md-12 col-sm-12 col-xs-12 col-lg-12">
	<center><h3 class="form-group">Gestión de Garantias</label></h3>
		<br>
</div>
<div class="clearfix"></div>
<div class="container navbar-light bg-light col-md-12">
	<form action="" method="post">
		<div class="row">
			<?php
			 if ($_SESSION["oficina"]=='004'){


			?>
			<div class="form-column col-md-7 col-sm-7 col-xs-7 col-lg-7">
				<div class="form-inline">
					<a class="navbar-brand">Referencia</a>
					<input class="form-control col-md-9 col-sm-9 col-xs-9 col-lg-9" name="txtFind" id="txtFind" type="search" required="required" ">
				</div>
			</div>
			<?php
			 }
			?>

			<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
				<div class="form-group">
					<select class="form-control" id="opcion" name="opcion" required="required">
						<option value="0">Filtrar:</option>
						<option value="En Proceso">En Proceso</option>
						<option value="Observada">Observada</option>
						<option value="Inscrita">Inscrita</option>
					</select>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</form>
	<br>
	<div class="result"></div>
</div>
<!--Ingresar Nuevo Empleado-->
<div class="modal fade" id="GarantiasModal" tabindex="-1" role="dialog" aria-labelledby="NuevoProductoModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="NuevoEmpleadoModalLabel">Detalle de Garantias</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="" method="post" id="actualizarGarantia" name="actualizarGarantia">
				<div class="modal-body">
					<div class="row">
						<div class="clearfix"></div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Referencia</label>
								<input type="text" id="txtReferencia" name="txtReferencia" class="form-control" required>
							</div>
						</div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Nombre</label>
								<input type="text" id="txtNombre" name="txtNombre" class="form-control" onKeyup="this.value=this.value.toUpperCase()" required>
							</div>
						</div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Producto</label>
								<input type="text" id="txtProducto" name="txtProducto" class="form-control" required>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Linea</label>
								<input type="text" id="txtLinea" name="txtLinea" class="form-control" onKeyup="this.value=this.value.toUpperCase()" required>
							</div>
						</div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Asesor</label>
								<input type="text" id="txtAsesor" name="txtAsesor" class="form-control" required>
							</div>
						</div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Agencia</label>
								<input type="text" id="txtAgencia" name="txtAgencia" class="form-control" onKeyup="this.value=this.value.toUpperCase()" required>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Entrega Abogado</label>
								<input type="date" id="txtentregaAbogado" name="txtentregaAbogado" class="form-control" required>
							</div>
						</div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Firma Rep. Legal</label>
								<input type="date" id="txtfirma" name="txtfirma" class="form-control" required>
							</div>
						</div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Resguardo Operaciones</label>
								<input type="date" id="txtresguardo" name="txtresguardo" class="form-control" required>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Entrega a Firma</label>
								<input type="date" id="txtentregaFirma" name="txtentregaFirma" class="form-control" required>
							</div>
						</div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Inscripcion</label>
								<input type="date" id="txtInscripcion" name="txtInscripcion" class="form-control" required>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="form-column col-md-4 col-sm-4 col-xs-4 col-lg-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Estado</label>
								<select class="form-control" id="cbxEstado" name="cbxEstado" required="required">
									<option value="0">Seleccione:</option>
									<option value="En Proceso">En Proceso</option>
									<option value="Observada">Observada</option>
									<option value="Inscrita">Inscrita</option>
								</select>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="form-column col-md-12 col-sm-12 col-xs-12 col-lg-12">
							<label for="cliente" class="control-label">Descripción</label>
							<textarea class="form-control" id="txtDescripcion" rows="5" name="txtDescripcion" style="overflow:auto;resize:none"></textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<?php
					if ($_SESSION["oficina"]=="004")
						{
					?>
					<input class='btn btn-success' type="submit" value="Añadir" id="btnNuevoProducto" name="btnNuevoProducto">
					<?php
						}
					?>
				</div>
			</form>
		</div>
	</div>
</div>
</body>
</html>

