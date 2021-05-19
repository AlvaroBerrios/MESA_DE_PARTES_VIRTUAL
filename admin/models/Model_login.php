<?php
class Model_login extends CI_Model
{
	
	
    function __construct()
    {
		//$this->db_sinad = $this->load->database('db_sinad', TRUE);
		
        parent::__construct();
    }
	
	

	function getInfoUsuario($id)
    {
		
		$sql = "SELECT * FROM tb_usuario WHERE id='".$id."' AND flg=1";
		
		$query = $this->db->query($sql);
		if($query->result()){
			return $query->row_array();
				
		}
		else
			return false;
        
    }
	
	
	
	
	function Get_user($id,$pass)
    {
		
		$sql = "SELECT * FROM tb_usuarios WHERE dni='".$id."' AND contraseña='". sha1($pass)."' AND estado=1";
		
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
	
   
	
}