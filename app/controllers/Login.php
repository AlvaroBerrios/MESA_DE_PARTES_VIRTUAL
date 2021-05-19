<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	//$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

	function __construct()
    {
        parent::__construct();
		ini_set("max_execution_time", 0);
		$this->load->library("session");
		// Importa el modelo y le da el nombre "login"
		$this->load->model("Model_login","login");
		$this->load->library('My_PHPMailer');
		$this->load->library('My_dom');
    }

	public function index()
		{	
			 $this->load->view('login/login');
		}

	public function olvidar()
		{	
			 $this->load->view('login/olvido');
		}

	public function registrate()
		{	
			 $dataview['tipopersona'] = $this->login->gettipopersona();
			 // Envia la variable Cargo al modelo 
			 $dataview['Cargo'] = $this->login->gettipocargo();
			 $this->load->view('login/registro',$dataview);
		}	
	
		
	public function usuario()
	{	
		 if ($this->session->userdata('nroDocumento')) {
			$dataview['data_usuario']= $this->login->obtenerUsuario($this->session->userdata('iduser'));
			$dataview['Via'] = $this->login->gettipovia();
			$dataview['Zona'] = $this->login->gettipozona();
			$dataview['ubicacion'] = $this->login->getubicacion(); // Obtenemos los Departamentos
			$this->load->view('usuario/usuario',$dataview);
        } else {

            $this->session->set_userdata(array('msg' => ''));
            $this->load->view('login/login');  // CARGA la Pagina Login
        }
	}	

	public function getprovincia()
	{
		   $options = "";
           if($this->input->post('depa_id')){
           $depa_id = $this->input->post('depa_id');
           $proovincia = $this->login->getprovincia($depa_id);
		   ?>
		   		<option value="0">[--Seleccione--]</option>
				<?php
                foreach($proovincia as $fila)
                {
				?>
					<option value="<?=$fila->idProv?>"><?=$fila->provincia?></option>
				<?php
                }
           }
	}

	public function getdistrito(){
		$options = "";
		if($this->input->post('id_prov'))
		{
		$id_prov = $this->input->post('id_prov');
		$distrito = $this->login->getdistrito($id_prov);
			 foreach($distrito as $fila)
			 {
			 ?>
			 <option value="<?=$fila->idDist?>"><?=$fila->distrito?></option>
			 <?php
			 }
		}
 	}

	public function gettipodoc(){
		
		   $options = "";
           if($this->input->post('TipoPersona'))
           {
           $TipoPersona = $this->input->post('TipoPersona');
           $Tipodoc = $this->login->getTipoDoc($TipoPersona);
                foreach($Tipodoc as $fila)
                {
                ?>
                <option value="<?=$fila->idDoc?>"><?=$fila->descripcion?></option>
                <?php
                }
           }
	}
	
	public function consultaruc(){
		   $ruc=$this->input->post("id");
		   $data = file_get_html("https://api.sunat.cloud/ruc/".$ruc);
		   $info = json_decode($data, true);

		   if($data==='[]' || $info['fecha_inscripcion']==='--'){
     	        $datos = array(0 => 'nada');
              	echo json_encode($datos);
           }else{
                $datos = array(
                	1 => $info['razon_social'],
           );
		   
		       $datosRuc["razonsocial"] = html_entity_decode($datos[1], ENT_QUOTES, "UTF-8");
		        echo json_encode($datosRuc);
	       }
	}  

	public function consultadni(){
		$dni = $this->input->post('id');
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
	    curl_setopt($curl, CURLOPT_URL, 'https://dni.optimizeperu.com/api/persons/' .$dni);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	    $result = curl_exec($curl);
	    curl_close($curl);
	    $_result = json_decode($result);
	    $datos['nombres'] = $_result->name;
	    $datos['apellido_paterno'] = $_result->first_name;
	    $datos['apellido_materno'] = $_result->last_name;
	    echo json_encode($datos);
		
	}
  
	public function enviarLogin()
	 {
		$msg = array();
		$data = $this->login->Get_user($this->input->post("userLogin"),$this->input->post("passuser"));

        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
            
        $id_usuario = $data['id_usuario'];
        $nroDocumento = $data['nroDocumento'];
        $correo = $data['correo'];
        $pass = $data['pass'];


        $dataview["nroDocumento"] = $nroDocumento;
        $dataview["id_usuario"] = $id_usuario;
        $dataview["correo"] = $correo;
        $dataview["pass"] = $pass;
        $dataview["fecha"] = date("Y-m-d");
        $dataview["ip"] = $ipaddress;
        $dataview["modificado"] = date("Y-m-d H:i:s");
        $dataview["estado"] = '1';

		/**********************************************************/

		if($data){
			
			//$this->login->save_primerlogin($dataview);
			$this->session->set_userdata(array(
				"correo"=>$data['correo'],
				"nroDocumento"=>$data['nroDocumento'],
				"iduser"=>$data['id_usuario'],
				"TipoPersona"=>$data['idTipPer'],
				"TipoDocumento"=>$data['idtTipDoc'],
				"nameuser"=>$data['nombre'],
				"apaterno"=>$data['apPaterno'],
				"amaterno"=>$data['apMaterno'],
				"celular"=>$data['celular'],
				"pass"=>$data['pass'],
				"logueado"=>true));

			$msg["resp"] = 100;
			$msg["text"] = "Inicio de Sesion Exitoso!";
			echo json_encode($msg);
			//return $this->load->view('usuario/vistausuario');
			//redirect("Login/vistausuario","refresh"); 
		}else{
			$msg["resp"] = 10;
			$msg["text"] = "Usuario y/o contraseña incorrecta.";
			echo json_encode($msg);
		}

	 }
	/*****************************************************/

	function generate_string($input, $strength = 6) {
		$input_length = strlen($input);
		$random_string = '';
		for($i = 0; $i < $strength; $i++) {
			$random_character = $input[mt_rand(0, $input_length - 1)];
			$random_string .= $random_character;
		}
	 
		return $random_string;
	}


	/*****************************************************************************************/
	
	public function enviarRegistroDatos()
	{
	
	    $msg = array();
	    date_default_timezone_set('America/Lima');      
		/* Re-capcha:v3 */
		$url = "https://www.google.com/recaptcha/api/siteverify";
			$data = [
			'secret' => "6Ld3b9EZAAAAADFQvB3E4IgED1k0VIHx0KSX2EV4",
			//'response' => $_POST['token'],
			'remoteip' => $_SERVER['REMOTE_ADDR']
			];
		$options = array(
			'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($data)
			)
		);
		$context  = stream_context_create($options);
	  	//$response = file_get_contents($url, false, $context);
		//$res = json_decode($response, true);

		if(true) {

			 $tipoPersona=$this->input->post("cboTipoPersona");
			 $documento=trim($this->input->post("coTipoDocumento"));
			 $dni=trim($this->input->post("txtdoc"));
			 $txtnombre = $this->input->post("txtnombre");
		     $txtapepat = $this->input->post("txtapepat");
		     $txtapemat = $this->input->post("txtapemat");
		     $txtrazonsocial = $this->input->post("txtrazonsocial");
		     $txtie = $this->input->post("txtie");

			 // ID DE CARGO: NUMERO
			 $idCargo = $this->input->post("cboCargo");
			 // TEXTO QUE INGRESA EN EL INPUT DE CARGO
		     //$txtcargo=$this->input->post("txtcargo");
			 // CONTRASEÑA DE 6 DIGITOS
		     $txtcontra=$this->input->post("txtcontra");

		     $txtphone=trim($this->input->post("txtphone"));
		     $txtemail = trim($this->input->post("txtemail"));
			 $txtemail2= trim($this->input->post("txtemail2"));
			 $resultadocheck= $this->input->post("resultadocheck");
			 $from_name = $txtapepat.' '.$txtapemat.' ,'.$txtnombre;
			 $from_name2 = $txtnombre;
			 $verifica = '';
			 //$contra1 = generate_string($permitted_chars, 6);
			 //$contra = sha1('AFj34d'); // ENCRIPTACION DE CONTRASEÑA
			 $contra = 'AFj34d'; // ENCRIPTACION DE CONTRASEÑA
			 //$contra = password_hash($contra1,PASSWORD_DEFAULT); // ENCRIPTACION DE CONTRASEÑA
			 $estado = '1';

		/******************************VALIDA CAMPOS VACÍOS***********************************************/

			if ($tipoPersona != 0) {
				$verifica = true ;
			} else {
				$msg["resp"] = 10;
				$msg["text"] = "Debe seleccionar un tipo de persona.";
				echo json_encode($msg);die;
				
			}

			if ($documento != 0) {
				$verifica = true ;
			} else {
				$msg["resp"] = 10;
				$msg["text"] = "Debe seleccionar un tipo de documento.";
				echo json_encode($msg);die;
			}

		/******************************VALIDA CORREOS IGUALES Y CHECK***********************************************/

			if ($txtemail==$txtemail2) {
				$verifica = true ;
			} else {
				//$verifica = false ;
				$msg["resp"] = 10;
				$msg["text"] = "Los correos electrónicos no coinciden.";
				echo json_encode($msg);die;
				// CAMBIO MODIFICADO
				/*$data["message"] = "Los correos electrónicos no coinciden";
				$error = 2;
				$data = array(
						"msg"=>$data["message"],
						"error" => $error
				);
			  	echo json_encode($data);die;*/

			}


			if ($resultadocheck == 1) {
				$verifica = true ;	
			}else{
				$msg["resp"] = 10;
				$msg["text"] = "Debe seleccionar la casilla de acepto contacto.";
				echo json_encode($msg);die;

			}

			
		/******************************VALIDA DNI Y EMAIL***********************************/
		
		    $verificaemail = $this->login->buscaEmail($txtemail);
		    $verificaDocumento = $this->login->buscaDni($dni);

			if($verificaemail["num"] == 0){
				$verfica = true ;
			}else if($verificaemail["num"] >= 1){
				//$verifica = false ;
				$msg["resp"] = 10;
				$msg["text"] = "El Correo electronico ya se encuentra registrado.";
				echo json_encode($msg);die;
			}

			if($verificaDocumento["num"] == 0){
				$verifica = true ;
			} else if($verificaDocumento["num"] >= 1){
				//$verifica = false ;
				$msg["resp"] = 10;
				$msg["text"] = "El DNI ya se encuentra registrado.";
				echo json_encode($msg);die;
			}


			/******************************TIEMPO DATE**********************************/

	        date_default_timezone_set('America/Lima');
	        $timestamp = time();
	        $fecha_actual = date("Y-m-d H:i:s", $timestamp);


	        /**********************************CORREO*******************************/
		

	    	if($verifica){
				  	
				/*$mail = new PHPMailer();
				$mail->isSMTP();
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
				$mail->From = $txtemail;
				$mail->FromName = $from_name;
				
				
				if(!$mail->Send()) {
		            $data["message"] = "Error en el envío: " . $mail->ErrorInfo;
					$error = 1;
					
		        } else {
					$data["message"] = $txtnombre."  ¡En buena hora! datos registrados correctamente, se ha enviado al correo el último paso para crear una cuenta en Mesa de Partes Virtual.";
					$error = 0;
		        }
				
				
				$Pass = $dni;
				$from_mail = 'consulta@ugel03.gob.pe' ; 
				$mail->From = $txtemail;
				$mail->FromName = $from_name;
				$mail->AddCC((string)$this->input->post("txtemail"),"Usuario");
				$mail->Subject = '[UGEL03] Confirmación de cuenta para Mesa de Partes Virtual';
				$mail->Body = 
				'<b>UNIDAD DE GESTION EDUCATIVA LOCAL 03 </b>
				<br>Estimado(a) <b>'.$from_name.'</b>
				<br>
				<br> Gracias por registrarse a Mesa de Partes Virtual, a través de este correo damos a conocer su usuario y contraseña provisional:
				<br>
				<br>Usuario : '.trim($this->input->post("txtemail")).'
				<br>Contraseña : '.$Pass.'
				<br>
				<br>Para ingresar al sistema debe generar su contraseña oficial, a través del siguiente enlace: <a href="http://sistemas01.ugel03.gob.pe/mesadepartesvirtual/generar"> Generar Contraseña Virtual</a>
				<br> 
				<br>
				<br>Atte:
				<br>
				<br><b>UGEL03</b>
				<br>Telef : (01) 6155800 Anexo: 13018 Informes 
				<br>Atención de 8:30am a 1:00pm y 2:00 a 4:30pm
				<br>UGEL 03 - Av. Iquitos 918, La Victoria';
				
				$mail->IsHTML(true);
				$mail->CharSet = 'UTF-8';
				
				if(!$mail->Send()) {
		            $data["message"] = "Error en el envío: " . $mail->ErrorInfo;
					$error = 1;
		        } else {
		            $data["message"] = $txtnombre."  ¡En buena hora! datos registrados correctamente, se ha enviado al correo sus credenciales de acceso a la plataforma de Reasignación.";
					$error = 0;
		        }
				$data = array(
						"msg"=>$data["message"],
						"error" => $error
				);*/
				
				
				$this->session->set_userdata($data);
				
				
				/***********GUARDADO***********************/

				$dataview["idTipPer"] = $this->input->post("cboTipoPersona");
			    $dataview["idtTipDoc"] = $this->input->post("coTipoDocumento");
				$dataview["idCargo"] = $this->input->post("cboCargo");
				
				if($tipoPersona == '1'){
					$dataview["nroDocumento"] = $this->input->post("txtdoc");
					$dataview["nombre"] = $this->input->post("txtnombre");
					$dataview["apPaterno"] = $this->input->post("txtapepat");
					$dataview["apMaterno"] = $this->input->post("txtapemat");
				}
				if($tipoPersona == '2'){
					$dataview["nroDocumento"] = $this->input->post("txtdoc");
					$dataview["nombre"] = $this->input->post("txtrazonsocial");
				}
				if($tipoPersona == '3'){
					$dataview["nroDocumento"] = $this->input->post("txtdoc");
					$dataview["nombre"] = $this->input->post("txtie");
					$dataview["idCargo"] = $this->input->post("cboCargo");
					$dataview["descripcion_cargo"] = $this->input->post("txtcargo");
					// VALIDA SI SE SELECCIONO 12 EN EL SELECT
					/*if($idCargo == '12'){
						$dataview["descripcion_cargo"] = $this->input->post("txtCargo");
					}*/
				}
				if($tipoPersona == '4'){
					$dataview["nroDocumento"] = $this->input->post("txtdoc");
					$dataview["nombre"] = $this->input->post("txtnombre");
					$dataview["apPaterno"] = $this->input->post("txtapepat");
					$dataview["apMaterno"] = $this->input->post("txtapemat");
				}
				$dataview["celular"] = $this->input->post("txtphone");
				$dataview["correo"] = trim($this->input->post("txtemail"));
				//$dataview["pass"] = $this->input->post("txtcontra");
				$dataview["pass"] = $contra;
				$dataview["estado"] = $estado;
				//$dataview["estado"] = val("1");
				$dataview["modificado"] = date("Y-m-d H:i:s");   	   
				/* Registra un Usuario*/
				$this->login->save_registroUsuario($dataview);

				$idusu = $this->login->buscaIdUsuario($dni);
				$id_usuario = $idusu["usu"];
				$dataview2["id_usuario"] = $id_usuario;
				//$dataview2["pass"] = $this->input->post("txtdoc");
				$dataview["modificado"] = date("Y-m-d H:i:s");  

				$msg["resp"] = 100;
				$msg["text"] = "En buena Hora registro exitoso.";
				echo json_encode($msg);die;  


				/*$this->login->save_credencialUsuario($dataview2);		
				echo json_encode($data);	*/
		 
			}else{
				     
					$msg["resp"] = 10;
					$msg["text"] = "Error al guardar la información.";
					echo json_encode($msg);die;  
			}
				
		} else {
				
				    $msg["resp"] = 10;
					$msg["text"] = "Error! No eres un humano.";
					echo json_encode($msg);die;
		}
 	
    }

	
	public function enviarActualizarDatos()
	{
		$msg = array();
		date_default_timezone_set('America/Lima');

		/* Re-capcha:v3 */
		$url = "https://www.google.com/recaptcha/api/siteverify";
			$data = [
			'secret' => "6Ld3b9EZAAAAADFQvB3E4IgED1k0VIHx0KSX2EV4",
			//'response' => $_POST['token'],
			'remoteip' => $_SERVER['REMOTE_ADDR']
			];
		$options = array(
			'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($data)
			)
		);
		$context  = stream_context_create($options);
	  	//$response = file_get_contents($url, false, $context);
		//$res = json_decode($response, true);

		if(true){
			 $data = $this->login->Get_user($this->input->post("userLogin"),$this->input->post("passuser"));
			 $this->session->set_userdata($data);
			 // DATOS DE PERSONA
			 $tipoPersona  = $this->session->userdata('idTipPer');
			 $dni=trim($this->session->userdata("nroDocumento"));
			 $celular = $this->input->post("celular");
		     $correo = $this->input->post("correo");
		     $password1 = $this->input->post("password1");
			// Datos de Direccion
			 $departamento =  $this->input->post("cbDepartamento");
			 $provincia = $this->input->post("cbProvincia");
			 $distrito = $this->input->post("cbDistrito");
			 $via = $this->input->post("cbVia");
			 $zona = $this->input->post("cbZona");
			 $txtvia = $this->input->post("txtvia");
			 $txtzona = $this->input->post("txtzona");
			 $txtreferencia = $this->input->post("txtreferencia");
			 $id_usuario = $this->session->userdata('id_usuario');
			 $estado = '1';
			 $verifica = true;

			 /******************************VALIDA CAMPOS VACÍOS***********************************************/

			if ($departamento != 0) {
				$verifica = true ;
			} else {
				$msg["resp"] = 10;
				$msg["text"] = "Debe seleccionar un Departamento.";
				echo json_encode($msg);die;
				
			}

			if ($provincia != 0) {
				$verifica = true ;
			} else {
				$msg["resp"] = 10;
				$msg["text"] = "Debe seleccionar una Provincia.";
				echo json_encode($msg);die;
			}

			if ($distrito != 0) {
				$verifica = true ;
			} else {
				$msg["resp"] = 10;
				$msg["text"] = "Debe seleccionar una Distrito.";
				echo json_encode($msg);die;
			}

			
			if ($via != 0) {
				$verifica = true ;
			} else {
				$msg["resp"] = 10;
				$msg["text"] = "Debe seleccionar una Via.";
				echo json_encode($msg);die;
			}

			if ($zona != 0) {
				$verifica = true ;
			} else {
				$msg["resp"] = 10;
				$msg["text"] = "Debe seleccionar una Zona.";
				echo json_encode($msg);die;
			}

			if ($txtvia != '') {
				$verifica = true ;
			} else {
				$msg["resp"] = 10;
				$msg["text"] = "Debe escribir el Nombre de la Via.";
				echo json_encode($msg);die;
			}

			if ($txtzona != '') {
				$verifica = true ;
			} else {
				$msg["resp"] = 10;
				$msg["text"] = "Debe escribir el Nombre de la Zona.";
				echo json_encode($msg);die;
			}

			if ($txtvia != '') {
				$verifica = true ;
			} else {
				$msg["resp"] = 10;
				$msg["text"] = "Debe escribir el Nombre de la Referencia.";
				echo json_encode($msg);die;
			}


			 /******************************TIEMPO DATE**********************************/

			 date_default_timezone_set('America/Lima');
			 $timestamp = time();
			 $fecha_actual = date("Y-m-d H:i:s", $timestamp);

			if($verifica){

				$this->session->set_userdata($data);

				/***********GUARDADO***********************/

			
				if($id_usuario > 0){
					$dataview1["id_usuario"] = $id_usuario;
					$dataview1["idDist"] = $this->input->post("cbDistrito");
					$dataview1["idProv"] = $this->input->post("cbProvincia");
					$dataview1["idDepa"] = $this->input->post("cbDepartamento");
					$dataview1["idVia"] = $this->input->post("cbVia");
					$dataview1["idZona"] = $this->input->post("cbZona");
					$dataview1["nomVia"] = $this->input->post("txtvia");
					$dataview1["nomZona"] = $this->input->post("txtzona");
					$dataview1["referencia"] = $this->input->post("txtreferencia");
					$dataview1["estado"] = $estado;
					$dataview1["modificado"] = date("Y-m-d H:i:s");
					$this->login->save_direccionusuario($dataview1);
				}
				
				if($tipoPersona == '1'){
					$dataview["idTipPer"] = $tipoPersona;
					$dataview["celular"] = $this->input->post("celular");
					$dataview["correo"] = $this->input->post("correo");
					$dataview["pass"] = $this->input->post("password1");
				}
				if($tipoPersona == '2'){
					$dataview["idTipPer"] = $tipoPersona;
					$dataview["celular"] = $this->input->post("celular");
					$dataview["correo"] = $this->input->post("correo");
					$dataview["pass"] = $this->input->post("password1");
				}
				if($tipoPersona == '3'){
					$dataview["idTipPer"] = $tipoPersona;
					$dataview["celular"] = $this->input->post("celular");
					$dataview["correo"] = $this->input->post("correo");
					$dataview["pass"] = $this->input->post("password1");
				}
				if($tipoPersona == '4'){
					$dataview["idTipPer"] = $tipoPersona;
					$dataview["celular"] = $this->input->post("celular");
					$dataview["correo"] = $this->input->post("correo");
					$dataview["pass"] = $this->input->post("password1");
				}
				$dataview["modificado"] = date("Y-m-d H:i:s");
				$this->login->update_datosPersonales($dataview);

				$idusu = $this->login->buscaIdUsuario($dni);
				$id_usuario = $idusu["usu"];
				$dataview2["id_usuario"] = $id_usuario;
				//$dataview2["pass"] = $this->input->post("txtdoc");
				$dataview["modificado"] = date("Y-m-d H:i:s");  

				$msg["resp"] = 100;
				$msg["text"] = "En buena Hora registro exitoso.";
				echo json_encode($msg);die;


			}else{
				$msg["resp"] = 10;
				$msg["text"] = "Error al actualizar la información.";
				echo json_encode($msg);die;  
			}
		}else{
			$msg["resp"] = 10;
			$msg["text"] = "Error! No eres un humano.";
			echo json_encode($msg);die;
		}     
	}


	
	public function olvidoPassword(){
		
		$msg = array();
		
		$data = $this->login->Get_user2($this->input->post("userLogin"));
		
		/*********************************************/

    
        $id_usuario = $data['id_usuario'];
        $nroDocumento = $data['nroDocumento'];
        $from_mail = $data['correo'];
        $email = $data['correo'];
        $pass = $data['pass'];
        $txtnombres = $data['nombre'];
        $txtapePaterno = $data['apPaterno'];
        $txtapeMaterno = $data['apMaterno'];
        $from_name = $txtapePaterno.' '.$txtapeMaterno.' ,'.$txtnombres;

    

        /**********************************************************/
		
		if($data){
			$mail = new PHPMailer();
			$mail->isSMTP();
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
		
		
			if(!$mail->Send()) {
	            $data["message"] = "Error en el envío: " . $mail->ErrorInfo;
				$error = 1;
				
	        } else {
				$data["message"] = $txtnombres."  ¡En buena hora! datos registrados correctamente , se ha enviado credenciales de acceso a Mesa de Partes Virtual. ";
				$error = 0;
	        }
			$Pass = $pass;
			$from_mail = 'consulta@ugel03.gob.pe' ; 
			$mail->From = $from_mail;
			$mail->FromName = $from_name;
			$mail->AddCC((string)$this->input->post("userLogin"),"Usuario");
			$mail->Subject = '[UGEL03] Envío de contraseña de Mesa de Partes Virtual';
			$mail->Body = '<b>UNIDAD DE GESTION EDUCATIVA LOCAL 03 </b><br>
			Estimado(a) <b>'.$from_name.'</b><br>
			A través de este correo damos a conocer su usuario y contraseña de ingreso al sistema :<br>
			<br>Usuario : '.trim($email).'<br>
			Contraseña : '.$Pass.'<br>
			<br>Puede ingresar al Sistema a través del siguiente enlace :<a href="http://sistemas01.ugel03.gob.pe/pruebamdp2/"> Mesa de Partes Virtual </a> <br>
			Nota: Recuerde que las mayúsculas y minúsculas afectan en la clave presente.<br>
			<br> Atte:<br><br><br><b>UGEL03  </b><br>
	        Telef : (01) 6155800 Anexo: 13018 Informes <br> Atención de 8:30am a 1:00pm y 2:00 a 4:30pm<br> UGEL 03 - Av. Iquitos 918, La Victoria';
			
			$mail->IsHTML(true);
			$mail->CharSet = 'UTF-8';
		
			if(!$mail->Send()) {
	            $data["message"] = "Error en el envío: " . $mail->ErrorInfo;
				$error = 1;
	        } else {
	            $data["message"] = $txtnombres."  ¡En buena hora! datos registrados correctamente , el sistema enviara las credenciales de acceso a su correo electronico ";
				$error = 0;
	        }

			$data = array(
					"msg"=>$data["message"],
					"error" => $error
			);
			$msg["resp"] = 10;
			$msg["text"] = "¡En buena hora! El sistema enviará las credenciales de acceso a su correo electronico";
			
			echo json_encode($msg);
		}else{
			$msg["resp"] = 10;
			$msg["text"] = "Correo no registrado";
			echo json_encode($msg);
		}
	}
	

    public function change_password()
		{
		
			$msg = array();
			
			$data['dni'] = $this->session->userdata("nroDoc");
			$data['email'] = $this->session->userdata("user");
			$data['passaActual'] = $this->input->post("passAnterior");
			
			if($this->homeAdjudicaciones->Get_userChangePass($data)){
				$this->session->set_userdata(array("user"=>$data['email']));
				
				$data = array();
				$data['pass'] = $this->input->post("passRepetir");
				$data['nroDoc'] = $this->session->userdata("nroDoc");
				$data['email'] = $this->session->userdata("user");
				if($this->homeAdjudicaciones->Change_PasswordUser($data)){
					$msg["resp"] = 100;
					$msg["text"] = "La contraseña se cambio correctamente.";
				}
				else{
					$msg["resp"] = 0;
					$msg["text"] = "Ha ocurrido un error.";
				}
			}
			else{
				$msg["resp"] = 10;
				$msg["text"] = "Ingrese correctamente su contraseña actual.";
			}
			
			echo json_encode($msg);
			
			
		}


	public function logout()
		{
			$this->session->sess_destroy();
			redirect("homeAdjudicaciones/index");
	    }

}
