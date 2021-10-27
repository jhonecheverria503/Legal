<?php


class GestionMenu extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->helper("url");
		$this->load->model("GestionPermiso_Model");
		$this->load->model("GestionMenu_Model");
		$this->load->model("Bitacora_Model");
		$this->ObtenerPermiso();
	}

	public function index(){
		$dataBitacora = array(
			"idAccion" => 3,
			"descripcion" => "Usuario ".$_SESSION['usuario']." ingresó al Modulo de Gestión de Menú.",
			"usuario" => $_SESSION['usuario'],
			"dirIp"=>$_SERVER['REMOTE_ADDR'],
			"nomMaquina"=>gethostbyaddr($_SERVER['REMOTE_ADDR'])
		);
		$this->Bitacora_Model->insertAccion($dataBitacora);
		$Usuario=$this->input->post("Referencia");
		$data['datos'] = $this->GestionPermiso_Model->getUsuarios($Usuario);
		$permiso["padres"]=$this->GestionPermiso_Model->getPadres($_SESSION['usuario']);
		$permiso["hijos"]=$this->GestionPermiso_Model->getHijos($_SESSION['usuario']);
		$this->load->view("layout/head");
		$this->load->view("layout/sidebar",$permiso);
		$this->load->view("layout/navbar");
		$this->load->view("Sistema/GestionMenu");
		$this->load->view("layout/footer");
		$this->load->view("layout/end_footer");
		$this->load->view("Sistema/end_GestionMenu");
	}

	public function getOpciones(){
		$datos = $this->GestionMenu_Model->getOpciones();
	?>
		<table class="table">
			<thead>
			<tr>
				<th>ID</th>
				<th>Categoria</th>
				<th>Descripción</th>
				<th>URL</th>
				<th>Opción</th>
			</tr>
			</thead>
			<tbody>
			<?php
			if (!empty($datos)){
				foreach ($datos as $datos){
					?>
			<tr>
				<td>
					<?php echo $datos->idOpcion ?>
				</td>
				<td>
					<?php echo $datos->categoria ?>
				</td>
				<td>
					<?php echo $datos->descripcion ?>
				</td>
				<td>
					<?php echo $datos->URL ?>
				</td>
				<td>
					<button class='btn btn-primary edit' type="submit" data-toggle="modal" value="<?php echo $datos->idOpcion; ?>" id="prueba">Editar</i></button>
				</td>
			</tr>
					<?PHP
				}
			}
			?>
			</tbody>
		</table>
	<?php
	}

	public function getPadres(){
		$opcionPadre = $this->GestionMenu_Model->getPadres();
		echo '<option value="Null">Padre</option>';
		foreach ($opcionPadre as $fila) {
	?>
		<option value="<?php echo $fila->idOpcion ?>"><?php echo $fila->descripcion ?></option>
	<?php
		}
	}

	public function getParameter(){
		$datos = $this->input->post();
		if($datos['tipo']=='agregar'){
			if($datos['cbxPadre']=="Null"){
				$this->Padre($datos);
			}
			else{
				$this->Hijas($datos);
			}
		}
		elseif($datos['tipo']=='editar'){
			$this->editOpcion($datos);
		}
	}

	private function Padre($datos){
		$insert = array(
			"idPadre"=>'',
			"categoria"=>$datos['txtCategoria'],
			"descripcion"=>$datos['txtDescripcion'],
			"URL"=>'',
			"estado"=>isset($datos['chkEstado']) ? '' : 'X'
		);
		$rs = $this->GestionMenu_Model->insertOpcion($insert);
		echo $rs;
	}

	private function Hijas($datos){
		$insert = array(
			"idPadre"=>$datos['cbxPadre'],
			"categoria"=>$datos['txtCategoria'],
			"descripcion"=>$datos['txtDescripcion'],
			"URL"=>$datos['txtUrl'],
			"estado"=>isset($datos['chkEstado']) ? '' : 'X'
		);
		$rs = $this->GestionMenu_Model->insertOpcion($insert);
		echo $rs;
	}

	private function editOpcion($datos){
		$edit = array(
			"idPadre"=>$datos['cbxUPadre']=="Null" ? '0' : $datos['cbxUPadre'],
			"categoria"=>$datos['txtUCategoria'],
			"descripcion"=>$datos['txtUDescripcion'],
			"URL"=>$datos['txtUUrl'],
			"estado"=>isset($datos['chkUEstado']) ? '' : 'X'
		);
		$where = array(
			"id"=>$datos['idU']
		);
		$rs = $this->GestionMenu_Model->updateOpcion($edit,$where);
		echo $rs;
	}

	public function getOpcion(){
		$opcionPadre = $this->GestionMenu_Model->getOpcion($this->input->post('id'));
		echo json_encode($opcionPadre[0]);
	}

	public function ObtenerPermiso(){
		$permiso=$this->GestionPermiso_Model->getPermiso($_SESSION['usuario'],'5');
		if($permiso[0]->Contador>0) {
		}
		else{
			?>
			<script type="text/javascript">
				alert("No posee permisos para ingresar a éste modulo");
				window.setTimeout(function(){
					location = ('<?php echo site_url("Login")?>');
				} ,20);
			</script>
			<?php
		}
	}
}
