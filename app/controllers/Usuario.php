<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

		
	function __construct()
    {
        parent::__construct();
		ini_set("max_execution_time", 0);
		$this->load->library("session");
		$this->load->model("Model_login","login");
		$this->load->library('My_PHPMailer');
		$this->load->library('My_dom');
    }

	public function index()
		{	
			 $this->load->view('usuario/vistausuario');
		}
    }
