<?php
class Model_login extends CI_Model
{
	
    function __construct()
    {
		 parent::__construct();
	}

	public function Get_user($correo,$pass)
	    {
			//$sql = "SELECT FROM tb_usuarios u, tb_usutipopersona c WHERE u.idTipPer=c.idTipPer AND u.correo='".$correo."' AND c.pass='". $pass."' AND u.estado='1' AND c.estado='1'";
			$sql = "SELECT * FROM tb_usuarios WHERE correo='".$correo."' AND pass='".$pass."' AND estado=1" ;
			$query = $this->db->query($sql);
			if($query->result()){
				return $query->row_array();
			}
			else
				return false;   
	    }
	
	public function Get_user2($id){
		$sql = "SELECT u.*, c.pass FROM tb_usuarios u, tb_creden c WHERE u.id_usuario = c.id_usuario AND u.correo='".$id."' AND u.flg=1 AND c.flg=1";
		$query = $this->db->query($sql);
		if($query->result()){
			return $query->row_array();
		}
		else
			return false;
    } 


	public function obtenerUsuario($id){
		$sql = "SELECT * FROM tb_usuarios WHERE id_usuario='".$id."'";
		$query = $this->db->query($sql);
		$result = $query->row();
		if($result){
			return $result;
		}
		else
			return false;
    } 

	// MUESTRA EN UNA LISTA LOS DEPARTAMENTOS
	/*public function getubicacion(){
		$data = array();
		$this->db->where('estado','1');
		$this->db->order_by('departamento','asc');
        $query = $this->db->get('tb_ubdepartamento');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row){
                    $data[] = $row;
                }
        }
        $query->free_result();
        return $data;
    }*/ 

	/*public function getubicacion(){
		$this->db->order_by('departamento','asc');
		$query = $this->db->get('tb_ubdepartamento');
		//print_r($query->result());
		return $query->result();
    }*/

	
	public function getubicacion(){
		$data = array();
		$this->db->where('estado','1');
        $query = $this->db->get('tb_ubdepartamento');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row){
                    $data[] = $row;
                }
        }
        $query->free_result();
        return $data;
    }

	public function getprovincia($id_depa){
		$this->db->where('idDepa',$id_depa);
        $this->db->order_by('provincia','asc');
		$provincias = $this->db->get('tb_ubprovincia');
        if($provincias->num_rows()>0)
        {
			return $provincias->result();
        }
		
	}

	public function getdistrito($id_prov){
		$this->db->where('idProv',$id_prov);
        $this->db->order_by('distrito','asc');
		$id_prov = $this->db->get('tb_ubdistrito');
        if($id_prov->num_rows()>0)
        {
			return $id_prov->result();
        }
		
	}

	
	public function save_primerlogin($data)
		{
	        $this->db->insert("tb_primerlogin",$data);
	        $id = $this->db->insert_id();
	        if($id){
	            
	            return $id;
	        }
	        else{
	            return false;
	        }
	    }

	// MUESTRA LOS VALORES DE UNA TABALA DEPENDIENTE //
	public function gettipopersona(){
		$data = array();
		$this->db->where('estado','1');
        $query = $this->db->get('tb_usutipopersona');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row){
                    $data[] = $row;
                }
        }
        $query->free_result();
        return $data;
		
	}

	// MUESTRA LOS VALORES DE UNA TABALA DEPENDIENTE //
	public function getTipoDoc($tipodoc){
		
		$this->db->where('idTipPer',$tipodoc);
        $this->db->order_by('descripcion','desc');
        $tipodoc = $this->db->get('tb_usutipodocumento');
        if($tipodoc->num_rows()>0)
        {
			return $tipodoc->result();
        }
		
	}

	// MUESTRA LOS VALORES DE UNA SOLA TABLA //
	public function gettipocargo(){
		$data = array();
		$this->db->where('estado','1');
        $this->db->order_by('descripcion_cargo','desc');
        $query = $this->db->get('tb_usucargo');
        if($query->num_rows()>0)
        {
			foreach($query->result_array() as $row){
				$data[] = $row;
			}
        }
		$query->free_result();
		return $data;
	}

	// MUESTRA LOS VALORES DE UNA SOLA TABLA //
	public function gettipovia(){
		$data = array();
		$this->db->where('estado','1');
        $this->db->order_by('descripcion','asc');
        $query = $this->db->get('tb_ubvia');
        if($query->num_rows()>0)
        {
			foreach($query->result_array() as $row){
				$data[] = $row;
			}
        }
		$query->free_result();
		return $data;
	}

	// MUESTRA LOS VALORES DE UNA SOLA TABLA //
	public function gettipozona(){
		$data = array();
		$this->db->where('estado','1');
        $this->db->order_by('descripcion','desc');
        $query = $this->db->get('tb_ubzona');
        if($query->num_rows()>0)
        {
			foreach($query->result_array() as $row){
				$data[] = $row;
			}
        }
		$query->free_result();
		return $data;
	}

	public function buscaEmail($email){
			
	        $sql = "SELECT count(*) as num FROM tb_usuarios WHERE correo='".$email."' AND estado=1";
			$query = $this->db->query($sql);
			if($query->result()){
				return $query->row_array();
			}else{
			    return false;
			}
	}

	public function buscaDni($dni){
	        $sql = "SELECT count(*) as num FROM tb_usuarios WHERE nroDocumento='".$dni."' AND estado=1";
			$query = $this->db->query($sql);
			if($query->result()){
					return $query->row_array();		
			}
			else
				return false;
	}

	/* INGRESA CAMPOS A LA TABLA USUARIOS */
	public function save_registroUsuario($data){
			$this->db->insert("tb_usuarios",$data);
			$id = $this->db->insert_id();
			if($id){
				return $id;
			}
			else{
				return false;
			}
	}

	/* ACTUALIZA CAMPOS A LA TABLA USUARIOS */
	/*public function save_actualizacionUsuario($data){
			$this->db->update("tb_usuarios",$data);
			$id = $this->db->insert_id();
			if($id){
				return $id;
			}
			else{
				return false;
			}
	}*/

	function update_datosPersonales($data){
		$id = $this->db->update('tb_usuarios', $data);
		if($id){
			return true;
		}
		else{
			return false;
		}
	
	}

	/* INGRESA CAMPOS A LA TABLA USUARIOS */
	public function save_direccionusuario($data){
		$this->db->insert("tb_ubusuario",$data);
		$id = $this->db->insert_id();
		if($id){
			return $id;
		}
		else{
			return false;
		}
	}	

	public function buscaIdUsuario($dni){
	        $sql = "SELECT id_usuario as usu FROM tb_usuarios WHERE nroDocumento='".$dni."' AND estado=1";
			$query = $this->db->query($sql);
			if($query->result()){
					return $query->row_array();		
			}
			else
				return false;
	}


	public function save_credencialUsuario($data){
			$this->db->insert("tb_creden",$data);
			$id = $this->db->insert_id();
			if($id){
				return $id;
			}
			else{
				return false;
			}
	}
   

/***********************************************************************/

	public function save_meritonuevo($data)
		{
			$this->db->insert("tb_merito",$data);
			$id = $this->db->insert_id();
			if($id){
				return $id;
			}
			else{
				return false;
			}
		}

	public function getcargo()
		{
			$data = array();
			$this->db->where('vista','1');
			 $this->db->order_by('descripcion_cargo','asc');
	        $query = $this->db->get('tb_cargo');
	        if ($query->num_rows() > 0) {
	            foreach ($query->result_array() as $row){
	                    $data[] = $row;
	                }
	        }
	        $query->free_result();
	        return $data;
			
		}

	public function getmodalidad()
		{
			$data = array();
			$this->db->where('vista','1');
			 $this->db->order_by('descripcion_modalidad','asc');
	        $query = $this->db->get('tb_modalidad');
	        if ($query->num_rows() > 0) {
	            foreach ($query->result_array() as $row){
	                    $data[] = $row;
	                }
	        }
	        $query->free_result();
	        return $data;
			
		}

	public function getfase()
		{
			$data = array();
			$this->db->where('vista','1');
			 $this->db->order_by('descripcion_fase','asc');
	        $query = $this->db->get('tb_fase');
	        if ($query->num_rows() > 0) {
	            foreach ($query->result_array() as $row){
	                    $data[] = $row;
	                }
	        }
	        $query->free_result();
	        return $data;
			
		}

	public function getFaseEspecifico($etapa)
		{
			$this->db->where('id_etapa',$etapa);
			$this->db->where('vista','1');
	        $this->db->order_by('descripcion_fase','asc');
	        $fase = $this->db->get('tb_fase');
	        if($fase->num_rows()>0)
	        {
				return $fase->result();
	        }
		}

	public function getnivel()
		{
			$data = array();
			$this->db->where('vista','1');
			 $this->db->order_by('descripcion_nivel','asc');
	        $query = $this->db->get('tb_nivel');
	        if ($query->num_rows() > 0) {
	            foreach ($query->result_array() as $row){
	                    $data[] = $row;
	                }
	        }
	        $query->free_result();
	        return $data;
			
		}

    public function getetapa()
		{
			$data = array();
			$this->db->where('vista','1');
			 $this->db->order_by('descripcion_etapa','asc');
	        $query = $this->db->get('tb_etapa');
	        if ($query->num_rows() > 0) {
	            foreach ($query->result_array() as $row){
	                    $data[] = $row;
	                }
	        }
	        $query->free_result();
	        return $data;
			
		}

	 public function getNivelEspecifico($modalidad)
		{
			$this->db->where('id_modalidad',$modalidad);
			$this->db->where('vista','1');
	        $this->db->order_by('descripcion_nivel','asc');
	        $nivel = $this->db->get('tb_nivel');
	        if($nivel->num_rows()>0)
	        {
				return $nivel->result();
	        }
		}


	public function getcurricular()
		{
			$data = array();
			$this->db->where('vista','1');
			 $this->db->order_by('descripcion_curricular','asc');
	        $query = $this->db->get('tb_curricular');
	        if ($query->num_rows() > 0) {
	            foreach ($query->result_array() as $row){
	                    $data[] = $row;
	                }
	        }
	        $query->free_result();
	        return $data;
			
		}

	public function getCurricularEspecifico($cargo)
		{
			$this->db->where('id_cargo',$cargo);
			$this->db->where('vista','1');
	        $this->db->order_by('descripcion_curricular','asc');
	        $curricular = $this->db->get('tb_curricular');
	        if($curricular->num_rows()>0)
	        {
				return $curricular->result();
	        }
		}

	public function getCurricularEspecifico2($nivel)
		{
			$this->db->where('id_nivel',$nivel);
			$this->db->where('vista','1');
	        $this->db->order_by('descripcion_curricular','asc');
	        $curricular = $this->db->get('tb_curricular');
	        if($curricular->num_rows()>0)
	        {
				return $curricular->result();
	        }
		}
	
	public function buscaMerito($dni)
		{

	        $sql = "SELECT count(*) as num FROM tb_merito WHERE dni ='".$dni."' and estado=1 ";
			
			$query = $this->db->query($sql);
			if($query->result()){
					return $query->row_array();
					
			}
			else
				return false;

		}

	public function buscaAdjudicado($dni)
		{

	        $sql = "SELECT count(*) as num FROM tb_merito WHERE dni='".$dni."' and flg = 1 and estado=1 ";
			
			$query = $this->db->query($sql);
			if($query->result()){
					return $query->row_array();
					
			}
			else
				return false;

		}

	public function buscaTiempo($dni)
		{

	        $sql = "SELECT f.fechaini, f.fechafin FROM tb_merito m, tb_control_adju ca, tb_fechas f WHERE m.control_id = ca.id_control and ca.id_fecha = f.id_fecha and m.dni='".$dni."' and m.flg = 0 and m.estado = '1' and ca.estado = '1' and f.estado = '1' ";
			
			$query = $this->db->query($sql);
			if($query->result()){
					return $query->row_array();
					
			}
			else
				return false;

		}
	
	

	
	 

    
	
	public function Get_userChangePass($data = array())
	    {
			
			$sql = "SELECT * FROM tb_postulante WHERE nroDoc='".$data['dni']."' and email='".$data['email']."' and pass='".$data['passaActual']."' and flg='1'";
		
			$query = $this->db->query($sql);
			if($query->result()){
					return $query->row_array();
					
			}
			else
				return false;
 
		} 
	
	public function Change_PasswordUser($data)
		{
			$id = $this->db->update('tb_postulante', $data, array('nroDoc' => $data['nroDoc'],'email' => $data['email']));
			if($id){
				return true;
			}
			else{
				return false;
			}
		}


	
	
}
