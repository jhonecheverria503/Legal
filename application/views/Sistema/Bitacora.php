<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<title>Inicio</title>
		<p1></p1>
		<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	</head>
	<body>
		<div class="form-column col-md-12 col-sm-12 col-xs-12 col-lg-12">
			<center><h3 class="form-group">Bitacoras del Sistema</label></h3>
		</div>
		<div class="clearfix"></div>
		<div class="container navbar-light bg-light col-md-12">
			<button class='btn btn-primary' type="submit" data-toggle="modal" data-target="#reporteModal" id="prueba">GENERAR REPORTE</i></button>
			<div class="table-responsive">
				<br>
				<table class="table" id="Bitacora">
				<div id="result">
				</div>
				</table>
			</div>
		</div>
		<div class="modal fade" id="reporteModal" tabindex="-1" role="dialog" aria-labelledby="reporteModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="reporteModalLabel">Reporte de bitacoras</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form action="<?php echo site_url("Bitacora/getParameters")?>" method="post" target="_blank" >
						<div class="modal-body">
							<div class="row">
								<div class="form-column col-md-6">
									<div class="form-group">
										<label for="cliente" class="control-label">Desde</label>
										<input type="date" id="fechaInicio" name="fechaInicio" class="form-control" required>
									</div>
								</div>
								<div class="form-column col-md-6">
									<div class="form-group">
										<label for="cliente" class="control-label">Hasta</label>
										<input type="date" id="fechaFin" name="fechaFin" class="form-control" required>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="form-column col-md-12 col-sm-12 col-xs-12 col-lg-12">
									<div class="form-group">
										<label for="cliente" class="control-label">Accion</label>
										<select class="form-control" id="cbxAccion" name="cbxAccion" required="required">
											<option value="null">TODOS...</option>
										</select>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="form-column col-md-12 col-sm-12 col-xs-12 col-lg-12">
									<div class="form-group">
										<label for="cliente" class="control-label">Usuario</label>
										<select class="form-control" id="cbxUsuario" name="cbxUsuario" required="required">
											<option value="null">TODOS...</option>
										</select>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
							<input class='btn btn-danger' onclick="javascript:$('#reporteModal').modal('hide');" type="submit" value="Generar">
						</div>
					</form>
				</div>
				</form>
			</div>
		</div>




