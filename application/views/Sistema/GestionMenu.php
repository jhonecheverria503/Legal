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
				<center><h3 class="form-group">Gestión de menú</label></h3>
			</div>
			<div class="clearfix"></div>
			<div class="container navbar-light bg-light col-md-12">
				<button class='btn btn-primary' type="submit" data-toggle="modal" data-target="#opcionMenuModal" id="prueba">Ingresar Nueva Opción</i></button>
				<div class="table-responsive">
					<br>
					<div id="result">
					</div>
				</div>
			</div>
			<div class="modal fade" id="opcionMenuModal" tabindex="-1" role="dialog" aria-labelledby="opcionMenuModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="opcionMenuModalLabel">Nueva Opción de Menú</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form method="post" target="_blank" id="frmOpcionMenu" name="frmOpcionMenu">
							<input type="hidden" value="agregar" name="tipo" id="tipo">
							<div class="modal-body">
								<div class="row">
									<div class="form-column col-md-12 col-sm-12 col-xs-12 col-lg-12">
										<div class="form-group">
											<label for="cliente" class="control-label">Pertenece a:</label>
											<select class="form-control" id="cbxPadre" name="cbxPadre" required="required">
											</select>
										</div>
									</div>
									<div class="clearfix"></div>
									<div class="form-column col-md-12 col-sm-12 col-xs-12 col-lg-12">
										<div class="form-group">
											<label for="cliente" class="control-label">Categoria</label>
											<input type="text" id="txtCategoria" name="txtCategoria" class="form-control" required>
										</div>
									</div>
									<div class="clearfix"></div>
									<div class="form-column col-md-12 col-sm-12 col-xs-12 col-lg-12">
										<div class="form-group">
											<label for="cliente" class="control-label">Descripción</label>
											<input type="text" id="txtDescripcion" name="txtDescripcion" class="form-control" required>
										</div>
									</div>
									<div class="clearfix"></div>
									<div class="form-column col-md-9 col-sm-9 col-xs-9 col-lg-9">
										<div class="form-group">
											<label for="cliente" class="control-label">URL</label>
											<input type="text" id="txtUrl" name="txtUrl" class="form-control">
										</div>
									</div>
									<div class="form-column col-md-3 col-sm-3 col-xs-3 col-lg-3">
										<div class="form-group">
											<label for="cliente" class="control-label">Estado</label><br>
											<input type="checkbox" id="chkEstado" name="chkEstado" class="">Activo
										</div>
									</div>
									<div class="clearfix"></div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
								<input class='btn btn-danger' type="submit" value="Añadir">
							</div>
						</form>
					</div>
					</form>
				</div>
			</div>
			<div class="modal fade" id="EditarOpcionModal" tabindex="-1" role="dialog" aria-labelledby="EditarOpcionModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="opcionMenuModalLabel">Editar Opción de Menú</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form method="post" target="_blank" id="frmUOpcionMenu" name="frmUOpcionMenu">
							<input type="hidden" value="editar" name="tipo" id="tipo">
							<input type="hidden" name="idU" id="idU">
							<div class="modal-body">
								<div class="row">
									<div class="form-column col-md-12 col-sm-12 col-xs-12 col-lg-12">
										<div class="form-group">
											<label for="cliente" class="control-label">Pertenece a:</label>
											<select class="form-control" id="cbxUPadre" name="cbxUPadre" required="required">
											</select>
										</div>
									</div>
									<div class="clearfix"></div>
									<div class="form-column col-md-12 col-sm-12 col-xs-12 col-lg-12">
										<div class="form-group">
											<label for="cliente" class="control-label">Categoria</label>
											<input type="text" id="txtUCategoria" name="txtUCategoria" class="form-control" required>
										</div>
									</div>
									<div class="clearfix"></div>
									<div class="form-column col-md-12 col-sm-12 col-xs-12 col-lg-12">
										<div class="form-group">
											<label for="cliente" class="control-label">Descripción</label>
											<input type="text" id="txtUDescripcion" name="txtUDescripcion" class="form-control" required>
										</div>
									</div>
									<div class="clearfix"></div>
									<div class="form-column col-md-9 col-sm-9 col-xs-9 col-lg-9">
										<div class="form-group">
											<label for="cliente" class="control-label">URL</label>
											<input type="text" id="txtUUrl" name="txtUUrl" class="form-control">
										</div>
									</div>
									<div class="form-column col-md-3 col-sm-3 col-xs-3 col-lg-3">
										<div class="form-group">
											<label for="cliente" class="control-label">Estado</label><br>
											<input type="checkbox" id="chkUEstado" name="chkUEstado" class="">Activo
										</div>
									</div>
									<div class="clearfix"></div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
								<input class='btn btn-danger' type="submit" value="Añadir">
							</div>
						</form>
					</div>
					</form>
				</div>
			</div>
