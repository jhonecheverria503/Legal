<?php


class GestionMenu_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function getPadres(){
		$this->db->select("om.id AS idOpcion, om.categoria, om.descripcion, om.estado, p.permiso, om.URL");
		$this->db->from("opcionModulo AS om");
		$this->db->join("permiso AS p "," om.id = p.idOpcion AND om.idPadre = '0'");
		$this->db->where("om.estado = ''");
		$this->db->where("p.permiso = '1'");
		$this->db->where("p.idOpcion != '1'");
		$this->db->order_by("p.idOpcion,om.descripcion");
		$query=$this->db->get();
		return $query->result();
	}

	public function getOpciones(){
		$this->db->select("om.id AS idOpcion, om.idPadre, om.categoria, om.URL, om.descripcion, om.estado");
		$this->db->from("opcionModulo AS om");
		$query=$this->db->get();
		return $query->result();
	}

	public function getOpcion($id){
		$this->db->select("om.id AS idOpcion, om.idPadre, om.categoria, om.URL, om.descripcion, om.estado");
		$this->db->from("opcionModulo AS om");
		$this->db->where("om.id",$id);
		$query=$this->db->get();
		return $query->result();
	}

	public function insertOpcion($data){
		$this->db->insert('opcionModulo',$data);
		$res=$this->db->affected_rows();
		$data = array();
		if ($res){
			$data['estado']=true;
			$data['descripcion']="Factura Ingresada Correctamente";
			return json_encode($data);
		}
		else{
			$data['estado']=false;
			$data['descripcion']="Error al ingresar los datos";
			return json_encode($data);
		}
	}

	public function updateOpcion($data,$where){
		$this->db->update('opcionModulo',$data,$where);
		$res=$this->db->affected_rows();
		$data = array();
		if ($res){
			$data['estado']=true;
			$data['descripcion']="Opción Modificada Correctamente";
			return json_encode($data);
		}
		else{
			$data['estado']=false;
			$data['descripcion']="Error en Modificar Opción";
			return json_encode($data);
		}
	}

}
