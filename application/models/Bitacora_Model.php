<?php


class Bitacora_Model extends CI_Model{
	private $tableBitacora = "bitacora";

	public function __construct(){
		parent::__construct();
	}

	Public function insertAccion($data){
		$this->db->insert($this->tableBitacora,$data);
		return $this->db->affected_rows();
	}

	public function getBitacoras(){
		$this->db->limit('20');
		$this->db->select("b.id,a.accion,b.descripcion,b.usuario,b.fechaServ");
		$this->db->from("bitacora as b");
		$this->db->join("accion As a","b.idAccion = a.id");
		$this->db->order_by("b.fechaServ","DESC");
		$query=$this->db->get();
		return $query->result();
	}

	public function getAccion(){
		$this->db->select("id,accion");
		$this->db->from("accion");
		$query = $this->db->get();
		return $query->result();
	}

	public function getUsuario(){
		$this->db->select("b.usuario,u.nombre");
		$this->db->from("bitacora AS b");
		$this->db->join("ASEIRTM.dbo.usuarios As u","u.usuario = b.usuario");
		$this->db->group_by(array("b.usuario"));
		$this->db->group_by(array("u.nombre"));
		$query = $this->db->get();
		return $query->result();
	}

	public function getBitacorasRpt($data){
		$this->db->select("b.id,a.accion,b.descripcion,b.usuario,b.fechaServ");
		$this->db->from("bitacora as b");
		if($data["Accion"] != 'X'){
			$this->db->where("a.id",$data["Accion"]);
		}
		if($data["Usuario"] != 'X'){
			$this->db->where("b.usuario",$data["Usuario"]);
		}
		$this->db->where("b.fechaServ BETWEEN ('".$data['fechaInicio']." 00:00:00') AND ('".$data['fechaFin']." 23:59:59')");
		$this->db->join("accion As a","b.idAccion = a.id");
		$this->db->order_by("b.fechaServ","ASC");
		$query=$this->db->get();
		return $query->result();
	}
}
