<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//use Luecano\NumeroALetras\NumeroALetras;
class Cartas extends CI_CONTROLLER
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->model("GestionPermiso_Model");
		$this->load->model("Cartas_Model");
	}

	public function index()
	{
		$permiso["padres"]=$this->GestionPermiso_Model->getPadres($_SESSION['usuario']);
		$permiso["hijos"]=$this->GestionPermiso_Model->getHijos($_SESSION['usuario']);
		$datos["agencias"]=$this->Cartas_Model->getAgencias();
		$this->load->view("layout/head");
		$this->load->view("layout/sidebar",$permiso);
		$this->load->view("layout/navbar");
		$this->load->view("Cartas/Cartas",$datos);
		$this->load->view("layout/footer");
		$this->load->view("layout/end_footer");
		$this->load->view("Cartas/end_Cartas");
	}

	public function findCliente(){
		$datos=$this->input->post();
		$Cliente=$datos["Cliente"];
		$data = $this->Cartas_Model->getCliente($Cliente);
		if (!empty($data)){
			if(!empty($Cliente)){
				?>
				<div class="table-responsive">
				<table class="table" id="Cliente">
				<thead class="thead-light">
				<tr>
					<th scope="col">ID</th>
					<th scope="col">Nombre</th>
					<th scope="col">Agencia</th>
					<th scope="col">Grupo</th>
					<th scope="col">Monto</th>
					<th scope="col"></th>
					<th scope="col"></th>
				</tr>
				</thead>
				<tbody>
				<?php
				foreach ($data as $datos){
					?>
					<tr>
						<td id="Id<?php echo $datos->id; ?>"><?php echo $datos->id; ?></td>
						<td id="Nombre<?php echo $datos->id; ?>"><?php echo $datos->Nombre; ?></td>
						<td id="Agencia<?php echo $datos->id; ?>"><?php echo $datos->agencia; ?></td>
						<td id="Grupo<?php echo $datos->id; ?>"><?php echo $datos->Grupo; ?></td>
						<td id="Monto<?php echo $datos->id; ?>"><?php echo $datos->Monto; ?></td>
						<td>
							<button class='btn btn-success edit' type="submit" data-toggle="modal" value="<?php echo $datos->id; ?>" data-target="#EditarProductoModal">
								<i class="fas fa-edit"></i>
							</button>
						</td>

						<td>
							<form action="<?php echo site_url("Cartas/printContrato")?>" type="POST" target="_blank">
								<input type="hidden" value="<?php echo $datos->id; ?>" name="idCliente" id="idCliente">
								<button class='btn btn-primary' type="submit">
									<i class="fas fa-print"></i>
								</button>
							</form>
						</td>
					</tr>
					<?PHP
				}
			}
			?>
			</tbody>
			</table>
			</div>

			<?php
		}
		else{
			if(!empty($Cliente)){
				?>
				<div class="row">
					<div class="form-column col-md-9 col-sm-9 col-xs-9 col-lg-9">
					</div>
					<div class="form-column col-md-3 col-sm-3 col-xs-3 col-lg-3">
						<label for="">SIN RESULTADOS</label>
					</div>
				</div>
				<?php
			}
		}
	}

	public function saveCliente()
	{
		$datos=$this->input->post();
		$nombre=$datos["txtNombre"];
		$agencia=$datos["txtAgencia"];
		$DUI=$datos["txtDui"];
		$NIT=$datos["txtNIT"];
		$Monto=$datos["txtMonto"];
		$Dias=$datos["txtMora"];
		$grupo=$datos["txtGrupo"];
		$sexo=$datos["cmbsexo"];


		if ($agencia=="0" or $sexo=="0"){
			$data = array();
			$data['estado']=FALSE;
			$data['descripcion']="Seleccione una agencia y sexo valido";
			echo json_encode($data);
		}
		else
		{
			$datoCliente= array(
				'Nombre'=>$nombre,
				'DUI'=> $DUI,
				'NIT'=>$NIT,
				'sexo'=>$sexo,
				'Monto'=>$Monto,
				'DiasMora'=>$Dias,
				'Agencia'=>$agencia,
				'Grupo'=>$grupo
			);

			$res=$this->Cartas_Model->saveCliente($datoCliente);
			echo $res;
		}

	}

	public function updateCliente()
	{
		$datos=$this->input->post();
		$nombre=$datos["txtUNombre"];
		$agencia=$datos["txtUAgencia"];
		$DUI=$datos["txtUDui"];
		$NIT=$datos["txtUNIT"];
		$Monto=$datos["txtUMonto"];
		$Dias=$datos["txtUMora"];
		$grupo=$datos["txtUGrupo"];
		$sexo=$datos["cmbUsexo"];
		$fecha=$datos["txtfecha"];


		if ($agencia=="0" or $sexo=="0"){
			$data = array();
			$data['estado']=FALSE;
			$data['descripcion']="Seleccione una agencia y sexo valido";
			echo json_encode($data);
		}
		else
		{
			if ($fecha==""){
				$datoCliente= array(
					'Nombre'=>$nombre,
					'DUI'=> $DUI,
					'NIT'=>$NIT,
					'sexo'=>$sexo,
					'Monto'=>$Monto,
					'DiasMora'=>$Dias,
					'Agencia'=>$agencia,
					'Grupo'=>$grupo
				);
			}
			else
			{
				$datoCliente= array(
					'Nombre'=>$nombre,
					'DUI'=> $DUI,
					'NIT'=>$NIT,
					'sexo'=>$sexo,
					'Monto'=>$Monto,
					'DiasMora'=>$Dias,
					'Agencia'=>$agencia,
					'Grupo'=>$grupo,
					'fecha'=>date("d-m-Y H:i:s ",strtotime($fecha))
				);

			}

		}
			$where=array("id"=>$datos["txtid"]);
			$res=$this->Cartas_Model->actualizarCliente($datoCliente,$where);
			echo $res;
	}


	public function getInfo(){
		$cliente=$this->Cartas_Model->obtenerCliente($this->input->post('id'));
		$cliente[0]->fecha = (date("Y-m-d",strtotime($cliente[0]->fecha))).'T'.(date("H:i",strtotime($cliente[0]->fecha)));
		echo json_encode($cliente);
	}

	public function getAgencias(){
		$data = $this->input->post();
		//var_dump($data['idAgencia']);
		$Agencia = $this->Cartas_Model->getAgencias();
		echo '<option value="null">Seleccione...</option>';
		foreach ($Agencia as $fila) {
			if(isset($data['idAgencia']) AND ($data['idAgencia'])==rtrim($fila->cnomofi)){
				?>
				<option value="<?php echo rtrim($fila->ccodofi) ?>" selected><?php echo $fila->cnomofi ?></option>
				<?php
			}
			else{
				?>
				<option value="<?php echo rtrim($fila->ccodofi) ?>"><?php echo $fila->cnomofi ?></option>
				<?php
			}
		}
	}

	public function printContrato(){
		$datos=$this->input->get("idCliente");
		$datosCliente=$this->Cartas_Model->getInfoContrato($datos);
		$sexo=$datosCliente[0]->sexo;
		$Grupo=$datosCliente[0]->Grupo;
		$nombre=$datosCliente[0]->Nombre;
		$DUI=$datosCliente[0]->Dui;
		$NIT=$datosCliente[0]->Nit;
		$hora=date("H",strtotime($datosCliente[0]->fecha));
		$minutos=date("i:s",strtotime($datosCliente[0]->fecha));
		$horario="am";
		if (intval($hora)>12)
		{
			$hora=$this->changeHora($hora);
			$horario="pm";
		}
		$articulo="";

		if ($sexo=="M")
		{
			$articulo="Sr";
		}
		else
		{

			$articulo="Sra";
		}

		require 'vendor/autoload.php';
		$formatter = new \Luecano\NumeroALetras\NumeroALetras();
		$DiasMora=($formatter->toWords($datosCliente[0]->DiasMora));
		$Monto=($formatter->toWords($datosCliente[0]->Monto));
		//funcion explode extrae decimales posicion 0 es el entero y posicion 1 es el decimal
		$fraccion=explode(".",$datosCliente[0]->Monto);

		$inputFileType = 'Xlsx';
		$inputFileName =APPPATH."../resources/templates/Plantilla.xlsx";
		/** Create a new Xls Reader  **/

		//$formatter->toWords();
		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
		$spreadsheet = $reader->load($inputFileName);
		$spreadsheet->getActiveSheet()->setCellValue('C11', $Grupo);
		$spreadsheet->getActiveSheet()->setCellValue('B12', $articulo);
		$spreadsheet->getActiveSheet()->setCellValue('C12', $nombre);
		$spreadsheet->getActiveSheet()->setCellValue('C13', $DUI);
		$spreadsheet->getActiveSheet()->setCellValue('C14', $NIT);
		$spreadsheet->getActiveSheet()->setCellValue('B21', "que a esta fecha tiene mas de ".mb_strtolower($DiasMora)." dias mora y una deuda pendiente de cancelar por la cantidad total de ".$Monto." ".$fraccion[1]."/100 DOLARES DE LOS ESTADOS UNIDOS DE AMERICA ($".$datosCliente[0]->Monto.") nos vemos en la obligación de utilizar la documentación legal para exigir la totalidad del pago por la vía judicial, sin embargo, a efecto de interrumpir el proceso en la etapa que se encuentra requerimos su pago inmediato.");
		$spreadsheet->getActiveSheet()->setCellValue('B29', "De no realizar su pago inmediato; y si a usted le interesa llegar a una CONCILIACION para solventar el caso, deberá presentarse el día ".$datosCliente[0]->dia. ", ".$datosCliente[0]->numero. " de ".$datosCliente[0]->Mes. " de ".$datosCliente[0]->anio." a las ".$hora.":".$minutos." ".$horario. " a nuestro departamento jurídico ubicado en CENTRO FINANCIERO ASEI: Colonia San Francisco, Calle Los Bambúes, #19, San Salvador, o cancelará lo adeudado.");
		$writer = new Xlsx($spreadsheet);
		$filename = 'Carta '.$nombre;

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');

	}

	public function changeHora($hora){

		switch ($hora) {
			case "13":
				$hora="01";
				break;
			case "14":
				$hora="02";
				break;
			case "15":
				$hora="03";
				break;
			case "16":
				$hora= "04";
				break;
			case "17":
				$hora="05";
				break;
			case "18":
				$hora="06";
				break;
			case "19":
				$hora="07";
				break;
			case "20":
				$hora= "08";
				break;
			case "21":
				$hora= "09";
				break;
			case "22":
				$hora="10";
				break;
			case "23":
				$hora= "11";
				break;
			case "24":
				$hora= "12";
				break;
		}
		return $hora;

	}

	public function getReporte()
	{
		$fechainicio=$this->input->post("FechaInicio");
		$fechafin=$this->input->post("FechaFin");
		$ccodofi=$this->input->post("oficina");
		$res=$this->Resumen_Model->getInfo($fechainicio,$fechafin,$ccodofi);

		if (COUNT($res)>0)
		{
			//Cargamos la librería de excel.
			$this->load->library('excel'); $this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->setTitle("Antorchas otorgadas");
			//Contador de filas
			$contador = 1;
			$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(17);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);

			//Le aplicamos negrita a los títulos de la cabecera.
			$this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);

			//Le aplicamos color a los titulos.
			$this->excel->getActiveSheet()->getStyle("A{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
			$this->excel->getActiveSheet()->getStyle("B{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
			$this->excel->getActiveSheet()->getStyle("C{$contador}")->getFill()->getStartColor()->setRGB('FF0000');


			$this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Total Antorchas');
			$this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Empleado');
			$this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Oficina');


			foreach($res as $d){
				//Incrementamos una fila más, para ir a la siguiente.
				$contador++;
				//Informacion de las filas de la consulta.
				$this->excel->getActiveSheet()->setCellValue("A{$contador}", $d->estrellas);
				$this->excel->getActiveSheet()->setCellValue("B{$contador}", $d->nombre);
				$this->excel->getActiveSheet()->setCellValue("C{$contador}", $d->cnomofi);
			}
			$estiloTituloReporte = array(
					'font' => array(
							'name'      => 'Arial',
							'bold'      => true,
					),
					'fill' => array(
							'type'  => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'B0C8E0')
					),
					'borders' => array(
							'allborders' => array(
									'style' => PHPExcel_Style_Border::BORDER_THIN
							)
					),
			);
			$this->excel->getActiveSheet()->getStyle('A1:C1')->applyFromArray($estiloTituloReporte);
			//Le ponemos un nombre al archivo que se va a generar.
			$archivo = "TopAntorchas.xls";
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$archivo.'"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
			//Hacemos una salida al navegador con el archivo Excel.
			$objWriter->save('php://output');
			$dataBitacora = array(
					"idAccion" => 7,
					"descripcion" => "Usuario ".$_SESSION['usuario']." Genero reporte de antorchas desde el ".$fechainicio."hasta el ".$fechafin."de agencia ".$ccodofi,
					"usuario" => $_SESSION['usuario'],
					"dirIp"=>$_SERVER['REMOTE_ADDR'],
					"nomMaquina"=>gethostbyaddr($_SERVER['REMOTE_ADDR'])
			);
			$this->Bitacora_Model->insertAccion($dataBitacora);
		}
		else{
			echo '<script>alert("NO HAY DATOS PARA MOSTRAR");</script>';
			echo "<script>window.close();</script>";
			exit;
		}
	}



}
