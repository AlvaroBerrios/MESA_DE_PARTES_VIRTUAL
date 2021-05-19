<?php
class Model_adjudicaciones extends CI_Model
{
	
	private $db_sinad;
	
	
    function __construct()
    {
		//$this->db_sinad = $this->load->database('db_sinad', TRUE);
		
        parent::__construct();
    }
	
	
	/********** RECLAMOS ************/
	
	function save_registroUsuario($data){
		$this->db->insert("tb_usuario",$data);
		$id = $this->db->insert_id();
		if($id){
			return $id;
		}
		else{
			return false;
		}
	}
	function save_Consultabuzon($data){
		$this->db->insert("tb_buzonConsultas",$data);
		$id = $this->db->insert_id();
		if($id){
			
			return $id;
		}
		else{
			return false;
		}
	}
	
	function save_Reclamo($data){
		$this->db->insert("test",$data);
		$id = $this->db->insert_id();
		if($id){
			
			return $id;
		}
		else{
			return false;
		}
	}

 function update_datosPersonales($data){
		$id = $this->db->update('tb_usuario', $data, array('nroDoc'=>$data['nroDoc']));
		if($id){
			return true;
		}
		else{
			return false;
		}
	
	}


        function update_reclamo($data){
		$id = $this->db->update('test', $data, array('dato1'=>$data['dato1']));
		if($id){
			return true;
		}
		else{
			return false;
		}
	
	}


	function getInfoUsuario($id)
    {
		
		$sql = "SELECT * FROM tb_ussuario WHERE id='".$id."' AND flg=1";
		
		$query = $this->db->query($sql);
		if($query->result()){
			return $query->row_array();
				
		}
		else
			return false;
        
    }
	
	
	
	
	function Get_user($id,$pass)
    {
		
		$sql = "SELECT * FROM tb_postulante WHERE email='".$id."' AND pass='". $pass."' AND flg=1";
		
		$query = $this->db->query($sql);
		if($query->result()){
			return $query->row_array();
				
		}
		else
			return false;
        
    } 
	
	
	function buscaDni($id){

        $sql = "SELECT * FROM tb_usuario WHERE nroDoc='".$id."' AND flg=1";
		
		$query = $this->db->query($sql);
		if($query->result()){
				return $query->row_array();
				
		}
		else
			return false;

	}
	
    function buscaie($codmodular){
		
        $sql = "SELECT nombre as num FROM ie WHERE id_modular='".$codmodular."'  AND estado=1";
		
		$query = $this->db->query($sql);
		
		if($query->result()){
		
			return $query->row_array();
			//return true;	
				
		}else{
		
		    return false;
		  //return false;
		  
		}
			

	}

	function buscaTelefono($email,$dni){
		
        $sql = "SELECT celular as num FROM tb_usuario WHERE email='".$email."' AND nroDoc='".$dni."'  AND flg=1";
		
		$query = $this->db->query($sql);
		
		if($query->result()){
		
			return $query->row_array();
			//return true;	
				
		}else{
		
		    return false;
		  //return false;
		  
		}
			

	}
	function buscaEmail($email){
		
        $sql = "SELECT count(*) as num FROM tb_usuario WHERE email='".$email."' AND flg=1";
		
		$query = $this->db->query($sql);
		
		if($query->result()){
		
			return $query->row_array();
			//return true;	
				
		}else{
		
		    return false;
		  //return false;
		  
		}
			

	}
	
	
	/*******************************/
	
	function getCount($params = ''){
		$params['count'] = true;
		return $this->getAll($params);
	}
	function getAll($params = ''){

		$select = $where = $limit = $order = '';
		$where = " WHERE ";//"WHERE c.cupon_id=tc.cupon_id AND tc.id_categoria=ct.id_categoria";
		#$where = "WHERE (d.State=1 OR d.State=-1) AND a.IdDisco=d.IdDisco";
		//writer($params['idUser']); exit;
		if (is_array($params)) {
			if (isset($params['start'],$params['limit']))
				$limit = "LIMIT " . $params['start'] . ", " . $params['limit'];
			if (isset($params['orderBy'],$params['sentido']))
				$order = "ORDER BY " . $params['orderBy'] . " " . $params['sentido'];
			if (isset($params['status']))
				$where .= " (b.status = '".$params['status']."')";
			
			if(isset($params['search2']))
				$where .= " AND b.idperiodo = ".$params['search2'];
			;
			if(isset($params['search']))
				$where .= " AND (CONCAT(b.nombre) LIKE('%".$params['search']."%') OR b.dni LIKE('".$params['search']."%'))";
			;
			
				
		}
		
		
		
		if (isset($params['count'])){
			$select = "SELECT COUNT(*) AS total";
		}
		else{
			
			$select = "SELECT b.* ";
			//$select = "SELECT c.*, ct.categoria_name ";
		}

		$sql = "$select
				FROM boleta b    
				$where
				$order
				$limit";
		$query = $this->db->query($sql);
		
		if (isset($params['count'])) {
			$result = $query -> row();
			return $result -> total;
		}
		else
		if ( $query -> result() )
			return $query -> result();
		else
			return false;
			
			
	}
    //obtenemos las localidades dependiendo de la provincia escogida
    function Get_TipPedido($buscar)
    {
        $sql = "SELECT * FROM tb_tippedido WHERE id_tippedido=$buscar AND estado=1";
		$query = $this->db->query($sql);
		if($query->result()){
				return $query->row()->nombre;
				
		}
		else
			return false;
        
    } 
	function Get_Requisito($buscar)
    {
        $sql = "SELECT * FROM tb_requisitos WHERE id_tippedido=$buscar AND estado=1";
		$query = $this->db->query($sql);
		if($query->result()){
			$data["requisitos"] = $query->result();
			$data["costo"] = $this->Get_Costo($buscar);
				return $data;
				
		}
		else
			return false;
        
    }
	function Get_Costo($id)
    {
        $sql = "SELECT * FROM tb_costopedido WHERE id_tippedido=$id AND estado=1";
		$query = $this->db->query($sql);
		if($query->result()){
				return $query->result();
				
		}
		else
			return false;
        
    }       
	function Get_AllTipPedido(){
		
		$sql = "SELECT * FROM tb_tippedido WHERE estado=1";
		$query = $this->db->query($sql);
		if($query->result()){
				return $query->result_array();
				
		}
		else
			return false;
	}
	function save_pedido($data){
		$this->db->insert("tb_solicitud",$data);
		$id = $this->db->insert_id();
		if($id){
			
			return $id;
		}
		else{
			return false;
		}
	}
	/**********************************************************************/
	
	function testSinad(){
		
		
		$sql = "SELECT TOP 1 * FROM [db_sinad].[dbo].[t_Expediente]";
		
		$query = $this->db_sinad->query($sql);
	
		if($query->result()){
			return $query->row();
		}
		else{
			return false;
		}
		
	}
	function Get_userChangePass($data = array())
    {
		
		$sql = "SELECT * FROM tb_usuario WHERE nroDoc='".$data['dni']."' and email='".$data['email']."' and pass='".$data['passaActual']."' and flg='1'";
	
		$query = $this->db->query($sql);
		if($query->result()){
				return $query->row_array();
				
		}
		else
			return false;
		
		
        
	} 
	
	function Change_PasswordUser($data){
		$id = $this->db->update('tb_usuario', $data, array('nroDoc' => $data['nroDoc'],'email' => $data['email']));
		if($id){
			return true;
		}
		else{
			return false;
		}
	

	}
   function getConsultaBuzon($dni){

	 $sql = "SELECT * FROM tb_buzonConsultas WHERE  idUsuario='".$dni."' and estado='1'";
	
	$query = $this->db->query($sql);
	$result = $query->result();
	
	if($result){
		return $result;

	}else{
		return false;
	}
   }

	
	function numeroRegistro(){
		
		$sql = "SELECT count(*) as 'num' FROM tb_buzonConsultas where flg='1'";
		$query = $this->db->query($sql);
	    if($query->result()){
			return $query->row();
		}
		 else{
			return false;
		}
		
	}
	
	
	
	function validaEmail($email){
		 
		 $sql = "SELECT*FROM  tb_usuario where email='$email' and flg='1'";
		$query = $this->db->query($sql);
	    if($query->result()){
			return $query->row();
		}
		 else{
			return false;
		}
		
	}
	
	
	function verificaNroDocumento($nroDocumento){
		 
		$sql = "SELECT*FROM  t_Persona where NumeroDocumento='$nroDocumento' and Estado='1'";
		$query = $this->db_sinad->query($sql);
	    if($query->result()){
			return $query->row();
		}
		 else{
			return false;
		}
		
	}
	
	function saveDataPersonal($Nombres,$Apellidos,$TipoDocumento,$NumeroDocumento,$Telefono1,$Telefono2,$Email,$CodigoUbigeo,$CodigoUbigeoDes,$PaisId,$Direccion,$UsuarioCreador,$FechaCreacion){
	
		$sql = "EXEC [dbo].[ADM_INS_PersonaNaturalInsertarU] '$Nombres','$Apellidos',$TipoDocumento,'$NumeroDocumento','$Telefono1','$Telefono2','$Email',NULL,'$CodigoUbigeoDes','$PaisId','$Direccion','$UsuarioCreador','$FechaCreacion'";
	
		$query = $this->db_sinad->query($sql);
		
		if($query->result()){
			return $query->row();
		}
		else{
		
			return false;
		}
	}
	
	
	function saveDataPersonalJuridica($Descripcion,$CodigoModular,$TipoSectorId,$TipoSectorDes,$TipoDocumento, $NumeroDocumento, $Telefono1, $Telefono2, $Email, $CodigoUbigeo,$CodigoUbigeoDes ,$PaisId ,$Direccion,$UsuarioCreador,$FechaCreacion){
	
		$sql = "EXEC [dbo].[ADM_INS_PersonaJuridicaInsertarU] '$Descripcion','$CodigoModular',$TipoSectorId,'$TipoSectorDes',$TipoDocumento, '$NumeroDocumento', '$Telefono1', '$Telefono2', '$Email',NULL,'$CodigoUbigeoDes' ,$PaisId ,'$Direccion','$UsuarioCreador','$FechaCreacion'";
	
		$query = $this->db_sinad->query($sql);
		
		if($query->result()){
			return $query->row();
		}
		else{
		
			return false;
		}
	}
	
	function saveExpediente($SedeId,$Anio,$Numero,$NumeroExpediente,$TipoExpediente,$TupaTramiteId ,$SedeTramiteId,$TipoRegistro ,$Prioridad,$RecepcionSinConformidad,
		 $Subsanar,$CantidadFolios,$TipoDocumentoTramite,$NumeroDocumentoTramite,$Cerrado,$FechaCerrado ,$SolicitanteId ,$TipoSolicitante ,$Confidencial ,
		 $FechaRegistroParcial,$FechaRegistroTotal,$FechaRegistroExpediente,$UsuarioCreador,$FechaCreacion,$WorkflowInstanceId,$Anulado,$SolicitudAccesoId,$CanalAtencionId){
		 
		 $sql = "EXEC [dbo].[GEX_INS_ExpedienteSolicitudInsertarU3] $SedeId,$Anio,$Numero,$NumeroExpediente,$TipoExpediente,$TupaTramiteId ,$SedeTramiteId,$TipoRegistro ,$Prioridad,$RecepcionSinConformidad,
		 $Subsanar,$CantidadFolios,$TipoDocumentoTramite,$NumeroDocumentoTramite,$Cerrado,$FechaCerrado ,$SolicitanteId ,$TipoSolicitante ,$Confidencial ,
		 $FechaRegistroParcial,$FechaRegistroTotal,$FechaRegistroExpediente,$UsuarioCreador,$FechaCreacion,$WorkflowInstanceId,$Anulado,$SolicitudAccesoId,$CanalAtencionId";
	
		$query = $this->db_sinad->query($sql);
		
		if($query->result()){
			return $query->row();
		}
		else{
		
			return false;
		}
		 
	 }
	
	
	function saveEstadoExpediente($SedeId,$Anio,$Numero,$EstadoId,$FechaInicio,$Accion){
		
		$sql = "EXEC [dbo].[GEX_INS_ExpedienteEstadoInsertarUg3l] $SedeId,$Anio,$Numero,$EstadoId,'$FechaInicio',$Accion";
	
		$query = $this->db_sinad->query($sql);
		
		if($query->result()){
			return $query->row();
		}
		else{
		
			return false;
		}
	}
	
	
	function saveEtapaExpediente($UltimoEstadoId,$TipoAccion ,$Accion ,$AsuntoAccion,$Prioridad,$OficinaRemitenteId,$OficinaActualId,$CodigoEtapa,$RequiereRespuesta,$SolicitaRespuesta,                
				$PadreEtapaExpedienteId,$TipoDocumentoRespuesta,$NumeroDocumentoRespuesta,$AsuntoRespuesta,$Observaciones,$Devolucion,$Anulada,$AccionEtapa,$SedeId,                
				$Anio,$Numero,$UsuarioCreador,$FechaCreacion,$WorkflowInstanceId,$DescripcionAcciones,$ObservacionesRuta,
				$TupaTramiteEtapaId,$CantidadFoliosEtapa,$PadreEtapaReingresoId){
		
	    $sql = "EXEC [dbo].[GEX_INS_EtapaExpedienteInsertarUg3l] $UltimoEstadoId,$TipoAccion ,$Accion ,$AsuntoAccion,$Prioridad,$OficinaRemitenteId,$OficinaActualId,$CodigoEtapa,$RequiereRespuesta,$SolicitaRespuesta,                
				$PadreEtapaExpedienteId,$TipoDocumentoRespuesta,$NumeroDocumentoRespuesta,$AsuntoRespuesta,$Observaciones,$Devolucion,$Anulada,$AccionEtapa,$SedeId,                
				$Anio,$Numero,$UsuarioCreador,$FechaCreacion,'00000000-0000-0000-0000-000000000000',$DescripcionAcciones,NULL,
				$TupaTramiteEtapaId,$CantidadFoliosEtapa,$PadreEtapaReingresoId";
	
		$query = $this->db_sinad->query($sql);
		
		if($query->result()){
			return $query->result_array();
		}
		else{
		
			return false;
		}
	}
	
	
	
	function saveEtapaEstadoExpediente($EtapaExpedienteId,$EstadoId,$WorkflowInstanceId,$FechaInicio){
		
		$sql = "EXEC [dbo].[GEX_INS_EtapaEstadoInsertarUg3l] $EtapaExpedienteId,$EstadoId,'$WorkflowInstanceId','$FechaInicio'";
	
		$query = $this->db_sinad->query($sql);
		
		if($query->result()){
			return $query->row();
		}
		else{
		
			return false;
		}
	}
	
	
	function saveProgramacionExpediente($SedeId ,$Anio ,$Numero,$TipoDestino,$TipoUbicacion,$Courier,$TipoAccion,$Accion,$AsuntoAccion,$Prioridad,$Observaciones,$OficinaDestinoId,$PersonaDestinoId,  
              $TipoPersonaDestino,$EtapaExpedienteId,$Devolucion , $TipoDevolucion ,$MotivoDevolucion ,$FechaDevolucion ,$RutaProcesada ,$UsuarioCreador,$FechaCreacion ,  
              $WorkflowInstanceId ,$RepresentanteDestinoId ,$TipoDocumentoRespuesta ,$NumeroDocumentoRespuesta ,$AsuntoRespuesta , $DetalleExpedienteId,$AccionesRuta ,  
              $DescripcionAcciones ,$SolicitaRespuestaCongreso){
		
		      $sql = "EXEC [dbo].[GEX_INS_ProgramacionRutaInsertar] $SedeId ,$Anio ,$Numero,$TipoDestino,$TipoUbicacion,$Courier,$TipoAccion,$Accion,$AsuntoAccion,$Prioridad,$Observaciones,$OficinaDestinoId,$PersonaDestinoId,  
              $TipoPersonaDestino,$EtapaExpedienteId,$Devolucion , $TipoDevolucion ,$MotivoDevolucion ,$FechaDevolucion ,$RutaProcesada ,$UsuarioCreador,$FechaCreacion ,  
              $WorkflowInstanceId ,$RepresentanteDestinoId ,$TipoDocumentoRespuesta ,$NumeroDocumentoRespuesta ,$AsuntoRespuesta , $DetalleExpedienteId,$AccionesRuta ,  
              $DescripcionAcciones ,$SolicitaRespuestaCongreso";
	
		 $query = $this->db_sinad->query($sql);
		
		if($query->result()){
			return $query->row();
		}
		else{
		
			return false;
		}
	}
	
	function saveAsignacionExpediente($NumeroExpediente,$NumeroHojaEnvio,$Asunto ,$Prioridad ,$GeneraRespuesta,$EspecialistaPrincipal,$EtapaExpedienteId,
				  $Accion,$PersonaNaturalId ,$Indicaciones ,$Estado,$FechaBaja,$Observaciones ,$UsuarioCreador,$FechaCreacion ,$Acciones){
					  
			 $sql = "EXEC [dbo].[GEX_INS_AsignacionEspecialistaInsertar]  $NumeroExpediente,$NumeroHojaEnvio,$Asunto ,$Prioridad ,$GeneraRespuesta,$EspecialistaPrincipal,$EtapaExpedienteId,
				  $Accion,$PersonaNaturalId ,$Indicaciones ,$Estado,$FechaBaja,$Observaciones ,$UsuarioCreador,$FechaCreacion ,$Acciones";
	
		$query = $this->db_sinad->query($sql);
		
		if($query->result()){
			return $query->row();
		}
		else{
		
			return false;
		}	


				
    }
	
	function getTicket($SedeId,$Anio,$Numero){
		
		 $sql = "EXEC [dbo].[REP_SEL_TicketTramite] $SedeId,$Anio,$Numero";
	
		 $query = $this->db_sinad->query($sql);
		
		if($query->result()){
			return $query->row();
		}
		else{
		
			return false;
		}
	}
	
	
	
	
	function save_solicitudTransparencia($data){
		$this->db->insert("tb_solicitudtransparencia",$data);
		$id = $this->db->insert_id();
		if($id){
			
			return $id;
		}
		else{
			return false;
		}
	}
	
	
	
	function save_detallePedido($data){
		$this->db->insert("tb_pedido_detalle",$data);
		$id = $this->db->insert_id();
		if($id){
			
			return $id;
		}
		else{
			return false;
		}
	}
	
	
	function update_periodo($data){
		$id = $this->db->update('periodo', $data, array('idperiodo' => $data['idperiodo']));
		if($id){
			return true;
		}
		else{
			return false;
		}
	

	}
	function Obt_Periodo(){
		$sql = "SELECT * FROM periodo WHERE status=1";
		$query = $this->db->query($sql);
		if($query->result()){
				return $query->result();
				
		}
		else
			return false;
	}
	
	
	
	function delete($data){
		
		$id = $this->db->update('boleta', $data, array('idboleta' => $data['idboleta']));
		if($id){
			
		
			return true;
		}
		else{
			return false;
		}
		
	}
	/***************** ap_051218******************************/
	
	public  function getvia() {
        $data = array();
        $query = $this->db->get('tb_via');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row){
                    $data[] = $row;
				//	var_dump($data);
                }
        }
        $query->free_result();
        return $data;
    }
	
	public  function getie() {
        $data = array();
       // $this->db->distinct();
       //$this->db->select('nombre');
       $this->db->order_by('nombre','asc');
       $this->db->where('estado','1');
        $query = $this->db->get('ie');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row){
                    $data[] = $row;
				//	var_dump($data);
                }
        }
        $query->free_result();
        return $data;
    }
	public  function getzona() {
        $data = array();
        $query = $this->db->get('tb_zona');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row){
                    $data[] = $row;
				//	var_dump($data);
                }
        }
        $query->free_result();
        return $data;
    }
	
	public  function getdepartamento() {
        $data = array();
        $query = $this->db->get('ubdepartamento');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row){
                    $data[] = $row;
                }
        }
        $query->free_result();
        return $data;
    }
	
	
	/*
	public function getarea(){
		$data = array();
        $query = $this->db->get('db_area');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row){
                    $data[] = $row;
                }
        }
        $query->free_result();
        return $data;
		
	}
	*/
	
	public function gettipopersona(){
		$data = array();
		$this->db->where('estado','1');
        $query = $this->db->get('tb_tipopersona');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row){
                    $data[] = $row;
                }
        }
        $query->free_result();
        return $data;
		
	}
	
	public function gettipopersonaGet($id){
		$data = array();
		$this->db->where('estado','1');
		$this->db->where('id',$id);
        $query = $this->db->get('tb_tipopersona');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row){
                    $data[] = $row;
                }
        }
        $query->free_result();
        return $data;
		
	}
	
	
	public function getTipoDocCbo($id){
		$data = array();
		$this->db->where('estado','1');
		$this->db->where('id',$id);
        $query = $this->db->get('tb_tipodocumento');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row){
                    $data[] = $row;
                }
        }
        $query->free_result();
        return $data;
		
	}
	
	public function getTipoDoc($tipodoc){
		
	
		$this->db->where('idTipo',$tipodoc);
        $this->db->order_by('descripcion','asc');
        $provincias = $this->db->get('tb_tipodocumento');
        if($provincias->num_rows()>0)
        {
			return $provincias->result();
        }
		
		
	}
	
	public function GetcboTipoPersona($id){
		$sql = " SELECT descripcion FROM tb_tipopersona WHERE  id='$id' and estado=1";
		
		$query = $this->db->query($sql);
	
		if($query->result()){
			return $query->row();
		}
		else{
			return false;
		}
		
	}
	
	
	public function GetcboTipoDoc($id){
		$sql = "SELECT descripcion FROM tb_tipodocumento WHERE  id='$id' and estado=1";
		
		$query = $this->db->query($sql);
	
		if($query->result()){
			return $query->row();
		}
		else{
			return false;
		}
		
	}
	
	public function GetcboVia($id){
		$sql = "SELECT descripcion FROM tb_via WHERE  id='$id' and estado=1";
		
		$query = $this->db->query($sql);
	
		if($query->result()){
			return $query->row();
		}
		else{
			return false;
		}
		
	}
	
	public function GetcboZona($id){
		$sql = "SELECT descripcion FROM tb_zona WHERE  id='$id' and estado=1";
		
		$query = $this->db->query($sql);
	
		if($query->result()){
			return $query->row();
		}
		else{
			return false;
		}
		
	}
	
	/*
	public function Getcboarea($id){
		$sql = "SELECT descripcion FROM db_area WHERE  id_area='$id' and estado=1";
		
		$query = $this->db->query($sql);
	
		if($query->result()){
			return $query->row();
		}
		else{
			return false;
		}
		
	}
	*/
	
	public function Getcboequipo($id){
		$sql = "SELECT descripcion FROM db_equipo WHERE id_equipo='$id' and estado=1";
		
		$query = $this->db->query($sql);
	
		if($query->result()){
			return $query->row();
		}
		else{
			return false;
		}
		
	}
	
	
	public function GetdescripcioUbigeo($departamento,$provincia,$distrito){
		
		//$sql = "SELECT descripcion FROM db_equipo WHERE id_equipo='$id' and estado=1";
		$sql =" SELECT p.departamento , 
		       (SELECT pro.provincia FROM ubprovincia pro WHERE p.idDepa=pro.idDepa and idProv=$provincia ) as provincia , 
			   (SELECT dis.distrito FROM ubdistrito dis WHERE idDist=$distrito ) as distrito 
			   FROM ubdepartamento p where p.idDepa='$departamento'";
			   
		$query = $this->db->query($sql);
	
		if($query->result()){
			return $query->row();
		}
		else{
			return false;
		}
		
	}
	
	/**********************************************************/
	public function getEquipos($area){
		
		$this->db->where('id_area',$area);
        $this->db->order_by('descripcion','asc');
        $provincias = $this->db->get('db_equipo');
        if($provincias->num_rows()>0)
        {
			return $provincias->result();
        }
		
	}
	
	
	 public function getProvincias($departamento)
	{
		$this->db->where('idDepa',$departamento);
        $this->db->order_by('provincia','asc');
        $provincias = $this->db->get('ubprovincia');
        if($provincias->num_rows()>0)
        {
			return $provincias->result();
        }
	}
	
	
	 public function getDistritos($provincia)
	{
		$this->db->where('idProv',$provincia);
        $this->db->order_by('distrito','asc');
        $provincias = $this->db->get('ubdistrito');
        if($provincias->num_rows()>0)
        {
			return $provincias->result();
        }
	}
}