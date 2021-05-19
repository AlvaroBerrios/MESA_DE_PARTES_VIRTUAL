<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Merito_model extends CI_Model
{

    public $table = 'tb_merito';
    public $id = 'id_merito';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all(){
        $this->db->distinct();
        $this->db->join('tb_inscripcion', 'tb_inscripcion.id_inscripcion = tb_merito.inscripcion_id');
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();

  
    }

    // get data by id
    function get_by_id($id)
    {     $this->db->distinct();
        $this->db->join('tb_inscripcion', 'tb_inscripcion.id_inscripcion = tb_merito.inscripcion_id');
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->distinct();
        $this->db->join('tb_inscripcion', 'tb_inscripcion.id_inscripcion = tb_merito.inscripcion_id');
        
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_merito', $q);
	    $this->db->or_like('control_id', $q);
        $this->db->or_like('inscripcion_id', $q);
        $this->db->or_like('descripcion_ins', $q);
	    $this->db->or_like('orden', $q);
	    $this->db->or_like('dni', $q);
	    $this->db->from($this->table);
        return $this->db->count_all_results();
    }
 
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->distinct();
        $this->db->join('tb_inscripcion', 'tb_inscripcion.id_inscripcion = tb_merito.inscripcion_id');
        $this->db->join('tb_control_adju', 'tb_control_adju.id_control = tb_merito.control_id');
        $this->db->join('tb_fase', 'tb_fase.id_fase = tb_control_adju.id_fase');
        $this->db->join('tb_etapa', 'tb_etapa.id_etapa = tb_control_adju.id_etapa');
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_merito', $q);
//   	$this->db->or_like('control_id', $q);

        $this->db->or_like('inscripcion_id', $q);
        $this->db->or_like('descripcion_ins', $q);
	 //$this->db->or_like('orden', $q);
	   $this->db->or_like('dni', $q);
	   $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}
