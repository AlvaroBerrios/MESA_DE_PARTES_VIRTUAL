<?php
class Model_boleta extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

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
    function search($buscar)
    {
        /*$sql = "SELECT * FROM boleta where idboleta =".$buscar;*/
		$sql = "SELECT * FROM boleta where idboleta IN (".$buscar.")";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		if($result){
			
			return $result;
			
		}
		else{
			return false;
		}
        
    }       
	function save($data){
		$this->db->insert("boleta",$data);
		$id = $this->db->insert_id();
		if($id){
			
			return $id;
		}
		else{
			return false;
		}
	}
	function saveperiodo($data){
		$this->db->insert("periodo",$data);
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
	function Get_TotPagosVenta($id){
		$sql = "SELECT SUM(monto) AS total FROM tb_cobro WHERE status=1 AND id_venta=".$id;
		$query = $this->db->query($sql);
		if($query->result()){
				return $query->row()->total;
				
		}
		else
			return false;
		
	}
	function Get_VentaById($id){
		$sql = "SELECT SUM(total) AS monto, CONCAT(p.name,' ',p.lastname) AS cliente,v.id_venta FROM tb_detventa dv, tb_venta v, persona p, 
				cliente cl WHERE dv.id_venta=$id 
				AND dv.status>0 
				AND dv.id_venta=v.id_venta AND v.id_cliente=cl.id_cliente AND cl.id_persona=p.id_persona";
				//die($sql);
		$query = $this->db->query($sql);
		if($query->result()){
			
			$data = $query->row();
			$data->monto = $data->monto - str_replace(",","",$this->Get_pagos($id));
			$data->cobros = str_replace(",","",$this->Get_pagos($id));
			return $data;
		}
		else{
			return false;
		}
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
	
}