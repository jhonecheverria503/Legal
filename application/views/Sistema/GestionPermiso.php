<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Inicio</title>
	<p1></p1>
</head>
<body>
<div class="form-column col-md-12 col-sm-12 col-xs-12 col-lg-12">
	<center><h3 class="form-group">Buscar Usuario</label></h3>
</div>
<div class="clearfix"></div>
<div class="container navbar-light bg-light col-md-12">
	<form action="<?php echo site_url("GestionPermiso/BuscarUsuario")?>" method="post">
		<div class="row">
			<div class="form-column col-md-12 col-sm-12 col-xs-12 col-lg-12">
				<div class="form-inline">
					<a class="navbar-brand">Usuario</a>
					<input class="form-control col-md-8 col-sm-8 col-xs-8 col-lg-8" name="Referencia" type="search" placeholder="Search" aria-label="Search" required="required" ">
					<button class="btn btn-outline-success col-md-3 col-sm-3 col-xs-3 col-lg-2 " type="submit" >Buscar</button>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</form>
	<div class="table-responsive">
		<br>
		<table class="table" id="GestionPermiso">
			<thead class="thead-light">
			<tr>
				<th scope="col">Agencia</th>
				<th scope="col">Nombre</th>
				<th scope="col">Usuario</th>
				<th scope="col">Grupo</th>
				<th scope="col"><center>Opcion</center></th>
			</tr>
			</thead>
			<tbody>
			<!-- IMPRIME LOS DATOS Y DA FORMATO DECIMAL A LOS QUE RETOTNAN .00 -->
			<?php
			if (!empty($datos)){
				foreach ($datos as $datos){
					?>
					<tr>
						<td id="Agencia"><?php echo $datos->Agencia; ?></td>
						<td id="Nombre"><?php echo $datos->Nombre; ?></td>
						<td id="Usuario"><?php echo $datos->usuario; ?></td>
						<td id="Grupo"><?php echo $datos->Grupo; ?></td>
						<td>
							<button class='btn btn-primary' type="submit" data-toggle="modal" data-target="#GestionPermisoModal" id="prueba">ACTUALIZAR</i></button>
						</td>
					</tr>
					<?PHP
				}
			}
			?>
			</tbody>
		</table>
	</div>
</div>
<div class="modal fade" id="GestionPermisoModal" tabindex="-1" role="dialog" aria-labelledby="GestionPermisoModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="GestionPermisoModalLabel">Actualizar Asesor</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="" method="post" id="GestionPermisoForm" name="GestionPermisoForm">
				<div class="modal-body">
					<div class="row">
						<div class="form-column col-md-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Agencia</label>
								<input type="text" id="txtAgencia" name="txtAgencia[]" class="form-control" readonly>
							</div>
						</div>
						<div class="form-column col-md-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Usuario</label>
								<input type="text" id="txtUsuario" name="txtUsuario[]" class="form-control" readonly>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="form-column col-md-4">
							<div class="form-group">
								<label for="cliente" class="control-label">Grupo</label>
								<input type="text" id="txtGrupo" name="txtGrupo[]" class="form-control" readonly>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="form-column col-md-12 col-sm-12 col-xs-12 col-lg-12">
							<div class="form-group">
								<label for="cliente" class="control-label">Nombre Usuario</label>
								<input type="text" id="txtNombre" name="txtNombre[]" class="form-control" readonly>
							</div>
						</div>

						<div class="clearfix"></div>
						<div class="form-column col-md-12 col-sm-12 col-xs-12 col-lg-12">
							<div class="form-group">
								<label for="cliente" class="control-label">Permisos</label>
								<div id="tablePermiso">
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<input class='btn btn-danger btnGestionPermiso' type="button" value="ACTUALIZAR" id="btnCambioEdad">
				</div>
			</form>
		</div>
		</form>
	</div>
</div>
</body>
</html>
