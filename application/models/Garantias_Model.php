<?php


class Garantias_Model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function buscarCredito($referencia)
	{
		$this->db->limit(30);
		$this->db->select("dg.Referencia,dg.cnomcli,dg.Agencia,
		  CASE 
		  WHEN dg.Estado='F' THEN 'VIGENTE'
		  WHEN dg.Estado='G' THEN 'Cancelado' 
		  END AS Estado, dg.FecOtor,dg.Desembolso");
		$this->db->from("ASEIRTM.dbo.RefGar AS r");
		$this->db->join("ASEIRTM.dbo.V_DFPC_General AS dg","r.Referencia=dg.Referencia");
		$this->db->where("dg.Estado in('F','G')");
		$this->db->like("r.referencia",$referencia);
		$query=$this->db->get();
		return $query->result();

	}
	public function estadoCredito($estado)
	{
		$this->db->limit(30);
		$this->db->select("dg.Referencia,dg.cnomcli,dg.Agencia,
		  CASE 
		  WHEN dg.Estado='F' THEN 'VIGENTE'
		  WHEN dg.Estado='G' THEN 'Cancelado' 
		  END AS Estado, dg.FecOtor,dg.Desembolso");
		$this->db->from("ASEIRTM.dbo.V_DFPC_General AS dg");
		$this->db->join("ASEIRTM.dbo.refGar AS r","r.Referencia=dg.Referencia");
		$this->db->where("dg.Estado in('F','G')");
		$this->db->where("r.estado",$estado);
		if ($_SESSION["oficina"]!="004")
		{
			$this->db->where("dg.ccodofi",$_SESSION["oficina"]);

		}
		$query=$this->db->get();
		return $query->result();

	}


	public function obtenerCredito($referencia)
	{
		$this->db->select("dg.Referencia,dg.cnomcli,dg.Producto,dg.Linea,dg.Asesor,dg.Agencia");
		$this->db->from("ASEIRTM.dbo.V_DFPC_General AS dg");
		if ($_SESSION["oficina"]!="004")
		{
			$this->db->where("dg.Referencia",$referencia);
			$this->db->where("dg.ccodofi",$_SESSION["oficina"]);
		}
		$this->db->where("dg.Referencia",$referencia);
		$query=$this->db->get();
		return $query->result();

	}

	public function obtenerGarantias($referencia)
	{
		$sql="SELECT TipGar = (Select t.cdescri From ASEIRTM.dbo.tabttab AS t Where t.ccodtab='307' And t.ccodigo=rg.Tipo), rg.IdGen,rg.Referencia,rg.Tipo,
		rg.CorGar,rg.Descripcion,CONVERT(varchar,rg.dEntrAbog,23) AS Abogado,CONVERT(varchar,rg.dEntFirma,23) AS firma,CONVERT(varchar,rg.dEntrRepLeg,23) AS entregaRepresentante,CONVERT(varchar,rg.dEntrInscri,23) AS inscripcion,
		CONVERT(varchar,rg.dEntrOper,23)AS entregaOperaciones,rg.cNoIncripcion,rg.cObservaciones,estado
		FROM ASEIRTM.dbo.RefGar AS rg WHERE rg.Referencia='$referencia'";
		$query = $this->db->query($sql);
		return $query->result();
	}


	public function actualizarGarantia($data,$where)
	{
		$this->db->update('ASEIRTM.dbo.RefGar',$data,$where);
		$res=$this->db->affected_rows();
		$data = array();
		if ($res){
			$data['estado']=true;
			$data['descripcion']="Garantia Modificada Correctamente";
			return json_encode($data);
		}
		else{
			$data['estado']=false;
			$data['descripcion']="Error al Actualizar los datos";
			return json_encode($data);
		}

	}


}
