<?php

class Judiciales extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->model("GestionPermiso_Model");
		$this->load->model("Judiciales_Model");
	}

	public function index()
	{
		$permiso["padres"]=$this->GestionPermiso_Model->getPadres($_SESSION['usuario']);
		$permiso["hijos"]=$this->GestionPermiso_Model->getHijos($_SESSION['usuario']);
		$datos["agencias"]=$this->Judiciales_Model->getAgencias();
		$this->load->view("layout/head");
		$this->load->view("layout/sidebar",$permiso);
		$this->load->view("layout/navbar");
		$this->load->view("Judiciales/Judiciales",$datos);
		$this->load->view("layout/footer");
		$this->load->view("layout/end_footer");
		$this->load->view("Judiciales/end_Judiciales");
	}

	public function findCliente(){
		$datos=$this->input->post();
		$Cliente=$datos["Cliente"];
		$data = $this->Judiciales_Model->getCliente($Cliente);
		if (!empty($data)){
			if(!empty($Cliente)){
				?>
				<div class="table-responsive">
				<table class="table" id="Cliente">
				<thead class="thead-light">
				<tr>
					<th scope="col">ID</th>
					<th scope="col">Nombre</th>
					<th scope="col">Agencia</th>
					<th scope="col">Estado</th>
					<th scope="col">Fecha</th>
					<th scope="col"></th>
				</tr>
				</thead>
				<tbody>
				<?php
				foreach ($data as $datos){
					?>
					<tr>
						<td id="Id<?php echo $datos->id; ?>"><?php echo $datos->id; ?></td>
						<td id="Nombre<?php echo $datos->id; ?>"><?php echo $datos->nombreCli; ?></td>
						<td id="Agencia<?php echo $datos->id; ?>"><?php echo $datos->agencia; ?></td>
						<td id="Estado<?php echo $datos->id; ?>"><?php echo $datos->estado; ?></td>
						<td id="Fecha<?php echo $datos->id; ?>"><?php echo $datos->FechaDemanda; ?></td>
						<td>
							<button class='btn btn-success edit' type="submit" data-toggle="modal" value="<?php echo $datos->id; ?>" data-target="#EditarProductoModal">
								Seleccionar
							</button>
						</td>
					</tr>
					<?PHP
				}
			}
			?>
			</tbody>
			</table>
			</div>

			<?php
		}
		else{
			if(!empty($Cliente)){
				?>
				<div class="row">
					<div class="form-column col-md-9 col-sm-9 col-xs-9 col-lg-9">
					</div>
					<div class="form-column col-md-3 col-sm-3 col-xs-3 col-lg-3">
						<label for="">SIN RESULTADOS</label>
					</div>
				</div>
				<?php
			}
		}
	}

	public function saveCliente()
	{
		$datos=$this->input->post();
		$nombre=$datos["txtNombre"];
		$juzgado=$datos["txtJuzgado"];
		$agencia=$datos["txtAgencia"];
		$fecha=$datos["txtfecha"];
		$estado=$datos["cmbestado"];
		$monto=$datos["txtMonto"];
		$correlativo=$datos["txtCorrelativo"];
		$Observaciones=$datos["txtObservaciones"];

		if ($estado=="0" or $agencia=="0"){


			$data = array();
			$data['estado']=FALSE;
			$data['descripcion']="Seleccione un estado y una agencia";
			echo json_encode($data);
		}
		else
		{
			$datoCliente= array(
				'nombreCli'=>$nombre,
				'Juzgado'=>$juzgado,
				'FechaDemanda'=>date("d-m-Y",strtotime($fecha)),
				'Agencia'=>$agencia,
				'Estado'=>$estado,
				'Observaciones'=>$Observaciones,
				'Monto'=>$monto
			);

			 $res=$this->Judiciales_Model->saveCliente($datoCliente);
			 echo $res;
		}

	}

	public function updateCliente()
	{
		$datos=$this->input->post();
		$nombre=$datos["txtUNombre"];
		$juzgado=$datos["txtUJuzgado"];
		$agencia=$datos["txtUAgencia"];
		$fecha=$datos["txtUfecha"];
		$estado=$datos["cmbUestado"];
		$monto=$datos["txtUMonto"];
		$correlativo=$datos["txtUCorrelativo"];
		$Observaciones=$datos["txtUObservaciones"];
		$Bitacora=$datos["txtUBitacora"];

		if ($estado=="0" or $agencia=="0"){


			$data = array();
			$data['estado']=FALSE;
			$data['descripcion']="Seleccione un estado y una agencia";
			echo json_encode($data);
		}
		else
		{
			$datoCliente= array(
					'nombreCli'=>$nombre,
					'Juzgado'=>$juzgado,
					'FechaDemanda'=>date("d-m-Y",strtotime($fecha)),
					'Agencia'=>$agencia,
					'Estado'=>$estado,
					'Observaciones'=>$Observaciones,
					'Monto'=>$monto,
					'Bitacora'=>$Bitacora,
					'Correlativo_Juzgado'=>$correlativo
			);
			$where=array("id"=>$datos["txtid"]);

			$res=$this->Judiciales_Model->actualizarCliente($datoCliente,$where);
			echo $res;
		}

	}

	public function findCredito(){
		$datos=$this->input->post();
		$Referencia=$datos["Referencia"];
		$data = $this->Garantias_Model->buscarCredito($Referencia);
		if (!empty($data)){
			if(!empty($Referencia)){
				?>
				<div class="table-responsive">
				<table class="table" id="Creditos">
				<thead class="thead-light">
				<tr>
					<th scope="col">Referencia</th>
					<th scope="col">Nombre</th>
					<th scope="col">Agencia</th>
					<th scope="col">Estado</th>
					<th scope="col">Fec.Vig</th>
					<th scope="col">Monto</th>
					<th scope="col"></th>


				</tr>
				</thead>
				<tbody>
				<?php
				foreach ($data as $datos){
					?>
					<tr>
						<td id="Id<?php echo $datos->Referencia; ?>"><?php echo $datos->Referencia; ?></td>
						<td id="Nombre<?php echo $datos->cnomcli; ?>"><?php echo $datos->cnomcli; ?></td>
						<td id="Agencia<?php echo $datos->Agencia; ?>"><?php echo $datos->Agencia; ?></td>
						<td id="Correo<?php echo $datos->Estado; ?>"><?php echo $datos->Estado; ?></td>
						<td id="Estado<?php echo $datos->FecOtor; ?>"><?php echo $datos->FecOtor; ?></td>
						<td id="Desembolso<?php echo $datos->Desembolso; ?>"><?php echo $datos->Desembolso; ?></td>
						<td>
							<button class='btn btn-success edit' type="submit" data-toggle="modal" value="<?php echo $datos->Referencia; ?>" data-target="#EditarProductoModal">
								Seleccionar
							</button>
						</td>
					</tr>
					<?PHP
				}
			}
			?>
			</tbody>
			</table>
			</div>

			<?php
		}
		else{
			if(!empty($Referencia)){
				?>
				<div class="row">
					<div class="form-column col-md-9 col-sm-9 col-xs-9 col-lg-9">
					</div>
					<div class="form-column col-md-3 col-sm-3 col-xs-3 col-lg-3">
						<label for="">SIN RESULTADOS</label>
					</div>
				</div>
				<?php
			}
		}
	}

	public function getInfo(){
		$cliente=$this->Judiciales_Model->obtenerCliente($this->input->post('id'));
		echo json_encode($cliente);
	}

	public function getAgencias(){
		$data = $this->input->post();
		//var_dump($data['idAgencia']);
		$Agencia = $this->Judiciales_Model->getAgencias();
		echo '<option value="null">Seleccione...</option>';
		foreach ($Agencia as $fila) {
			if(isset($data['idAgencia']) AND ($data['idAgencia'])==rtrim($fila->cnomofi)){
				?>
				<option value="<?php echo rtrim($fila->ccodofi) ?>" selected><?php echo $fila->cnomofi ?></option>
				<?php
			}
			else{
				?>
				<option value="<?php echo rtrim($fila->ccodofi) ?>"><?php echo $fila->cnomofi ?></option>
				<?php
			}
		}
	}

}
