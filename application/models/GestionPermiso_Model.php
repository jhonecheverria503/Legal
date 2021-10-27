<?php


class GestionPermiso_Model extends CI_Model{

	private $tablePermiso = "permiso";
	public function __construct(){
		parent::__construct();
	}

	public function getUsuarios($usuario){
		$this->db->select("t.cnomofi AS Agencia,u.nombre AS Nombre,u.usuario,g.grupo AS Grupo");
		$this->db->from("ASEIRTM.dbo.usuarios AS u");
		$this->db->join("ASEIRTM.dbo.tabtofi AS t "," u.ccodofi = t.ccodofi");
		$this->db->join("ASEIRTM.dbo.usuarioGrupo AS ug "," u.idUsuario = ug.idUsuario","LEFT");
		$this->db->join("ASEIRTM.dbo.grupos AS g "," g.idGrupo = ug.idGrupo","LEFT");
		$this->db->where("u.usuario",$usuario);
		$query=$this->db->get();
		return $query->result();
	}

	public function getPadres($usuario){
		$this->db->select("om.id AS idOpcion, om.categoria, om.descripcion, om.estado, p.permiso");
		$this->db->from("opcionModulo AS om");
		$this->db->join("permiso AS p "," om.id = p.idOpcion AND om.idPadre = '0'");
		$this->db->where("p.usuario",$usuario);
		$this->db->where("om.estado = ''");
		$this->db->where("p.permiso = '1'");
		$this->db->where("p.idOpcion != '1'");
		$this->db->order_by("p.idOpcion");
		$query=$this->db->get();
		return $query->result();
	}

	public function getHijos($usuario){
		$this->db->select("om.id AS idOpcion, om.idPadre, om.categoria, om.descripcion, om.url, om.estado, p.permiso");
		$this->db->from("opcionModulo AS om");
		$this->db->join("permiso AS p "," om.id = p.idOpcion AND om.idPadre <> '0'");
		$this->db->where("p.usuario",$usuario);
		$this->db->where("om.estado = ''");
		$this->db->where("p.permiso = '1'");
		$this->db->order_by("p.idOpcion");
		$query=$this->db->get();
		return $query->result();
	}

	public function getPermiso($usuario,$opcion){
		$this->db->select("COUNT(p.idOpcion) as Contador");
		$this->db->from("opcionModulo AS om");
		$this->db->join("permiso AS p "," om.id = p.idOpcion");
		$this->db->where("p.usuario",$usuario);
		$this->db->where("p.idOpcion",$opcion);
		$query=$this->db->get();
		return $query->result();
	}

	public function getPermisos($usuario){
		$this->db->select("om.id AS idOpcion, om.categoria, om.descripcion, om.estado, p.permiso ");
		$this->db->from("opcionModulo AS om");
		$this->db->join("permiso AS p "," om.id = p.idOpcion");
		$this->db->where("p.usuario",$usuario);
		$this->db->order_by("p.idOpcion");
		$query=$this->db->get();
		return $query->result();
	}

	public function getPermisosNotIn($usuario){
		$sql="SELECT id 
				FROM opcionModulo AS om 
				WHERE id NOT IN (SELECT idOpcion FROM permiso AS p WHERE p.usuario = '$usuario')
				ORDER BY id";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getOpcion(){
		$this->db->select("om.id AS idOpcion, om.descripcion, om.estado");
		$this->db->from("opcionModulo AS om");
		$this->db->where("om.estado = '' ");
		$query=$this->db->get();
		return $query->result();
	}

	Public function insertPermiso($data){
		$this->db->insert($this->tablePermiso,$data);
		return $this->db->affected_rows();
	}

	public function cleanPermiso($usuario){
		$sql="UPDATE permiso SET permiso='0' WHERE usuario='$usuario'";
		$this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function setPermiso($usuario,$accion){
		$userSession = $_SESSION['usuario'];
		$sql="UPDATE permiso SET permiso='1', update_by = '$userSession', fechaUpd = GETDATE()  WHERE usuario='$usuario' AND idOpcion='$accion'";
		$this->db->query($sql);
		return $this->db->affected_rows();
	}
	public function getFoto($usuario){
		$this->db->select("foto");
		$this->db->from("empleado");
		$this->db->where("Usuario_SIM",$usuario);
		$query=$this->db->get();
		return $query->result();
	}
}
