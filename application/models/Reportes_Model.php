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
		if ($ccodofi!="0"){
			$sql="SELECT pj.id,pj.nombreCli,pj.Juzgado,pj.Observaciones,
       CASE 
		WHEN pj.Estado='Proceso' THEN 'En Proceso'
		WHEN pj.Estado='Arreglo' THEN 'Arreglo ExtraJudicial' 
		ELSE pj.Estado
		END AS Estado ,t.cnomofi,pj.FechaDemanda,pj.Correlativo_juzgado,pj.Monto
					 FROM Procesos_Judiciales AS pj
		  	JOIN ASEIRTM.dbo.tabtofi AS t ON t.ccodofi=pj.Agencia
			WHERE pj.FechaDemanda BETWEEN '$fechainicio' AND '$fechafin' and pj.agencia='$ccodofi'";
		}else{
			$sql="SELECT pj.id,pj.nombreCli,pj.Juzgado,pj.Observaciones,
     	  CASE 
			WHEN pj.Estado='Proceso' THEN 'En Proceso'
			WHEN pj.Estado='Arreglo' THEN 'Arreglo ExtraJudicial' 
			ELSE pj.Estado
			END AS Estado ,t.cnomofi,pj.FechaDemanda,pj.Correlativo_juzgado,pj.Monto
		 	 FROM Procesos_Judiciales AS pj
		  	JOIN ASEIRTM.dbo.tabtofi AS t ON t.ccodofi=pj.Agencia
			WHERE pj.FechaDemanda BETWEEN '$fechainicio' AND '$fechafin'";
		}


		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getLaborales($fechainicio,$fechafin,$ccodofi)
	{
		$sql="";
		if ($ccodofi!=0){
			$sql="SELECT pl.id,pl.Demandante,pl.Juzgado,pl.FechaDemanda,t.cnomofi,
      		 CASE 
				WHEN pl.Estado='Proceso' THEN 'En Proceso'
				WHEN pl.Estado='Auditoria' THEN 'En Auditoria' 
				ELSE pl.Estado
				END AS Estado,pl.Observaciones
		  	FROM Procesos_Laborales AS pl
		  	JOIN ASEIRTM.dbo.tabtofi AS t ON t.ccodofi=pl.Agencia
			WHERE pl.FechaDemanda BETWEEN '$fechainicio' AND '$fechafin' and pl.agencia='$ccodofi'";
		}
		else{
			$sql="SELECT pl.id,pl.Demandante,pl.Juzgado,pl.FechaDemanda,t.cnomofi,
      		 CASE 
				WHEN pl.Estado='Proceso' THEN 'En Proceso'
				WHEN pl.Estado='Auditoria' THEN 'En Auditoria' 
				ELSE pl.Estado
				END AS Estado,pl.Observaciones
		  	FROM Procesos_Laborales AS pl
		  	JOIN ASEIRTM.dbo.tabtofi AS t ON t.ccodofi=pl.Agencia
			WHERE pl.FechaDemanda BETWEEN '$fechainicio' AND '$fechafin'";
		}

		$query = $this->db->query($sql);
		return $query->result();

	}

	public function getEmbargados($fechainicio,$fechafin,$ccodofi)
	{
		$sql="";
		if ($ccodofi!=0){
			$sql="
			SELECT be.id, be.Nombre,be.BienEmbargado,be.Placa,t.cnomofi,be.Fecha,	
			    CASE 
				WHEN be.Estado='Proceso' THEN 'En Proceso'
				ELSE be.Estado
				END AS Estado,be.Monto,be.Observaciones
		  FROM Bienes_Embargados AS be
		  JOIN ASEIRTM.dbo.tabtofi AS t ON t.ccodofi=be.Agencia
			WHERE be.Fecha BETWEEN '$fechainicio' AND '$fechafin' and be.agencia='$ccodofi'";
		}else{
			$sql="
			SELECT be.id, be.Nombre,be.BienEmbargado,be.Placa,t.cnomofi,be.Fecha,	
			    CASE 
				WHEN be.Estado='Proceso' THEN 'En Proceso'
				ELSE be.Estado
				END AS Estado,be.Monto,be.Observaciones
		  FROM Bienes_Embargados AS be
		  JOIN ASEIRTM.dbo.tabtofi AS t ON t.ccodofi=be.Agencia
			WHERE be.Fecha BETWEEN '$fechainicio' AND '$fechafin'";
		}

		$query = $this->db->query($sql);
		return $query->result();

	}

	public function getDemandas($fechainicio,$fechafin,$ccodofi)
	{
		$fecha1 = date('d/m/Y',strtotime($fechainicio));
		$fecha2 = date('d/m/Y',strtotime($fechafin));
		$sql="";
		if ($ccodofi!=0){
			$sql="
			DECLARE @fecha1  datetime
			declare @fecha2 datetime 
			SET @fecha1 = '$fecha1 00:00:00' 
			SET @fecha2 ='$fecha2 23:59:59' 
			SELECT dd.id,dd.Nombre,dd.Fecha,
			CASE 
			WHEN dd.Estado='Contestacion' THEN 'Contestacion de denuncia'
			WHEN dd.Estado='Audiencia' THEN 'Audiencia Conciliatoria'
			ELSE dd.Estado END AS Estado,t.cnomofi,dd.Observaciones,dd.ReferenciaCaso
		 	FROM Demandas_DPC AS dd
		 	JOIN ASEIRTM.dbo.tabtofi AS t ON t.ccodofi=dd.Agencia
			WHERE dd.Fecha BETWEEN @fecha1 AND @fecha2 and dd.Agencia='$ccodofi'";
		}else{
			$sql="
			DECLARE @fecha1  datetime
			declare @fecha2 datetime 
			SET @fecha1 = '$fecha1 00:00:00' 
			SET @fecha2 ='$fecha2 23:59:59' 
			SELECT dd.id,dd.Nombre,dd.Fecha,
			CASE 
			WHEN dd.Estado='Contestacion' THEN 'Contestacion de denuncia'
			WHEN dd.Estado='Audiencia' THEN 'Audiencia Conciliatoria'
			ELSE dd.Estado END AS Estado,t.cnomofi,dd.Observaciones,dd.ReferenciaCaso
		 	FROM Demandas_DPC AS dd
		 	JOIN ASEIRTM.dbo.tabtofi AS t ON t.ccodofi=dd.Agencia
			WHERE dd.Fecha BETWEEN @fecha1 AND @fecha2";
		}

		$query = $this->db->query($sql);
		return $query->result();
	}
}
