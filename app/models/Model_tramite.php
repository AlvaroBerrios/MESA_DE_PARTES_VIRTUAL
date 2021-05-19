<?php
class Model_tramite extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

	function getCount($params = ''){
		$params['count'] = true;
		return $this->getAll($params);
	}
	
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
	public function gettramite(){
		$data = array();
		$this->db->where('estado','1');
		$this->db->where('orden !=','0');
        $query = $this->db->get('tb_tippedido');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row){
                    $data[] = $row;
                }
        }
        $query->free_result();
        return $data;
		
	}
	public  function getie() {
	  /*
		$data = array();
       // $this->db->distinct();
       //$this->db->select('nombre');
       $this->db->order_by('nombre','asc');
       $this->db->where('estado','1');
        $query = $this->db->get('ie');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row){
                    $data[] = $row;
					//var_dump($data);
                }
        }
        $query->free_result();
	//	return $data;*/
		
	               $data = array();
	            	$url='http://rap.ugel03.gob.pe/wsAdjudicaciones/index.php/api/WsAdjudicaUgel03/InstitucionesEducativas/';
				    $data = null;
				    $method='GET';
					$result = llamadoApi($method, $url, $data );
					
					$result2 = json_decode(json_encode($result), true);

                    foreach ($result2 as $row){
						$data[] = $row;
						//var_dump($data);
					}
					return $data;
				
				  /*  $PersonaId=$result->PersonaJuridicaId;
				    $TipoSolicitante=$result->TipoDocumento;*/


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

	public function getNivelPedido($id,$nivel){
		
		$this->db->where('nivelPadre',$id);
		$this->db->where('nivel',$nivel);
        $this->db->order_by('nombre','asc');
        $nivelesTramites = $this->db->get('tb_tippedido');
        if($nivelesTramites->num_rows()>0)
        {
			return $nivelesTramites->result_array();
        }
		
	}


	public function getNivelPedidoLev2($id,$nivel){

		$this->db->where('nivelPadre',$id);
		$this->db->where('nivel',$nivel);
        $this->db->order_by('nombre','asc');
        $nivelesTramites = $this->db->get('tb_tippedido');
        if($nivelesTramites->num_rows()>0)
        {
			return $nivelesTramites->result_array();
        }
		
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
        $sql = "SELECT nombre FROM tb_tippedido WHERE id_tippedido=$buscar AND estado=1";
		$query = $this->db->query($sql);
		if($query->result()){
				return $query->row()->nombre;
				
		}
		else
			return false;
        
	} 

    function Get_TipPedido2($buscar)
    {
        $sql = "SELECT nombre FROM tb_tippedido WHERE id_tippedido=$buscar AND estado=2";
		$query = $this->db->query($sql);
		if($query->result()){
				return $query->row()->nombre;
				
		}
		else
			return false;
        
	} 

	function Get_TipPedidoid($buscar)
    {
        $sql = "SELECT id_tippedido FROM tb_tippedido WHERE id_tippedido=$buscar AND estado=1";
		$query = $this->db->query($sql);
		if($query->result()){
				return $query->row()->id_tippedido;
				
		}
		else
			return false;
        
    } 

    function Get_TipPedidoid2($buscar)
    {
        $sql = "SELECT id_tippedido FROM tb_tippedido WHERE id_tippedido=$buscar AND estado=2";
		$query = $this->db->query($sql);
		if($query->result()){
				return $query->row()->id_tippedido;
				
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
	
	function getUltimoNivel($buscar)
    {
        $sql = "SELECT * FROM tb_tippedido WHERE id_tippedido=$buscar ";
		$query = $this->db->query($sql);
		if($query->result()){
			$data["nivel"] = $query->result();
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
		
		$sql = "SELECT * FROM tb_tippedido WHERE estado=1 order by orden asc";
		$query = $this->db->query($sql);
		if($query->result()){
				return $query->result_array();
				
		}
		else
			return false;
	}
	function save_pedido($data){
		$this->db->insert("tb_pedido",$data);
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
	
}