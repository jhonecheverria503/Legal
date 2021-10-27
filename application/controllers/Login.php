<?php


class Login extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper("url");
		$this->load->model("Login_Model");
		$this->load->model("Bitacora_Model");
		$this->load->model("GestionPermiso_Model");
	}

	public function index(){

		$logged = $this->session->has_userdata("logged_in");
		if ($logged){
			header("Location: ".site_url("Dashboard"));
		}
		else{
			//header("Location: ".site_url("Login"));
			$this->load->view("Login/Login");
			$this->load->view("Login/end_Login");
		}
	}

	public function InicioSesion(){
		$array = array();
		$usuario=$this->input->post("usuario");
		$contra=$this->input->post("contra");
		if(!empty($usuario)){
			$permiso=$this->GestionPermiso_Model->getPermiso($usuario,'1');
			if($permiso[0]->Contador>0){
				$res=$this->Login_Model->loggin($usuario,strtoupper($contra));
				if ($res->estado){
					$dataBitacora = array(
						"idAccion" => 1,
						"descripcion" => "Usuario ".$usuario." ingreso al sistema desde la IP ".$_SERVER['REMOTE_ADDR']." y equipo ".gethostbyaddr($_SERVER['REMOTE_ADDR']).".",
						"usuario" => $usuario,
						"dirIp"=>$_SERVER['REMOTE_ADDR'],
						"nomMaquina"=>gethostbyaddr($_SERVER['REMOTE_ADDR'])
					);
					$res=$this->Bitacora_Model->insertAccion($dataBitacora);
					if($res>0){
						$array['estado']=true;
						$array['descripcion']="Session iniciada correctamente.";
						echo json_encode($array);
					}
				}
				else{
					$array['estado']=false;
					$array['descripcion']="Usuario o contraseña incorrectos.";
					echo json_encode($array);
				}
			}
			else{
				$array['estado']=false;
				$array['descripcion']="No posee permisos para ingresar";
				echo json_encode($array);
			}
		}
		else{
			$array['estado']=false;
			$array['descripcion']="Por favor ingrese un usuario y contrasea";
			echo json_encode($array);
		}
	}

	public function logOut(){
		$usuario = $_SESSION['usuario'];
		$dataBitacora = array(
			"idAccion" => 2,
			"descripcion" => "Usuario ".$usuario." salió del sistema desde la IP ".$_SERVER['REMOTE_ADDR'].".",
			"usuario" => $usuario,
			"dirIp"=>$_SERVER['REMOTE_ADDR'],
			"nomMaquina"=>gethostbyaddr($_SERVER['REMOTE_ADDR'])
		);
		$res=$this->Bitacora_Model->insertAccion($dataBitacora);
		$this->session->sess_destroy();
		session_write_close();
		if($res>0){
			header("Location: ".site_url("Login"));
		}
	}

}
