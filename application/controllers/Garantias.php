<?php


class Garantias extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->model("Garantias_Model");
		$this->load->model("GestionPermiso_Model");
		$this->load->model("Bitacora_Model");

	}

	public function index(){
		$permiso["padres"]=$this->GestionPermiso_Model->getPadres($_SESSION['usuario']);
		$permiso["hijos"]=$this->GestionPermiso_Model->getHijos($_SESSION['usuario']);
		$this->load->view("layout/head");
		$this->load->view("layout/sidebar",$permiso);
		$this->load->view("layout/navbar");
		$this->load->view("Garantias/Garantias");
		$this->load->view("layout/footer");
		$this->load->view("layout/end_footer");
		$this->load->view("Garantias/end_Garantias");
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

	public function listarCredito(){
		$datos=$this->input->post();
		$estado=$datos["opciones"];

		$data = $this->Garantias_Model->estadoCredito($estado);
		if (!empty($data)){
			if(!empty($estado)){
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

	public function getCredito()
	{
		$credito=$this->Garantias_Model->obtenerCredito($this->input->post('id'));
		echo json_encode($credito);

	}

	public function getGarantia()
	{
		$garantias=$this->Garantias_Model->obtenerGarantias($this->input->post('id'));
		echo json_encode($garantias);

	}

	function actualizarGar()
	{
		$datos=$this->input->post();
		$Referencia=$datos["txtReferencia"];

		$ActualizarGarantia=array(
				"dEntrAbog"=>date("d-m-Y",strtotime($datos["txtentregaAbogado"])) ,
				"dEntFirma"=>date("d-m-Y",strtotime($datos["txtentregaFirma"])),
				"dEntrRepLeg"=>date("d-m-Y",strtotime($datos["txtfirma"])),
				"dEntrInscri"=>date("d-m-Y",strtotime($datos["txtInscripcion"])),
				"dEntrOper"=>date("d-m-Y",strtotime($datos["txtresguardo"])),
				"estado"=>$datos["cbxEstado"]
		);
		$res=$this->Garantias_Model->actualizarGarantia($ActualizarGarantia,array("Referencia"=>$Referencia));
		$dataBitacora = array(
				"idAccion" => 4,
				"descripcion" => "Usuario ".$_SESSION['usuario']." Actualizo la garantia ".$Referencia." a estado ".$datos["cbxEstado"].".",
				"usuario" => $_SESSION['usuario'],
				"dirIp"=>$_SERVER['REMOTE_ADDR'],
				"nomMaquina"=>gethostbyaddr($_SERVER['REMOTE_ADDR'])
		);
		$this->Bitacora_Model->insertAccion($dataBitacora);
		echo $res;
	}
}
