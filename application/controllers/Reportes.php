<?php

class Reportes extends CI_CONTROLLER
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->model("GestionPermiso_Model");
		$this->load->model("Reportes_Model");
		$this->load->model("Bitacora_Model");
	}

	public function index()
	{
		$permiso["padres"]=$this->GestionPermiso_Model->getPadres($_SESSION['usuario']);
		$permiso["hijos"]=$this->GestionPermiso_Model->getHijos($_SESSION['usuario']);
		$datos["agencias"]=$this->Reportes_Model->getAgencias();
		$this->load->view("layout/head");
		$this->load->view("layout/sidebar",$permiso);
		$this->load->view("layout/navbar");
		$this->load->view("Reportes/Reportes",$datos);
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
			case "Judiciales":
				$res=$this->Reportes_Model->getJudiciales($fechainicio,$fechafin,$ccodofi);
				if (COUNT($res)>0)
				{
					//Cargamos la librería de excel.
					$this->load->library('excel'); $this->excel->setActiveSheetIndex(0);
					$this->excel->setActiveSheetIndex(0);
					$this->excel->getActiveSheet()->setCellValue("A1", 'Proceso Judiciales del: '.$fechainicio.' al '.$fechafin);
					$this->excel->getActiveSheet()->setTitle('Procesos Judiciales');
					$this->excel->setActiveSheetIndex(0)->mergeCells('A1:I1');

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
					$this->excel->getActiveSheet()->getStyle('A1:I1')->applyFromArray($estiloTituloReporte);
					$this->excel->setActiveSheetIndex(0)->mergeCells('A1:I1');

					//Contador de filas
					$contador = 2;
					$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
					$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
					$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
					$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
					$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
					$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
					$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
					$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
					$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(10);


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


					//Le aplicamos color a los titulos.
					$this->excel->getActiveSheet()->getStyle("A{$contador}")->getFill()->getStartColor()->setRGB('255,204,255');
					$this->excel->getActiveSheet()->getStyle("B{$contador}")->getFill()->getStartColor()->setRGB('255,204,255');
					$this->excel->getActiveSheet()->getStyle("C{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("D{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("E{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("F{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("G{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("H{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("I{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');



					$this->excel->getActiveSheet()->setCellValue("A{$contador}", 'ID');
					$this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Nombre');
					$this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Juzgado');
					$this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Observaciones');
					$this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Estado');
					$this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Oficina');
					$this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Fecha de demanda');
					$this->excel->getActiveSheet()->setCellValue("H{$contador}", 'Correlativo Juzgado');
					$this->excel->getActiveSheet()->setCellValue("I{$contador}", 'Monto');



					foreach($res as $d){
						//Incrementamos una fila más, para ir a la siguiente.
						$contador++;
						//Informacion de las filas de la consulta.
						$this->excel->getActiveSheet()->setCellValue("A{$contador}", $d->id);
						$this->excel->getActiveSheet()->setCellValue("B{$contador}", $d->nombreCli);
						$this->excel->getActiveSheet()->setCellValue("C{$contador}", $d->Juzgado);
						$this->excel->getActiveSheet()->setCellValue("D{$contador}", $d->Observaciones);
						$this->excel->getActiveSheet()->setCellValue("E{$contador}", $d->Estado);
						$this->excel->getActiveSheet()->setCellValue("F{$contador}", $d->cnomofi);
						$this->excel->getActiveSheet()->setCellValue("G{$contador}", $d->FechaDemanda);
						$this->excel->getActiveSheet()->setCellValue("H{$contador}", $d->Correlativo_juzgado);
						$this->excel->getActiveSheet()->setCellValue("I{$contador}", $d->Monto);
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
					$this->excel->getActiveSheet()->getStyle('A2:I2')->applyFromArray($estiloTituloReporte);
					//Le ponemos un nombre al archivo que se va a generar.
					$archivo = "ProcesosJudiciales.xls";
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
			case "Laborales":
				$res=$this->Reportes_Model->getLaborales($fechainicio,$fechafin,$ccodofi);
				if (COUNT($res)>0)
				{
					//Cargamos la librería de excel.
					$this->load->library('excel'); $this->excel->setActiveSheetIndex(0);
					$this->excel->setActiveSheetIndex(0);
					$this->excel->getActiveSheet()->setCellValue("A1", 'Proceso Laborales del: '.$fechainicio.' al '.$fechafin);
					$this->excel->getActiveSheet()->setTitle('Procesos Laborales');
					$this->excel->setActiveSheetIndex(0)->mergeCells('A1:G1');

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
					$this->excel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($estiloTituloReporte);
					$this->excel->setActiveSheetIndex(0)->mergeCells('A1:G1');

					//Contador de filas
					$contador = 2;
					$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
					$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
					$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
					$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
					$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
					$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
					$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);

					//Le aplicamos negrita a los títulos de la cabecera.
					$this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("G{$contador}")->getFont()->setBold(true);

					//Le aplicamos color a los titulos.
					$this->excel->getActiveSheet()->getStyle("A{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("B{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("C{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("D{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("E{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("F{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("G{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');

					$this->excel->getActiveSheet()->setCellValue("A{$contador}", 'ID');
					$this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Demandante');
					$this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Juzgado');
					$this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Fecha Demanda');
					$this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Oficina');
					$this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Estado');
					$this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Observaciones');


					foreach($res as $d){
						//Incrementamos una fila más, para ir a la siguiente.
						$contador++;
						//Informacion de las filas de la consulta.
						$this->excel->getActiveSheet()->setCellValue("A{$contador}", $d->id);
						$this->excel->getActiveSheet()->setCellValue("B{$contador}", $d->Demandante);
						$this->excel->getActiveSheet()->setCellValue("C{$contador}", $d->Juzgado);
						$this->excel->getActiveSheet()->setCellValue("D{$contador}", $d->FechaDemanda);
						$this->excel->getActiveSheet()->setCellValue("E{$contador}", $d->cnomofi);
						$this->excel->getActiveSheet()->setCellValue("F{$contador}", $d->Estado);
						$this->excel->getActiveSheet()->setCellValue("G{$contador}", $d->Observaciones);
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
					$this->excel->getActiveSheet()->getStyle('A2:G2')->applyFromArray($estiloTituloReporte);

					//Le ponemos un nombre al archivo que se va a generar.
					$archivo = "ProcesosLaborales.xls";
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
			case "Embargados":
				$res=$this->Reportes_Model->getEmbargados($fechainicio,$fechafin,$ccodofi);
				if (COUNT($res)>0)
				{
					//Cargamos la librería de excel.
					$this->load->library('excel'); $this->excel->setActiveSheetIndex(0);
					$this->excel->setActiveSheetIndex(0);
					$this->excel->getActiveSheet()->setCellValue("A1", 'Bienes embargados del: '.$fechainicio.' al '.$fechafin);
					$this->excel->getActiveSheet()->setTitle('Bienes Embargados');
					$this->excel->setActiveSheetIndex(0)->mergeCells('A1:I1');

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
					$this->excel->getActiveSheet()->getStyle('A1:I1')->applyFromArray($estiloTituloReporte);
					$this->excel->getActiveSheet()->getStyle('A2:I2')->applyFromArray($estiloTituloReporte);
					$this->excel->setActiveSheetIndex(0)->mergeCells('A1:I1');

					//Contador de filas
					$contador = 2;
					$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
					$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
					$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
					$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
					$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
					$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
					$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
					$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
					$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(30);

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

					//Le aplicamos color a los titulos.
					$this->excel->getActiveSheet()->getStyle("A{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("B{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("C{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("D{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("E{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("F{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("G{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("H{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("I{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');

					$this->excel->getActiveSheet()->setCellValue("A{$contador}", 'ID');
					$this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Nombre');
					$this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Bien Embargado');
					$this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Placa o Matricula');
					$this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Agencia');
					$this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Fecha');
					$this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Estado');
					$this->excel->getActiveSheet()->setCellValue("H{$contador}", 'Monto');
					$this->excel->getActiveSheet()->setCellValue("I{$contador}", 'Observaciones');


					foreach($res as $d){
						//Incrementamos una fila más, para ir a la siguiente.
						$contador++;
						//Informacion de las filas de la consulta.
						$this->excel->getActiveSheet()->setCellValue("A{$contador}", $d->id);
						$this->excel->getActiveSheet()->setCellValue("B{$contador}", $d->Nombre);
						$this->excel->getActiveSheet()->setCellValue("C{$contador}", $d->BienEmbargado);
						$this->excel->getActiveSheet()->setCellValue("D{$contador}", $d->Placa);
						$this->excel->getActiveSheet()->setCellValue("E{$contador}", $d->cnomofi);
						$this->excel->getActiveSheet()->setCellValue("F{$contador}", $d->Fecha);
						$this->excel->getActiveSheet()->setCellValue("G{$contador}", $d->Estado);
						$this->excel->getActiveSheet()->setCellValue("H{$contador}", $d->Monto);
						$this->excel->getActiveSheet()->setCellValue("I{$contador}", $d->Observaciones);
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
					$this->excel->getActiveSheet()->getStyle('A2:I2')->applyFromArray($estiloTituloReporte);
					//Le ponemos un nombre al archivo que se va a generar.
					$archivo = "BienesEmbargados.xls";
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
			case "Demandas":
				$res=$this->Reportes_Model->getDemandas($fechainicio,$fechafin,$ccodofi);
				if (COUNT($res)>0)
				{
					//Cargamos la librería de excel.
					$this->load->library('excel'); $this->excel->setActiveSheetIndex(0);
					$this->excel->setActiveSheetIndex(0);
					$this->excel->getActiveSheet()->setCellValue("A1", 'Demandas del: '.$fechainicio.' al '.$fechafin);
					$this->excel->getActiveSheet()->setTitle('Demandas DPC');
					$this->excel->setActiveSheetIndex(0)->mergeCells('A1:G1');

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
					$this->excel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($estiloTituloReporte);
					$this->excel->setActiveSheetIndex(0)->mergeCells('A1:G1');

					//Contador de filas
					$contador = 2;
					$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
					$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
					$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
					$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
					$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
					$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
					$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(30);

					//Le aplicamos negrita a los títulos de la cabecera.
					$this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("G{$contador}")->getFont()->setBold(true);


					//Le aplicamos color a los titulos.
					$this->excel->getActiveSheet()->getStyle("A{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
					$this->excel->getActiveSheet()->getStyle("B{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
					$this->excel->getActiveSheet()->getStyle("C{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
					$this->excel->getActiveSheet()->getStyle("D{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
					$this->excel->getActiveSheet()->getStyle("E{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
					$this->excel->getActiveSheet()->getStyle("F{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
					$this->excel->getActiveSheet()->getStyle("G{$contador}")->getFill()->getStartColor()->setRGB('FF0000');

					$this->excel->getActiveSheet()->setCellValue("A{$contador}", 'ID');
					$this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Nombre');
					$this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Fecha');
					$this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Estado');
					$this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Oficina');
					$this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Observaciones');
					$this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Referencia del caso');

					foreach($res as $d){
						//Incrementamos una fila más, para ir a la siguiente.
						$contador++;
						//Informacion de las filas de la consulta.
						$this->excel->getActiveSheet()->setCellValue("A{$contador}", $d->id);
						$this->excel->getActiveSheet()->setCellValue("B{$contador}", $d->Nombre);
						$this->excel->getActiveSheet()->setCellValue("C{$contador}", $d->Fecha);
						$this->excel->getActiveSheet()->setCellValue("D{$contador}", $d->Estado);
						$this->excel->getActiveSheet()->setCellValue("E{$contador}", $d->cnomofi);
						$this->excel->getActiveSheet()->setCellValue("F{$contador}", $d->Observaciones);
						$this->excel->getActiveSheet()->setCellValue("G{$contador}", $d->ReferenciaCaso);
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
					$this->excel->getActiveSheet()->getStyle('A2:G2')->applyFromArray($estiloTituloReporte);
					//Le ponemos un nombre al archivo que se va a generar.
					$archivo = "Demandas.xls";
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
			case "0":
				$res=$this->Reportes_Model->getJudiciales($fechainicio,$fechafin,$ccodofi);
				if (COUNT($res)>0)
				{
					//Cargamos la librería de excel.
					$this->load->library('excel'); $this->excel->setActiveSheetIndex(0);
					$this->excel->setActiveSheetIndex(0);
					$this->excel->getActiveSheet()->setCellValue("A1", 'Proceso Judiciales del: '.$fechainicio.' al '.$fechafin);
					$this->excel->getActiveSheet()->setTitle('Procesos Judiciales');
					$this->excel->setActiveSheetIndex(0)->mergeCells('A1:I1');

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
					$this->excel->getActiveSheet()->getStyle('A1:I1')->applyFromArray($estiloTituloReporte);
					$this->excel->setActiveSheetIndex(0)->mergeCells('A1:I1');

					//Contador de filas
					$contador = 2;
					$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
					$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
					$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
					$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
					$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
					$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
					$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
					$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
					$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(10);


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


					//Le aplicamos color a los titulos.
					$this->excel->getActiveSheet()->getStyle("A{$contador}")->getFill()->getStartColor()->setRGB('255,204,255');
					$this->excel->getActiveSheet()->getStyle("B{$contador}")->getFill()->getStartColor()->setRGB('255,204,255');
					$this->excel->getActiveSheet()->getStyle("C{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("D{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("E{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("F{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("G{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("H{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("I{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');



					$this->excel->getActiveSheet()->setCellValue("A{$contador}", 'ID');
					$this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Nombre');
					$this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Juzgado');
					$this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Observaciones');
					$this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Estado');
					$this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Oficina');
					$this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Fecha de demanda');
					$this->excel->getActiveSheet()->setCellValue("H{$contador}", 'Correlativo Juzgado');
					$this->excel->getActiveSheet()->setCellValue("I{$contador}", 'Monto');



					foreach($res as $d){
						//Incrementamos una fila más, para ir a la siguiente.
						$contador++;
						//Informacion de las filas de la consulta.
						$this->excel->getActiveSheet()->setCellValue("A{$contador}", $d->id);
						$this->excel->getActiveSheet()->setCellValue("B{$contador}", $d->nombreCli);
						$this->excel->getActiveSheet()->setCellValue("C{$contador}", $d->Juzgado);
						$this->excel->getActiveSheet()->setCellValue("D{$contador}", $d->Observaciones);
						$this->excel->getActiveSheet()->setCellValue("E{$contador}", $d->Estado);
						$this->excel->getActiveSheet()->setCellValue("F{$contador}", $d->cnomofi);
						$this->excel->getActiveSheet()->setCellValue("G{$contador}", $d->FechaDemanda);
						$this->excel->getActiveSheet()->setCellValue("H{$contador}", $d->Correlativo_juzgado);
						$this->excel->getActiveSheet()->setCellValue("I{$contador}", $d->Monto);
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
					$this->excel->getActiveSheet()->getStyle('A2:I2')->applyFromArray($estiloTituloReporte);
					//Le ponemos un nombre al archivo que se va a generar.
					$contador++;
					$contador++;

				}
				$res=$this->Reportes_Model->getLaborales($fechainicio,$fechafin,$ccodofi);
				if (COUNT($res)>0)
				{
					//Cargamos la librería de excel.
					$this->load->library('excel'); $this->excel->setActiveSheetIndex(0);
					$this->excel->setActiveSheetIndex(0);
					$this->excel->getActiveSheet()->setCellValue("A".$contador, 'Proceso Laborales del: '.$fechainicio.' al '.$fechafin);
					$this->excel->getActiveSheet()->setTitle('Procesos Laborales');
					$this->excel->setActiveSheetIndex(0)->mergeCells('A'.$contador.':G'.$contador);

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
					$this->excel->getActiveSheet()->getStyle('A'.$contador.':G'.$contador)->applyFromArray($estiloTituloReporte);
					$this->excel->setActiveSheetIndex(0)->mergeCells('A'.$contador.':G'.$contador);

					//Contador de filas
					$contador++;
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
					$this->excel->getActiveSheet()->getStyle('A'.$contador.':G'.$contador)->applyFromArray($estiloTituloReporte);

					$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
					$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
					$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
					$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
					$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
					$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
					$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);

					//Le aplicamos negrita a los títulos de la cabecera.
					$this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("G{$contador}")->getFont()->setBold(true);

					//Le aplicamos color a los titulos.
					$this->excel->getActiveSheet()->getStyle("A{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("B{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("C{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("D{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("E{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("F{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("G{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');

					$this->excel->getActiveSheet()->setCellValue("A{$contador}", 'ID');
					$this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Demandante');
					$this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Juzgado');
					$this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Fecha Demanda');
					$this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Oficina');
					$this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Estado');
					$this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Observaciones');


					foreach($res as $d){
						//Incrementamos una fila más, para ir a la siguiente.
						$contador++;
						//Informacion de las filas de la consulta.
						$this->excel->getActiveSheet()->setCellValue("A{$contador}", $d->id);
						$this->excel->getActiveSheet()->setCellValue("B{$contador}", $d->Demandante);
						$this->excel->getActiveSheet()->setCellValue("C{$contador}", $d->Juzgado);
						$this->excel->getActiveSheet()->setCellValue("D{$contador}", $d->FechaDemanda);
						$this->excel->getActiveSheet()->setCellValue("E{$contador}", $d->cnomofi);
						$this->excel->getActiveSheet()->setCellValue("F{$contador}", $d->Estado);
						$this->excel->getActiveSheet()->setCellValue("G{$contador}", $d->Observaciones);
					}
					$contador++;
					$contador++;
				}
				$res=$this->Reportes_Model->getEmbargados($fechainicio,$fechafin,$ccodofi);
				if (COUNT($res)>0)
				{
					//Cargamos la librería de excel.
					$this->load->library('excel'); $this->excel->setActiveSheetIndex(0);
					$this->excel->setActiveSheetIndex(0);
					$this->excel->getActiveSheet()->setCellValue("A".$contador, 'Proceso Laborales del: '.$fechainicio.' al '.$fechafin);
					$this->excel->getActiveSheet()->setTitle('Procesos Laborales');
					$this->excel->setActiveSheetIndex(0)->mergeCells('A'.$contador.':I'.$contador);

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
					$this->excel->getActiveSheet()->getStyle('A'.$contador.':I'.$contador)->applyFromArray($estiloTituloReporte);
					$this->excel->setActiveSheetIndex(0)->mergeCells('A'.$contador.':I'.$contador);

					//Contador de filas
					$contador++;
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
					$this->excel->getActiveSheet()->getStyle('A'.$contador.':I'.$contador)->applyFromArray($estiloTituloReporte);

					$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
					$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
					$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
					$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
					$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
					$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
					$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
					$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
					$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(30);

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

					//Le aplicamos color a los titulos.
					$this->excel->getActiveSheet()->getStyle("A{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("B{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("C{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("D{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("E{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("F{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("G{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("H{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("I{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');


					$this->excel->getActiveSheet()->setCellValue("A{$contador}", 'ID');
					$this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Nombre');
					$this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Bien Embargado');
					$this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Placa o Matricula');
					$this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Agencia');
					$this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Fecha');
					$this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Estado');
					$this->excel->getActiveSheet()->setCellValue("H{$contador}", 'Monto');
					$this->excel->getActiveSheet()->setCellValue("I{$contador}", 'Observaciones');


					foreach ($res as $d) {
						//Incrementamos una fila más, para ir a la siguiente.
						$contador++;
						//Informacion de las filas de la consulta.
						$this->excel->getActiveSheet()->setCellValue("A{$contador}", $d->id);
						$this->excel->getActiveSheet()->setCellValue("B{$contador}", $d->Nombre);
						$this->excel->getActiveSheet()->setCellValue("C{$contador}", $d->BienEmbargado);
						$this->excel->getActiveSheet()->setCellValue("D{$contador}", $d->Placa);
						$this->excel->getActiveSheet()->setCellValue("E{$contador}", $d->cnomofi);
						$this->excel->getActiveSheet()->setCellValue("F{$contador}", $d->Fecha);
						$this->excel->getActiveSheet()->setCellValue("G{$contador}", $d->Estado);
						$this->excel->getActiveSheet()->setCellValue("H{$contador}", $d->Monto);
						$this->excel->getActiveSheet()->setCellValue("I{$contador}", $d->Observaciones);
					}
					$contador++;
					$contador++;
				}
				$res=$this->Reportes_Model->getDemandas($fechainicio,$fechafin,$ccodofi);
				if (COUNT($res)>0)
				{
					//Cargamos la librería de excel.
					$this->load->library('excel'); $this->excel->setActiveSheetIndex(0);
					$this->excel->setActiveSheetIndex(0);
					$this->excel->getActiveSheet()->setCellValue("A".$contador, 'Demandas del: '.$fechainicio.' al '.$fechafin);
					$this->excel->getActiveSheet()->setTitle('Demandas DPC');
					$this->excel->setActiveSheetIndex(0)->mergeCells('A'.$contador.':G'.$contador);

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
					$this->excel->getActiveSheet()->getStyle('A'.$contador.':G'.$contador)->applyFromArray($estiloTituloReporte);
					$this->excel->setActiveSheetIndex(0)->mergeCells('A'.$contador.':G'.$contador);

					//Contador de filas
					$contador++;
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
					$this->excel->getActiveSheet()->getStyle('A'.$contador.':G'.$contador)->applyFromArray($estiloTituloReporte);
					$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
					$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
					$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
					$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
					$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
					$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
					$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(30);

					//Le aplicamos negrita a los títulos de la cabecera.
					$this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle("G{$contador}")->getFont()->setBold(true);


					//Le aplicamos color a los titulos.
					$this->excel->getActiveSheet()->getStyle("A{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("B{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("C{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("D{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("E{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("F{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');
					$this->excel->getActiveSheet()->getStyle("G{$contador}")->getFill()->getStartColor()->setRGB('FFCCFF');

					$this->excel->getActiveSheet()->setCellValue("A{$contador}", 'ID');
					$this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Nombre');
					$this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Fecha');
					$this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Estado');
					$this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Oficina');
					$this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Observaciones');
					$this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Referencia del caso');

					foreach($res as $d){
						//Incrementamos una fila más, para ir a la siguiente.
						$contador++;
						//Informacion de las filas de la consulta.
						$this->excel->getActiveSheet()->setCellValue("A{$contador}", $d->id);
						$this->excel->getActiveSheet()->setCellValue("B{$contador}", $d->Nombre);
						$this->excel->getActiveSheet()->setCellValue("C{$contador}", $d->Fecha);
						$this->excel->getActiveSheet()->setCellValue("D{$contador}", $d->Estado);
						$this->excel->getActiveSheet()->setCellValue("E{$contador}", $d->cnomofi);
						$this->excel->getActiveSheet()->setCellValue("F{$contador}", $d->Observaciones);
						$this->excel->getActiveSheet()->setCellValue("G{$contador}", $d->ReferenciaCaso);
					}
					$contador++;
					$contador++;

				}


					$archivo = "Conglomerado.xls";
					header('Content-Type: application/vnd.ms-excel');
					header('Content-Disposition: attachment;filename="' . $archivo . '"');
					header('Cache-Control: max-age=0');
					$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
					//Hacemos una salida al navegador con el archivo Excel.
					$objWriter->save('php://output');


				break;

			default:
				echo '<script>alert("NO HAY DATOS PARA MOSTRAR");</script>';
				echo "<script>window.close();</script>";
				exit;
				break;
		}
		$dataBitacora = array(
			"idAccion" => 7,
			"descripcion" => "Usuario ".$_SESSION['usuario']." generó el reporte ".$reporte,
			"usuario" => $_SESSION['usuario'],
			"dirIp"=>$_SERVER['REMOTE_ADDR'],
			"nomMaquina"=>gethostbyaddr($_SERVER['REMOTE_ADDR'])
		);
		$this->Bitacora_Model->insertAccion($dataBitacora);
	}

}
