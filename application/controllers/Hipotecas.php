<?php

class Hipotecas extends CI_CONTROLLER
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->model("GestionPermiso_Model");
		$this->load->model("Hipotecas_Model");
	}

	public function index()
	{
		$permiso["padres"]=$this->GestionPermiso_Model->getPadres($_SESSION['usuario']);
		$permiso["hijos"]=$this->GestionPermiso_Model->getHijos($_SESSION['usuario']);
		$datos["agencias"]=$this->Hipotecas_Model->getAgencias();
		$this->load->view("layout/head");
		$this->load->view("layout/sidebar",$permiso);
		$this->load->view("layout/navbar");
		$this->load->view("Hipotecas/Hipotecas",$datos);
		$this->load->view("layout/footer");
		$this->load->view("layout/end_footer");
		$this->load->view("Hipotecas/end_Hipotecas");
	}

	public function findCliente(){
		$datos=$this->input->post();
		$Cliente=$datos["Cliente"];
		$data = $this->Hipotecas_Model->getCliente($Cliente);
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
					<th scope="col">Entregado a Legal</th>
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
						<td id="Fecha<?php echo $datos->id; ?>"><?php echo $datos->FechaLegal; ?></td>
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
		$Observaciones=$datos["txtObservaciones"];

		if ($estado=="0" or $agencia=="0" or $tramite=="0"){


			$data = array();
			$data['estado']=FALSE;
			$data['descripcion']="Seleccione un estado una agencia y un estado de trámite";
			echo json_encode($data);
		}
		else
		{
			$datoCliente= array(
				'Nombre'=>$nombre,
				'FecOtor'=>date("d-m-Y",strtotime($fechaOtorgamiento)),
				'Placa'=> $placa,
				'FechaLegal'=>date("d-m-Y",strtotime($fechaLegal)),
				'NumeroPresentacion'=>$presentacion,
				'FechaCancelacion'=>date("d-m-Y",strtotime($fechaCancelacion)),
				'Estado'=>$estado,
				'EstadoTramite'=>$tramite,
				'Agencia'=>$agencia,
				'Observaciones'=>$Observaciones
			);

			$res=$this->Hipotecas_Model->saveCliente($datoCliente);
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
		$Observaciones=$datos["txtUObservaciones"];

		if ($estado=="0" or $agencia=="0" or $tramite=="0"){

			$data = array();
			$data['estado']=FALSE;
			$data['descripcion']="Seleccione un estado una agencia y un estado de trámite";
			echo json_encode($data);
		}
		else
		{
			$datoCliente= array(
				'Nombre'=>$nombre,
				'FecOtor'=>date("d-m-Y",strtotime($fechaOtorgamiento)),
				'Placa'=> $placa,
				'FechaLegal'=>date("d-m-Y",strtotime($fechaLegal)),
				'NumeroPresentacion'=>$presentacion,
				'FechaCancelacion'=>date("d-m-Y",strtotime($fechaCancelacion)),
				'Estado'=>$estado,
				'EstadoTramite'=>$tramite,
				'Agencia'=>$agencia,
				'Observaciones'=>$Observaciones
			);
			$where=array("id"=>$datos["txtid"]);
			$res=$this->Hipotecas_Model->actualizarCliente($datoCliente,$where);
			echo $res;
		}

	}


	public function getInfo(){
		$cliente=$this->Hipotecas_Model->obtenerCliente($this->input->post('id'));
		echo json_encode($cliente);
	}

	public function getAgencias(){
		$data = $this->input->post();
		//var_dump($data['idAgencia']);
		$Agencia = $this->Hipotecas_Model->getAgencias();
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
