<?php if (!defined('BASEPATH')) exit('');
	include_once APPPATH.'/third_party/mpdf/mpdf.php';

class Pdf
{
	public $param;
	public $pdf;

	public function __construct($param = '"en-GB-x","A4","","",10,10,10,10,6,3'){
		$this->param = $param;
		$this->pdf = new mPDF($this->param);
	}

	function pdf(){
		$CI = & get_instance();
		log_message('Debug', 'mPDF class is loaded.');
	}

	function load($param=NULL){
		require_once APPPATH.'../resources/vendor/autoload.php';
		return new \Mpdf\Mpdf([
			'margin_left'       =>  '5',
			'margin_right'      =>  '5',
			'mode'              =>  'utf-8',     //Codepage Values OR Codepage Values
			'format'            =>  'A4',        //A4, Letter, Legal, Executive, Folio, Demy, Royal, etc
			'orientation'       =>  'P'          //"L" for Landscape orientation, "P" for Portrait orientation
		]);
	}
}

