<?php
require_once APPPATH.'../vendor/autoload.php';
ob_start();

$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type=”text/css”>
body{
 background:url('. base_url().'/resources/img/fondo.png) no-repeat;
 background-image-resolution:300dpi;
 background-image-resize:6;
 }
 .sad5eedae{
 text-align: justify;
 }
</style>
</head>
<body style="margin:0;">
		<div class="pagemargins">
			<table cellspacing="0" cellpadding="0" border="0" style="border-width:0px;width:741px;border-collapse:collapse;white-space:normal;">
				<tr style="height:75px;">
					<td style="border:0px;height:75px;width:30px;"></td><td style="border:0px;height:75px;width:244px;"></td><td style="border:0px;height:75px;width:192px;"></td><td style="border:0px;height:75px;width:18px;"></td><td style="border:0px;height:75px;width:211px;"></td><td style="border:0px;height:75px;width:46px;"></td>
				</tr><tr style="height:23px;">
					<td style="border:0px;height:23px;width:30px;"></td><td style="border:0px;height:23px;width:244px;"></td><td style="border:0px;height:23px;width:192px;"></td><td style="border:0px;height:23px;width:18px;"></td><td class="s59a9c4fd" style="max-width:205px;max-height:17px;padding:3px 3px 3px 3px;white-space:nowrap;height:17px;width:205px;overflow:hidden;text-overflow:clip;box-sizing:border-box;"><div>&ensp;&ensp;&ensp;&ensp; San Salvador, '.date('d').' de '.$mesActual.' de '.date('Y').'</div></td><td style="border:0px;height:23px;width:46px;"></td>
				</tr><tr style="height:30px;">
					<td style="border:0px;height:30px;width:30px;"></td><td style="border:0px;height:30px;width:244px;"></td><td style="border:0px;height:30px;width:192px;"></td><td style="border:0px;height:30px;width:18px;"></td><td style="border:0px;height:30px;width:211px;"></td><td style="border:0px;height:30px;width:46px;"></td>
				</tr><tr style="height:730px;">
					<td style="border:0px;height:730px;width:30px;"></td><td class="sad5eedae" colspan="4" style="max-width:659px;max-height:724px;padding:3px 3px 3px 3px;word-wrap:break-word;white-space:pre-wrap;height:724px;width:659px;overflow:hidden;text-overflow:clip;box-sizing:border-box;"><div><div style="display:table-cell;width:659px;text-align:justify;"><br>'.$grupo.'<br>'.$articulo.'  '.$nombre.'<br>DUI:  '.$Dui.'	<br>NIT:	 '.$Nit.'	<br>Presente:		<br><br><br><br>Por este medio el DEPARTAMENTO LEGAL de ASEI le informa que su caso ha pasado a la etapa de COBRO JURÍDICO, por haber realizado gestiones de cobro administrativas, sin haber logrado un resultado favorable a nuestra institución<br><br><br>'.$parrafo1.'<br><br><br>'.$parrafo2.' <br><br><br>Se le informa que de no presentarse en la fecha y hora indicada se entenderá que existe renuencia de su parte a llegar a un acuerdo, por lo que se continuará el Proceso Legal, efectuándole el cobro por el saldo total, más sus respectivos intereses y costas procesales, efectuando el retiro de garantías o en su caso cobrar el Pagare y documentación legal firmada, por lo que de usted depende adquirir la responsabilidad ante nuestra institución o hacerlo ante los tribunales, sufriendo consecuencias legales más graves, por lo que le recomendamos presentarse en la fecha indicada.<br><br><br><br><br><br></br>________________________________<br>                     <br>                   &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;Área Legal</div></div></td><td style="border:0px;height:730px;width:46px;"></td>
				</tr><tr style="height:67px;">
					<td style="border:0px;height:67px;width:30px;"></td><td style="border:0px;height:67px;width:244px;"></td><td style="border:0px;height:67px;width:192px;"></td><td style="border:0px;height:67px;width:18px;"></td><td style="border:0px;height:67px;width:211px;"></td><td style="border:0px;height:67px;width:46px;"></td>
				</tr><tr style="height:1px;">
					<td style="border:0px;height:1px;width:30px;"></td><td style="border:0px;height:1px;width:244px;"></td><td style="border:0px;height:1px;width:192px;"></td><td style="border:0px;height:1px;width:18px;"></td><td style="border:0px;height:1px;width:211px;"></td><td style="border:0px;height:1px;width:46px;"></td>
				</tr>
			</table>
		</div><script type="text/javascript">
		</script><script type="text/javascript">
		</script>
	</body>
</html>
';

$mpdf = new \Mpdf\Mpdf(['format' => 'Letter']);
/*/Marcas de agua en MPDF
$mpdf->SetWatermarkText('PRUEBA WATERMARK');
$mpdf->showWatermarkText = true;
*/
$mpdf->WriteHTML($html);
$mpdf->Output($nombre.'.pdf',\Mpdf\Output\Destination::DOWNLOAD);
//$mpdf->Output();
//echo $html;



