<?php


class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->model("GestionPermiso_Model");

	}
	public function index(){
		$permiso["padres"]=$this->GestionPermiso_Model->getPadres($_SESSION['usuario']);
		$permiso["hijos"]=$this->GestionPermiso_Model->getHijos($_SESSION['usuario']);
		$this->load->view("layout/head");
		$this->load->view("layout/sidebar",$permiso);
		$this->load->view("layout/navbar");
		//redireccion de login
		$this->load->view("Layout/Dashboard");
		$this->load->view("layout/footer");
		$this->load->view("layout/end_footer");
		$this->load->view("layout/end_Dashboard");
	}

	public function indexsesion(){
		$permiso["data"]=$this->GestionPermiso_Model->getPermisos($_SESSION['usuario']);
		$this->load->view("layout/head");
		$this->load->view("layout/sidebar",$permiso);
		$this->load->view("layout/navbar");

		//redireccion de login
		$this->load->view("Layout/Dashboard");
		$this->load->view("layout/footer");
		$this->load->view("layout/end_footer");
	}

}
