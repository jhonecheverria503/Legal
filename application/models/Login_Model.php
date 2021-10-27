<?php


class Login_Model extends CI_Model
{
	private $table="usuarios";
	public function __construct()
	{
		parent::__construct();
		$this->load->database();


	}
	//subida

	public function getLogin($usuario,$contra)
	{
		$newPass= md5($contra);
		$this->db->select("Count(u.idUsuario) AS login,u.idUsuario,u.usuario,u.nombre,u.password as pass,u.cargo,u.lactivo,g.idGrupo,g.grupo,u.ccodofi");
		$this->db->from("ASEIRTM.dbo.usuarios u");
		$this->db->join("ASEIRTM.dbo.usuarioGrupo ug","u.idUsuario=ug.idUsuario");
		$this->db->join("ASEIRTM.dbo.grupos g","ug.idGrupo=g.idGrupo");
		$this->db->where("u.usuario",$usuario,"u.password",$newPass);
		$this->db->where("u.lactivo='1'");
		$this->db->group_by(array("u.idUsuario"));
		$this->db->group_by(array("u.nombre"));
		$this->db->group_by(array("u.usuario"));
		$this->db->group_by(array("u.password"));
		$this->db->group_by(array("u.cargo"));
		$this->db->group_by(array("u.lactivo"));
		$this->db->group_by(array("g.idGrupo"));
		$this->db->group_by(array("g.grupo"));
		$this->db->group_by(array("u.ccodofi"));
		$query=$this->db->get();
		return $query->row();
	}

	public function getDia()
	{
		$this->db->select("cconvar");
		$this->db->from("ASEIRTM.dbo.TABTVAR");
		$this->db->where("cnomvar = 'GDFECSIS' AND ccodapl = 'CRE'");
		$query=$this->db->get();
		return $query->result();
	}

	public function Grupo($usuarioGrupo)
	{
		$this->db->select("ug.idGrupo,gr.grupo");
		$this->db->from("ASEIRTM.dbo.usuarioGrupo ug");
		$this->db->join("ASEIRTM.dbo.usuarios us","ug.idUsuario = us.idUsuario");
		$this->db->join("ASEIRTM.dbo.grupos gr","gr.idGrupo = ug.idGrupo");
		$this->db->where("us.usuario",$usuarioGrupo);
		$query=$this->db->get();
		return $query->row();
	}

	Public function array_session($objquery,$pass){
		$Dia = $this->getDia();
		$usuarioGrupo=$objquery->usuario;
		$grupo=$this->Grupo($usuarioGrupo);
		$idGrupo=$grupo->idGrupo;
		$nombreGrupo=$grupo->grupo;

		$datasession = array(
			"idUsuario"=>$objquery->idUsuario,
			"usuario"=>$objquery->usuario,
			"cargo"=>$objquery->cargo,
			"nombre"=>$objquery->nombre,
			"pass"=>$objquery->pass,
			"passPOST"=>$pass,
			"oficina"=>$objquery->ccodofi,
			"logged_in"=>TRUE,
			"Dia"=> $Dia[0]->cconvar,
			"idGrupo"=>$idGrupo,
			"nombreGrupo"=>$nombreGrupo
		);

		return $datasession;
	}

	Public function loggin($user,$pass){
		$utf8 = utf8_encode($pass);
		$sha1 = sha1($utf8, TRUE);
		$newPass = base64_encode($sha1);
		$datos = new stdClass();
		$datos->estado = false;
		$objquery = $this->getLogin($user,$pass);

		if ($objquery!=null){
			if ($objquery->pass == $newPass){
				if($objquery->login==1){
					$datos->estado = true;
					$datos->mensaje = "Login Correcto";
				}
			}
			else{
				$datos->estado = false;
				$datos->mensaje = "Error".$newPass.'&'.$objquery->pass;
			}
			if($datos->estado==true){
				$arraySession = $this->array_session($objquery,$newPass);
				$this->session->set_userdata($arraySession);
			}
		}
		else{
			$datos->estado = false;
			$datos->mensaje = "Sin datos";
		}
		return $datos;
	}

	Public function logginGet($user,$oficina){
		$datos = new stdClass();
		$datos->estado = false;
		$objquery = $this->getLoginGet($user,$oficina);
		if ($objquery!=null){
			if($objquery->login==1){
				$datos->estado = true;
				$datos->mensaje = "Login Correcto";
			}
		}
		else{
			$datos->estado = false;
			$datos->mensaje = "Error";
		}
		if($datos->estado==true){
			$arraySession = $this->array_session($objquery);
			var_dump($arraySession);
			die();
			$this->session->set_userdata($arraySession);
		}
		return $datos;
	}

}
