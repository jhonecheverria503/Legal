<?php

class Reportes_Model extends CI_MODEL
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getAgencias()
	{
		$this->db->select("t.ccodofi,t.cnomofi");
		$this->db->from("ASEIRTM.dbo.tabtofi AS t");
		if ($_SESSION["oficina"]!="004")
		{
			$this->db->where("t.ccodofi",$_SESSION["oficina"]);
		}
		$this->db->where("t.ccodofi NOT IN('009','005')");
		$query=$this->db->get();
		return $query->result();

	}

	public function getJudiciales($fechainicio,$fechafin,$ccodofi)
	{
		$sql="";
			$sql="SELECT pj.id,pj.nombreCli,pj.Juzgado,pj.Observaciones,pj.Estado,t.cnomofi,pj.FechaDemanda,pj.Correlativo_juzgado,pj.Monto,pj.Bitacora
		 	 FROM Procesos_Judiciales AS pj
		  	JOIN ASEIRTM.dbo.tabtofi AS t ON t.ccodofi=pj.Agencia
			WHERE pj.FechaDemanda BETWEEN '$fechainicio' AND '$fechafin' and pj.agencia='$ccodofi'";
		$query = $this->db->query($sql);
		return $query->result();

	}

	public function getLaborales($fechainicio,$fechafin,$ccodofi)
	{
		$sql="";
		$sql="SELECT pl.id,pl.Demandante,pl.Juzgado,pl.FechaDemanda,t.cnomofi,pl.Estado,pl.Observaciones
		  	FROM Procesos_Laborales AS pl
		  	JOIN ASEIRTM.dbo.tabtofi AS t ON t.ccodofi=pl.Agencia
			WHERE pl.FechaDemanda BETWEEN '$fechainicio' AND '$fechafin' and pl.agencia='$ccodofi'";
		$query = $this->db->query($sql);
		return $query->result();

	}

	public function getEmbargados($fechainicio,$fechafin,$ccodofi)
	{
		$sql="";
		$sql="
		SELECT be.id, be.Nombre,be.BienEmbargado,be.Placa,t.cnomofi,be.Fecha,be.Estado,be.Monto,be.Observaciones
		  FROM Bienes_Embargados AS be
		  JOIN ASEIRTM.dbo.tabtofi AS t ON t.ccodofi=be.Agencia
			WHERE be.Fecha BETWEEN '$fechainicio' AND '$fechafin' and be.agencia='$ccodofi'";
		$query = $this->db->query($sql);
		return $query->result();

	}

	public function getDemandas($fechainicio,$fechafin,$ccodofi)
	{
		$fecha1 = date('d/m/Y',strtotime($fechainicio));
		$fecha2 = date('d/m/Y',strtotime($fechafin));

		$sql="";
		$sql="
			DECLARE @fecha1  datetime
			declare @fecha2 datetime 
			SET @fecha1 = '$fecha1 00:00:00' 
			SET @fecha2 ='$fecha2 23:59:59' 
			SELECT dd.id,dd.Nombre,dd.Fecha,dd.Estado,t.cnomofi,dd.Observaciones
		 	FROM Demandas_DPC AS dd
		 	JOIN ASEIRTM.dbo.tabtofi AS t ON t.ccodofi=dd.Agencia
			WHERE dd.Fecha BETWEEN @fecha1 AND @fecha2 and dd.Agencia='$ccodofi'";
		$query = $this->db->query($sql);
		return $query->result();
	}
}
