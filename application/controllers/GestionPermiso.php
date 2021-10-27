<?php


class GestionPermiso extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->helper("url");
		$this->load->model("GestionPermiso_Model");
		$this->load->model("Bitacora_Model");
		$this->ObtenerPermiso();
	}

	public function index(){
		$dataBitacora = array(
			"idAccion" => 03,
			"descripcion" => "Usuario ".$_SESSION['usuario']." ingresó al Modulo de Gestión de Permisos.",
			"usuario" => $_SESSION['usuario'],
			"dirIp"=>$_SERVER['REMOTE_ADDR'],
			"nomMaquina"=>gethostbyaddr($_SERVER['REMOTE_ADDR'])
		);
		$this->Bitacora_Model->insertAccion($dataBitacora);
		$Usuario=$this->input->post("Referencia");
		$data['datos'] = $this->GestionPermiso_Model->getUsuarios($Usuario);
		$permiso["padres"]=$this->GestionPermiso_Model->getPadres($_SESSION['usuario']);
		$permiso["hijos"]=$this->GestionPermiso_Model->getHijos($_SESSION['usuario']);
		//subir
		$this->load->view("layout/head");
		$this->load->view("layout/sidebar",$permiso);
		$this->load->view("layout/navbar");
		$this->load->view("Sistema/GestionPermiso");
		$this->load->view("layout/footer");
		$this->load->view("layout/end_footer");
	}

	public function BuscarUsuario(){
		$Usuario=$this->input->post("Referencia");
		$data['datos'] = $this->GestionPermiso_Model->getUsuarios($Usuario);
		$permiso["padres"]=$this->GestionPermiso_Model->getPadres($_SESSION['usuario']);
		$permiso["hijos"]=$this->GestionPermiso_Model->getHijos($_SESSION['usuario']);
		$dataBitacora = array(
			"idAccion" => 16,
			"descripcion" => "Usuario ".$_SESSION['usuario']." buscó al usuario ".$Usuario." en Modulo de Gestión de Permisos.",
			"usuario" => $_SESSION['usuario'],
			"dirIp"=>$_SERVER['REMOTE_ADDR'],
			"nomMaquina"=>gethostbyaddr($_SERVER['REMOTE_ADDR'])
		);
		$this->Bitacora_Model->insertAccion($dataBitacora);
		$this->load->view("layout/head");
		$this->load->view("layout/sidebar",$permiso);
		$this->load->view("layout/navbar");
		$this->load->view("Sistema/GestionPermiso",$data);
		$this->load->view("layout/footer");
		$this->load->view("layout/end_footer");
		$this->load->view("Sistema/end_GestionPermiso");
	}

	public function getPermisos(){
		$Usuario = $this->input->post('id_Usuario');
		$Permisos = $this->GestionPermiso_Model->getPermisos($Usuario);
		if(empty($Permisos)){
			$accion = $this->GestionPermiso_Model->getOpcion();
			foreach ($accion as $fila){
				$data = array(
					"usuario"=>$Usuario,
					"idOpcion"=>$fila->idOpcion,
					"update_by"=>$_SESSION['usuario'],
					"permiso"=>0
				);
				$resInsert = $this->GestionPermiso_Model->insertPermiso($data);
			}
			$this->getPermisos();
		}
		else{
			$PermisosNot = $this->GestionPermiso_Model->getPermisosNotIn($Usuario);
			if(!empty($PermisosNot)){
				foreach ($PermisosNot as $p) {
					$data = array(
							"usuario"=>$Usuario,
							"idOpcion"=>$p->id,
							"update_by"=>$_SESSION['usuario'],
							"permiso"=>0
					);
					$resInsert = $this->GestionPermiso_Model->insertPermiso($data);
				}
				$this->getPermisos();
			}
			else{
				echo '
					<table class="table">
						<thead>
							<tr>
								<th>ID</th>
								<th>Categoria</th>
								<th>Opcion</th>
								<th>Autorizado</th>
							</tr>
						</thead>
						<tbody>';
				foreach ($Permisos as $fila) {
					?>
					<tr>
						<td>
							<input type="hidden" id="txtIdAccion[]" name="txtIdAccion[]" class="textGroup" class="form-control" readonly>
							<?php echo $fila->idOpcion ?>
						</td>
						<td>
							<?php echo $fila->categoria ?>
						</td>
						<td>
							<?php echo $fila->descripcion ?>
						</td>
						<td>
							<?php
								if($fila->permiso=='1'){
									echo '<input type="checkbox"  value="'.$fila->idOpcion.'" id="rbtPermiso" name="rbtPermiso" checked>';
								}
								else{
									echo '<input type="checkbox"  value="'.$fila->idOpcion.'" id="rbtPermiso" name="rbtPermiso">';
								}
							?>
						</td>
					</tr>
					<?php
				}
				echo '</tbody>
					</table>';
			}
		}
	}

	public function GetParameters(){
		$datos=$this->input->post();
		$usuario = $datos["usuario"];
		$opciones = $datos["selected"];
		$count = 0;
		$resUpdate = $this->GestionPermiso_Model->cleanPermiso($usuario);
		if($resUpdate>0){
			foreach ($opciones as $acc){
				$setPermiso = $this->GestionPermiso_Model->setPermiso($usuario,$acc);
				if($setPermiso>0){
					$count = $count + 1;
					$dataBitacora = array(
							"idAccion" => 04,
							"descripcion" => "Usuario ".$_SESSION['usuario']." otorgó el permiso N° ".$acc." al usuario ".$usuario." en Modulo de Gestión de Permisos.",
							"usuario" => $_SESSION['usuario'],
							"dirIp"=>$_SERVER['REMOTE_ADDR'],
							"nomMaquina"=>gethostbyaddr($_SERVER['REMOTE_ADDR'])
					);
					$this->Bitacora_Model->insertAccion($dataBitacora);
				}
			}
			if(count($opciones)==$count){
				$data['estado']=true;
				$data['descripcion']="Permisos Otorgados Correctamente";
				echo json_encode($data);
			}
			else{
				$data['estado']=false;
				$data['descripcion']="Error al otorgar permisos, por favor verificar";
				echo json_encode($data);
			}
		}
	}


	public function ObtenerPermiso(){
		$permiso=$this->GestionPermiso_Model->getPermiso($_SESSION['usuario'],'8');
		if($permiso[0]->Contador>0){
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
