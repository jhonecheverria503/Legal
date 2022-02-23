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
		$fecha1=date("Y-d-m",strtotime($fechainicio));
		$fecha2=date("Y-d-m",strtotime($fechafin));
		$sql="";
		if ($ccodofi!=0){
			$sql="	
			DECLARE @fecha1  datetime
			declare @fecha2 datetime 
				SET @fecha1 = '$fecha1 00:00:00' 
			SET @fecha2 ='$fecha2 23:59.59' 
			SELECT cp.id,cp.Nombre,cp.Placa,cp.NumeroPresentacion,cp.FecOtor,cp.FechaLegal,cp.FechaCancelacion,
			       CASE 
					WHEN cp.Estado='Proceso' THEN 'En Proceso'
					ELSE cp.Estado
					END AS Estado,cp.Estado,t.cnomofi,cp.EstadoTramite,cp.Observaciones,cp.finalizacionTramite,cp.fechacrea
		 	 FROM Cancelaciones_Prenda AS cp
			JOIN ASEIRTM.dbo.tabtofi AS t ON t.ccodofi=cp.Agencia
			WHERE cp.fechacrea BETWEEN @fecha1 AND '@fecha2 AND  cp.Agencia='$ccodofi'";
		}else{
			$sql="	
			DECLARE @fecha1  datetime
			declare @fecha2 datetime 
				SET @fecha1 = '$fecha1 00:00:00' 
			SET @fecha2 ='$fecha2 23:59.59' 
			SELECT cp.id,cp.Nombre,cp.Placa,cp.NumeroPresentacion,cp.FecOtor,cp.FechaLegal,cp.FechaCancelacion,
			       CASE 
					WHEN cp.Estado='Proceso' THEN 'En Proceso'
					ELSE cp.Estado
					END AS Estado,cp.Estado,t.cnomofi,cp.EstadoTramite,cp.Observaciones,cp.finalizacionTramite,cp.fechacrea
		 	 FROM Cancelaciones_Prenda AS cp
			JOIN ASEIRTM.dbo.tabtofi AS t ON t.ccodofi=cp.Agencia
			WHERE cp.fechacrea BETWEEN @fecha1 AND @fecha2";
		}

		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getHipotecas($fechainicio,$fechafin,$ccodofi)
	{
		$fecha1=date("Y-d-m",strtotime($fechainicio));
		$fecha2=date("Y-d-m",strtotime($fechafin));
		$sql="";
		if($ccodofi!=0){
			$sql="
			DECLARE @fecha1  datetime
			declare @fecha2 datetime 
				SET @fecha1 = '$fecha1 00:00:00' 
			SET @fecha2 ='$fecha2 23:59.59' 
			SELECT ch.id,ch.Nombre,ch.Placa,ch.NumeroPresentacion,
			 CASE 
			     WHEN ch.Estado='Proceso' THEN 'En Proceso' 
			     ELSE ch.Estado
			     END AS Estado,ch.FecOtor,ch.FechaLegal,ch.FechaCancelacion,
			       CASE 
			     WHEN ch.EstadoTramite='Operaciones' THEN 'Entrega a Operaciones' 
			     WHEN ch.EstadoTramite='Cliente' THEN 'Entregado a Cliente' 
			     WHEN ch.EstadoTramite='Agencia' THEN 'Entregado a Agencia' 
			     ELSE ch.EstadoTramite
			     END AS EstadoTramite,
				t.cnomofi,ch.Observaciones,ch.fechacrea
		 	 	FROM Cancelaciones_Hipotecas AS ch
				JOIN ASEIRTM.dbo.tabtofi AS t ON t.ccodofi=ch.Agencia
				WHERE ch.fechacrea BETWEEN @fecha1 AND @fecha2 AND ch.Agencia='$ccodofi'";
		}else{
			$sql="	
			DECLARE @fecha1  datetime
			declare @fecha2 datetime 
				SET @fecha1 = '$fecha1 00:00:00' 
					SET @fecha2 ='$fecha2 23:59.59' 
			SELECT ch.id,ch.Nombre,ch.Placa,ch.NumeroPresentacion,
			    CASE 
				WHEN ch.Estado='Proceso' THEN 'En Proceso' 
			    ELSE ch.Estado
			    END AS Estado,ch.FecOtor,ch.FechaLegal,ch.FechaCancelacion,
			       CASE 
			     WHEN ch.EstadoTramite='Operaciones' THEN 'Entrega a Operaciones' 
			     WHEN ch.EstadoTramite='Cliente' THEN 'Entregado a Cliente' 
			     WHEN ch.EstadoTramite='Agencia' THEN 'Entregado a Agencia' 
			     ELSE ch.EstadoTramite
			     END AS EstadoTramite,
				t.cnomofi,ch.Observaciones,ch.fechacrea
		 		 FROM Cancelaciones_Hipotecas AS ch
				JOIN ASEIRTM.dbo.tabtofi AS t ON t.ccodofi=ch.Agencia
				WHERE ch.fechacrea BETWEEN @fecha1 AND @fecha2";
		}

		$query = $this->db->query($sql);
		return $query->result();
	}

}
