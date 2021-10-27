<?php


class Bitacora extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->helper("url");
		$this->load->model("Bitacora_Model");
		$this->load->model("GestionPermiso_Model");
		$this->ObtenerPermiso();
	}

	public function index(){
		$dataBitacora = array(
				"idAccion" => 03,
				"descripcion" => "Usuario ".$_SESSION['usuario']." ingresó al Modulo de Bitacoras del sistema.",
				"usuario" => $_SESSION['usuario'],
				"dirIp"=>$_SERVER['REMOTE_ADDR'],
				"nomMaquina"=>gethostbyaddr($_SERVER['REMOTE_ADDR'])
		);
		$this->Bitacora_Model->insertAccion($dataBitacora);
		$permiso["padres"]=$this->GestionPermiso_Model->getPadres($_SESSION['usuario']);
		$permiso["hijos"]=$this->GestionPermiso_Model->getHijos($_SESSION['usuario']);
		//subir nuevamente
		$foto["foto"]=$this->GestionPermiso_Model->getFoto($_SESSION["usuario"]);
		$this->load->view("layout/head");
		$this->load->view("layout/sidebar",$permiso);
		$this->load->view("layout/navbar",$foto);
		$this->load->view("Sistema/Bitacora");
		$this->load->view("layout/footer");
		$this->load->view("layout/end_footer");
		$this->load->view("Sistema/end_Bitacora");
	}

	public function getAccion(){
		$Accion = $this->Bitacora_Model->getAccion();
		echo "<option value=\"X\">TODAS...</option>";
		foreach ($Accion as $fila) {
			?>
			<option value="<?php echo $fila->id ?>"><?php echo $fila->accion ?></option>
			<?php
		}
	}

	public function getUsuarios(){
		$Usuarios = $this->Bitacora_Model->getUsuario();
		echo "<option value=\"X\">TODOS...</option>";
		foreach ($Usuarios as $fila) {
			?>
			<option value="<?php echo $fila->usuario ?>"><?php echo $fila->nombre ?></option>
			<?php
		}
	}

	public function getTabla(){
		$data = $this->Bitacora_Model->getBitacoras();
		?>
		<table class="table" id="Bitacora">
			<thead class="thead-light">
			<tr>
				<th scope="col">N°</th>
				<th scope="col">Accion</th>
				<th scope="col">Descripcion</th>
				<th scope="col">Usuario</th>
				<th scope="col">Fecha</th>
			</tr>
			</thead>
			<tbody>
			<?php
			if (!empty($data)){
				foreach ($data as $datos){
					?>
					<tr>
						<td id="codigo"><?php echo $datos->id; ?></td>
						<td id="descripcion"><?php echo $datos->accion; ?></td>
						<td id="descripcion"><?php echo $datos->descripcion; ?></td>
						<td id="usuario"><?php echo $datos->usuario; ?></td>
						<td id="fecha"><?php echo date("d/m/Y h:m:s",strtotime($datos->fechaServ)); ?></td>
					</tr>
					<?PHP
				}
			}
			?>
			</tbody>
		</table>
		<?php
	}

	public function getParameters(){
		$datos=$this->input->post();
		$data = array(
				"fechaInicio"=>date("d/m/Y",strtotime($datos["fechaInicio"])),
				"fechaFin"=>date("d/m/Y",strtotime($datos["fechaFin"])),
				"Accion"=>$datos["cbxAccion"],
				"Usuario"=>$datos["cbxUsuario"]
		);
		$this->generar_excel($data);
	}

	public function generar_excel($data){
		$datos = $this->Bitacora_Model->getBitacorasRpt($data);
		if(count($datos) > 0){
			//Cargamos la librería de excel.
			$this->load->library('excel'); $this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->setTitle('REPORTE DE BITACORAS');
			//Contador de filas
			$contador = 1;
			//Le aplicamos ancho las columnas.
			$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(45);
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
			$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
			//Le aplicamos negrita a los títulos de la cabecera.
			$this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
			//Le aplicamos color a los titulos.
			$this->excel->getActiveSheet()->getStyle("A{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
			$this->excel->getActiveSheet()->getStyle("B{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
			$this->excel->getActiveSheet()->getStyle("C{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
			$this->excel->getActiveSheet()->getStyle("D{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
			$this->excel->getActiveSheet()->getStyle("E{$contador}")->getFill()->getStartColor()->setRGB('FF0000');
			//Definimos los títulos de la cabecera.
			$this->excel->getActiveSheet()->setCellValue("A{$contador}", 'ID');
			$this->excel->getActiveSheet()->setCellValue("B{$contador}", 'ACCION');
			$this->excel->getActiveSheet()->setCellValue("C{$contador}", 'DESCRIPCION');
			$this->excel->getActiveSheet()->setCellValue("D{$contador}", 'USUARIO');
			$this->excel->getActiveSheet()->setCellValue("E{$contador}", 'FECHA');
			//Definimos la data del cuerpo.
			foreach($datos as $d){
				//Incrementamos una fila más, para ir a la siguiente.
				$contador++;
				//Informacion de las filas de la consulta.
				$this->excel->getActiveSheet()->setCellValue("A{$contador}", $d->id);
				$this->excel->getActiveSheet()->setCellValue("B{$contador}", $d->accion);
				$this->excel->getActiveSheet()->setCellValue("C{$contador}", $d->descripcion);
				$this->excel->getActiveSheet()->setCellValue("D{$contador}", $d->usuario);
				$this->excel->getActiveSheet()->setCellValue("E{$contador}", DATE("d/m/Y h:m:s",strtotime($d->fechaServ)));
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
			$this->excel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($estiloTituloReporte);
			//Le ponemos un nombre al archivo que se va a generar.
			$archivo = "rptBitacora.xls";
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$archivo.'"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
			//Hacemos una salida al navegador con el archivo Excel.
			$dataBitacora = array(
					"idAccion" => 7,
					"descripcion" => "Usuario ".$_SESSION['usuario']." Descargó reporte de Bitacoras desde la IP ".$_SERVER['REMOTE_ADDR']." y equipo ".gethostbyaddr($_SERVER['REMOTE_ADDR']).".",
					"usuario" => $_SESSION['usuario'],
					"dirIp"=>$_SERVER['REMOTE_ADDR'],
					"nomMaquina"=>gethostbyaddr($_SERVER['REMOTE_ADDR'])
			);
			$this->Bitacora_Model->insertAccion($dataBitacora);
			$objWriter->save('php://output');
		}
		else{
			echo '<script>alert("ERROR NO HAY DATOS");</script>';
			echo "<script>window.close();</script>";
			exit;
		}
	}

	public function ObtenerPermiso(){
		$permiso=$this->GestionPermiso_Model->getPermiso($_SESSION['usuario'],'3');
		if($permiso[0]->Contador>0) {
		}
		else{
			?>
			<script type="text/javascript">
				alert("No posee permisos para ingresar a éste modulo");
				window.setTimeout(function(){
					location = ('<?php echo site_url("Login")?>');
				} ,20);
			</script>
			<?php
		}
	}
}
