<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

					
	function __construct()
    {
        parent::__construct();
         date_default_timezone_set('America/Lima'); 
		ini_set("max_execution_time", 0);
		
		//$this->load->helper('captcha');
		$this->load->library("session");
		$this->load->model("Model_login","login");
		$this->load->library('My_PHPMailer');
		
    }
	


	public function index()
	{	
		 $this->load->view('login/home');
	}
	
	public function enviarLogin(){
		
		$msg = array();
		
		$data = $this->login->Get_user($this->input->post("userLogin"),$this->input->post("passuser"));
		
		if($data){
			
			$this->session->set_userdata(array("iduser"=>$data['id_usuario'],"idtipo"=>$data['id_tipo'],"user"=>$data['email'],"dni"=>$data['dni'],"nombres"=>$data['nombres'],"apepa"=>$data['apellido_pat'],"apema"=>$data['apellido_mat'],"logueado"=>true));
               
			$msg["resp"] = 100;
			$msg["text"] = "Accediendo!!!.";
			echo json_encode($msg);
			
		}else{
		    
			$msg["resp"] = 10;
			$msg["text"] = "Usuario y/o contraseña incorrecta.";
			echo json_encode($msg);
		}
		
		//echo json_encode($msg);
	}
	
	
    	
   public function enviaCredenciales(){

	date_default_timezone_set('America/Lima'); 
	        
	/* Re-capcha:v3 */
	
	
	$nroDoc = $this->input->post("nroDoc");
	$fechaRegistro = $this->input->post("fechaRegistro");
	//$emailUser = $this->input->post("emailUser");
	$txtnombres = $this->input->post("nombresuser");
	$apellidosuser = $this->input->post("apellidosuser");
	
    $tituloConsulta = $this->input->post("tituloConsulta");
	$asuntoReclamo = $this->input->post("asuntoReclamo");
	$codModular = $this->input->post("ie");

		$from_name = $txtnombres.' ,'.$apellidosuser;
		$from_name2 = $txtnombres;
	 
	
	  
	  $from_mail = trim($this->input->post("emailUser"));
	 
      $telefonoUsuario = $this->tramite->buscaTelefono($from_mail,$nroDoc);
	  $nombreIe = $this->tramite->buscaie($codModular);
	 /*comrobamos si el correo y/o Dni se encuentra registrado*/
	  /*$verficaDocumento = $this->tramite->buscaEmail($from_mail);
	  
	  $verfica = '';
	  if($verficaDocumento["num"] == 0){
		 $verfica = true ;
	  }
	  
	  if($verficaDocumento["num"] >= 1){
		 $verfica = false ;
	  }

*/

	 if(true){
			   
	 $mail = new PHPMailer();
	 $mail->isSMTP();
	 //$mail->SMTPDebug = 1;
	 $mail->SMTPOptions = array(
	 'ssl' => array(
	 'verify_peer' => false,
	 'verify_peer_name' => false,
	 'allow_self_signed' => true
		 )
	 );
	 
	 $mail->Host = "mail.ugel03.gob.pe";
	 $mail->Port = 25;
	 $mail->SMTPSecure = 'tls';
	 $mail->SMTPAuth = false;
	 $mail->Username = "consulta@ugel03.gob.pe";
	 $mail->Password = "1234@abcd";
	 $mail->From = $from_mail;
	 $mail->FromName = $from_name;
	 $mail->AddAddress('consulta@ugel03.gob.pe',"Generico");
	 
	 
	 if(!$mail->Send()) {
		 $data["message"] = "Error en el envíos: " . $mail->ErrorInfo;
		 $error = 1;
		 
	 } else {
		 
		 $data["message"] = $txtnombres." ¡En buena hora! datos registrados correctamente  ";
		 $error = 0;
	 }
	 
	 /*envio mensaje de confirmacion al solicitante*/
	// $Pass = generateRandomPass(6);
	 $from_mail = 'consulta@ugel03.gob.pe' ; 
	 $mail->From = $from_mail;
	 $mail->FromName = $from_name;
	 $mail->AddCC((string)$this->input->post("emailUser"),"Usuario");
	 $mail->Subject = '[UGEL03]Buzon de Consultas UGEL03';
	 $mail->Body = '<b>UNIDAD DE GESTION EDUCATIVA LOCAL 03 </b><br>
	 Estimado(a) <b>'.$from_name2.'</b><br>
	 Se ha registrado correctamente su consulta a nuestro buzon.<br>
	 <b>Detalle:</b><br>
	 <b>Asunto: </b>'.$tituloConsulta.'<br>
	 <b>Descripción: </b>'.$asuntoReclamo.'<br>
	 <b>Institución educativa: </b>'.$nombreIe["num"].'<br>
	 <b>Fecha de Registro: </b>'.$fechaRegistro.'<br>
	 <b>Medios de comunicación usuario:</b><br>
	 <b>Telefono Usuario : </b>'.$telefonoUsuario["num"].'<br>
	 <b>Correo Usuario : </b>'.trim($this->input->post("emailUser")).'<br>
	 Gracias por registrar su consulta al nuevo portal de Buzon de Consultas <br>
	 <br> Atte:<br><b>UGEL03  </b><br>
	 Telef : (01) 6155800 Anexo: 13018 Informes <br> Atención de 8:30am a 1:00pm y 2:00 a 4:30pm<br> UGEL 03 - Av. Iquitos 918, La Victoria';
	 
	 $mail->IsHTML(true);
	 $mail->CharSet = 'UTF-8';
	 
	 if(!$mail->Send()) {
		 $data["message"] = "Error en el envío: " . $mail->ErrorInfo;
		 $error = 1;
	 } else {
		 $data["message"] = $from_name2.",  Se ha enviado un correo de confirmacion sus datos fueron registrados correctamente. ";
		 $error = 0;
	 }
	 $data = array(
			 "msg"=>$data["message"],
			 "error" => $error
	 );
	 
	 
	 $this->session->set_userdata($data);
	 
	 
	 /***********savedata***********************/
	
	 
		 $dataview["idUsuario"] = $this->input->post("doc");
		 $dataview["titulo"] = $this->input->post("tituloConsulta");
		 $dataview["descripcion"] = $this->input->post("asuntoReclamo");
		 $dataview["ie"] = $this->input->post("ie");
		 $dataview["fechaConsulta"] = date("Y-m-d H:i:s");
		 $dataview["modificado"] = date("Y-m-d H:i:s");
		 $dataview["estado"] = '1';
		$dataview["flg"] = '1';
 
		 $this->tramite->save_Consultabuzon($dataview);

		 echo json_encode($data["msg"]);
	  
	 }/*else{
		  
		 $data["message"] = "El correo electronico ya se encuentra registrado";
		 $error = 2;
	
		 $data = array(
				 "msg"=>$data["message"],
				 "error" => $error
		 );
		  
		  
		   echo json_encode($data);
		   
		   
		   
	 }*/
		 
		 
   	   
   }

  
	
	



	public function logout(){
		$this->session->sess_destroy();
		redirect("login/index");
   }



}
