<?php

class Laborales extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->model("GestionPermiso_Model");
		$this->load->model("Laborales_Model");
		$this->load->model("Bitacora_Model");
	}

	public function index()
	{
		$permiso["padres"]=$this->GestionPermiso_Model->getPadres($_SESSION['usuario']);
		$permiso["hijos"]=$this->GestionPermiso_Model->getHijos($_SESSION['usuario']);
		$datos["agencias"]=$this->Laborales_Model->getAgencias();
		$this->load->view("layout/head");
		$this->load->view("layout/sidebar",$permiso);
		$this->load->view("layout/navbar");
		$this->load->view("Laborales/Laborales",$datos);
		$this->load->view("layout/footer");
		$this->load->view("layout/end_footer");
		$this->load->view("Laborales/end_Laborales");
	}

	public function findCliente(){
		$datos=$this->input->post();
		$Cliente=$datos["Cliente"];
		$data = $this->Laborales_Model->getCliente($Cliente);
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
						<td id="Nombre<?php echo $datos->id; ?>"><?php echo $datos->Demandante; ?></td>
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
				'Demandante'=>$nombre,
				'Juzgado'=>$juzgado,
				'FechaDemanda'=>date("d-m-Y",strtotime($fecha)),
				'Agencia'=>$agencia,
				'Estado'=>$estado,
				'Observaciones'=>$Observaciones,

			);

			$res=$this->Laborales_Model->saveCliente($datoCliente);
			$dataBitacora = array(
					"idAccion" => 5,
					"descripcion" => "Usuario ".$_SESSION['usuario']." ingresó al cliente ".$nombre." en procesos laborales",
					"usuario" => $_SESSION['usuario'],
					"dirIp"=>$_SERVER['REMOTE_ADDR'],
					"nomMaquina"=>gethostbyaddr($_SERVER['REMOTE_ADDR'])
			);
			$this->Bitacora_Model->insertAccion($dataBitacora);
			echo $res;
		}

	}

	public function getAgencias(){
		$data = $this->input->post();
		//var_dump($data['idAgencia']);
		$Agencia = $this->Laborales_Model->getAgencias();
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

	public function getInfo(){
		$cliente=$this->Laborales_Model->obtenerCliente($this->input->post('id'));
		echo json_encode($cliente);
	}

	public function updateCliente()
	{
		$datos=$this->input->post();
		$nombre=$datos["txtUNombre"];
		$juzgado=$datos["txtUJuzgado"];
		$agencia=$datos["txtUAgencia"];
		$fecha=$datos["txtUfecha"];
		$estado=$datos["cmbUestado"];
		$Observaciones=$datos["txtUObservaciones"];

		if ($estado=="0" or $agencia=="0"){


			$data = array();
			$data['estado']=FALSE;
			$data['descripcion']="Seleccione un estado y una agencia";
			echo json_encode($data);
		}
		else
		{
			$datoCliente= array(
					'Demandante'=>$nombre,
					'Juzgado'=>$juzgado,
					'FechaDemanda'=>date("d-m-Y",strtotime($fecha)),
					'Agencia'=>$agencia,
					'Estado'=>$estado,
					'Observaciones'=>$Observaciones
			);
			$where=array("id"=>$datos["txtid"]);

			$res=$this->Laborales_Model->actualizarCliente($datoCliente,$where);
			$dataBitacora = array(
					"idAccion" => 5,
					"descripcion" => "Usuario ".$_SESSION['usuario']." actualizó al cliente ".$nombre." en procesos laborales",
					"usuario" => $_SESSION['usuario'],
					"dirIp"=>$_SERVER['REMOTE_ADDR'],
					"nomMaquina"=>gethostbyaddr($_SERVER['REMOTE_ADDR'])
			);
			$this->Bitacora_Model->insertAccion($dataBitacora);
			echo $res;
		}

	}

}
