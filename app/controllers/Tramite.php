<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tramite extends CI_Controller {

	var $solicitud;
	var $filesdirectory;

					
	function __construct()
    {
        parent::__construct();
		ini_set("max_execution_time", 0);
		$this->load->library("session");
		$this->load->model("Model_tramite","tramite");
		$this->load->library('My_PHPMailer');
		$this->load->library('My_dom');
		
    } 
	public function index()
	{   
		$dataview['ie'] = $this->tramite->getie();
		
	     $dataview['tipopersona'] = $this->tramite->gettipopersona();
		$dataview["solicitud"] = $this->tramite->Get_AllTipPedido();



		//writer($dataview["solicitud"]);die;
		$this->load->view('tramite/home',$dataview);
		
		/*$this->load->view('boleta/home');*/
	}



	public function getNivelPedido(){
		$html="";
		$id = $_POST['id'];
		$nivel = $_POST['nivel'];
		$rs = $this->tramite->getNivelPedido($id,$nivel);
		      $html.= "<option value=''>[--SELECCIONE--]</option>";
		 foreach($rs as $item){
			   $html.= "<option value='".$item["id_tippedido"]."'>".$item["nombre"]."</option>";
		 }
		   echo $html;
	}

	   
	public function getNivelPedidoLev2(){

        $html="";
		$id = $_POST['id2']; 
		$nivel = $_POST['nivel'];
		$rs = $this->tramite->getNivelPedidoLev2($id,$nivel);
		        $html.= "<option value=''>[--SELECCIONE--]</option>";
		if($rs){
			foreach($rs as $item){
				$html.= "<option value='".$item["id_tippedido"]."'>".$item["nombre"]."</option>";
		  }
			echo $html;

			
		}else{
			echo false;
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
                //	0 => $info['ruc'], 
                	1 => $info['razon_social'],
                //	2 => date("d/m/Y", strtotime($info['fecha_actividad'])),
                //	3 => $info['contribuyente_condicion'],
                //	4 => $info['contribuyente_tipo'],
                //	5 => $info['contribuyente_estado'],
                //	6 => date("d/m/Y", strtotime($info['fecha_inscripcion'])),
               // 	7 => $info['domicilio_fiscal'],
               // 	8 => date("d/m/Y", strtotime($info['emision_electronica']))
           );
		   
		       $datosRuc["razonsocial"] = html_entity_decode($datos[1], ENT_QUOTES, "UTF-8");
		        echo json_encode($datosRuc);
	       }
	}  
	public function consultadni(){
	    
		
		$dni = $this->input->post('id');
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
	    curl_setopt($curl, CURLOPT_URL, 'https://dni.optimizeperu.com/api/persons/' . $dni);
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

	public function getUltimoNivel(){
		$nivel = $this->tramite->getUltimoNivel($this->input->post("id"));
		echo(json_encode($nivel));
	}
    
	public function gettipodoc(){
		
		    $options = "";
           if($this->input->post('TipoPersona'))
           {
           $TipoPersona = $this->input->post('TipoPersona');
           $Tipodoc = $this->tramite->getTipoDoc($TipoPersona);
                foreach($Tipodoc as $fila)
                {
                ?>
                <option value="<?=$fila->id?>"><?=$fila->descripcion?></option>
                <?php
                }
           }
	}

    

	public function enviar(){
		
					
		$dataview["servicio"] = $this->tramite->Get_TipPedido($this->input->post("cbservicio"));
		$this->solicitud = $dataview["servicio"];
		$dataview["dependencia"] = $this->input->post("txtdependencia");
		$dataview["resumen"] = $this->input->post("txtresumen");
		$dataview["apepat"] = $this->input->post("txtapepat");
		$dataview["apemat"] = $this->input->post("txtapemat");
		$dataview["nombre"] = $this->input->post("txtnombre");
		$dataview["razonsocial"] = $this->input->post("txtrazonsocialhid");
		$dataview["doc"] = $this->input->post("txtdoc");
	//	$dataview["ie"] = $this->input->post("txtie");
		$dataview["ie"] = $this->input->post("txtie_val");
		
		$dataview["cargo"] = $this->input->post("txtcargo");
		$dataview["via"] = $this->input->post("rbtvia");
		$dataview["nombvia"] = $this->input->post("txtnomvia");
		$dataview["referencia"] = $this->input->post("txtreferencia");
		$dataview["telefono"] = $this->input->post("txtphone");
		$dataview["modular"] = $this->input->post("txtmodula");
		$dataview["email"] = $this->input->post("txtemail");	

    	if( $this->tramite->Get_TipPedidoid($this->input->post("cbservicio")) == 16 || $this->tramite->Get_TipPedidoid($this->input->post("cbservicio")) == 52){
			$dataview["fundamento"] = $this->input->post("txtfundpedido");
		}

		if( $this->tramite->Get_TipPedidoid($this->input->post("cbservicio")) == 51){
			$dataview["fundamento"] = 'RECLAMO REASIGNACIÓN '.$this->input->post("txtfundpedido");
		}
	
				
		$html = $this->load->view('tramite/pdf',$dataview,true);
		
		$this->genera($html);
	}
	
	public function genera($html)
	{
		
		ini_set("memory_limit","880M");
		set_time_limit(0);
		$this->load->library('Pdf');
				
		
		/*writer($dataview);die;*/
		//$mpdf=new mPDF('','', 0, '', 15, 15);
		#$mpdf=new mPDF('utf-8', 'A4-L');
		$mpdf=new mPDF('utf-8', 'A4',0, '', 10, 10, 13, 2, 9, 9, 'P');
		
		/*$mpdf=new mPDF('c'); */
		$mpdf->SetTitle('FUT');
		$mpdf->mirroMargins = 1;
		$mpdf->ignore_invalid_utf8 = true;
		$mpdf->defaultheaderfontsize = 9;	/* in pts */
		$mpdf->defaultheaderfontstyle = "";	/* blank, B, I, or BI */
		$mpdf->defaultheaderline = 1; 	/* 1 to include line below header/above footer */
		
		$mpdf->defaultfooterfontsize = 9;	/* in pts */
		$mpdf->defaultfooterfontstyle = "";	/* blank, B, I, or BI */
		$mpdf->defaultfooterline = 1; 	/* 1 to include line below header/above footer */
		
		/*$mpdf->SetHeader('');
		$mpdf->SetFooter('{PAGENO}');	 defines footer for Odd and Even Pages - placed at Outer margin */
		
		$mpdf->SetFooter(array(
			'L' => array(
				'content' => 'Text to go on the left',
				'font-family' => 'sans-serif',
				'font-style' => '',	/* blank, B, I, or BI */
				'font-size' => '10',	/* in pts */
			),
			'C' => array(
				'content' => '- {PAGENO} -',
				'font-family' => 'arial',
				'font-style' => '',
				'font-size' => '18',	/* gives default */
			),
			'R' => array(
				'content' => 'Printed @ {DATE j-m-Y H:m}',
				'font-family' => 'monospace',
				'font-style' => '',
				'font-size' => '10',
			),
			'line' => 1,		/* 1 to include line below header/above footer */
		), 'E'	/* defines footer for Even Pages */
		);
		
				
		
		
		$mpdf->WriteHTML($html);
		
		$path = dirname(APPPATH).'/resource/download/fut';
		if(!is_dir($path)):
			mkdir($path);
		endif;
		
		
		/*$mpdf->Output('Boletas.pdf','I');*/
		$namePdf = "FUT_".date("Y-m-d")."_".substr(md5(uniqid().rand(0,100).date("Y-m-d")),rand(0,17),15);
		
		/*Creando el directorio*/
		$directory = $namePdf;
		$this->filesdirectory = $directory;
		$pathfiles = dirname(APPPATH).'/resource/download/fut/'.$directory;
		
		if(!is_dir($pathfiles)):
			mkdir($pathfiles);
		endif;
		
		
		$namePdf = $namePdf.".pdf";
		$filepdf =  dirname(APPPATH).'/resource/download/fut/'.$directory."/".$namePdf;
		
		
		
		
		$mpdf->Output($filepdf,'F');
		
		$files = $_FILES['afr-file'];
		
		if($files != '')
		{

			foreach($files["name"] as $key=>$item){
			
				if($files["error"][$key] == 0 and $files["size"][$key] > 0){
					$newname = cleanString($item);
					if(move_uploaded_file($files['tmp_name'][$key], $pathfiles."/".$newname)){
					}
				}
			}

		}
		
		
		
		$this->sendmail($pathfiles);
		
	}
	
	public function sendmail($pathfiles){
		

        /* ap capcha  */
		if(isset($_POST['g-recaptcha-response'])){
			$captcha=$_POST['g-recaptcha-response'];
		  }
		  if(!$captcha){
			echo '<h2>Por favor revise el formulario captcha.</h2>';
			exit;
		  }

		  $secretKey = "6LeElakZAAAAALMAA3YM3jGXsRFwWYPCXi24zMaS";
		  $ip = $_SERVER['REMOTE_ADDR'];
		  // post request to server
		  $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
		  $response = file_get_contents($url);
		  $responseKeys = json_decode($response,true);
		  // should return JSON with success as true

	if($responseKeys["success"]) {


                		
		/*variables sinad ws */
		  $urlws='http://rap.ugel03.gob.pe/wsAdjudicaciones/index.php/api/WsAdjudicaUgel03/verificaIdentificacion/';
          if(isset($_POST["txtdoc"])){ $txtdni = $this->input->post("txtdoc"); }
		  if(isset($_POST["txtfolio"])){ $Folios = $this->input->post("txtfolio"); }
		  if(isset($_POST["txtfoficio"])){ $oficio = $this->input->post("txtfoficio"); }

		if($_POST['cboTipoPersona']==1){
			$from_name = $this->input->post("txtnombre")." ".$this->input->post("txtapepat");
			$destinatarioNombre = "sr(s)".$this->input->post("txtapepat")." ".$this->input->post("txtapemat").", ".$this->input->post("txtnombre");
			$valueEstadoTipo = 1 ;
			
		}
		if($_POST['cboTipoPersona']==2){
			$from_name = $this->input->post("txtrazonsocialhid");
	 	    $destinatarioNombre = "Sres de razón social ".$this->input->post("txtrazonsocialhid");
			$valueEstadoTipo = 2 ;
		}

	   if($_POST['cboTipoPersona']==4){
	       $from_name = "I.E:";
		  //$from_name = "Codigo modular :".$this->input->post("txtie");
		  $destinatarioNombre = "Sres de la Institución Educativa";
		  //$destinatarioNombre = "Sres de la Institución Educativa con codigo modular".$this->input->post("txtie");
		  $valueEstadoTipo = 3 ;
		  $txtdni = $this->input->post("txtie");
	   }

	    $cbservicio = $this->input->post("cbservicio");

	    if($cbservicio != ''){

	    	$id_tramite = $this->tramite->Get_TipPedidoid($this->input->post("cbservicio"));
		
			if($id_tramite == 21 || $id_tramite == 22){
				$cbservicio_sub = $this->input->post("cbservicio_sub");
				if($cbservicio_sub != '')
				{
					$dataview["servicio"] = $this->tramite->Get_TipPedido($this->input->post("cbservicio"));
					$dataview["subservicio"] = $this->tramite->Get_TipPedido2($this->input->post("cbservicio_sub"));
					$id_tramite = $this->tramite->Get_TipPedidoid2($this->input->post("cbservicio_sub"));
					$cbservicio_sub2 = $this->input->post("cbservicio_sub2");
					if($cbservicio_sub2 != '' && $cbservicio != '22')
					{	
						$dataview["subservicio2"] = $this->tramite->Get_TipPedido2($this->input->post("cbservicio_sub2"));
						if($id_tramite == 25 || $id_tramite == 26){
							$id_tramite = $this->tramite->Get_TipPedidoid2($this->input->post("cbservicio_sub2"));
							$this->solicitud = $dataview["servicio"].' - '.$dataview["subservicio"].' - '.$dataview["subservicio2"];
						}

					}else if($cbservicio == '22'){
						$this->solicitud = $dataview["servicio"].' - '.$dataview["subservicio"];
					}else{
						echo '<h2>Por favor agregar sub - trámite.</h2>';
						exit;
					}
						
				}else{
					echo '<h2>Por favor agregar sub - trámite.</h2>';
					exit;
				}

			}	
	    }else{
					echo '<h2>Por favor agregar trámite.</h2>';
					exit;
		}
		

		/* ap set parametros segun requerimientos */
		
	
		if( $id_tramite == 16 ||  $id_tramite  == 22 ||  $id_tramite  == 21 ||  $id_tramite  == 25 ||  $id_tramite  == 26 ||  $id_tramite  == 42 ||  $id_tramite  == 43 ||  $id_tramite  == 44 ||  $id_tramite  == 45 ||  $id_tramite  == 50 || $id_tramite  == 51 || $id_tramite  == 52 || $id_tramite  == 60 || $id_tramite  == 61){
		
			$emailFut = "mesadepartesvirtual@ugel03.gob.pe";$emailFutpass = "Minedu2096.";$booleansinad = false;$CC_emailFut_ugel = "buzondecomunicaciones1@ugel03.gob.pe";
		//	$emailFut = "apena@ugel03.gob.pe";$emailFutpass = "Adidas2020";$booleansinad = false;$CC_emailFut_ugel = "alexr2408@gmail.com";
			
         }else{
			 $emailFut = "mesadepartesvirtual@ugel03.gob.pe";$emailFutpass = "Minedu2096."; $booleansinad = true;
			//$emailFut = "apena@ugel03.gob.pe";$emailFutpass = "Adidas2020";$booleansinad = true;
		}

		 /* REGISTRA SINAD  WS*/
				
          /*input de tipo persona natural*/
		  $Nombres_tp1 = $this->input->post("txtnombre");
		  $Apellidos_tp1 = $this->input->post("txtapepat")." ".$this->input->post("txtapemat");
		  $NumeroDocumento_tp1 = $this->input->post("txtdoc");
		  $Telefono1_tp1 = $this->input->post("txtphone");
		  $Telefono2_tp1 = "";
		  $Email_tp1 = $this->input->post("txtemail");
		  $CodigoUbigeo_tp1 = "150132";
		  $CodigoUbigeoDes_tp1 ="";
		  $PaisId_tp1 = "";
		  $Direccion_tp1 = $this->input->post("txtnomvia")." ref:".$this->input->post("txtreferencia");
	  
		/*Complemento persona juridica data */
		  $Descripcion_tp2= $this->input->post("txtrazonsocialhid");
		  $CodigoModular_tp2 = NULL ;
		  $TipoSectorId_tp2 ='13';
		  $TipoSectorDes_tp2 = "OTRAS INSTITUCIONES";
		  $TipoDocumento_tp2 = NULL ;

	   /*Complemento datos reg i.e*/
		  $personaJuridicaId = $this->input->post("txtie");

		$CC_emailFut_ugel ="";
		$part_url="rap.ugel03.gob.pe/wsAdjudicaciones/index.php/api/WsAdjudicaUgel03/saveExpedienteDocentet";

		if($booleansinad){
		    switch ($id_tramite) {
                /*Propuesta Contrato Docente case 1 */
				case 13:
					//$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
					//$CC_emailFut_ugel = "apena@ugel03.gob.pe";
					$CC_emailFut_ugel = "arh-eap@ugel03.gob.pe";/*CORREO COPIA AL EQUIPO DE PERSONAL */
					   $data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
					   $result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
				     if($result){
					    $PersonaId=$result["PersonaId"]; 
					     if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
					    $url_saveExp='http://'.$part_url.'1/';
				         $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
						 $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
						//var_dump($rest);die;
						 $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
				         $Pass = $rest["Pass"];
				     }
		    	break;
		    	/*2 Solicitud de receso temporal y/o definitivo de institución educativa privada case 2*/	   
				case 14:
					//$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
					//$CC_emailFut_ugel = "apena@ugel03.gob.pe";
				    $CC_emailFut_ugel = "asgese@ugel03.gob.pe";
					$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
					$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
				
					if($result){
					  $PersonaId=$result["PersonaId"]; 
					  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
					  $url_saveExp='http://'.$part_url.'2/';
					  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
					  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
					 
					  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
					  $Pass = $rest["Pass"];
				   }
		    	break;
		    	/*3 Solicitud de reconocimiento de promotores de institución educativa privada case 3*/	
				case 15:
				    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
					//$CC_emailFut_ugel = "apena@ugel03.gob.pe";
					$CC_emailFut_ugel = "asgese@ugel03.gob.pe";
					$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
					$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
				  if($result){
					  $PersonaId=$result["PersonaId"]; 
					  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
					  $url_saveExp='http://'.$part_url.'3/';
					  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
					  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
					  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
					  $Pass = $rest["Pass"];
				   }
				break;
				/* 4 Autorización a los comités de recursos propios y actividades productivas empresariales de las i.e. públicas, para abrir cuenta bancaria mancomunada y registrar firmas en el banco para manejar la cuenta bancaria mancomunada*/  
			   case 17:
			   		//$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
				    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
					$CC_emailFut_ugel = "adm-ec@ugel03.gob.pe";
					$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
					$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
				  if($result){
					  $PersonaId=$result["PersonaId"]; 
					  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
					  $url_saveExp='http://'.$part_url.'4/';
					  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
					  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
					  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
					  $Pass = $rest["Pass"];
				   }
				break;
				/*5  Presentación de los comites de Recursos propios y actividades productivas empresariales de las i.e. públicas, del libro caja y bancos */ 
				case 18:
				        //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
					    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
						$CC_emailFut_ugel = "adm-ec@ugel03.gob.pe";
						$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
						$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
					  if($result){
						  $PersonaId=$result["PersonaId"]; 
						  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
						  $url_saveExp='http://'.$part_url.'5/';
						  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
						  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
						  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
						  $Pass = $rest["Pass"];
					   }
					break;
                /* 6 	Presentación del plan anual de recursos propios y actividades productivas empresariales de las i.e. públicas*/
				case 19:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "adm-ec@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'6/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
					break;
                /* 7.	Reconocimiento de adeudos de ejercicios presupuestales anteriores (devengados */
                 case 20:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "adm-ec@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'7/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 8.1.1. Solicito licencia con goce de haber por incapacidad temporal: Si es otorgado por ESSALUD */
                 case 27:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "arh-eel@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'811/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 8.1.2. Solicito licencia con goce de haber por incapacidad temporal: Si es otorgado por MÉDICO PARTICULAR */
                 case 28:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "arh-eel@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'812/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 8.1.3. Solicito licencia por maternidad */
                 case 29:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "arh-eel@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'813/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 8.1.4. Solicito licencia con goce de haber por paternidad */
                 case 30:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "arh-eel@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'814/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 8.1.5. Solicito licencia por adopción */
                 case 31:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "arh-eel@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'815/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 8.1.6. Solicito asumir representación oficial del Estado Peruano */
                 case 32:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "arh-eel@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'816/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 8.1.7. Solicito licencia por citación expresa judicial, militar o policial */
                 case 33:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "arh-eel@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'817/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 8.1.8. Solicito licencia por siniestro */
                 case 34:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "arh-eel@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'818/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 8.1.10. Solicito licencia por fallecimiento de padres, cónyuges, hijos o hermanos (luto) */
                 case 35:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "arh-eel@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'8110/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 8.1.11. Representación sindical */
                 case 36:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "arh-eel@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'819/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 8.1.11. Solicito licencia por capacitación organizada y autorizada por el MINEDU */
                 case 37:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "arh-eel@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'8111/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 8.1.12. Solicito licencia por estudios de postgrado, especialización o perfeccionamiento, autorizado por el MINEDU y por los gobiernos regionales en el país o el extranjero */
                 case 38:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "arh-eel@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'8112/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 8.1.13. Solicito licencia por desempeño de cargo de consejero regional o regidor municipal */
                 case 39:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "arh-eel@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'8113/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 8.1.14. Solicito licencia por enfermedad grave o terminal de familiares directos (hijos, padres y cónyuge) */
                 case 40:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "arh-eel@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'8114/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 8.1.15. Solicito licencia por capacitación oficializada */
                 case 41:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "arh-eel@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'8115/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 8.2.1. Motivos particulares */
                 case 50:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "arh-eel@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'821/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 8.2.2. Capacitación no oficializada */
                 case 42:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "arh-eel@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'822/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 8.2.3. Enfermendad grave de los padres, conyuge, conviviente o hijos */
                 case 43:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "arh-eel@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'823/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 8.2.4. Desempeño de funciones públicas o cargos de confianza (solo para docentes y auxiliares de educación) */
                 case 44:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "arh-eel@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'824/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 8.2.5. Contrato cas en los programas presupuestales de logros de aprendizaje – pela (solo para docente) */
                 case 45:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "arh-eel@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'825/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 9.1. En caso de fallecimiento de madre, padre e hijos del servidor público */
                 case 46:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "arh-eel@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'91/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 9.2. En caso de fallecimiento del servidor público, solicitado por el conyuge */
                 case 47:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "arh-eel@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'92/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;


				/* 9.3. En caso de fallecimiento de servidor público, solicitado por hijos y hermanos */
                 case 48:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "arh-eel@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'93/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;


				/* 9.4. En caso de fallecimiento de su conyuge (reconocido judicialmente) */
                 case 49:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "arh-eel@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'94/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;


				/* 10. Solicitud de elaboración de constancia de pagos de haberes y descuentos (solo hasta marzo 1998) */
                 case 23:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "adm-ea@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'10/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 11. Solicitud de copia digital de resoluciones directorales */
                 case 24:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "adm-resol@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'11/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 15. Actualización de Datos de Cuenta en el Banco de la Nación */
                 case 53:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "adm-et@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'15/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 16. Aperturas de cuenta en el Banco de la Nación */
                 case 1:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "adm-et@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'16/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 17. Emisión de Constancia y/o Certificado de Trabajo */
                 case 5:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "arh@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'17/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 18. Elaboración de Informe Escalafonario */
                 case 3:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "arh-eel@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'18/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 19. Recepción de resoluciones de la ONP para notificación y archivo */
                 case 54:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "adm-etd@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'19/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 20. Solicitud de cese por fallecimiento */
                 case 55:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "arh-eel@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'20/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 21. Cese voluntario */
                 case 56:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "arh-eel@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'21/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 22. Soporte Tecnológico para los Equipos de Cómputo de las Instituciones Educativas */
                case 57:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "app-eti@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'22/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;
				
				/* 23. Tramite de Subsidio ante Essalud por COVID-19 */
                 case 58:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "arh-ebth@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'23/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 24. Subsidio por Maternidad */
                 case 59:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "arh-ebth@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'24/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 25. Constancia de Ubicación Geográfica */
                 case 8:
						    //$CC_emailFut_ugel = "aguzman@ugel03.gob.pe";
						    //$CC_emailFut_ugel = "apena@ugel03.gob.pe";
							$CC_emailFut_ugel = "app@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'25/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 28. Atención de Requerimiento de expedientes solicitados por los juzgados de trabajo */
                 case 62:
							$CC_emailFut_ugel = "adm-etd@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'28/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;

				/* 29. Autorización de Funcionamiento y Registro de Instituciones Educativas Privadas */
                 case 63:
							$CC_emailFut_ugel = "asgese@ugel03.gob.pe";
							$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
							$result_ = llamadoApi('GET', $urlws, $data ); $result = json_decode(json_encode($result_), true);
						  if($result){
							  $PersonaId=$result["PersonaId"]; 
							  if(is_null($result["TipoDocumento"])){$TipoSolicitante='NULL';}else{$TipoSolicitante=$result["TipoDocumento"];}
							  $url_saveExp='http://'.$part_url.'29/';
							  $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
							  $rest_ = llamadoApi('GET', $url_saveExp, $dataSave ); $rest = json_decode(json_encode($rest_), true);
							  $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
							  $Pass = $rest["Pass"];
						   }
						break;
		    }
	   }


				

			 // $valueEstadoTipo 
			 /*
                if($booleansinad){

					switch ($id_tramite) {

						case 13:
						    	
				            	$data = array("id" => "$txtdni","Nombres_tp1"=>"$Nombres_tp1","Apellidos_tp1"=>"$Apellidos_tp1","NumeroDocumento_tp1"=>"$NumeroDocumento_tp1" ,"Telefono1_tp1"=>"$Telefono1_tp1","Telefono2_tp1"=>"$Telefono2_tp1" ,"Email_tp1"=>"$Email_tp1","CodigoUbigeo_tp1"=>"$CodigoUbigeo_tp1","CodigoUbigeoDes_tp1"=>"$CodigoUbigeoDes_tp1","PaisId_tp1"=>"$PaisId_tp1","Direccion_tp1"=>"$Direccion_tp1","Descripcion_tp2"=>"$Descripcion_tp2","CodigoModular_tp2"=>"$CodigoModular_tp2","TipoSectorId_tp2"=>"$TipoSectorId_tp2","TipoSectorDes_tp2"=>"$TipoSectorDes_tp2","TipoDocumento_tp2"=>"$TipoDocumento_tp2","valueEstadoTipo"=>"$valueEstadoTipo","personaJuridicaId"=>"$personaJuridicaId"); 
				                 $method='GET';
				            	$result_ = llamadoApi($method, $urlws, $data );
				            	$result = json_decode(json_encode($result_), true);
			
				               if($result){
			
								$PersonaId=$result["PersonaId"]; 
								if(is_null($result["TipoDocumento"])){
									$TipoSolicitante='NULL';
								}else{
									$TipoSolicitante=$result["TipoDocumento"];
								}
						
				            	$url_saveExp='http://rap.ugel03.gob.pe/wsAdjudicaciones/index.php/api/WsAdjudicaUgel03/saveExpedienteDocentet1/';
				            	
				            	 $method='GET';
				            	 $dataSave = array("PersonaId" => "$PersonaId","folio" => "$Folios","TipoSolicitante"=>"$TipoSolicitante","oficio"=>"$oficio"); 
					 
								 $rest_ = llamadoApi($method, $url_saveExp, $dataSave );
								 $rest = json_decode(json_encode($rest_), true);
				            	 $NumeroExp = 'MPT-FUT'.date('Y').'-EXT-'.$rest["NumeroExp"];
				            	 $Pass = $rest["Pass"];
		            
				               }
            
							break;
						case 14:
							echo "en progress";
							break;
						case 15:
							echo "en progress";
							break;
					}	

				}
				*/
				
				/* fin activa registro sinad*/ 

                if( $id_tramite == 16  || $id_tramite  == 22 ||  $id_tramite  == 21 ||  $id_tramite  == 25 ||  $id_tramite  == 26 || $id_tramite  == 42 ||  $id_tramite  == 43 ||  $id_tramite  == 44 ||  $id_tramite  == 45 ||  $id_tramite  == 50|| $id_tramite  == 51 || $id_tramite  == 52 || $id_tramite  == 60 || $id_tramite  == 61){
					$emailFut = "mesadepartesvirtual@ugel03.gob.pe";$emailFutpass = "Minedu2096.";$booleansinad = false;$CC_emailFut_ugel = "buzondecomunicaciones1@ugel03.gob.pe";
				//	$emailFut = "apena@ugel03.gob.pe";$emailFutpass = "Adidas2020";$booleansinad = false;$CC_emailFut_ugel = "alexr2408@gmail.com";
					
				 }else{
					 $emailFut = "mesadepartesvirtual@ugel03.gob.pe";$emailFutpass = "Minedu2096."; $booleansinad = true;
					//$emailFut = "apena@ugel03.gob.pe";$emailFutpass = "Adidas2020";$booleansinad = true;
				}


            /*****************************************************************/
			      $body_email_especialista ='';
			      if($booleansinad){
					  $body_email_especialista = 'Estimado especialista :<br>
					  La plataforma de Mesa de partes virtual a registrado un solicitud para el tramite de '.$this->solicitud.'
					  generando un  N° EXP: '.$NumeroExp.' <br>';
				  }else{
					  $body_email_especialista = 'Estimado especialista :<br>
					La plataforma de Mesa de partes virtual a registrado un solicitud para el tramite de '.$this->solicitud.'<br>';

				  }

	               $from_mail = trim($this->input->post("txtemail"));
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
	               $mail->Username = $emailFut;
	               $mail->Password = $emailFutpass;
		           $mail->From = $from_mail;
		           $mail->FromName = $from_name;
				  /* $mail->AddAddress($emailFut,"Generico");*/
				   $mail->AddAddress($CC_emailFut_ugel,"Generico");
				//   $mail->addBCC('apena@ugel03.gob.pe',"Generico");
	               $mail->addCC("noreplympv@ugel03.gob.pe","Generico");
	            // $mail->AddCC("apena@ugel03.gob.pe","Generico");
            	// $mail->AddCC("aguzman@ugel03.gob.pe","Generico");

           
		           $mail->Subject = 'Mesa de Partes Virtual Tramite: '.$this->solicitud;
				   $mail->Body =$body_email_especialista;

		           $mail->IsHTML(true);
		           // Activo condificacción utf-8
		           $mail->CharSet = 'UTF-8';
		           $directorio = opendir($pathfiles); //ruta actual
		           while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
		           {
		           	if (!is_dir($archivo))//verificamos si es o no un directorio
		           	{
		           		$mail->AddAttachment($pathfiles."/".$archivo);
		           	}
		           }
		           // Envio mail
		           if(!$mail->Send()) {
                       $data["message"] = "Error en el envío: " . $mail->ErrorInfo;
		           	   $error = 1;
                   } else {
                       $data["message"] = "¡Su Solicitud fue enviado correctamente!";
		               $error = 0;
                   }
		           
		           $data = array(
		           		"msg"=>$data["message"],
		           		"error" => $error
		           		
		           	);
		           
		           $this->session->set_userdata($data);
		           $datasave["id_tippedido"] = $this->input->post("cbservicio");
		           $datasave["ape_pat"] = $this->input->post("txtapepat");
		           $datasave["ape_mat"] = $this->input->post("txtapemat");
		           $datasave["Nombre"] = $this->input->post("txtnombre");
		           $datasave["razon_social"] = $this->input->post("txtrazonsocialhid");
		           $datasave["documento"] = $this->input->post("txtdoc");
		           $datasave["cargo"] = $this->input->post("txtcargo");
		           $datasave["telefono"] = $this->input->post("txtphone");
		           $datasave["correo"] = $this->input->post("txtemail");		
		           $datasave["archivo"] = $this->filesdirectory;
				   $datasave["creado"] = date("Y-m-d H:i:s");
				   $datasave["tipo_doc"] = $_POST['cboTipoPersona'] ;
				   $datasave["oficio"] = $_POST['txtfoficio'] ;
				   $datasave["folio"] = $_POST['txtfolio'] ;

				 //  $datasave["asunto"] = $this->input->post("txtfundpedido");
				   if ($_POST['txtfundpedido']){
					   $datasave["asunto"]=$this->input->post("txtfundpedido");
			    	}else{
					   $datasave["asunto"]='';
					};
					
				   $this->tramite->save_pedido($datasave);
		   

				   /**********************Envio de confirmacion**************************/
				   $body_email_solicitante ='';
			      if($booleansinad){
					  $body_email_solicitante= '<br> Estimado <br> '.$destinatarioNombre.'<br>
					  En buena hora su solicitud estará siendo procesada por un especialista,usted recibira la respuesta de la solicitud por este medio.
   
					   Tambien estamos brindando los accesos para hacer seguimiento al tramite  habiéndose generado 
					   el:<br> N° EXP: '.$NumeroExp.' <br> Contraseña: '.$Pass.'<br>  <a href="http://sinad.ugel03.gob.pe/Sinad/ConsultaExterna/loginExterno.aspx">Click aqui para consultar el Expediente</a>.<br>
		               <b> BUZÓN DESATENDIDO, No se responderán a los correos electrónicos enviados a esta dirección.</b><br>
						<br>Telef : 4273210 / 4262627 / 4261562<br> Atención de 8:30am a 4:30pm<br> UGEL 03 - Av. Iquitos 918, La Victoria, La Victoria';
				  }else{
					$body_email_solicitante = '<br> Estimado <br> '.$destinatarioNombre.'<br>
					En buena hora su solicitud estará siendo procesada por un especialista,usted recibira la respuesta de la solicitud por este medio.
					 <br>
					 <b> BUZÓN DESATENDIDO, No se responderán a los correos electrónicos enviados a esta dirección.</b><br>
					  <br>Telef : 4273210 / 4262627 / 4261562<br> Atención de 8:30am a 4:30pm<br> UGEL 03 - Av. Iquitos 918, La Victoria, La Victoria';

				  }


		           $mail_r='';
      	           $from_mail_reenvio = $emailFut;
		           $from_name_reenvio = 'Mesa de partes Virtual UGEL03';
		           $mail_r = new PHPMailer();
		           $mail_r->isSMTP();
		           $mail_r->SMTPOptions = array(
		           'ssl' => array(
		           'verify_peer' => false,
		           'verify_peer_name' => false,
		           'allow_self_signed' => true
		           	)
		           );
	           
	               $mail_r->Host = "mail.ugel03.gob.pe";
	               $mail_r->Port = 25;
	               $mail_r->SMTPSecure = 'tls';
	               $mail_r->SMTPAuth = false;
	               $mail_r->Username = $emailFut;
	               $mail_r->Password = $emailFutpass;
           
		           $mail_r->From = $from_mail_reenvio;
		           $mail_r->FromName = $from_name_reenvio;
		           $mail_r->AddAddress(trim($this->input->post("txtemail")),"Generico");
		           $mail_r->Subject = 'Mesa de partes Virtual : Tramite '.$this->solicitud;
           
				   $mail_r->Body = $body_email_solicitante ;
		           
		           $mail_r->IsHTML(true);
		           $mail_r->CharSet = 'UTF-8';
		           
		           // Envio mail
		           if(!$mail_r->Send()) {
                       $data["message"] = "Error en el envío: " . $mail_r->ErrorInfo;
		               $error = 1;
                   } else {
                       $data["message"] = "¡Su Solicitud fue enviado correctamente!";
		               $error = 0;
                   }
		           
                   redirect("tramite");
		

		  } else {
				$data["message"] = "Posiblemente seas un bot, intente de nuevo";
			   $error = 1;
		  }

	 
		
		
	}
	
	public function requisitos()
	{
		
		$requisitos = $this->tramite->Get_Requisito($this->input->post("id"));
		/*writer($requisitos);die;
		$response = "";
		foreach($requisitos as $item){
			$response = $response."<li>
										<label>". $item->descripcion ." :</label>
                                        <input type='file' name='afr-file[]' class='required' >
									</li>";
		}*/
		
		echo(json_encode($requisitos));
		
	}
	public function formato(){
		$dataview["solicitud"] = $this->tramite->Get_AllTipPedido();
		//writer($dataview["solicitud"]);die;
		$this->load->view('tramite/formato-silencioadm',$dataview);
		
	}

	public function institucion_educativa()
    {
        $ie = $this->tramite->getie();
        $like = $_POST['searchTerm'];
        $result = array_filter($ie, function ($item) use ($like) {
            if (stripos($item['Descripcion'], $like) !== false) {
                return true;
            }
            return false;
        });
        echo json_encode($result, JSON_PRETTY_PRINT);
    }

     public function tipo_pedido()
    {
        $pedido = $this->tramite->gettramite();
        $like = $_POST['searchTerm'];
        $result = array_filter($pedido, function ($item) use ($like) {
            if (stripos($item['nombre'], $like) !== false) {
                return true;
            }
            return false;
        });
        echo json_encode($result, JSON_PRETTY_PRINT);
    }
}
