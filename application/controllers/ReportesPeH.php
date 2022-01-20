<?php

class ReportesPeH extends CI_CONTROLLER
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->model("GestionPermiso_Model");
		$this->load->model("ReportesPeH_Model");
	}

	public function index()
	{
		$permiso["padres"]=$this->GestionPermiso_Model->getPadres($_SESSION['usuario']);
		$permiso["hijos"]=$this->GestionPermiso_Model->getHijos($_SESSION['usuario']);
		$datos["agencias"]=$this->ReportesPeH_Model->getAgencias();
		$this->load->view("layout/head");
		$this->load->view("layout/sidebar",$permiso);
		$this->load->view("layout/navbar");
		$this->load->view("Reportes/ReportesPeH",$datos);
		$this->load->view("layout/footer");
		$this->load->view("layout/end_footer");
	}

	public function getReporte()
	{
		$fechainicio=$this->input->post("FechaInicio");
		$fechafin=$this->input->post("FechaFin");
		$ccodofi=$this->input->post("oficina");
		$reporte=$this->input->post("cmbReporte");
		$res="";
		switch ($reporte){
			case "Prenda":
				$res=$this->ReportesPeH_Model->getPrendas($fechainicio,$fechafin,$ccodofi);
				if (COUNT($res)>0)
				{
					//Cargamos la librería de excel.
					$this->load->library('excel'); $this->excel->setActiveSheetIndex(0);
					$this->excel->setActiveSheetIndex(0);
					$this->excel->getActiveSheet()->setCellValue("A1", 'Cancelaciones de Prenda: '.$fechainicio.' al '.$fechafin);
					$this->excel->getActiveSheet()->setTitle('Procesos Judiciales');
					$this->excel->setActiveSheetIndex(0)->mergeCells('A1:L1');

					$estiloTituloReporte = array(
						'font' => array(
							'name' => 'Arial',
							'bold' => true,
						),
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'B0C8E0')
						),
						'borders' => array(
							'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						),
					);
					$style = array(
						'alignment' => array(
							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						)
					);
					$this->excel->getDefaultStyle()->applyFromArray($style);
					$this->excel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($estiloTituloReporte);
					$this->excel->setActiveSheetIndex(0)->mergeCells('A1:L1');

					//Contador de filas
					$contador = 2;
					$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
					$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
					$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
					$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
					$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(45);
					$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
					$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(50);
					$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
					$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
					$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(40);
					$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(40);
					$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(40);

					//Le aplicamos negrita a los títulos de la cabecera.
					$this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("G{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("H{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("I{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("J{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("K{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("L{$contador}")->getFont()->setBold(true);

					//Le aplicamos color a los titulos.
					$this->excel->getActiveSheet()->getStyle("A{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
					$this->excel->getActiveSheet()->getStyle("B{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
					$this->excel->getActiveSheet()->getStyle("C{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
					$this->excel->getActiveSheet()->getStyle("D{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
					$this->excel->getActiveSheet()->getStyle("E{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
					$this->excel->getActiveSheet()->getStyle("F{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
					$this->excel->getActiveSheet()->getStyle("G{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
					$this->excel->getActiveSheet()->getStyle("H{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
					$this->excel->getActiveSheet()->getStyle("I{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
					$this->excel->getActiveSheet()->getStyle("J{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
					$this->excel->getActiveSheet()->getStyle("K{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
					$this->excel->getActiveSheet()->getStyle("L{$contador}")->getFill()->getStartColor()->setRGB('FF0000');


					$this->excel->getActiveSheet()->setCellValue("A{$contador}", 'ID');
					$this->excel->getActiveSheet()->setCellValue("B{$contador}", 'NOMBRE DE CLIENTE');
					$this->excel->getActiveSheet()->setCellValue("C{$contador}", 'PLACA DEL VEHICULO');
					$this->excel->getActiveSheet()->setCellValue("D{$contador}", 'NUMERO DE PRESENTACION');
					$this->excel->getActiveSheet()->setCellValue("E{$contador}", 'FECHA DE OTORGAMIENTO DE CRÉDITO');
					$this->excel->getActiveSheet()->setCellValue("F{$contador}", 'FECHA DE INGRESO EN AREA LEGAL');
					$this->excel->getActiveSheet()->setCellValue("G{$contador}", 'FECHA DE CANCELACIÓN DEL CRÉDITO');
					$this->excel->getActiveSheet()->setCellValue("H{$contador}", 'ESTADO DEL TRAMITE');
					$this->excel->getActiveSheet()->setCellValue("I{$contador}", 'OFICINA');
					$this->excel->getActiveSheet()->setCellValue("J{$contador}", 'ESTADO FINALIZACION TRAMITE');
					$this->excel->getActiveSheet()->setCellValue("K{$contador}", 'OBSERVACIONES');
					$this->excel->getActiveSheet()->setCellValue("L{$contador}", 'FECHA FINALIZACION');


					foreach($res as $d){
						//Incrementamos una fila más, para ir a la siguiente.
						$contador++;
						//Informacion de las filas de la consulta.
						$this->excel->getActiveSheet()->setCellValue("A{$contador}", $d->id);
						$this->excel->getActiveSheet()->setCellValue("B{$contador}", $d->Nombre);
						$this->excel->getActiveSheet()->setCellValue("C{$contador}", $d->Placa);
						$this->excel->getActiveSheet()->setCellValue("D{$contador}", $d->NumeroPresentacion);
						$this->excel->getActiveSheet()->setCellValue("E{$contador}", $d->FecOtor);
						$this->excel->getActiveSheet()->setCellValue("F{$contador}", $d->FechaLegal);
						$this->excel->getActiveSheet()->setCellValue("G{$contador}", $d->FechaCancelacion);
						$this->excel->getActiveSheet()->setCellValue("H{$contador}", $d->Estado);
						$this->excel->getActiveSheet()->setCellValue("I{$contador}", $d->cnomofi);
						$this->excel->getActiveSheet()->setCellValue("J{$contador}", $d->EstadoTramite);
						$this->excel->getActiveSheet()->setCellValue("K{$contador}", $d->Observaciones);
						$this->excel->getActiveSheet()->setCellValue("L{$contador}", $d->finalizacionTramite);
					}
					$estiloTituloReporte = array(
						'font' => array(
							'name'      => 'Arial',
							'bold'      => true,
						),
						'fill' => array(
							'type'  => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'FFCCFF')
						),
						'borders' => array(
							'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						),
					);
					$this->excel->getActiveSheet()->getStyle('A2:L2')->applyFromArray($estiloTituloReporte);
					//Le ponemos un nombre al archivo que se va a generar.
					$archivo = "Cancelaciones_Prendas.xls";
					header('Content-Type: application/vnd.ms-excel');
					header('Content-Disposition: attachment;filename="'.$archivo.'"');
					header('Cache-Control: max-age=0');
					$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
					//Hacemos una salida al navegador con el archivo Excel.
					$objWriter->save('php://output');

				}
				else{
					echo '<script>alert("NO HAY DATOS PARA MOSTRAR");</script>';
					echo "<script>window.close();</script>";
					exit;
				}
				break;
			case "Hipoteca":
				$res=$this->ReportesPeH_Model->getHipotecas($fechainicio,$fechafin,$ccodofi);
				if (COUNT($res)>0)
				{
					//Cargamos la librería de excel.
					$this->load->library('excel'); $this->excel->setActiveSheetIndex(0);
					$this->excel->setActiveSheetIndex(0);
					$this->excel->getActiveSheet()->setCellValue("A1", 'Cancelaciones de Hipotecas: '.$fechainicio.' al '.$fechafin);
					$this->excel->getActiveSheet()->setTitle('Procesos Judiciales');
					$this->excel->setActiveSheetIndex(0)->mergeCells('A1:K1');

					$estiloTituloReporte = array(
						'font' => array(
							'name' => 'Arial',
							'bold' => true,
						),
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'B0C8E0')
						),
						'borders' => array(
							'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						),
					);
					$style = array(
						'alignment' => array(
							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						)
					);
					$this->excel->getDefaultStyle()->applyFromArray($style);
					$this->excel->getActiveSheet()->getStyle('A1:K1')->applyFromArray($estiloTituloReporte);
					$this->excel->getActiveSheet()->getStyle('A2:K2')->applyFromArray($estiloTituloReporte);
					$this->excel->setActiveSheetIndex(0)->mergeCells('A1:K1');

					//Contador de filas
					$contador = 2;
					$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
					$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
					$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
					$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
					$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
					$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
					$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
					$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
					$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(40);
					$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(40);
					$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(40);

					//Le aplicamos negrita a los títulos de la cabecera.
					$this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("G{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("H{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("I{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("J{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("K{$contador}")->getFont()->setBold(true);

					//Le aplicamos color a los titulos.
					$this->excel->getActiveSheet()->getStyle("A{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
					$this->excel->getActiveSheet()->getStyle("B{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
					$this->excel->getActiveSheet()->getStyle("C{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
					$this->excel->getActiveSheet()->getStyle("D{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
					$this->excel->getActiveSheet()->getStyle("E{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
					$this->excel->getActiveSheet()->getStyle("F{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
					$this->excel->getActiveSheet()->getStyle("G{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
					$this->excel->getActiveSheet()->getStyle("H{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
					$this->excel->getActiveSheet()->getStyle("I{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
					$this->excel->getActiveSheet()->getStyle("J{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
					$this->excel->getActiveSheet()->getStyle("K{$contador}")->getFill()->getStartColor()->setRGB('FF0000');


					$this->excel->getActiveSheet()->setCellValue("A{$contador}", 'ID');
					$this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Nombre');
					$this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Matricula de inmueble');
					$this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Numero Presentacion');
					$this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Estado Tramite');
					$this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Fecha Otorgamiento del crédito');
					$this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Fecha de presentacion (CNR)');
					$this->excel->getActiveSheet()->setCellValue("H{$contador}", 'Finalizacion del tramite');
					$this->excel->getActiveSheet()->setCellValue("I{$contador}", 'Estado Finalizado de Tramite');
					$this->excel->getActiveSheet()->setCellValue("J{$contador}", 'Agencia');
					$this->excel->getActiveSheet()->setCellValue("K{$contador}", 'Observaciones');


					foreach($res as $d){
						//Incrementamos una fila más, para ir a la siguiente.
						$contador++;

						//Informacion de las filas de la consulta.
						$this->excel->getActiveSheet()->setCellValue("A{$contador}", $d->id);
						$this->excel->getActiveSheet()->setCellValue("B{$contador}", $d->Nombre);
						$this->excel->getActiveSheet()->setCellValue("C{$contador}", " ".$d->Placa);
						$this->excel->getActiveSheet()->setCellValue("D{$contador}", $d->NumeroPresentacion);
						$this->excel->getActiveSheet()->setCellValue("E{$contador}", $d->Estado);
						$this->excel->getActiveSheet()->setCellValue("F{$contador}", $d->FecOtor);
						$this->excel->getActiveSheet()->setCellValue("G{$contador}", $d->FechaLegal);
						$this->excel->getActiveSheet()->setCellValue("H{$contador}", $d->FechaCancelacion);
						$this->excel->getActiveSheet()->setCellValue("I{$contador}", $d->EstadoTramite);
						$this->excel->getActiveSheet()->setCellValue("J{$contador}", $d->cnomofi);
						$this->excel->getActiveSheet()->setCellValue("K{$contador}", $d->Observaciones);


					}
					$estiloTituloReporte = array(
						'font' => array(
							'name'      => 'Arial',
							'bold'      => true,
						),
						'fill' => array(
							'type'  => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'FFCCFF')
						),
						'borders' => array(
							'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						),
					);
					$this->excel->getActiveSheet()->getStyle('A2:K2')->applyFromArray($estiloTituloReporte);
					//Le ponemos un nombre al archivo que se va a generar.
					$archivo = "Cancelaciones_Hipotecas.xls";
					header('Content-Type: application/vnd.ms-excel');
					header('Content-Disposition: attachment;filename="'.$archivo.'"');
					header('Cache-Control: max-age=0');
					$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
					//Hacemos una salida al navegador con el archivo Excel.
					$objWriter->save('php://output');

				}
				else{
					echo '<script>alert("NO HAY DATOS PARA MOSTRAR");</script>';
					echo "<script>window.close();</script>";
					exit;
				}
				break;

		}
	}

}
