<?php

class Hipotecas_Model extends CI_MODEL
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getCliente($nombre)
	{
		$this->db->select("id,Nombre,CASE 
		WHEN agencia='001' THEN 'CENTRO'
		WHEN agencia='002' THEN 'COJUTEPEQUE'
		WHEN agencia='003' THEN 'SANTA ANA'
		WHEN agencia='004' THEN 'OFICINAS ADMON'
		WHEN agencia='006' THEN 'APOPA'
		WHEN agencia='007' THEN 'SONSONATE'
		WHEN agencia='008' THEN 'SOYAPANGO'
		WHEN agencia='010' THEN 'SANTA TECLA'
		WHEN agencia='011' THEN 'AHUACHAPAN'
		WHEN agencia='012' THEN 'AGENCIA MONEY CASH'
		WHEN agencia='013' THEN 'AGENCIA ADESCO'
		WHEN agencia='014' THEN 'LA LIBERTAD'
		WHEN agencia='015' THEN 'ZACATECOLUCA'
		WHEN agencia='016' THEN 'GRAMMEN BANK'
		WHEN agencia='017' THEN 'CLINICA MEDICA'
		END AS agencia,estado,FechaLegal");
		$this->db->from("Cancelaciones_Hipotecas");
		if ($_SESSION["oficina"]!="004")
		{
			$this->db->where("agencia",$_SESSION["oficina"]);
		}
		$this->db->like("Nombre",$nombre,"both");
		$query=$this->db->get();
		return $query->result();
	}

	public function getAgencias()
	{
		$this->db->select("t.ccodofi,t.cnomofi");
		$this->db->from("ASEIRTM.dbo.tabtofi AS t");
		$this->db->where("t.ccodofi NOT IN('009','005')");
		$query=$this->db->get();
		return $query->result();

	}

	public function saveCliente($data){
		$this->db->insert('Cancelaciones_Hipotecas',$data);
		$res=$this->db->affected_rows();
		$data = array();
		if ($res){
			$data['estado']=true;
			$data['descripcion']="Guardado Correctamente";
			return json_encode($data);
		}
		else{

			$data['estado']=false;
			$data['descripcion']="Error al Guardar los datos";
			return json_encode($data);
		}

	}

	public function ObtenerCliente($id){
		$this->db->select("p.id,p.Nombre,p.FecOtor ,p.Placa,p.FechaLegal,p.NumeroPresentacion,p.FechaCancelacion,p.Estado,p.EstadoTramite,p.Agencia,p.Observaciones");
		$this->db->from("Cancelaciones_Hipotecas AS p");
		$this->db->where("id",$id);
		$query=$this->db->get();
		return $query->result();
	}

	public function actualizarCliente($data,$where){
		$this->db->update('Cancelaciones_Hipotecas',$data,$where);
		$res=$this->db->affected_rows();
		$mensaje = array();
		if ($res){
			$mensaje['estado']=true;
			$mensaje['descripcion']="Actualizado Correctamente";
			return json_encode($mensaje);
		}
		else{
			$mensaje['estado']=false;
			$mensaje['descripcion']="Error al Actualizar los datos";
			return json_encode($mensaje);
		}
	}

}
