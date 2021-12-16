<?php

class ReportesPeH_Model extends CI_MODEL
{

	public function __construct()
	{
		parent::__construct();
	}

	public function getAgencias()
	{
		$this->db->select("t.ccodofi,t.cnomofi");
		$this->db->from("ASEIRTM.dbo.tabtofi AS t");
		$this->db->where("t.ccodofi NOT IN('009','005')");
		$query=$this->db->get();
		return $query->result();

	}

	public function getPrendas($fechainicio,$fechafin,$ccodofi)
	{
		$sql="";
		$sql="	
		SELECT cp.id,cp.Nombre,cp.Placa,cp.NumeroPresentacion,cp.FecOtor,cp.FechaLegal,cp.FechaCancelacion,cp.Estado,t.cnomofi,cp.EstadoTramite,cp.Observaciones
		  FROM Cancelaciones_Prenda AS cp
		JOIN ASEIRTM.dbo.tabtofi AS t ON t.ccodofi=cp.Agencia
		WHERE cp.FechaLegal BETWEEN '$fechainicio' AND '$fechafin'AND  cp.Agencia='$ccodofi'";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getHipotecas($fechainicio,$fechafin,$ccodofi)
	{
		$sql="";
		$sql="	
		SELECT ch.id,ch.Nombre,ch.Placa,ch.NumeroPresentacion,ch.Estado,ch.FecOtor,ch.FechaLegal,ch.FechaCancelacion,ch.EstadoTramite,
		t.cnomofi,ch.Observaciones
		  FROM Cancelaciones_Hipotecas AS ch
		JOIN ASEIRTM.dbo.tabtofi AS t ON t.ccodofi=ch.Agencia
		WHERE ch.FechaLegal BETWEEN '$fechainicio' AND '$fechafin' AND ch.Agencia='$ccodofi'";
		$query = $this->db->query($sql);
		return $query->result();
	}

}
