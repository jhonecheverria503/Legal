<?php

class Cancelaciones extends CI_CONTROLLER
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->model("GestionPermiso_Model");
		$this->load->model("Cancelaciones_Model");
		$this->load->model("Bitacora_Model");
	}

	public function index()
	{
		$permiso["padres"]=$this->GestionPermiso_Model->getPadres($_SESSION['usuario']);
		$permiso["hijos"]=$this->GestionPermiso_Model->getHijos($_SESSION['usuario']);
		$datos["agencias"]=$this->Cancelaciones_Model->getAgencias();
		$this->load->view("layout/head");
		$this->load->view("layout/sidebar",$permiso);
		$this->load->view("layout/navbar");
		$this->load->view("Cancelaciones/Cancelaciones",$datos);
		$this->load->view("layout/footer");
		$this->load->view("layout/end_footer");
		$this->load->view("Cancelaciones/end_Cancelaciones");
	}

	public function findCliente(){
		$datos=$this->input->post();
		$Cliente=$datos["Cliente"];
		$data = $this->Cancelaciones_Model->getCliente($Cliente);
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
					<th scope="col"></th>
				</tr>
				</thead>
				<tbody>
				<?php
				foreach ($data as $datos){
					?>
					<tr>
						<td id="Id<?php echo $datos->id; ?>"><?php echo $datos->id; ?></td>
						<td id="Nombre<?php echo $datos->id; ?>"><?php echo $datos->Nombre; ?></td>
						<td id="Agencia<?php echo $datos->id; ?>"><?php echo $datos->agencia; ?></td>
						<td id="Estado<?php echo $datos->id; ?>"><?php echo $datos->estado; ?></td>
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
		$agencia=$datos["txtAgencia"];
		$fechaOtorgamiento=$datos["txtfecha"];
		$estado=$datos["cmbestado"];
		$placa=$datos["txtPlaca"];
		$fechaCancelacion=$datos["txtfechaCancelacion"];
		$fechaLegal=$datos["txtfechaLegal"];
		$presentacion=$datos["txtpresentacion"];
		$tramite=$datos["cmbTramite"];
		$finalizacion=$datos["txtFinalizacion"];
		$Observaciones=$datos["txtObservaciones"];

		if ($agencia=="0"){

			$data = array();
			$data['estado']=FALSE;
			$data['descripcion']="Seleccione una agencia";
			echo json_encode($data);
		}
		else
		{
			$datoCliente= array(
					'Nombre'=>$nombre,
					'FecOtor'=>$fechaOtorgamiento=='' ? null :date("d-m-Y",strtotime($fechaOtorgamiento)),
					'Placa'=> $placa,
					'FechaLegal'=>$fechaLegal=='' ? null : date("d-m-Y",strtotime($fechaLegal)),
					'NumeroPresentacion'=>$presentacion,
					'FechaCancelacion'=>$fechaCancelacion== '' ? null :date("d-m-Y",strtotime($fechaCancelacion)),
					'Estado'=>$estado,
					'EstadoTramite'=>$tramite,
					'Agencia'=>$agencia,
					'Observaciones'=>$Observaciones,
					'finalizacionTramite'=>$finalizacion=='' ? null : date("d-m-Y",strtotime($finalizacion)),
					'fechacrea'=>date('d-m-Y H:i:s')
			);

			$res=$this->Cancelaciones_Model->saveCliente($datoCliente);
			$dataBitacora = array(
					"idAccion" => 6,
					"descripcion" => "Usuario ".$_SESSION['usuario']." ingresó al cliente ".$nombre." en cancelaciones de prenda",
					"usuario" => $_SESSION['usuario'],
					"dirIp"=>$_SERVER['REMOTE_ADDR'],
					"nomMaquina"=>gethostbyaddr($_SERVER['REMOTE_ADDR'])
			);
			$this->Bitacora_Model->insertAccion($dataBitacora);
			echo $res;
		}

	}

	public function updateCliente()
	{
		$datos=$this->input->post();
		$nombre=$datos["txtUNombre"];
		$agencia=$datos["txtUAgencia"];
		$fechaOtorgamiento=$datos["txtUfecha"];
		$estado=$datos["cmbUestado"];
		$placa=$datos["txtUPlaca"];
		$fechaCancelacion=$datos["txtUfechaCancelacion"];
		$fechaLegal=$datos["txtUfechaLegal"];
		$presentacion=$datos["txtUpresentacion"];
		$tramite=$datos["cmbUTramite"];
		$finalizacion=$datos["txtUFinalizacion"];
		$Observaciones=$datos["txtUObservaciones"];

		if ($agencia=="0"){
			$data = array();
			$data['estado']=FALSE;
			$data['descripcion']="Seleccione una agencia";
			echo json_encode($data);
		}
		else
		{
			$datoCliente= array(
					'Nombre'=>$nombre,
					'FecOtor'=>$fechaOtorgamiento=='' ? null :date("d-m-Y",strtotime($fechaOtorgamiento)),
					'Placa'=> $placa,
					'FechaLegal'=>$fechaLegal=='' ? null : date("d-m-Y",strtotime($fechaLegal)),
					'NumeroPresentacion'=>$presentacion,
					'FechaCancelacion'=>$fechaCancelacion== '' ? null :date("d-m-Y",strtotime($fechaCancelacion)),
					'Estado'=>$estado,
					'EstadoTramite'=>$tramite,
					'Agencia'=>$agencia,
					'Observaciones'=>$Observaciones,
					'finalizacionTramite'=>$finalizacion=='' ? null : date("d-m-Y",strtotime($finalizacion)),
					'fechaupd'=>date('d-m-Y H:i:s')
			);
			$where=array("id"=>$datos["txtid"]);
			$res=$this->Cancelaciones_Model->actualizarCliente($datoCliente,$where);
			$dataBitacora = array(
					"idAccion" => 6,
					"descripcion" => "Usuario ".$_SESSION['usuario']." actualizó al cliente ".$nombre." en cancelaciones de prenda",
					"usuario" => $_SESSION['usuario'],
					"dirIp"=>$_SERVER['REMOTE_ADDR'],
					"nomMaquina"=>gethostbyaddr($_SERVER['REMOTE_ADDR'])
			);
			$this->Bitacora_Model->insertAccion($dataBitacora);
			echo $res;
		}

	}


	public function getInfo(){
		$cliente=$this->Cancelaciones_Model->obtenerCliente($this->input->post('id'));
		echo json_encode($cliente);
	}

	public function getAgencias(){
		$data = $this->input->post();
		//var_dump($data['idAgencia']);
		$Agencia = $this->Cancelaciones_Model->getAgencias();
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
