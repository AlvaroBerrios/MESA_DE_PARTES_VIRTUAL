<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller {

	/**
	
	 */
	function __construct()
    {
        parent::__construct();
		ini_set("max_execution_time", 0);
		$this->load->library("session");
		$this->load->model("Model_boleta","boleta");
		
    } 
	public function index()
	{
		//cargamos la librería	
		$this->load->library('ciqrcode');
		//hacemos configuraciones
//		$params['data'] = $this->random(30);
		$params['data'] = "Americo Farfan Ramos";
		
		//writer($params['data']);die;
		$params['level'] = 'H';
		$params['size'] = 3;
		//decimos el directorio a guardar el codigo qr, en este 
		//caso una carpeta en la raíz llamada qr_code
		
		$params['savename'] = FCPATH.'resource/qr_code/qrcode.png';
		//generamos el código qr
		$this->ciqrcode->generate($params);	
		echo '<img src="'.base_url().'resource/qr_code/qrcode.png" />';
	}
	public function random($num){
		$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		$string = '';
		for ($i = 0; $i < $num; $i++) {
		     $string .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $string;
	}
	
}
